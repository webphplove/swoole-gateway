<?php

namespace GateWay\Filter;


use GateWay\http\Request;
use Swoole\Http\Response;

class Filter
{

    static public $instance = null;

    /**
     * Request过滤操作链
     */
    private $requestFrontFilterList = array();
    /**
     * Response过滤操作链
     */
    private $responseBackendFilters = array();

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Filter();
        }
        return self::$instance;
    }

    public function requestProcess(Request $request)
    {
        /**
         * @var RequestFilter $filter
         */
        foreach ($this->requestFrontFilterList as $filter) {
            $filter->filter($request);
        }
    }


    public function responseProcess(Response $request)
    {
        /**
         * @var ResponseFilter $filter
         */
        foreach ($this->responseBackendFilters as $filter) {
            $filter->filter($request);
        }
    }


    public function registerRequestFrontFilter(RequestFilter $requestFrontFilter)
    {
        $this->requestFrontfilterList[] = $requestFrontFilter;
    }

    public function registerResponseBackendFilter(ResponseFilter $responseBackendFilter)
    {
        $this->responseBackendFilters[] = $responseBackendFilter;
    }

    public function getRequestFrontFilterList(): array
    {
        return $this->requestFrontFilterList;
    }

    public function getResponseBackendFilters(): array
    {
        return $this->responseBackendFilters;
    }
}