<?php

require './vendor/autoload.php';

use GateWay\env\Env;
use Swoole\Coroutine;
use Swoole\Http\Request as CoRequest;
use GateWay\http\Request;
use GateWay\route\RouteTable;
use GateWay\Filter\Filter;


RouteTable::getInstance()->initTable();
Filter::getInstance();

//use Request
//高性能HTTP服务器
$http = new Swoole\Http\Server("127.0.0.1", 9501);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on('WorkerStart', function (){

});


$http->on("request", function (CoRequest $coRequest, Swoole\Http\Response $response) {

    $request = Request::new($coRequest);


    $targetUrl = RouteTable::getInstance()->getTargetUrl($request->getUriPath());


    Filter::getInstance()->requestProcess($request);

    Coroutine::create(function () use ($request, $response, $targetUrl) {

        $url = parse_url($targetUrl);
        $ssl = $url['scheme'] === 'https';

        $cli = new Swoole\Coroutine\Http\Client($url['host'], $ssl? 443: 80, $ssl);
        $cli->get($request->getUriPath());
        $cli->setCookies($request->getCookieParams());
        $cli->setMethod($request->getMethod());
        $cli->close();

        Filter::getInstance()->responseProcess($response);
        $response->header = $cli->getHeaders();
        $response->setStatusCode($cli->statusCode);
        $response->end($cli->body);
    });
});

$http->start();


