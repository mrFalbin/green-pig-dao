<?php
namespace GreenPigDAO;

/**
 *  author:        Falbin
 *  email:         ifalbin@yandex.ru
 *  homepage:      https://falbin.ru
 *  documentation: https://falbin.ru/documentation/greenpig
 *  github:        https://github.com/mrFalbin/green-pig-dao
 *
 *                             ╔═══╗╔═══╗╔═══╗╔═══╗╔╗─╔╗────╔═══╗╔══╗╔═══╗
 *                             ║╔══╝║╔═╗║║╔══╝║╔══╝║╚═╝║────║╔═╗║╚╗╔╝║╔══╝
 *                             ║║╔═╗║╚═╝║║╚══╗║╚══╗║╔╗─║────║╚═╝║─║║─║║╔═╗
 *                             ║║╚╗║║╔╗╔╝║╔══╝║╔══╝║║╚╗║────║╔══╝─║║─║║╚╗║
 *                             ║╚═╝║║║║║─║╚══╗║╚══╗║║─║║────║║───╔╝╚╗║╚═╝║
 *                             ╚═══╝╚╝╚╝─╚═══╝╚═══╝╚╝─╚╝────╚╝───╚══╝╚═══╝
 *
 *
 *                                                                  MMMM:
 *                                                                 MMMMMMMMMA9
 *                                                                 GMMMMMMMMMMMMMM
 *                                                                  SMMMMMMMMMMMMMMM
 *                                                                        ,5HMMMMMMMM
 *                                                                            MMMMMMMM
 *                                                                            GMMMMMMMM
 *                                                                            &MMMMMMMM
 *                                                 23S,.                      MMMMMMMMM
 *                                              MMMMMMMMMMMMMMMMM3i          MMMMMMMMMM
 *                                             MMMMMMMMMMMMMMMMMMMMMMMMMM3AMMMMMMMMMMMH
 *                                         MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *                                        MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *                                        MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *                                       MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *                                      MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *                                HMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMi
 *                            MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *                       rMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM 9MMM2
 *                   :MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM,
 *                 MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *              rMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMB
 *            iMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM5
 *           MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM.
 *           MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *        MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *        MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMr
 *       MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *       MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *      MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *     MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *    MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMi
 *   MM  MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *   M   MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *  3M   MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 *  9M   MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 * .MM   sMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM
 * MMM    MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM5                                    5HHHG
 * MM     MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM                         HH       HHHHHHH
 *        MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM                       9HHHA    HHHHHHHH5
 *        MMMMMMMMMMMMMMMMMMMMMMMMMMMMMMM   MMMMMMMMMMMMMMMMM                     HHHHHHHHHHHHHHHHHH  9HHHHH5
 *         MMMMMMMMMMMMM3MMMMMMMMMMMMMA     3MMMMMMM MMMMMMMM                   5HHHHHHHHHHHHHHHHHHHHHHHHHHH
 *          MMMMMMMM     ,MMMMMMMMMMM        MMMMMMM MMMMMMMM                  HHHHHHHHHHHHHHHHHHHHHHHHHHHH
 *          MMMMMMMh      AMMMMMMMMM         ;MMMMMM SMMMMMMM                ;HHHHHHHHHHHHHHHHHHHHHHHHHHA
 *          MMMMMMM       hMMMMMMM            MMMMMM. MMMMMMM                 H2   HHHHHHHHHHHHHHHHHHHHHH
 *          AMMMMMM       MMMMMMMM            MMMMMM  MMMMMMM                      HHHHHHHHHHHHHHHHHHHHHHH9
 *          3MMMMMM      2MMMMMMM            HMMMMMM  MMMMMMM                       HHHHHHHHHHHHHHHHHHHHHHH
 *          9MMMMMM      MMMMMMM             MMMMMMM  MMMMMMM                       AHHHHHHHHHHHHHHHHHHHHHH
 *          MMMMMMM     MMMMMMMM             MMMMMMM  MMMMMMM                        HHHHHHHHHHHHHHHHHHHHH9  iHS
 *          MMMMMMM     MMMMMMMM             MMMMMMi  MMMMMMM                         HHHHHHHHHHHHHHHHHHHHHHhh
 *          MMMMMMM    BMMMMMMMA            MMMMMMM   MMMMMMM                          HHHHHHHHHHHHHHHHHH
 *          MMMMMMM    MMMMMMMMM           MMMMMMMX   MMMMMMM                         AA HHHHHHHHHHHHHH3
 *         9MMMMMMM&   MMMMMMMMM           MMMMMMMi   MMMMMMM                        &H  Hi         HS Hr
 *         MMMMMMMMM                       MMMMMMMMM ;MMMMMMM                        &  H&          H&  Hi
 *
 */

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



    public function where($alias, $where, $isWhere = false)
    {
        if (!$this->isClass($where, 'Where')) throw new \Exception('Параметр where должен быть экземпляром класса Where.');
        if (!$where->getSql()) $where->generate();
        $sql = $isWhere ? ' WHERE ' : '';
        $sql .= $where->getSql();
        if ($where->getSql()) $this->sqlPart($alias, $sql, $where->getBind());
        return $this;
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
            $aggregateData = [];
            try {
                $startQuery = microtime(true);
                $rawData = $this->db->fetchAll($sql, $binds);
                $aggregateData = $this->aggregator($options, $rawData);
                $this->_afterRequest($rawData, $aggregateData, $sql, $binds, $startQuery);
            } catch (\Exception $e) { $this->_error($e, $sql, $binds); }
            return $aggregateData;
            // --- Простой запрос, без агрегации ---
        } else {
            // --- Если $options - строка, то это PK для пагинации ---
            if (is_string($options) && is_array($this->pagination)) {
                $sql = $this->_processingPagination($options, $sql, $binds);
                if ($sql === false) return []; // пустая выборка при пагинации   (важное изменение c false на [])
            }
            $aliasTable1 = "table_" . $this->genStr();
            if ($this->sort) $sql = "SELECT * FROM ($sql) $aliasTable1 ORDER BY ". implode(",", $this->sort);
            try {
                $startQuery = microtime(true);
                $rawData = $this->db->fetchAll($sql, $binds);
                $this->_afterRequest($rawData, false, $sql, $binds, $startQuery);
                return $rawData;
            } catch (\Exception $e) { $this->_error($e, $sql, $binds); }
        }
    }

    private function _processingPagination($pk, $sql, &$binds)
    {
        $aliasTable1 = "table_" . $this->genStr();
        try {
            $timeStartQuery = microtime(true);
            $sqlCount = "SELECT COUNT(distinct $aliasTable1.$pk) as total_count FROM ( $sql ) $aliasTable1";
            $result = $this->db->fetchRow($sqlCount, $binds);
            $this->debugInfo[] = [
                'type' => 'info',
                'sql' => $sqlCount,
                'binds' => $binds,
                'timeQuery' => (microtime(true) - $timeStartQuery)
            ];
        } catch (\Exception $e) { $this->_error($e, $sql, $binds); }
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
        // ----- !!!!!!!!!!!!!!!!!!!!!!!
        $wh = new Where($this->settings);
        $wh->linkAnd([$pk, 'in', $arrPkResultRequest])->generate();
        $sql = "SELECT * FROM ($sql) $aliasTable2 WHERE ". $wh->getSql();
        $binds = array_merge($binds, $wh->getBind());
        // ---
        return count($arrPkResultRequest) ? $sql : false;
    }

    // $indexStart - включительно и начинается с 1
    // fetchAllPrimaryKey($sql, $binds, 'ID', 4, 2) );       1 2 3 4 5 6 7 8 9   Выдаст: 4, 5
    private function _fetchPKsOracle($sql, $binds, $primaryKey, $indexStart, $numberRowOnPage)
    {
        $timeStartQuery = microtime(true);
        $primaryKey = trim(strtolower($primaryKey));
        $sqlOrderBy = '';
        $sqlSelectOrGroup = '';
        //     В случае агрегированного запроса в массиве sort НЕ могут быть колонки из вложенных    !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //     параметров, сортировать можно только по значениям из первого уровня.
        //     1) Из массива sort получить все колонки для сортировки
        //     2) Удалить из них desc
        //     3) Удалить из них колонку первичного ключа, если есть
        //     4) Сформировать строку для select и group
        //     5) Cформировать строку для sort
        if ($this->sort) {
            // Используя цикл:
            // 1) Избегаем удаление desc из начала названия колонки
            // 2) Избегаем неоднозначности с primaryKey (есть запятая после, нет или сначало N пробелов)
            // и т.д.
            foreach ($this->sort as $srt) {
                $buf = trim(strtolower($srt));
                if ($sqlOrderBy) $sqlOrderBy .= ", $buf";
                else $sqlOrderBy = $buf;
                $buf = trim(str_replace(' desc', '', $buf));
                if ($primaryKey !== $buf) $sqlSelectOrGroup .= ", $buf";
            }
            if ($sqlOrderBy) $sqlOrderBy = " ORDER BY $sqlOrderBy";
        }
        $indexEnd = $indexStart + $numberRowOnPage;
        $aliasIndexStart = ':indexStart_'. $this->genStr();
        $aliasindexEnd = ':indexEnd_'. $this->genStr();
        $sql = "select $primaryKey from (
                     /* необходима дополнительная обертка, т.к. rownum_qyXzTempJR >= 2 всегда будет выдавать пустое множество 
                        (без псевдонима (rownum_qyXzTempJR) не работает) */
                     select rownum rownum_qyXzTempJR, $primaryKey $sqlSelectOrGroup from (                  
                         select $primaryKey $sqlSelectOrGroup from ($sql)  
                         group by $primaryKey $sqlSelectOrGroup
                         $sqlOrderBy
                     ) /* тут сортировка не имеет ссмысла, т.к. во-первых она уже не повлияет на значения нумерации, 
                          во-вторых у и так правильная нумерация, на основе вложенной выборки */
                ) where rownum_qyXzTempJR >= $aliasIndexStart and rownum_qyXzTempJR < $aliasindexEnd
                ";
        $binds = array_merge($binds, [$aliasIndexStart => $indexStart, $aliasindexEnd => $indexEnd]);
        try { $result = $this->db->fetchAll($sql, $binds); }
        catch (\Exception $e) { $this->_error($e, $sql, $binds); }
        $this->debugInfo[] = [
            'type' => 'info',
            'sql' => $sql,
            'binds' => $binds,
            'timeQuery' => (microtime(true) - $timeStartQuery)
        ];
        $resultFinal = [];
        foreach ($result as $r) {
            $r = array_change_key_case($r, CASE_LOWER);
            $resultFinal[] = $r[$primaryKey];
        }
        return $resultFinal;
    }

    private function _fetchPKsMySql($sql, $binds, $primaryKey, $indexStart, $numberRowOnPage)
    {
        $aliasTable = "table_" . $this->genStr();
        $timeStartQuery = microtime(true);
        $indexStart--;
        $aliasIndexStart = ':indexStart_'. $this->genStr();
        $aliasNumberRowOnPage = ':numberRowOnPage_'. $this->genStr();
        $sqlOB = '';
        if ($this->sort) $sqlOB = "  ORDER BY ". implode(",", $this->sort);
        $sql = "select $primaryKey from ($sql) $aliasTable 
                group by $primaryKey 
                $sqlOB 
                limit $aliasIndexStart, $aliasNumberRowOnPage";
        $binds = array_merge($binds, [$aliasIndexStart => $indexStart,
            $aliasNumberRowOnPage => $numberRowOnPage]);
        try { $result = $this->db->fetchAll($sql, $binds); }
        catch (\Exception $e) { $this->_error($e, $sql, $binds); }
        $this->debugInfo[] = [
            'type' => 'info',
            'sql' => $sql,
            'binds' => $binds,
            'timeQuery' => (microtime(true) - $timeStartQuery)
        ];
        $primaryKey = mb_strtolower($primaryKey);
        $resultFinal = [];
        foreach ($result as $r) {
            $r = array_change_key_case($r, CASE_LOWER);
            $resultFinal[] = $r[$primaryKey];
        }
        return $resultFinal;
    }



// === БУДЕТ ===
// Функция all() не будет выдавать агрегированные запросы. В качестве параметра будет только строка
// (название первичного ключа) для пагинации. Результат выборки:
//[
//    0 => [
//        'id' => 3,
//        'name' => 'Паша',
//        'title_id' => 6,
//        'title' => '«Азы» программирования и обучающие программы',
//    ],
//    1=> [
//        'id' => 3,
//        'name' => 'Паша',
//        'title_id' => 7,
//        'title' => 'История возникновения Интернет'
//    ]
//]
//
//
// Для выборки с агрегацией по старому правилу (в качестве ключей массива - PK) нужно будет использовать
// функцию allAggregatorKeyPK()  (сейчас пока функция all() ). Результат выборки:
//[
//    3 => [
//        'name' => 'Паша',
//        'courseworks' => [
//            6 => ['title' => '«Азы» программирования и обучающие программы'],
//            7 => ['title' => 'История возникновения Интернет']
//        ]
//    ]
//]
//
// Для выборки с агрегацией по новому правилу (обычный одномерный массив с ассоциативными массивами, удобно для JS
// фреймворков, типа Vue) нужно будет использовать функцию allAggregator(). Результат выборки:
//[
//    0 => [
//        'id' => 3,
//        'name' => 'Паша',
//        'courseworks' => [
//            0 => ['title_id' => 6, 'title' => '«Азы» программирования и обучающие программы'],
//            1 => ['title_id' => 7, 'title' => 'История возникновения Интернет']
//        ]
//    ]
//]
    public function allAggregator($options)
    {
        if (!is_array($options)) throw new \Exception('Параметр options далжен быть массивом.');
        $aggregateDataKeyPK = $this->all($options);
        if (is_array($aggregateDataKeyPK) && count($aggregateDataKeyPK)) {          // count(false)  =>  1
            $aggregateData = $this->_allAggregator($aggregateDataKeyPK, $options);
            $this->aggregateData = $aggregateData;
            return $aggregateData;
        }
        return [];
    }

    private function _allAggregator($aggregatorData, $options)
    {
        $pk = $this->_getPrimaryKeyForAggregator($options);
        $result = [];
        foreach ($aggregatorData as $pkVal => $arr) {
            $buf = [];
            $buf[$pk] = $pkVal;
            foreach ($arr as $nameColumn => $val) {
                if (is_array($val)) $buf[$nameColumn] = $this->_allAggregator($val, $options[$nameColumn]);
                else $buf[$nameColumn] = $val;
            }
            $result[] = $buf;
        }
        return $result;
    }



    public function one($nameColumn = null)
    {
        $startQuery = microtime(true);
        $arrSqlBinds = $this->_genSqlBinds();
        $sql = $arrSqlBinds['sql'];
        $binds = $arrSqlBinds['binds'];
        // --- проверяем, чтобы возвращалась только 1 запись ---
        $sqlCheck = "SELECT COUNT(*) as total_count FROM ( $sql ) a";
        try { $tc = $this->db->fetchRow($sqlCheck, $binds); }
        catch (\Exception $e) { $this->_error($e, $sqlCheck, $binds); }
        $this->debugInfo[] = [
            'type' => 'info',
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
        try { $data = $this->db->fetchRow($sql, $binds); }
        catch (\Exception $e) { $this->_error($e, $sql, $binds); }
        $this->_afterRequest($data, false, $sql, $binds, $startQuery);
        if ($nameColumn) {
            if (!array_key_exists($nameColumn, $data)) throw new \Exception('Колонки с таким именем не существует.');
            else return $data[$nameColumn];
        } else return $data;
    }



    public function first($nameColumn = null)
    {
        $startQuery = microtime(true);
        $arrSqlBinds = $this->_genSqlBinds();
        $sql = $arrSqlBinds['sql'];
        $binds = $arrSqlBinds['binds'];
        try { $data = $this->db->fetchRow($sql, $binds); }
        catch (\Exception $e) { $this->_error($e, $sql, $binds); }
        $this->_afterRequest($data, false, $sql, $binds, $startQuery);
        if ($nameColumn) {
            if (!array_key_exists($nameColumn, $data)) throw new \Exception('Колонки с таким именем не существует.');
            else return $data[$nameColumn];
        } else return $data;
    }

    // =================================================================================================================

    public function query()
    {
        $startQuery = microtime(true);
        $arrSqlBinds = $this->_genSqlBinds();
        $sql = $arrSqlBinds['sql'];
        $binds = $arrSqlBinds['binds'];
        try { $rawData = $this->db->query($sql, $binds); }
        catch (\Exception $e) { $this->_error($e, $sql, $binds); }
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
        try { $result = $this->db->insert($sql, $sqlData['bind'], $table, $primaryKey); }
        catch (\Exception $e) { $this->_error($e, $sql, $sqlData['bind']); }
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
        try { $this->db->query($sql, $binds); }
        catch (\Exception $e) { $this->_error($e, $sql, $binds); }
        $updateLinesSql = "SELECT * FROM $table WHERE " . $wh->getSql();
        $startQuery2 = microtime(true);
        try { $updateLines = $this->db->fetchAll($updateLinesSql, $wh->getBind()); }
        catch (\Exception $e) { $this->_error($e, $updateLinesSql, $wh->getBind()); }
        $this->debugInfo[] = [
            'type' => 'info',
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
        try { $delLines = $this->db->fetchAll($delLinesSql, $wh->getBind()); }
        catch (\Exception $e) { $this->_error($e, $delLinesSql, $wh->getBind()); }
        $this->debugInfo[] = [
            'type' => 'info',
            'sql' => $delLinesSql,
            'binds' => $wh->getBind(),
            'timeQuery' => (microtime(true) - $startQuery)
        ];
        $sql = "DELETE FROM $table WHERE " . $wh->getSql();
        try { $this->db->query($sql, $wh->getBind()); }
        catch (\Exception $e) { $this->_error($e, $sql, $wh->getBind()); }
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



    // ---------- whereWithJoin ----------
    public function whereWithJoin($aliasJoin, $options, $aliasWhere, $where, $union = null, $whereMore = null)
    {
        if ($union && is_string($union)) $union = mb_strtolower(trim($union));
        $this->_validWhereWithJoin($aliasJoin, $options, $aliasWhere, $where, $union, $whereMore);
        $cJn = new CollectionJoin($this->settings);
        $where->setRaw( $this->_whereWithJoin($cJn, $where->getRaw(), $options) );
        if (is_string($union)) {
            if ($union == 'and') $where->linkAnd([$where->getRaw(), $whereMore->getRaw()]);
            else $where->linkOr([$where->getRaw(), $whereMore->getRaw()]);
        }
        $this->where($aliasWhere, $where, $isWhere = true);
        $this->join($aliasJoin, $cJn);
        return $this;
    }

    private function _validWhereWithJoin($aliasJoin, $options, $aliasWhere, $where, $union, $whereMore)
    {
        if (!is_string($aliasWhere) || !is_string($aliasJoin) || !is_array($options) || !$this->isClass($where, 'Where')) {
            throw new \Exception('Параметры aliasWhere и aliasJoin должны быть строкой, options далжен быть массивом, а where должен быть экземпляром класса Where.');
        }
        if ($union) {
            if (!is_string($union) || !$this->isClass($whereMore, 'Where')) {
                throw new \Exception('Параметр whereMore должен быть экземпляром класса Where, а параметр union должен быть строкой.');
            }
            if (!($union == 'and' || $union == 'or')) throw new \Exception('union должна принимать значение либо OR либо AND');
        }
    }

    private function _whereWithJoin(&$cJn, $whRaw, $options)
    {
        // В теории внутри скобки только один знак OR или AND, но проверяем на случий, если была ошибка
        // или правили сырое выражение руками.
        $isOr = false;
        $isAnd = false;
        $arrColumns = [];
        foreach ($whRaw as $wr) {
            if (is_string($wr)) {
                $union = mb_strtolower(trim($wr));
                if ($union == 'or') $isOr = true;
                if ($union == 'and') $isAnd = true;
            }
        }
        if ($isOr && $isAnd) throw new \Exception('В рамках одной скобки связь может быть или только AND или только OR.');
        $arrJoin = []; // Массив джойнов в рамках 1ой скобки
        $rez = [];
        foreach ($whRaw as $wr) {
            if (!is_string($wr)) {
                if (is_array($wr[0])) {
                    $rez[] = $this->_whereWithJoin($cJn, $wr, $options);
                } else {
                    // Если в рамках 1ой скобки связь AND
                    if ($isAnd) {
                        $alias = false;
                        foreach ($options as $al => $val) {
                            if (preg_match("/(^|\W)$al\./", $wr[0])) $alias = $al;
                        }
                        // Проверяем нужно ли для данной таблицы делать join
                        if ($alias) {
                            // Проверяем сделан ли уже join для данной таблицы внутри даннорй скобки
                            if (!array_key_exists($alias, $arrJoin)) {
                                $table = $options[$alias][0];
                                $column = $options[$alias][1];
                                $outColumn = $options[$alias][2];
                                $arrJoin[$alias] = new Join($this->settings, 'inner', $table, $column, $outColumn);
                            }
                            $newAlias = $arrJoin[$alias]->getAlias();
                            // Если алиас у таблицы, скажем r (из $options), то при замене в переменной $wr[0], которая
                            // может принять значение "lower(r.verb_1)", замена будет в 3х местах (loweR(R.veRb_1)).
                            // Поэтому в замену включаем точку.
                            $wr[0] = preg_replace("/$alias\./", $newAlias . '.', $wr[0]);
                            $rez[] = $wr;
                        } else $rez[] = $wr;
                    } else $rez[] = $wr;
                }
            } else $rez[] = $wr;
        }
        foreach ($arrJoin as $al => $join) {
            $cJn->add($join);
        }
        return $rez;
    }
    // ---------- end whereWithJoin ----------



    // ---------- whereFromDetailedSearch (для плагина https://www.npmjs.com/package/detailed-search) ----------
    public function whereFromDetailedSearch($aliasWhere, $searchQuery, $aliasJoin = null, $options = null, $union = null, $whereMore = null)
    {
        if ($union && is_string($union)) $union = mb_strtolower(trim($union));
        $this->_validWhereFromDetailedSearch($aliasWhere, $searchQuery, $union, $whereMore);
        $where = new Where($this->settings);
        $arrWhere = [];
        foreach ($searchQuery as $sqBlock) {
            $arrWhere[] = $this->_dsLines($sqBlock);
        }
        $where->linkAnd($arrWhere);
        if ($aliasJoin && $options) {
            $this->whereWithJoin($aliasJoin, $options, $aliasWhere, $where, $union, $whereMore);
        } else {
            if (is_string($union)) {
                if ($union == 'and') $where->linkAnd([$where->getRaw(), $whereMore->getRaw()]);
                else $where->linkOr([$where->getRaw(), $whereMore->getRaw()]);
            }
            $this->where($aliasWhere, $where, $isWhere = true);
        }
        return $this;
    }

    private function _dsLines($sqBlock)
    {
        $where = new Where($this->settings);
        $arrWhere = [];
        foreach ($sqBlock as $sqLine) {
            $arrWhere[] = $this->_dsLogicalOperations($sqLine);
        }
        return $where->linkOr($arrWhere)->getRaw();
    }

    private function _dsLogicalOperations($sqLine)
    {
        $type = $sqLine['info']['type'];
        $column = $sqLine['info']['column'];
        $secondColumns = $sqLine['info']['secondColumns'];
        $objWhere = new Where($this->settings);
        // --- генерируем основную часть where ---
        $rawWhere = [$column];
        if ($type == 'text') {
            if (isset($sqLine['exclude'])) $rawWhere = $objWhere->notFlex($column, $sqLine['exclude']);
            else $rawWhere = $objWhere->flex($column, $sqLine['value']);
        } else {
            if (isset($sqLine['exclude'])) {
                $rawWhere[1] = ' <> ';
                $rawWhere[2] = $sqLine['exclude'];
            } else if (isset($sqLine['value'])) {
                $rawWhere[1] = ' = ';
                $rawWhere[2] = $sqLine['value'];
            } else if (isset($sqLine['start']) && isset($sqLine['end'])) {
                $rawWhere[1] = ' between ';
                // Если string, то считается что это дата и добавляется sql функция преобразования к дате
                $rawWhere[2] = $type == 'number' ? (int)$sqLine['start'] : (string)$sqLine['start'];
                $rawWhere[3] = $type == 'number' ? (int)$sqLine['end'] : (string)$sqLine['end'];
            } else {
                if (isset($sqLine['start'])) {
                    $rawWhere[1] = ' >= ';
                    $rawWhere[2] = $sqLine['start'];
                } else if (isset($sqLine['end'])) {
                    $rawWhere[1] = ' <= ';
                    $rawWhere[2] = $sqLine['end'];
                }
            }
        }
        // -----
        $arrWhere = [$rawWhere];
        if (isset($secondColumns) && count($secondColumns)) {
            foreach ($secondColumns as $cl => $val) {
                $arrWhere[] = [$cl, '=', $val];
            }
        }
        return $objWhere->linkAnd($arrWhere)->getRaw();
    }

    private function _validWhereFromDetailedSearch($aliasWhere, $searchQuery, $union, $whereMore)
    {
        if (!is_string($aliasWhere) || !is_array($searchQuery)) {
            throw new \Exception('Параметр aliasWhere должен быть строкой, а searchQuery должен быть массивом.');
        }
        if ($union) {
            if (!is_string($union) || !$this->isClass($whereMore, 'Where')) {
                throw new \Exception('Параметр whereMore должен быть экземпляром класса Where, а параметр union должен быть строкой.');
            }
            if (!($union == 'and' || $union == 'or')) throw new \Exception('union должна принимать значение либо OR либо AND');
        }
    }
    // ---------- end whereFromDetailedSearch ----------



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
            'type' => 'info',
            'sql' => $sql,
            'binds' => $binds,
            'timeQuery' => (microtime(true) - $timeStartQuery)
        ];
    }



    private function _error($ex, $sql, $binds)
    {
        $this->debugInfo[] = [
            'type' => 'error',
            'exception' => $ex,
            'sql' => $sql,
            'binds' => $binds
        ];
        throw new \Exception('Ошибка при обращении к БД, SQL: '. $sql);
    }

}
