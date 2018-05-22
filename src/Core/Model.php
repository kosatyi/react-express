<?php

namespace ReactExpress\Core;

/**
 * Class Model
 * @package ReactExpress\Core
 */
class Model implements \JsonSerializable, \Serializable
{

    /**
     *
     */
    const SEPARATOR = '.';

    /**
     * @var array
     */
    private $__data__ = [];

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {

    }

    /**
     * @param $key
     */
    public function __get($key)
    {

    }

    /**
     * @param $path
     * @return array|mixed|strlen
     */
    private function path($path)
    {
        $parts = array_filter(explode(static::SEPARATOR, (string)$path), 'strlen');
        $parts = array_reduce($parts, function ($a, $v) {
            $a[] = ctype_digit($v) ? intval($v) : $v;
            return $a;
        }, []);
        return $parts;
    }

    /**
     * @param $keys
     * @param null $value
     * @return $this|array|mixed|null
     */
    public function attr($keys, $value = null)
    {
        $getter = func_num_args() == 1;
        if (is_string($keys)) {
            $keys = $this->path($keys);
        }
        if ( $getter ) {
            $copy = $this->__data__;
        } else {
            $copy =& $this->__data__;
        }
        while (count($keys)) {
            if ($copy instanceof $this) {
                return $copy->attr($keys, $value);
            }
            if (is_callable($copy)) {
                return $copy($keys, $value);
            }
            $key = array_shift($keys);
            if (is_object($copy)) {
                $copy =& $copy->{$key};
            } else {
                $copy =& $copy[$key];
            }
        }
        if ( $getter ) {
            return $copy;
        }
        if (is_callable($copy)) {
            $copy($value);
        } else {
            if(is_null($value)){
                unset($copy);
            } else {
                $copy = $value;
            }
        }
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function data(array $data = [])
    {
        $this->__data__ = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->__data__;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize($this->__data__);
    }

    /**
     * @param string $data
     */
    public function unserialize($data)
    {
        $this->__data__ = unserialize($data);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->__data__;
    }

}