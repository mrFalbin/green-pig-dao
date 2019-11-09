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
        $this->mergeMethod = trim($mergeMethod);
        $this->alias = $table .'_'. $this->genStr();
        $this->table = $table;
        $this->column = $column;
        $this->outColumn = $outColumn;
        $this->rawBasicIf = [$this->alias .'.'. $this->column, '=', 'sql' => $this->outColumn];
        parent::__construct($settings);
    }


    public function linkAnd($expression)
    {
        // $this->rawWhere = [$this->rawBasicIf, 'and', parent::linkAnd($expression)->getRaw()];
        parent::linkAnd([$this->rawBasicIf,
                         parent::linkAnd($expression)->getRaw()]);
        return $this;
    }


    public function linkOr($expression)
    {
        parent::linkOr([$this->$expression,
                        parent::linkOr($expression)->getRaw()]);
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