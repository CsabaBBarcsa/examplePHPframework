<?php

namespace App\Controllers;

use Examp\Core\Controller;
/**
 * Description of MermberController
 */
class MermberController extends Controller
{
    public function index()
    {
        return $this->setView('protected', ['title'=>'Tagoknak']);
    }
}

