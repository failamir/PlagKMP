<?php

namespace App\Http\Controllers;

class KMPPrefix
{
    public $P;
    public $str;
    public $len;

    public function __construct()
    {

    }

    /**
     * @param mixed $len
     */
    public function setLen($len)
    {
        $this->len = $len;
    }

    /**
     * @param mixed $P
     */
    public function setP($P)
    {
        $this->P = $P;
    }

    /**
     * @param mixed $str
     */
    public function setStr($str)
    {
        $this->str = $str;
    }

    /**
     * @return mixed
     */
    public function getLen()
    {
        return $this->len;
    }

    /**
     * @return mixed
     */
    public function getP()
    {
        return $this->P;
    }

    /**
     * @return mixed
     */
    public function getStr()
    {
        return $this->str;
    }

}
