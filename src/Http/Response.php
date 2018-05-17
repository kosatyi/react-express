<?php

namespace ReactExpress\Http;

use React\Http\Response as HttpResponse;
use React\Promise\Deferred;
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
     * @return \React\Promise\Promise|\React\Promise\PromiseInterface
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
    public function header(string $name, string $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @param $code
     * @return $this
     */
    public function status( $code)
    {
        $this->status = $code;
        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function write(string $content = '')
    {
        $this->length += strlen($content);
        $this->content .= $content;
        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function send(string $content = '')
    {
        $this->reset();
        $this->header('Content-Type', 'text/html');
        $this->write($content);
        $this->end();
        return $this;
    }

    /**
     * @param $content
     * @return $this
     */
    public function json( $content )
    {
        $this->reset();
        $this->header('Content-Type', 'application/json');
        $this->write(json_encode($content,JSON_PRETTY_PRINT));
        $this->end();
        return $this;
    }

    /**
     * @return Response
     */
    public function jsonData()
    {
        return $this->json($this->all());
    }

    /**
     * @param $code
     * @param string $content
     * @return $this
     */
    public function sendStatus($code, string $content = '')
    {
        $this->reset();
        $this->header('Content-Type', 'text/plain');
        $this->status($code);
        $this->write($content);
        $this->end();
        return $this;
    }

    /**
     * @param string $url
     * @param int $code
     * @return $this
     */
    public function redirect(string $url = '', int $code = 303){

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
    public function sendFile()
    {

    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->length = 0;
        $this->content = '';
        $this->headers = [];
        $this->status = 200;
        return $this;
    }

    /**
     *
     */
    public function end()
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
    public function sendHeaders()
    {
        if ($this->headersSent) {
            return;
        }
        if (!isset($this->headers["Content-Length"])) {
            $this->sendContentLengthHeaders();
        }
        $this->headersSent = true;
    }

    /**
     *
     */
    public function sendContentLengthHeaders()
    {
        $this->header("Content-Length", $this->length);
        if (!isset($this->headers["Content-Type"])) {
            $this->header("Content-Type", "text/plain");
        }
    }
}