<?php

namespace Examp\Core\Response;

use Exception;

/**
 * Description of ResponseEmitter
 */
class ResponseEmitter
{
    /**/
    public function emit(Response $response)
    {
        if( headers_sent() )
        {
            throw new Exception("The header is already sent!");
        }

        $this->setStatusLine( $response->getProtocol(), $response->getStatusCode(), $response->getReasonPhrase());

        $this->setHeader($response->getHeader());

        $this->emitBody( $response->getBody() );
    }

    /**/
    protected function setStatusLine($protocol, $statusCode, $reasonPhrase)
    {
        $status = sprintf('%s %d %s', $protocol, $statusCode, $reasonPhrase);
        header($status, TRUE, $statusCode);
    }

    /**/
    protected function setHeader(array $headers)
    {
        foreach($headers as $name => $value)
        {
            header( sprintf('%s: %s', $name, $value), FALSE);
        }
    }

    /**/
    protected function emitBody(string $bodyContent)
    {
        echo $bodyContent;
    }

}
