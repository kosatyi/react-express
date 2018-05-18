<?php

namespace ReactExpress\Http;

use Psr\Http\Message\ServerRequestInterface;
use ReactExpress\Core\Model;
use WyriHaximus\React\Http\Middleware\SessionMiddleware;
use WyriHaximus\React\Http\Middleware\Session as HttpSession;

/**
 * Class Request
 * @package ReactExpress\Http
 */
class Request extends Model
{
    /**
     * @var ServerRequestInterface
     */
    private $request;
    /**
     * @var mixed
     */
    private $session;
    /**
     * Request constructor.
     * @param ServerRequestInterface $request
     */
    public function __construct( ServerRequestInterface $request)
    {
        $this->request = $request;
        $this->setData();
        $this->setSession();
    }
    /**
     *
     */
    private function setData(){

        $uri = $this->request->getUri();

        $this->attr('uri', (string) $uri);
        $this->attr('path', urldecode($uri->getPath()));
        $this->attr('host', urldecode($uri->getHost()));
        $this->attr('authority', urldecode($uri->getAuthority()));
        $this->attr('protocol', $uri->getScheme());
        $this->attr('port', $uri->getPort());

        $this->attr('method', $this->request->getMethod());
        $this->attr('cookies', $this->request->getCookieParams());
        $this->attr('headers', $this->request->getHeaders());
        $this->attr('query', $this->request->getQueryParams());
        $this->attr('data', $this->request->getParsedBody());
        $this->attr('files', $this->request->getUploadedFiles());

    }
    private function setSession(){
        $session = $this->request->getAttribute(SessionMiddleware::ATTRIBUTE_NAME);
        $this->session = new Session( $session );
    }
    /**
     * @return HttpSession;
     */
    public function session(){
        return $this->session;
    }

}
