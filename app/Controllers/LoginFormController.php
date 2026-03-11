<?php
namespace App\Controllers;

use Examp\Core\Containers\ServiceContainer;
use Examp\Core\Controller;
use Examp\Core\Session\Session;
/**
 * Description of LoginControllers
 */
class LoginFormController extends Controller
{    
    private $session;
    
    public function __construct(ServiceContainer $container)
    {
        parent::__construct();
        $this->session = $container->get(Session::class);
    }
    
    public function index()
    {        
        if (!$this->session->has('logged'))
        {
            return $this->setView('login', [ 'title' => 'Login!']);            
        }
        else
        {
            return $this->setRedirect('/');
        }
    }
    
}
