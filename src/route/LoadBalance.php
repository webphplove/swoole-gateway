<?php


namespace GateWay\route;


interface LoadBalance
{

    /**
     * 返回当前服务器组中下一个应该接受请求的机器地址
     * @param server 所有服务器列表
     * @param serverGroup 服务器组名称Rotation
     * @return 机器地址
     */
    public function get(array $server, string $serverGroup):string ;
}