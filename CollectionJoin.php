<?php
namespace GreenPigDAO;


class CollectionJoin
{
    use BaseFunctions;

    private $collection = [];
    private $sql;
    private $bind;
    private $settings;


    public function __construct($settings) {
        $this->settings = $settings;
    }


    public function addNew($mergeMethod, $table, $column, $outColumn)
    {
        $join = new Join($this->settings);
        $join->init($mergeMethod, $table, $column, $outColumn);
        $this->collection[$join->getAlias()] = $join;
        return $join->getAlias();
    }


    public function add($join)
    {
        $this->collection[$join->getAlias()] = $join;
        return $join->getAlias();
    }


    public function get($alias)
    {
        return $this->collection[$alias];
    }


    public function getAll()
    {
        return $this->collection;
    }


    public function getAllAlias()
    {
        return array_keys($this->collection);
    }


    public function getSql()
    {
        return $this->sql;
    }


    public function getBind()
    {
        return $this->bind;
    }


    public function remove($alias)
    {
        // isset не отрабатывает в случае null
        if(array_key_exists($alias, $this->collection)) unset($this->collection[$alias]);
        return $this;
    }


    public function generate()
    {
        $this->sql = '';
        $this->bind = [];
        foreach ($this->collection as $join) {
            $this->sql .= " {$join->generate()->getSql()}  ";
            $this->bind = array_merge($this->bind, $join->getBind());
        }
        return $this;
    }

}