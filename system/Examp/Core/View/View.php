<?php

namespace Examp\Core\View;

/**
 * Description of View
 */
class View 
{    
    protected $viewName;
    protected $viewData;
    
    public function getViewName() 
    {
        return $this->viewName;
    }

    public function getViewData() 
    {
        return $this->viewData;
    }

    public function setViewName($viewName): void 
    {
        $this->viewName = $viewName;
    }

    public function setViewData($viewData): void 
    {
        $this->viewData = $viewData;
    }
    
}
