<?php


namespace App\Controllers;


use App\Connection;

use MF\Controller\Action;
use MF\Model\Container;


class IndexController extends Action {

    public function index(){



        $this->render('index');
    }

    public function inscreverse(){


        
        $this->render('inscreverse');
    }

}