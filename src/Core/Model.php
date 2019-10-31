<?php

namespace ReactExpress\Core;

use JsonSerializable;
use Serializable;

/**
 * Class Model
 * @package ReactExpress\Core
 */
class Model implements JsonSerializable, Serializable
{
    /**
     *
     */
    protected const SEPARATOR = '.';
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
     * @return bool
     */
    public function __isset($key)
    {
        return false;
    }
    /**
     * @param $key
     */
    public function __get($key)
    {

    }

    /**
     * @param $path
     * @return array|mixed
     */
    private function path($path)
    {
        $parts = array_filter(explode(static::SEPARATOR, (string)$path), 'strlen');
        $parts = array_reduce($parts, static function ($a, $v) {
            $a[] = ctype_digit($v) ? (int)$v : $v;
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
        $getter = func_num_args() === 1;
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
        } else if($value === null){
            unset($copy);
        } else {
            $copy = $value;
        }
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function data(array $data = []): self
    {
        $this->__data__ = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->__data__;
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize($this->__data__);
    }

    /**
     * @param string $data
     */
    public function unserialize($data): void
    {
        $this->__data__ = unserialize( $data , [ 'allowed_classes' => false ]);
    }
    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->__data__;
    }
}