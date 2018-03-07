<?php

namespace ReactExpress\Http;

use Psr\Http\Message\ServerRequestInterface;

use ReactExpress\Core\Model;

/**
 * Class Request
 * @package ReactExpress\Http
 */
class Request extends Model
{

    /**
     * Request constructor.
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $uri = $request->getUri();
        $this->attr('path', urldecode($uri->getPath()));
        $this->attr('host', urldecode($uri->getHost()));
        $this->attr('authority', urldecode($uri->getAuthority()));
        $this->attr('protocol', $uri->getScheme());
        $this->attr('port', $uri->getPort());
        $this->attr('method', $request->getMethod());
        $this->attr('headers', $request->getHeaders());
        $this->attr('query', $request->getQueryParams());
        $this->attr('data', $request->getParsedBody());
        $this->attr('files', $request->getUploadedFiles());
    }

}
