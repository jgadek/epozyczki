<?php

namespace Acme\Utils;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class BuilderQuery
{

    protected $arrConditions = array();
    protected $orderBy = '';
    protected $limit = '';
    protected $mainQuery = '';
    protected $em;
    protected $count = null;
    protected $query = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * 
     * @return \Doctrine\ORM\Query
     */
    public function getQuery()
    {
        if($this->query !== null) {
            return $this->query;
        }
        $strQuery = $this->mainQuery;
        $glue = 'WHERE';
        foreach ($this->arrConditions as $value)
        {
            $strQuery .= ' '.$glue.' '.$value;
            $glue = 'AND';
        }
        $strQuery .= ' ORDER BY '.$this->orderBy;
        $this->query = $this->em->createQuery($strQuery);
        return $this->query;
    }
    
    public function getCount()
    {
        if($this->count !== null) {
            return $this->count;
        }
        $strQuery = $this->mainQuery;
        $alias = trim(preg_replace("/^SELECT/", '\\1', trim($strQuery)));
        $alias = trim(preg_replace('/ .+/', '', $alias));
        preg_match('/^[A-Za-z].*$/', $alias, $arrM);
        $alias = $arrM[0];
        preg_match('/FROM.+/', $strQuery, $arrMatches);
        $strQuery = 'SELECT COUNT('.$alias.') ' . $arrMatches[0] . ' ';
        $glue = 'WHERE';
        foreach ($this->arrConditions as $value)
        {
            $strQuery .= ' '.$glue.' '.$value;
            $glue = 'AND';
        }
        $this->count = $this->em->createQuery($strQuery)->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_SINGLE_SCALAR);
        return $this->count;
    }

    public function generateQuery($mainQuery)
    {
        $this->mainQuery = $mainQuery;
    }
    
    public function addCondition($strCondition)
    {
        $this->arrConditions[] = $strCondition;
    }
    
}
