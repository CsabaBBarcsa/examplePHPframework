<?php
namespace Examp\Core;

use Examp\Core\Helpers\StringCleaner;

/**
 * Description of Url
 */
class Url
{
    /**
     * @desc - Get the domain with the http(s)
     * @return string
     */
    public function getBaseUrl(): string
    {
        $checkHttps = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https://' : 'http://';
        $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $pathInfo = pathinfo(filter_input(INPUT_SERVER, 'PHP_SELF'));
        return $host == 'localhost' ? $checkHttps.$host.$pathInfo['dirname'] : $checkHttps.$host;
    }

    /**
     * @desc - Get the full url
     * @return string
     */
    public function getFullUrl(): string
    {
        return $this->getBaseUrl().$this->getFullUri();
    }

    /**
     * @desc - Get the url without the domain
     * @return string
     */
    public function getFullUri(): string
    {
        return $this->getCleanedUri();
    }

    /**
     * @desc - Get examined URI
     * @return string
     */
    private function getCleanedUri(): string
    {
        $getUri = $_SERVER['REQUEST_URI'] ?? '/';
        $stringCleaner = new StringCleaner();

        $rtrimUri = $stringCleaner->setUncleanedData($getUri)->trimBothSides()->getCleanedData();
        if (empty($rtrimUri))
        {
            $rtrimUri = '/';
        }

        return $stringCleaner->setUncleanedData($rtrimUri)->htmlSpecial()->getCleanedData();
    }

}
