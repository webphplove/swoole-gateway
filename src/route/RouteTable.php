<?php


namespace GateWay\route;


class RouteTable
{
    private static $instance;


    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    private $table = [];
    private $server = [];
    private $route = [];
    /**
     * 负载均衡：轮询算法
     * @var Rotation $rotationBalance
     */
    private $rotationBalance;

    public function initTable()
    {
        $config = include  __DIR__ . '/../config/config.php';
        $this->server =(array) $config['server'];
        $this->route = $config['route'];
        $this->rotationBalance = new Rotation($this->server);
    }

    public function getTargetUrl(string $url)
    {
        foreach ($this->route as $k => $v) {
            $source = $v['source'];
            $index = strpos($url, $source);
            if ($index === 0) {
                // 获取负载均衡后的服务器目标地址
                $target = $this->rotationBalance->get($this->server, $v['target']);
                return $target . substr($url, strlen($target));
            }
        }
        return $this->server['default'] . $url;
    }
}