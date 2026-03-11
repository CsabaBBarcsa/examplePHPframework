<?php

namespace App\Controllers;

use Examp\Core\Controller;

/**
 * Description of HomeController
 */
class HomeController extends Controller
{    
    public function index()
    {
        return $this->setView('public', ['title'=>'Főoldal']);        
    }
    
    /**
     * @desc - just for test
     * @return $this
     */
    public function teszt()
    {
        return $this->setRedirect('/');        
    }
    
}
