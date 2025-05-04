<?php

namespace Examp\Core\Helpers;

/**
 * Description of StringCleaner
 */
class StringCleaner
{
    protected $cleanedData = null;
    protected $uncleanedData;

    public function __construct() {}

    /**/
    public function setUncleanedData( string $uncleandData ): self
    {
        $this->uncleanedData = $uncleandData;
        return $this;
    }

    /**/
    public function getCleanedData (): string
    {
        return $this->cleanedData;
    }

    /**/
    public function rtrimForvardSlashs(): self
    {
        $this->cleanedData = rtrim( $this->uncleandDataChecker(), '/');
        return $this;
    }

    /**/
    public function trimBothSides(): self
    {
        $this->cleanedData = trim( $this->uncleandDataChecker() );
        return $this;
    }

    /**/
    public function stripTags(): self
    {
        $this->cleanedData = strip_tags( $this->uncleandDataChecker() );
        return $this;
    }

    /**/
    public function htmlSpecial(): self
    {
        $this->cleanedData = htmlspecialchars( $this->uncleandDataChecker(), ENT_QUOTES, 'UTF-8' );
        return $this;
    }

    /**/
    protected function uncleandDataChecker(): string
    {
        return $this->cleanedData !== null
                    ? $this->cleanedData
                    : $this->uncleanedData;
    }

}