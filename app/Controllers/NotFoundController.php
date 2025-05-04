<?php

namespace App\Controllers;

use Examp\Core\Controller;

/**
 * Description of NotFoundController
 */
class NotFoundController extends Controller
{    
    public function index()
    {
        $this->setView('404');
        return $this;
    }
    
}
