<?php

namespace WorkWechat\Template;

class Template implements \ArrayAccess
{
    public function __set($key, $value)
    {
        $this->$key = $value;
    }

    /**
     * toArray方法
     * @return array
     */
    public function toArray()
    {
        $arr = [];
        $vars = get_object_vars($this);
        foreach ($this as $key => $item) {
            $arr[$key] = $item;
        }
        return $arr;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {

        // TODO: Implement offsetExists() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        var_dump($offset);
        // TODO: Implement offsetGet() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}