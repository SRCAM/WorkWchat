<?php


namespace WorkWechat\Core;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use think\contract\Arrayable;
use IteratorAggregate;
use JsonSerializable;
use Serializable;
use Traversable;

class Collection implements ArrayAccess,Countable,IteratorAggregate,JsonSerializable,Serializable,Arrayable
{


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

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        // TODO: Implement count() method.
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}