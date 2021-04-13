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
    /**
     * @var ServerRequestInterface
     */
    private $request;
    /**
     * Request constructor.
     * @param ServerRequestInterface $request
     */
    public function __construct( ServerRequestInterface $request)
    {
        $this->request = $request;
        $this->setData();
    }
    /**
     *
     */
    private function setData(): void
    {
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
}
