<?php

namespace Examp\Core\Handlers\Input;

use Examp\Core\Handlers\Input\InputsFilter;
use Examp\Core\Handlers\Input\InputCleaner;
use Examp\Core\Request\Request;
use Exception;

class InputsManager
{
    const POST = "post";
    const GET = "get";
    const FILTER_OPTION_DIVIDER = ":";
    const FILTERS_DIVIDER = "|";

    private $filters = [];
    private $request;

    public function __construct( Request $request )
    {
        $this->request = $request;
    }

    public function getPost(string $indexName = NULL)
    {
        $postRequests = $this->request->getReqestedParams()[self::POST];
        return $this->getRequestParams($postRequests, $indexName);
    }

    public function getGet(string $indexName = NULL)
    {
        $getRequests = $this->request->getReqestedParams()[self::GET];
        return $this->getRequestParams($getRequests, $indexName);
    }

    /**
     * @desc - check the POST data with the specific InputCheck method
     * @param type $inputName
     * @param type $filters
     * @return boolean|$this
     */
    public function setFilter(string $inputName, string $filters)
    {
        if ( $filters === '')
        {
            throw new Exception("No filter set!");
        }

        $this->filters[$inputName] = explode(self::FILTERS_DIVIDER, $filters);
        return $this;
    }

    /**
     * @desc - scan the input reports
     * @return boolean - if no FALSE report at all, than give back TRUE, otherwise FALSE
     */
    public function scan()
    {
        $filterError = [];
        $inputCheck = new InputsFilter();

        foreach($this->filters as $inputName => $filterArr)
        {
            if (!empty($filterArr))
            {
                foreach($filterArr as $filter)
                {
                    $filterExp = explode(self::FILTER_OPTION_DIVIDER, $filter);
                    $filterName = $filterExp[0];
                    $filterOpt = !empty($filterExp[1]) ? $filterExp[1] : '';

                    $filterRes = $inputCheck->$filterName($this->getPost($inputName), $filterOpt);

                    if ( $filterRes === FALSE)
                    {
                        $filterError[$inputName] = $filterRes;
                        break;
                    }
                }
            }
        }

        if (empty($filterError))
            { return TRUE; }
        else
            { return $filterError; }
    }

    /**
     * @desc - set to the specific error the specific error message
     */
    public function setFormErrors(){}

    /**
     * @desc -
     * @param type $requestParamStore
     * @param type $indexName
     * @return type
     * @throws Exception
     */
    private function getRequestParams($requestParamStore, $indexName)
    {
        $inputCleaner = new InputCleaner();
        if (array_key_exists($indexName, $requestParamStore) && $indexName !== NULL)
        {
            return $inputCleaner->cleanOne( $requestParamStore[$indexName]);
        }
        else if ($indexName === NULL)
        {
            return $inputCleaner->cleanAll($requestParamStore);
        }
        else
        {
            throw new Exception("There is no such key like: ".$indexName);
        }
    }

}