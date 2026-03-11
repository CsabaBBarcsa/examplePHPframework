<?php
namespace Examp\Core\Handlers\Input;

use Examp\Core\Helpers\StringCleaner;
use Exception;
/**
 * Description of InputCleaner
 */
class InputCleaner
{
    public function __construct(){}

    /**/
    public function cleaningData($dataToClean)
    {
        $stringCleaner = new StringCleaner();

        return $stringCleaner->setUncleanedData($dataToClean)->trimBothSides()
            ->htmlSpecial()
            ->stripTags()
            ->getCleanedData();
    }

    /**/
    public function cleanOne( $dataToClean )
    {
        if ( is_scalar($dataToClean) )
        {
            return $this->cleaningData($dataToClean);
        }
        else
        {
            throw new Exception("The input data to clean is not scalar!");
        }
    }

    /**/
    public function cleanAll($dataToClean)
    {
        $retVal = [];
        if ( is_array($dataToClean) && $dataToClean !== [] ) {
            foreach ($dataToClean as $uncleanKey => $unclean)
            {
                if (is_array($unclean))
                {
                    $retVal [$uncleanKey] = $this->cleanAll($unclean);
                }
                else
                {
                    $retVal [$uncleanKey] = $this->cleaningData($unclean);
                }
            }
            return $retVal;
        }
        else
        {
            throw new \Exception("The array to clean is empty!");
        }
    }

}
