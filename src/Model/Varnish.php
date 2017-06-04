<?php

namespace Snowdog\DevTest\Model;

class Varnish
{
    private $varnish_id;
    private $IP;
    private $user_id;

    public function __construct()
    {
        $this->varnish_id = intval($this->varnish_id);
        $this->user_id = intval($this->user_id);
    }

    /**
     * @return mixed
     */
    public function getVarnishId()
    {
        return $this->varnish_id;
    }

    /**
     * @return mixed
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}