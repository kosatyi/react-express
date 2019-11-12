<?php

namespace ReactExpress\Core;

class Config extends Model {
    /**
     * @param $keys
     * @param $value
     * @return $this
     */
    public function set($keys,$value): self
    {
        $this->attr($keys,$value);
        return $this;
    }
    /**
     * @param $keys
     * @param null $default
     * @return $this|array|mixed|null
     */
    public function get($keys,$default=null)
    {
        $value = $this->attr($keys);
        if($value === null){
            return $default;
        }
        return $value;
    }
    public function load(): void
    {

    }
}