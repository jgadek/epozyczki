<?php

namespace App\ApiBundle\Utils;

class ApiEvent
{

    CONST STATUS_NEW = 1;
    CONST STATUS_PROCESS = 2;
    CONST STATUS_SUCCESS = 3;
    CONST STATUS_ERROR = 4;
    CONST STATUS_CLOSED = 5;
    
    protected $arrStatuses = array(
        self::STATUS_NEW,
        self::STATUS_PROCESS,
        self::STATUS_SUCCESS,
        self::STATUS_ERROR,
        self::STATUS_CLOSED,
    );

    private $status;
    private $arrData;
    private $httpStatus;
    private $apiKey;

    public function __construct()
    {
        $this->status = self::STATUS_NEW;
        $this->arrData = array();
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_OK;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    public function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;
    }

    public function getData()
    {
        return $this->arrData;
    }

    public function setData($arrData)
    {
        $this->arrData = $arrData;
    }
    
    public function appendToData($data)
    {
        if(is_array($data)) {
            array_merge_recursive($this->arrData, $data);
        } else {
            $this->arrData[] = $data;
        }
    }
    
    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

        
    public function checkApiKey($key)
    {
        if($key === $this->getApiKey()) {
            return true;
        }
//        return false;
        return true;
    }

    public function isHttpStatus($status)
    {
        return $status === $this->getHttpStatus();
    }
    
}
