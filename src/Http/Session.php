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
     * @param $session
     */
    public function __construct( $session ){
        $this->session = $session;
        $this->data($this->session->getContents());
    }
    /**
     * @return $this
     */
    public function start(): self
    {
        $this->session->begin();
        return $this;
    }
    /**
     * @return $this
     */
    public function end(): self
    {
        $this->session->end();
        return $this;
    }
    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->session->isActive();
    }
    /**
     * @param $keys
     * @param null $value
     * @return $this|array|mixed|null
     */
    public function attr($keys, $value = null){
        if(!$this->isActive()) {
            $this->start();
        }
        $this->data($this->session->getContents());
        $result = parent::attr($keys,$value);
        $this->session->setContents($this->all());
        return $result;
    }
}