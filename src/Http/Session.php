<?php

namespace ReactExpress\Http;

use ReactExpress\Core\Model;

use WyriHaximus\React\Http\Middleware\Session as HttpSession;

/**
 * Class Session
 * @package ReactExpress\Http
 */
class Session extends Model {
    /**
     * @var HttpSession
     */
    private $session;
    /**
     * Session constructor.
     * @param HttpSession $session
     */
    public function __construct(HttpSession $session ){
        $this->session = $session;
        $this->data($this->session->getContents());
    }
    /**
     * @return $this
     */
    public function start(){
        $this->session->begin();
        return $this;
    }
    /**
     * @return $this
     */
    public function end(){
        $this->session->end();
        return $this;
    }
    /**
     * @return bool
     */
    public function isActive(){
        return $this->session->isActive();
    }
    /**
     * @param $keys
     * @param null $value
     * @return $this|array|mixed|null
     */
    public function attr($keys, $value = null){
        if(!$this->isActive()) $this->start();
        $this->data($this->session->getContents());
        $getter = func_num_args() == 1;
        if($getter){
            $result = parent::attr($keys);
        } else {
            parent::attr($keys,$value);
            $this->session->setContents($this->all());
            $result = $this;
        }
        return $result;
    }
}