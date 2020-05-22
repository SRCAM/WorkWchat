<?php


namespace WorkWechat\Core\Interfaces;


use WorkWechat\Core\Collection;

abstract class Model extends Collection
{
    abstract public function bind(array $arr);
}