<?php
namespace GreenPigDAO;


class Query
{
    use BaseFunctions;

    private $db;
    private $settings;
    private $baseSQL;
    private $partsSql;
    private $binds;
    private $sort;
    private $pagination;
    private $paginationLastRequest;
    private $rawData;
    private $aggregateData;
    private $debugInfo;



    public function __construct($db, $settings, $baseSQL = '')
    {
        $this->db = $db;
        $this->settings = $settings;
        $this->baseSQL = $baseSQL;
        $this->partsSql = [];
        $this->binds = [];
        $this->sort = [];
        $this->pagination = false;
        $this->paginationLastRequest = false;
        $this->rawData = false;
        $this->aggregateData = false;
        $this->debugInfo = [];
    }



    public function sql($baseSQL)
    {
        $this->baseSQL = $baseSQL;
        return $this;
    }



    public function sqlPart($alias, $sql, $binds)
    {
        $this->partsSql[$alias] = [$sql, $binds];
        return $this;
    }



    public function binds($binds)
    {
        $this->binds = $binds;
        return $this;
    }



    public function addBinds($binds)
    {
        $this->binds = array_merge($this->binds, $binds);
        return $this;
    }



    public function bind($alias, $value)
    {
        $this->binds[$alias] = $value;
        return $this;
    }



    public function where($alias, $where)
    {
        $this->_where($alias, $where);
        return $this;
    }

    private function _where($alias, $where, $isWhere = false)
    {
        if (!$this->isClass($where, 'Where')) throw new \Exception('Параметр where должен быть экземпляром класса Where.');
        if (!$where->getSql()) $where->generate();
        $sql = $isWhere ? ' WHERE ' : '';
        $sql .= $where->getSql();
        if ($where->getSql()) $this->sqlPart($alias, $sql, $where->getBind());
    }



    public function whereAnd($alias, $where)
    {
        $this->_whereAndOr($alias, $where, 'and');
        return $this;
    }



    public function whereOr($alias, $where)
    {
        $this->_whereAndOr($alias, $where, 'or');
        return $this;
    }



    private function _whereAndOr($alias, $where, $union)
    {
        if (!is_array($where)) throw new \Exception('Параметр where должен быть массивом логических операций.');
        $wh = new Where($this->settings);
        if ($union === 'and') $wh->linkAnd($where)->generate();
        else $wh->linkOr($where)->generate();
        if ($wh->getSql()) $this->sqlPart($alias, ' WHERE '. $wh->getSql(), $wh->getBind());
    }



    public function join($alias, $join)
    {
        if ($this->isClass($join, 'Join') || $this->isClass($join, 'CollectionJoin')) {
            if (!$join->getSql()) $join->generate();
            if ($join->getSql()) $this->sqlPart($alias, $join->getSql(), $join->getBind());
        } else throw new \Exception('Параметр join должен быть экземпляром класса Join или CollectionJoin.');
        return $this;
    }



    public function sort($nameColumn)
    {
        if(!is_string($nameColumn)) throw new \Exception('Параметр nameColumn должен быть строкой.');
        $this->sort = [$nameColumn];
        return $this;
    }



    public function sortDesc($nameColumn)
    {
        if(!is_string($nameColumn)) throw new \Exception('Параметр nameColumn должен быть строкой.');
        $this->sort = [" $nameColumn desc "];
        return $this;
    }



    public function sorts($namesColumns)
    {
        if (!is_array($namesColumns)) throw new \Exception('Параметр namesColumns должен быть массивом.');
        $this->sort = $namesColumns;
        return $this;
    }



    public function pagination($currentPage, $numberRowOnPage)
    {
        $this->pagination = [
            'currentPage' => $currentPage,
            'numberRowOnPage' => $numberRowOnPage,
            'numberAllRow' => null,
            'numberAllPage' => null
        ];
        return $this;
    }

    // =================================================================================================================

    public function all($options = false)
    {
        // Сортировка должна быть во внешнем запросе, если сортировка находится внутри,
        // то Oracle не гарантирует ее соблюдение.
        $startQuery = microtime(true);
        $arrSqlBinds = $this->_genSqlBinds();
        $sql = $arrSqlBinds['sql'];
        $binds = $arrSqlBinds['binds'];
        // --- Передан массив $options, возвращаем агрегированные данные ---
        if (is_array($options)) {
            if ($this->pagination) {
                $pk = $this->_getPrimaryKeyForAggregator($options);
                $sql = $this->_processingPagination($pk, $sql, $binds);
                if (!$sql) return false; // пустая выборка при пагинации
            }
            $aliasTable = "table_" . $this->genStr();
            if ($this->sort) $sql = "SELECT * FROM ($sql) $aliasTable ORDER BY ". implode(",", $this->sort);

//            print_r($sql);
//            var_dump($binds);
//          return 0;

            $rawData = $this->db->fetchAll($sql, $binds);
            $aggregateData = $this->aggregator($options, $rawData);
            $this->_afterRequest($rawData, $aggregateData, $sql, $binds, $startQuery);
            return $aggregateData;
        // --- Простой запрос, без агрегации ---
        } else {

            echo '<pre>';
            print_r($sql);
            return false;

            // --- Если $options - строка, то это PK для пагинации ---
            if (is_string($options) && is_array($this->pagination)) {
                $sql = $this->_processingPagination($options, $sql, $binds);
                if (!$sql) return false; // пустая выборка при пагинации
            }
            $aliasTable1 = "table_" . $this->genStr();
            if ($this->sort) $sql = "SELECT * FROM ($sql) $aliasTable1 ORDER BY ". implode(",", $this->sort);
            $rawData = $this->db->fetchAll($sql, $binds);
            $this->_afterRequest($rawData, false, $sql, $binds, $startQuery);
            return $rawData;
        }
    }

    private function _processingPagination($pk, $sql, $binds)
    {
        $aliasTable1 = "table_" . $this->genStr();
        $result = $this->db->fetchRow("SELECT COUNT(distinct $aliasTable1.$pk) as total_count FROM ( $sql ) $aliasTable1", $binds);
        //  В зависимости от настройки БД она может вернуть данные, приведя название колонок к нижнему или верхнему
        // регистру. Нам нужен первый (в данном случае единственный) столбец.
        $firstKey = array_keys($result);
        $firstKey = $firstKey[0];
        $numberAllRow = (int)$result[$firstKey];
        $numberRowOnPage = $this->pagination['numberRowOnPage'];
        $this->pagination['numberAllRow'] = $numberAllRow;
        $this->pagination['numberAllPage'] =  ceil($numberAllRow / $numberRowOnPage);
        $indexStart = $numberRowOnPage * ($this->pagination['currentPage'] - 1) + 1;
        if (trim(strtolower($this->settings['nameDatabase'])) == 'oracle') $arrPkResultRequest =  $this->_fetchPKsOracle($sql, $binds, $pk, $indexStart, $numberRowOnPage);
        elseif (trim(strtolower($this->settings['nameDatabase'])) == 'mysql') $arrPkResultRequest = $this->_fetchPKsMySql($sql, $binds, $pk, $indexStart, $numberRowOnPage);
        else throw new \Exception('В settings неверно указано название базы данных.');
        $aliasTable2 = "table_" . $this->genStr();
        $sql = "SELECT * FROM ($sql) $aliasTable2 WHERE $pk IN (". implode(",", $arrPkResultRequest) .")";
        return count($arrPkResultRequest) ? $sql : false;
    }

    // $indexStart - включительно и начинается с 1
    // fetchAllPrimaryKey($sql, $binds, 'ID', 4, 2) );       1 2 3 4 5 6 7 8 9   Выдаст: 4, 5
    // todo: переделать алиасы биндов (возможно неуникальны) и экранирование таблиц и столбцов !!!!!
    private function _fetchPKsOracle($sql, $binds, $primaryKey, $indexStart, $numberRowOnPage)
    {
        $timeStartQuery = microtime(true);
        $sqlOB = '';
        if ($this->sort) $sqlOB = "  ORDER BY ". implode(",", $this->sort);
        $indexEnd = $indexStart + $numberRowOnPage;
        $sql = "select * from (
                  select rownum rnum, $primaryKey from (
                    select $primaryKey from ($sql) group by $primaryKey $sqlOB
                  )
                ) where rnum >= :indexStart and rnum < :indexEnd";
        $binds = array_merge($binds, ['indexStart' => $indexStart, 'indexEnd' => $indexEnd]);
        $result = $this->db->fetchAll($sql, $binds);
        $this->debugInfo[] = [
            'sql' => $sql,
            'binds' => $binds,
            'timeQuery' => (microtime(true) - $timeStartQuery)
        ];
        $resultFinal = [];
        foreach ($result as $r) $resultFinal[] = $r[$primaryKey];
        return $resultFinal;
    }

    private function _fetchPKsMySql($sql, $binds, $primaryKey, $indexStart, $numberRowOnPage)
    {
        $aliasTable = "table_" . $this->genStr();
        $timeStartQuery = microtime(true);
        $indexStart--;
        $sql = "select $primaryKey from ($sql) $aliasTable group by $primaryKey limit :indexStart, :numberRowOnPage";
        $binds = array_merge($binds, ['indexStart' => $indexStart, 'numberRowOnPage' => $numberRowOnPage]);
        $result = $this->db->fetchAll($sql, $binds);
        $this->debugInfo[] = [
            'sql' => $sql,
            'binds' => $binds,
            'timeQuery' => (microtime(true) - $timeStartQuery)
        ];
        $resultFinal = [];
        foreach ($result as $r) $resultFinal[] = $r[$primaryKey];
        return $resultFinal;
    }



    public function one($nameColumn = null)
    {
        $startQuery = microtime(true);
        $arrSqlBinds = $this->_genSqlBinds();
        $sql = $arrSqlBinds['sql'];
        $binds = $arrSqlBinds['binds'];
        // --- проверяем, чтобы возвращалась только 1 запись ---
        $sqlCheck = "SELECT COUNT(*) as total_count FROM ( $sql ) a";
        $tc= $this->db->fetchRow($sqlCheck, $binds);
        $this->debugInfo[] = [
            'sql' => $sqlCheck,
            'binds' => $binds,
            'timeQuery' => (microtime(true) - $startQuery)
        ];
        //  В зависимости от настройки БД она может вернуть данные, приведя название колонок к нижнему или верхнему
        // регистру. Нам нужен первый (в данном случае единственный) столбец.
        $firstKey = array_keys($tc);
        $firstKey = $firstKey[0];
        $totalCount = (int)$tc[$firstKey];
        if ($totalCount !== 1) throw new \Exception('В выборке может быть только одна запись.');
        // ---
        $data = $this->db->fetchRow($sql, $binds);
        $this->_afterRequest($data, false, $sql, $binds, $startQuery);
        return $nameColumn ? $data[$nameColumn] : $data;
    }



    public function first($nameColumn = null)
    {
        $startQuery = microtime(true);
        $arrSqlBinds = $this->_genSqlBinds();
        $sql = $arrSqlBinds['sql'];
        $binds = $arrSqlBinds['binds'];
        $data = $this->db->fetchRow($sql, $binds);
        $this->_afterRequest($data, false, $sql, $binds, $startQuery);
        return $nameColumn ? $data[$nameColumn] : $data;
    }

    // =================================================================================================================

    public function query()
    {
        $startQuery = microtime(true);
        $arrSqlBinds = $this->_genSqlBinds();
        $sql = $arrSqlBinds['sql'];
        $binds = $arrSqlBinds['binds'];
        $rawData = $this->db->query($sql, $binds);
        $this->_afterRequest($rawData, false, $sql, $binds, $startQuery);
        return $rawData;
    }



    private function _genSqlBinds()
    {
        $sql = $this->baseSQL;
        $binds = $this->binds;
        foreach ($this->partsSql as $alias => $part) {
            $sql = str_replace($alias, $part[0], $sql);
            $binds = array_merge($binds, $part[1]);
        }
        return ['sql' => $sql, 'binds' => $binds];
    }

    // =================================================================================================================

    public function insert($table, $parameters, $primaryKey = null)
    {
        $startQuery = microtime(true);
        $sqlData = $this->_decomposedParameters($parameters);
        $sql = "INSERT INTO $table ({$sqlData['columnSql']}) VALUES ({$sqlData['valueSql']})";
        $result = $this->db->insert($sql, $sqlData['bind'], $table, $primaryKey);
        $this->_afterRequest($result, false, $sql, $sqlData['bind'], $startQuery);
        return (is_array($result) && $primaryKey) ? $result[$primaryKey] : $result;
    }



    public function update($table, $parameters, $where, $union = null)
    {
        $startQuery = microtime(true);
        $wh = $this->_genWhereForUpdateAndDelete($where, $union);
        $sqlData = $this->_decomposedParameters($parameters);
        $sql = "UPDATE $table SET {$sqlData['forUpdate']} WHERE ". $wh->getSql();
        $binds = array_merge($sqlData['bind'], $wh->getBind());
        $this->db->query($sql, $binds);
        $updateLinesSql = "SELECT * FROM $table WHERE " . $wh->getSql();
        $startQuery2 = microtime(true);
        $updateLines = $this->db->fetchAll($updateLinesSql, $wh->getBind());
        $this->debugInfo[] = [
            'sql' => $updateLinesSql,
            'binds' => $wh->getBind(),
            'timeQuery' => (microtime(true) - $startQuery2)
        ];
        $this->_afterRequest($updateLines, false, $sql, $binds, $startQuery);
        return $updateLines;
    }



    // Если значение не массив, то биндим через параметры, если массив то вставляем в sql как есть
    // добавить случайной строки в $alias
    private function _decomposedParameters($parameters)
    {
        $column = array_keys($parameters);
        $column = implode(", ", $column);
        $aCol = [];
        $bind = [];
        $update = [];
        foreach ($parameters as $col => $val) {
            if (is_array($val)) {
                $aCol[] = " {$val[0]} ";
                $update[] = " $col = {$val[0]} ";
            } else {
                $alias = 'alias_'. $col;
                $aCol[] = ':'. $alias;
                $bind[$alias] = $val;
                $update[] = " $col = :$alias ";
            }
        }
        $aCol = implode(", ", $aCol);
        $update = implode(", ", $update);
        return [
            'columnSql' => $column,
            'valueSql' => $aCol,
            'bind' => $bind,
            'forUpdate' => $update
        ];
    }



    public function delete($table, $where, $union = null)
    {
        $startQuery = microtime(true);
        $wh = $this->_genWhereForUpdateAndDelete($where, $union);
        $delLinesSql = "SELECT * FROM $table WHERE " . $wh->getSql();
        $delLines = $this->db->fetchAll($delLinesSql, $wh->getBind());
        $this->debugInfo[] = [
            'sql' => $delLinesSql,
            'binds' => $wh->getBind(),
            'timeQuery' => (microtime(true) - $startQuery)
        ];
        $sql = "DELETE FROM $table WHERE " . $wh->getSql();
        $this->db->query($sql, $wh->getBind());
        $this->_afterRequest($delLines, false, $sql, $wh->getBind(), $startQuery);
        return $delLines;
    }



    private function _genWhereForUpdateAndDelete($where, $union)
    {
        if (($union === null) && $this->isClass($where, 'Where')) {
            $wh = $where;
            if (!$wh->getSql()) $wh->generate();
            if (!$wh->getSql()) throw new \Exception('Параметр where не может быть пустым.');
        } elseif (is_string($union) && is_array($where)) {
            $union = mb_strtolower(trim($union));
            if (!($union == 'and' || $union == 'or' )) throw new \Exception('union должна принимать значение либо OR либо AND.');
            $wh = new Where($this->settings);
            if ($union == 'and') $wh->linkAnd($where)->generate();
            else $wh->linkOr($where)->generate();
        } else throw new \Exception('WHERE часть задается либо только переменной where, которая является экземпляром класса Where, либо массивом where (массив логических операций) и строкой union (должна быть либо OR либо AND).');
        return $wh;
    }

    // =================================================================================================================

    public function rawData()
    {
        return $this->rawData;
    }



    public function aggregateData()
    {
        return $this->aggregateData;
    }



    public function getPagination()
    {
        return $this->paginationLastRequest;
    }



    public function column($nameColumn)
    {
        $rawData = $this->rawData;
        if ($rawData && count($rawData)) {
            if (is_array($rawData[0])) {
                $result = [];
                foreach ($rawData as $el) $result[] = $el[$nameColumn];
                return $result;
            } else return $rawData[$nameColumn];
        }
        return false;
    }



    public function map($pk, $columns = [])
    {
        $rawData = $this->rawData;
        $result = [];
        if ($columns) {
            foreach ($rawData as $el) {
                $buf = [];
                foreach ($columns as $c) {
                    $buf[$c] = $el[$c];
                }
                $result[$el[$pk]] = $buf;
            }
        } else {
            foreach ($rawData as $el) {
                $result[$el[$pk]] = $el;
            }
        }
        return $result;
    }



    // ---------- aggregator ----------
    public function aggregator($option, $rawData) {
        $pk = $this->_getPrimaryKeyForAggregator($option);
        $adaptedOption = []; // остается только 2 уровня вложенности
        foreach ($option as $nameColumn => $alias) {
            if (is_array($alias)) $adaptedOption[$nameColumn] = $this->_getAdaptedOptionForAggregator($alias);
            else $adaptedOption[$nameColumn] = $alias;
        }
        $processedData = $this->_getProcessedDataForAggregator($pk, $adaptedOption, $rawData);
        // рекурсивно обрабатываем сгруппированные части
        foreach ($processedData as $index => $pd) {
            foreach ($option as $nameNewColumn => $opt) {
                if (is_array($opt)) {
                    $lowerLevelPk = $this->_getPrimaryKeyForAggregator($opt);
                    if ($lowerLevelPk) {
                        $processedData[$index][$nameNewColumn] = $this->aggregator($opt, $pd[$nameNewColumn]);
                    }
                }
            }
        }
        return $processedData;
    }

    private function _getPrimaryKeyForAggregator($option) {
        $pk = [];
        foreach ($option as $nameColumn => $alias) {
            if (is_string($alias) && mb_strtolower(trim($alias)) == 'pk') $pk[] = $nameColumn;
        }
        if (count($pk) > 1) throw new \Exception('В массиве option на каждом уровне вложенности pk должен быть ТОЛЬКО ОДИН.');
        if (count($pk) === 0) throw new \Exception('В массиве option на каждом уровне вложенности ДОЛЖЕН быть pk.');
        return $pk[0];
    }

    private function _getAdaptedOptionForAggregator($option) {
        $adaptedOption = [];
        foreach ($option as $nameColumn => $alias) {
            if (is_array($alias)) $adaptedOption = array_merge($adaptedOption, $this->_getAdaptedOptionForAggregator($alias));
            else $adaptedOption[] = $nameColumn;
        }
        return $adaptedOption;
    }

    private function _getProcessedDataForAggregator($pk, $option, $rawData) {
        $processedData = [];
        foreach ($rawData as $rd) {
            $pLine = $this->_processedLineForAggregator($pk, $option, $rd);
            // повторяющаяся запись
            if (isset($processedData[$rd[$pk]])) {
                foreach ($option as $nameNewColumn => $opt) {
                    if (is_array($opt)) $processedData[$rd[$pk]][$nameNewColumn][] = $pLine[$nameNewColumn][0];
                }
            } else $processedData[$rd[$pk]] = $pLine; // новая запись
        }
        return $processedData;
    }

    private function _processedLineForAggregator($pk, $option, $rawDataLine) {
        $bData = [];
        foreach ($option as $nameColumn => $alias) {
            if (is_string($alias) && $nameColumn !== $pk) {
                $bData[$alias] = $rawDataLine[$nameColumn];
            } else if (is_array($alias)) {
                $nameNewColumn = $nameColumn;
                $arrNameColumn = $alias; // Одномерный массив названий колонок (после приведения опций к двумерному массиву)
                $bbData = [];
                foreach ($arrNameColumn as $nc) {
                    $bbData[$nc] = $rawDataLine[$nc];
                }
                $bData[$nameNewColumn][] = $bbData;
            }
        }
        return $bData;
    }
    // ---------- end aggregator ----------



    public function debugInfo()
    {
        return $this->debugInfo;
    }



    private function _afterRequest($rawData, $aggregateData, $sql, $binds, $timeStartQuery)
    {
        $this->partsSql = [];
        $this->binds = [];
        $this->sort = [];
        $this->rawData = $rawData;
        $this->aggregateData = $aggregateData;
        $this->paginationLastRequest = $this->pagination;
        $this->pagination = false;
        $this->debugInfo[] = [
            'sql' => $sql,
            'binds' => $binds,
            'timeQuery' => (microtime(true) - $timeStartQuery)
        ];
    }





    public function smartWhere($aliasWhere, $aliasJoin, $options, $where, $union = null, $whereMore = [])
    {
        $cJn = new CollectionJoin($this->settings);
        $where->setRaw( $this->_smartWhere($cJn, $where->getRaw(), $options) );
        $this->_where($aliasWhere, $where, $isWhere = true);
        $this->join($aliasJoin, $cJn);

//        if ($union) {
//            if ()
//            $where-> $whereMore
//        }

        return $this;
    }


    private function _smartWhere(&$cJn, $whRaw, $options)
    {
        $rez = [];
        foreach ($whRaw as $wr) {
            if (!is_string($wr)) {
                if (is_array($wr[0])) {
                    $rez[] = $this->_smartWhere($cJn, $wr, $options);
                } else {
                    $table = $options[$wr[0]][0];
                    $column = $options[$wr[0]][1];
                    $outColumn = $options[$wr[0]][2];
                    $aliasTable = $cJn->addNew('inner', $table, $column, $outColumn);
                    $wr[0] = "$aliasTable.$column";
                    $rez[] = $wr;
                }
            } else $rez[] = $wr;
        }
        return $rez;
    }





}