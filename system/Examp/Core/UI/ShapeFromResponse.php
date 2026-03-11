<?php

namespace Examp\Core\UI;

/**
 * Description of ShapeFromResponse
 * It's style formatting the response message to a form
 */
class ShapeFromResponse
{
    const MESSAGE_TYPE = [
        'info' => 'msg-info',
        'warn' => 'msg-warn',
        'error'=> 'msg-error'
    ];

    protected $responseTextStock = [];
    protected $messageStock = [];
    protected $messageType = null;
    protected $responseMessageBox = '<div class="%s">%s</div>';

    public function __construct( $responseTextStock, string $msgType = null)
    {
        $this->messageType = $msgType ?? 'info';
        $this->responseTextStock = $this->storeMessageToShape($responseTextStock);
    }

    /**
     * @desc - Get the processed text
     * @return string
     */
    public function getShapedMessage()
    {
        $warpperContainer = '<div class="msg-wrapper">';

        $warpperContainer .= $this->shapeMessage();

        $warpperContainer .= '</div>';

        return $warpperContainer;
    }

    /**
     * @desc - Store the incoming data to further process
     * @param type $responseTextData
     * @return array
     */
    protected function storeMessageToShape($responseTextData): array
    {
        $messageStock = [];

        if (!empty($responseTextData))
        {
            if ( !is_array($responseTextData))
            {
                $messageStock[$this->messageType] = $responseTextData;
            }
            else
            {
                $messageStock = $responseTextData;
            }
        }
        return $messageStock;
    }

    /**
     * @desc - Format the stored text data into proper string
     * @return string
     */
    protected function shapeMessage(): string
    {
        $formatedMessages = '';

        foreach ($this->responseTextStock as $msgType => $respTexts)
        {
            if (is_array($respTexts))
            {
                foreach ($respTexts as $respText)
                {
                    $formatedMessages .= sprintf($this->responseMessageBox, self::MESSAGE_TYPE[$msgType], $respText);
                }
            }
            else
            {
                $formatedMessages .= sprintf($this->responseMessageBox, self::MESSAGE_TYPE[$msgType], $respTexts);
            }
        }

        return $formatedMessages;
    }

}
