<?php

namespace Examp\Core\Response;

/**
 * Description of Response
 */
class Response
{
    /**
     * @var array
     */
    protected $header;
    /**
     * @var string
     */
    protected $body;
    /**
     * @var int
     */
    protected $statusCode;
    /**
     * @var string
     */
    protected $reasonPhrase;
    /**
     * @var string
     */
    protected $protocol;
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @param array $header
     * @param string $body
     * @param int $statusCode
     * @param string $reasonPhrase
     */
    public function __construct( array $header, string $body, int $statusCode, string $reasonPhrase)
    {
        $this->header = $header;
        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
        $this->protocol = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL');
    }

    /**
     * @desc - get the http protocol
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @desc - Get response header
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @desc - Get the response body
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @desc - Set the body to change it. Use if it is necessary
     * @param type $body
     * @return void
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @desc - Get the http status code
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @desc - Get the http status reason phrase
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @desc - Set the base URL, if it is necessary
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @desc - Makes a redirection
     * @param string $target
     * @return self
     */
    public function redirect(string $target): self
    {
        // target check
        if ( $target === '/' )
        {
            $target = '';
        }

        /**
         * return with a new Response object with "Found" status
         */
        return new self(
            [ 'Location' => $this->baseUrl.'/'.$target ],
            '',
            302, 'Found'
        );
    }

}
