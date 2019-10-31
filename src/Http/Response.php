<?php

namespace ReactExpress\Http;

use React\Http\Response as HttpResponse;
use React\Promise\Deferred;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use ReactExpress\Core\Model;

/**
 * Class Response
 * @package ReactExpress\Http
 */
class Response extends Model
{
    /**
     * @var Deferred
     */
    private $deferred;
    /**
     * @var int
     */
    private $status = 200;
    /**
     * @var array
     */
    private $headers = [];
    /**
     * @var string
     */
    private $content = '';
    /**
     * @var int
     */
    private $length = 0;
    /**
     * @var bool
     */
    private $headersSent = false;

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->deferred = new Deferred();
    }

    /**
     * @return Promise|PromiseInterface
     */
    public function promise()
    {
        return $this->deferred->promise();
    }
    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }
    /**
     * @param $code
     * @return $this
     */
    public function status( $code): self
    {
        $this->status = $code;
        return $this;
    }
    /**
     * @param string $content
     * @return $this
     */
    public function write(string $content = ''): self
    {
        $this->length += strlen($content);
        $this->content .= $content;
        return $this;
    }
    /**
     * @param string $content
     * @param int $code
     * @return Response
     */
    public function send(string $content = '', int $code = 200): self
    {
        $this->status($code);
        $this->header('Content-Type', 'text/html');
        $this->write($content);
        $this->end();
        return $this;
    }
    /**
     * @param $content
     * @param int $code
     * @return Response
     */
    public function json( $content , int $code = 200): self
    {
        $this->status($code);
        $this->header('Content-Type', 'application/json');
        $this->write(json_encode($content,JSON_PRETTY_PRINT));
        $this->end();
        return $this;
    }
    /**
     * @return Response
     */
    public function jsonData(): Response
    {
        return $this->json($this->all());
    }
    /**
     * @param $code
     * @param string $content
     * @return $this
     */
    public function sendStatus($code, string $content = ''): self
    {
        $this->status($code);
        $this->header('Content-Type', 'text/plain');
        $this->write($content);
        $this->end();
        return $this;
    }
    /**
     * @param string $url
     * @param int $code
     * @return $this
     */
    public function redirect(string $url = '', int $code = 303): self
    {
        $this->reset();
        $this->status($code);
        $this->header('Location', $url);
        $this->write($url);
        $this->end();
        return $this;
    }
    /**
     *
     */
    public function sendFile(): void
    {

    }
    /**
     * @return $this
     */
    public function reset(): self
    {
        $this->length  = 0;
        $this->content = '';
        $this->headers = [];
        $this->status  = 200;
        return $this;
    }
    /**
     *
     */
    public function end(): void
    {
        $this->sendHeaders();
        $response = new HttpResponse(
            $this->status,
            $this->headers,
            $this->content
        );
        $this->deferred->resolve($response);
    }
    /**
     *
     */
    public function sendHeaders(): void
    {
        if ($this->headersSent) {
            return;
        }
        if (!isset($this->headers['Content-Length'])) {
            $this->sendContentLengthHeaders();
        }
        $this->headersSent = true;
    }
    /**
     *
     */
    public function sendContentLengthHeaders(): void
    {
        $this->header('Content-Length', $this->length);
        if (!isset($this->headers['Content-Type'])) {
            $this->header('Content-Type', 'text/plain');
        }
    }
}