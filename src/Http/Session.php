<?php
namespace ReactExpress\Http;

use ReactExpress\Core\Model;

use Psr\Http\Message\ServerRequestInterface;
use WyriHaximus\React\Http\Middleware\Session as HttpSession;
use WyriHaximus\React\Http\Middleware\SessionMiddleware;

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
     * @param ServerRequestInterface $request
     */
    public function __construct( ServerRequestInterface $request ){
        $this->session = $request->getAttribute(SessionMiddleware::ATTRIBUTE_NAME );
        $this->data( $this->session->getContents() );
    }
    /**
     * @param $name
     * @param $params
     * @return mixed|null
     */
    public function __call($name, $params)
    {
        if ( $this->session && method_exists($this, $name) ) {
            return call_user_func_array([$this,$name],$params);
        }
        return null;
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
        $this->data( $this->session->getContents() );
        $result = parent::attr($keys,$value);
        $this->session->setContents( $this->all() );
        return $result;
    }
}