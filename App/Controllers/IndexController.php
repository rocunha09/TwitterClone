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
        $this->view->erroCadastro = '';
        $this->view->usuario = array(
            'nome' => '',
            'email' => '',
            'senha' => ''
        );

        $this->render('inscreverse');
    }

    public function registrar(){
        $usuario = Container::getModel('Usuario');
        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', $_POST['senha']);

        if($usuario->validarCadastro() && count($usuario->consultarExistente()) == 0){
            $usuario->salvar();
            $this->render('cadastro');

        } else {
            $this->view->usuario = array(
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => $_POST['senha']
            );

            if(!$usuario->validarCadastro()){
                $this->view->erroCadastro = 'erro_preenchimento';
                $this->render('inscreverse');
            }

            if(count($usuario->consultarExistente()) > 0){
                $this->view->erroCadastro = 'ja_existe';
                $this->render('inscreverse');
            }

        }

    }

}