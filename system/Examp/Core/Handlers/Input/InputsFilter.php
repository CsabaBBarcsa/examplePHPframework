<?php
namespace Examp\Core\Handlers\Input;

class InputsFilter
{
    /**
     * @desc - check the $inData is empty
     * @param type $inData
     * @return boolean
     */
    public function require($inData)
    {
        if ( empty($inData))
            { return FALSE; }
        else //nem üres - tehát jó
            { return TRUE; }
    }

    /**
     * @desc - check the $inData is not grater than $maxLength
     * @param type $inData
     * @param type $maxLength
     * @return boolean
     */
    public function maxLength( string $inData, $maxLength )
    {
        return mb_strlen($inData, 'utf8') < $maxLength;
    }

    /**
     * @desc - check the $inData is not less than $minLength
     * @param type $inData
     * @param type $minLength
     * @return boolean
     */
    public function minLength( string $inData, $minLength )
    {
        return mb_strlen($inData, 'utf8') > $minLength;
    }

    /**
     * @desc - check the $inData is a valid email string
     * @param type $inData
     * @return boolean
     */
    public function email( string $inData)
    {
        if ( filter_var($inData, FILTER_VALIDATE_EMAIL) )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

}