<?php


namespace GateWay\Filter;


use Swoole\Http\Response;

interface ResponseFilter
{
    public function filter(Response $response);
}