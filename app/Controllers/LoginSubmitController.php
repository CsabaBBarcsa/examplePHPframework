<?php
namespace App\Controllers;

use Examp\Core\Controller;
use Examp\Core\Containers\ServiceContainer;
use Examp\Core\Handlers\Input\InputsManager;

use App\Services\LoginSubmitService;

/**
 * Description of LoginSubmitController
 */
class LoginSubmitController extends Controller {

    /**
     * @desc - LoginSubmitService object
     * @var LoginSubmitService
     */
    private $loginService;
    /**
    * @desc - InputsManager object
    * @var InputsManager
    */
    private $inputManager;

    /**
     * @param ServiceContainer $container
     */
    public function __construct( ServiceContainer $container )
    {
        parent::__construct();

        $this->inputManager = $container->get(InputsManager::class);
        $this->loginService = $container->get(LoginSubmitService::class);
    }

    /**
     * @desc - submit the login data if valid, then verifies the data, and use it
     * @return Controller
     */
    public function submit()
    {
        $retVal = NULL;

        $this->inputManager->setFilter('usemail', 'require|email|maxLength:50');
        $this->inputManager->setFilter('paw', 'require|minLength:2');
        
        if ( $this->inputManager->scan() === TRUE )
        {
            $loginCheck = $this->loginService->login($this->inputManager->getPost('usemail'), $this->inputManager->getPost('paw'));
            if ( $loginCheck === TRUE )
            {
                $retVal = $this->setRedirect('protected');
            }
            else
            {
                $this->setFlashData('logSubError', 'Login failiure', 'warn');
                $retVal = $this->setRedirect('login');
            }
        }
        else
        {
            $this->setFlashData(  'logForError', [ 'error' => ['Login form error', 'Some data is not correct'] ] );
            $retVal = $this->setRedirect('login');
        }
        return $retVal;
    }

    /**
     * @desc - check the user, and then log them out, if they are logged in, and redirect to the proper route
     * @return type
     */
    public function logout()
    {
        if ($this->loginService->isLoggedIn()) {
            $this->loginService->logout();
            return $this->setRedirect('login');
        }
        return $this->setRedirect('/');
    }

}
