<?php
namespace GreenPigDAO;



class Where
{
    use BaseFunctions;


    protected $settings;
    protected $rawWhere = [];
    protected $sql = '';
    protected $bind = [];


    public function __construct($settings) {
        $this->settings = $settings;
    }


    /**
     * Получить where запрос представленный в виде массива
     * @return array
     */
	public function getRaw()
    {
    	return $this->rawWhere;
    }


    public function setRaw($raw)
    {
        $this->rawWhere = $raw;
        return $this;
    }


    public function getSql()
    {
        return $this->sql;
    }


    public function getBind()
    {
        return $this->bind;
    }


    /**
     *
     * @param $expression
     * @return $this
     */
    public function linkAnd($expression)
    {
    	$this->_expression('and', $expression);
    	return $this;
    }


    public function linkOr($expression)
    {
    	$this->_expression('or', $expression);
    	return $this;
    }


	private function _expression($union, $expression) {
		if (!is_array($expression) || count($expression) === 0) throw new \Exception('Неверный операнд.');
    	if (is_string($expression[0])) {
    		$this->rawWhere = [$expression];
    	} else {
			$this->rawWhere = [];
			$count = count($expression);
			for ($i = 0; $i < $count; $i++) {
				if ($i < ($count-1)) {
					$this->rawWhere[] = $expression[$i];
					$this->rawWhere[] = $union;
				} else $this->rawWhere[] = $expression[$i];
			}
    	}
	}


	public function fullFlex($column, $value)
	{
		return $this->flex($column, "*$value*");
	}


    public function flex($column, $value)
    {
        return $this->_flex($column, $value, false);
    }


    public function notFlex($column, $value)
    {
        return $this->_flex($column, $value, true);
    }


    private function _flex($column, $value, $isNot)
    {
        $not = $isNot ? ' not ' : '';
        $value = $this->repStar($value);
        $alias = 'al_where_'.  $this->genStr();
        return [
            "LOWER($column)",
            "$not like",
            'sql'  => "LOWER(:$alias)",
            'bind' => ["$alias" => $value]
        ];
    }



    /**
    * Заменяются * на %, причем можно экранировать \*, тогда * не заменяются.
    * @param $str
    * @return mixed
    */
    public function repStar($str)
    {
        $str = ''. $str;
        $str = str_replace('\*', '|-=star=-|', $str);
        $str = str_replace('*', '%', $str);
        $str = str_replace('|-=star=-|', '*', $str);
        return $str;
    }


    public function generate()
    {
        $this->bind = [];
        $this->sql = '';
        $this->_genWhere($this->rawWhere);
        return $this;
    }


   // -------------------------------- Вспомогательные приватные функции для genWhere ---------------------------------
   private function _genWhere($rawWhere)
   {
   		foreach ($rawWhere as $el) {
   			$typeEl = $this->_identifyTypeElement($el);
   			if ($typeEl == 'expression') {
				$this->sql .= $this->_genSql($el);
   			} else if ($typeEl == 'brackets') {
				$this->sql .= ' (';
		        $this->_genWhere($el);
	            $this->sql .= ') ';
   			} else $this->sql .= " $typeEl ";  // or and
   		}
   }


   private function _genSql($element)
   {
        $sql = '';
        $sql .=  " {$element[0]} "; // 1ый операнд
        $sql .=  " {$element[1]} "; // 2ой операнд
        // ------- 3ий операнд -------
        // Вставляем sql без обработки
        if (isset($element['sql'])) {
            $sql .=  " {$element['sql']} ";
        }
        else {
            $value = $element[2];
            // для between
            $isBetween = stripos($element[1], 'between') !== false;
            if ($isBetween) {
                $start = $element[2];
                $end = $element[3];
                $aliasStart = 'al_where_'.  $this->genStr();
                $aliasEnd = 'al_where_'.  $this->genStr();
                if(is_string($start) && is_string($end)) {
                    $sql .= ' '. $this->strToDate(":$aliasStart") .' and '.
                                 $this->strToDate(":$aliasEnd") . ' ';
                }
                else $sql .=  " :$aliasStart and :$aliasEnd ";
                $this->bind[$aliasStart] = $start;
                $this->bind[$aliasEnd] = $end;
            // для случая in
            } else if (is_array($value)) {
                 $sql .= ' (';
                 $i = 0;
                    foreach ($value as $val) {
                        $alias = 'al_where_'.  $this->genStr();
                        if ($i++) $sql .= ', ';
                        $sql .=  " :$alias ";
                        $this->bind[$alias] = $val;
                    }
                $sql .= ') ';
            // для обычного случая
            } else  {
                $alias = 'al_where_'.  $this->genStr();
                $this->bind[$alias] = $value;
                $sql .=  " :$alias ";
            }

        }
        if (isset($element['bind']) && is_array($element['bind'])) $this->bind = array_merge($this->bind, $element['bind']);
        return $sql;
   }


   private function _identifyTypeElement($element)
   {
       $kindElement = false;
       if (is_array($element)) {
           if (is_array($element[0])) $kindElement = 'brackets';
           else $kindElement = 'expression';
       } else if (is_string($element)) {
           if (trim(mb_strtolower($element)) == 'or') $kindElement = 'or';
           else if (trim(mb_strtolower($element)) == 'and') $kindElement = 'and';
       }
       if (is_object($element)) {
           throw new \Exception("Ошибка в построении запроса. Работа с объектом недопустима, 
           необходимо использовать функцию getRaw для получения сырых данных.");
       }
       if ($kindElement) return $kindElement;
       else throw new \Exception('Ошибка в построении запроса.');
   }

}