<?php

namespace Examp\Core;

defined('ISRUN') OR exit('Direct access to the script not allowed!');

use Examp\Core\View\View;
use Examp\Core\UI\ShapeFromResponse;

class Controller
{
    /**
     * @desc - View object
     * @var View 
     */
    protected $modelAndView;
    /**
     * @desc - Stores the redirection path
     * @var string
     */
    protected $redriectTarget;
    /**
     * @desc - Store flash data
     * @var array
     */
    protected $flashData = [];

    public function __construct()
    {
        $this->modelAndView = new View();
    }

    /**
     * @desc - sets the view file name, and the corresponding data
     * @param string $viewName
     * @param array $viewData
     * @return self
     */
    public function setView(string $viewName, array $viewData = []): self
    {
        $this->modelAndView->setViewName($viewName);
        $this->modelAndView->setViewData($viewData);
        return $this;
    }

    /**
     * @desc - setting the redirection route
     * @param string $redirectTarget
     * @return self
     */
    public function setRedirect(string $redirectTarget): self
    {
        $this->redriectTarget = $redirectTarget;
        return $this;
    }

    /**
     * @desc - get the redirect target
     * @return string|null
     */
    public function getRedriectTarget(): ?string
    {
        return $this->redriectTarget;
    }

    /**
     * @desc - Sets the flash data with shaped text 
     * @param string $flashkey
     * @param type $flashData
     * @param type $msgType
     * @return void
     */
    public function setFlashData(string $flashkey, $flashData, $msgType = null): void
    {
        $msgFormater = new ShapeFromResponse($flashData, $msgType);
        $this->flashData[$flashkey] = $msgFormater->getShapedMessage();
    }

    /**
     * @desc - Get the flash data
     * @return array
     */
    public function getFlashData(): array
    {
        return $this->flashData;
    }

    /**
     * @desc - Get the View instance
     * @return View
     */
    public function getView() : View
    {
        return $this->modelAndView;
    }

}