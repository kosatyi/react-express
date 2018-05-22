<?php

namespace ReactExpress\Core;

class Config extends Model {
    /**
     * @param $keys
     * @param $value
     * @return $this
     */
    public function set($keys,$value){
        $this->attr($keys,$value);
        return $this;
    }
    /**
     * @param $keys
     * @param null $default
     * @return $this|array|mixed|null
     */
    public function get($keys,$default=null){
        $value = $this->attr($keys);
        if(is_null($value)) return $default;
        return $value;
    }
}