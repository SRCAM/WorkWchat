<?php


namespace WorkWechat\Core;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use JsonSerializable;
use Serializable;
use think\helper\Arr;
use Traversable;
use WorkWechat\Core\Interfaces\Arrayable;

/**
 * Class Collection
 * @package WorkWechat\Core
 */
class Collection implements ArrayAccess, Countable, IteratorAggregate, JsonSerializable, Serializable, Arrayable
{
    protected $data = [];
    /**
     * Collection constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $kay => $value) {
            $this->set($kay, $value);
        }
    }

    public function convertToArray($items)
    {
        if ($items instanceof self) {
            return $items->all();
        }
        return (array)$items;
    }

    /**
     * 获取全部数据
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * 设置数据
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        Arr::set($this->data, $key, $value);
    }

    /**
     * 获取单个数据
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * 获取对应的值日
     * @param array $keys 需要查询的数据
     * @return Collection
     */
    public function only(array $keys)
    {
        $return = [];
        foreach ($keys as $key) {
            $value = $this->get($key);
            if (!is_null($value)) {
                $return[$key] = $value;
            }
        }
        return new static($return);
    }

    /**
     * @param $keys
     * @return Collection
     */
    public function except(array $keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();
        return new static(Arr::except($this->data, $keys));
    }

    /**
     * 合并
     * @param $items
     * @return Collection
     */
    public function merge($items)
    {
        $clone = new static($this->all());
        foreach ($items as $key => $value) {
            $clone->set($key, $value);
        }
        return $clone;
    }

    /**
     * 查询是否存在
     * @param Collection|array $key
     * @return bool
     */
    public function has($key)
    {
        return !is_null(Arr::get($this->data, $key));
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return reset($this->data);
    }

    /**
     * @return mixed
     */
    public function last()
    {
        $end = end($this->data);
        reset($this->data);
        return $end;
    }

    /**
     * @param $key
     */
    public function forget($key)
    {
        Arr::forget($this->data, $key);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $this->data);
    }

    /**
     * 转为数组
     * @param int $option
     * @return false|string
     */
    public function toJSon($option = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($this->all(), $option);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $this->forget($offset);
        }
    }

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->data);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        return $this->data = unserialize($serialized);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return $this->toJSon();
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    /**
     * @param $key
     */
    public function __unset($key)
    {
        $this->forget($key);
    }

}