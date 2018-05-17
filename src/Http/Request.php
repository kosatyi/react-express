<?php

namespace ReactExpress\Http;

use Psr\Http\Message\ServerRequestInterface;
use ReactExpress\Core\Model;
use WyriHaximus\React\Http\Middleware\SessionMiddleware;


/**
 * Class Request
 * @package ReactExpress\Http
 */
class Request extends Model
{

    private $session;
    /**
     * Request constructor.
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->session = $request->getAttribute(SessionMiddleware::ATTRIBUTE_NAME);
        $uri = $request->getUri();
        $this->attr('uri', (string) $uri);
        $this->attr('path', urldecode($uri->getPath()));
        $this->attr('host', urldecode($uri->getHost()));
        $this->attr('authority', urldecode($uri->getAuthority()));
        $this->attr('protocol', $uri->getScheme());
        $this->attr('port', $uri->getPort());
        $this->attr('method', $request->getMethod());
        $this->attr('cookies', $request->getCookieParams());
        $this->attr('headers', $request->getHeaders());
        $this->attr('query', $request->getQueryParams());
        $this->attr('data', $request->getParsedBody());
        $this->attr('files', $request->getUploadedFiles());
    }


    public function session(){
        return $this->session;
    }

}
