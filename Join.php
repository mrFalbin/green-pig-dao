<?php
namespace GreenPigDAO;



class Join extends Where
{
    private $alias;
    private $table;
    private $column;
    private $outColumn;
    private $rawBasicIf;
    private $mergeMethod;


    public function __construct($settings, $mergeMethod, $table, $column, $outColumn)
    {
        $mm = mb_strtolower(trim($mergeMethod));
        if (!($mm == 'inner' || $mm == 'left' || $mm == 'right' || $mm == 'full' || $mm == 'cross')) {
            throw new \Exception('mergeMethod может принимать только одно из следующих значений: inner, left, right, full, cross');
        }
        $this->mergeMethod = $mm;
        $this->alias = $table .'_'. $this->genStr();
        $this->table = $table;
        $this->column = $column;
        $this->outColumn = $outColumn;
        $this->rawBasicIf = [$this->alias .'.'. $this->column, '=', 'sql' => $this->outColumn];
        parent::__construct($settings);
    }


    public function linkAnd($expression)
    {
        parent::linkAnd([$this->rawBasicIf, parent::linkAnd($expression)->getRaw()]);
        return $this;
    }


    public function linkOr($expression)
    {
        parent::linkOr([$this->$expression, parent::linkOr($expression)->getRaw()]);
        return $this;
    }


    public function generate()
    {
        if (!$this->rawWhere) {
            $this->rawWhere = [$this->rawBasicIf];
        }
        parent::generate();
        return $this;
    }


    public function getAlias()
    {
        return $this->alias;
    }


    public function getSql()
    {
        return " {$this->mergeMethod} JOIN {$this->table} {$this->alias} ON {$this->sql}";
    }

}