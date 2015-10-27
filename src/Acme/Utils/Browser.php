<?php

namespace Acme\Utils;

use Symfony\Component\HttpFoundation\Request;
use App\GuardBundle\Entity\GuardUser;
use Acme\Utils\BuilderQuery;
use Doctrine\ORM\EntityManager;

abstract class Browser
{

    protected $objSortForm;
    protected $objFilterForm;
    protected $request;
    protected $objUser;
    protected $page;
    protected $order;
    protected $dir;
    protected $arrFields = array();
    protected $fields;
    protected $route_part;
    protected $builder;
    protected $arrResult = array();
    protected $limit;

    public function __construct(Request $request, GuardUser $objUser = null, EntityManager $em)
    {
        $this->request = $request;
        $this->objUser = $objUser;
        $this->page = (int) $request->get('page') > 0 ? (int) $request->get('page') : 1;
        $this->order = $request->get('order');
        $this->dir = $request->get('dir');
        $this->limit = $this->getLimit();
        $this->fields = $request->get('fields');
        $arrFields = explode('&', $this->fields);
        if (count($arrFields) && $arrFields[0] !== '') {
            foreach ($arrFields as $value) {
                $arrField = explode('=', $value);
                if (count($arrField)) {
                    $this->arrFields[$arrField[0]] = $arrField[1];
                }
            }
        }
        $this->builder = new BuilderQuery($em);
    }

    /**
     * 
     * @return \Doctrine\ORM\Query
     */
    public function getQuery()
    {
        $objSortForm = $this->getSortForm();
        $this->builder->setOrderBy($objSortForm->getSortToQuery());
        return $this->builder->getQuery();
    }

    public function getCount()
    {
        return $this->builder->getCount();
    }

    public function addContidion($string)
    {
        $this->builder->addCondition($string);
    }

    public function generateQuery($mainQuery)
    {
        $this->builder->generateQuery($mainQuery);
    }

    public function getRequest()
    {
        return $this->request;
    }

    protected function setSortForm(Form\SortForm $objSortForm)
    {
        $this->objSortForm = $objSortForm;
    }

    protected function setFilterForm(Form\FilterForm $objFilterForm)
    {
        $this->objFilterForm = $objFilterForm;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPages()
    {
        return ceil($this->getCount() / $this->getLimitToQuery());
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getDir()
    {
        return $this->dir;
    }

    public function getFieldsArray()
    {
        return $this->arrFields;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getSortForm()
    {
        return $this->objSortForm;
    }

    public function getFilterForm()
    {
        return $this->objFilterForm;
    }

    public function generateResult()
    {
        $page = $this->getPage();
        $limit = $this->getLimitToQuery();
        $offset = ($page - 1) * $limit;
        $this->arrResult = $this
                ->getQuery()
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->getResult();
    }

    public function getResults()
    {
        return $this->arrResult;
    }
    
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }
    
    public function getLimitToQuery()
    {
        return $this->limit;
    }

    abstract function getLimit();
}
