<?php


namespace GateWay\route;


class Rotation implements LoadBalance
{
    public $serverFlag = [];
    public $serverAmount = [];

    /**
     * Rotation constructor.
     * @param array $server [string, List<String>]
     */
    public function __construct(array $server)
    {
        foreach ($server as $k => $v) {
            $this->serverFlag[$k] = 0;
            if (is_array($server[$k]))
                $this->serverAmount[$k] = count($server[$k]);
            else
                $this->serverAmount[$k] = 1;

        }
    }


    public function get(array $server, string $serverGroup): string
    {
        $index = $this->serverFlag[$serverGroup];
        $target = $server[$serverGroup][$index];
        $nextIndex = $this->serverFlag[$serverGroup] + 1;
        if ($nextIndex >= $this->serverAmount[$serverGroup]) {
            $nextIndex = 0;
        }
        $this->serverFlag[$serverGroup] = $nextIndex;
        return $target;
    }
}