<?php


namespace GateWay\filter;



use GateWay\http\Request;

interface RequestFilter
{
    public function filter(Request $request);
}