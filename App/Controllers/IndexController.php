<?php


namespace App\Controllers;


use App\Connection;

use MF\Controller\Action;
use MF\Model\Container;


class IndexController extends Action {

    public function index(){
        $obj = Container::getModel('');
        $dados_do_banco = $obj->getDados();
        $this->view->dados = $dados_do_banco;

        $this->render('index', 'layout1');
    }

}