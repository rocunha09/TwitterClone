<?php


namespace App\Controllers;


use App\Connection;

use MF\Controller\Action;
use MF\Model\Container;


class AppController extends Action {

    public function validaAutenticacao(){
        session_start();
        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
            header('Location: /?login=erro');
        }
    }

    public function timeline(){
        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');
        $tweet->__set('id_usuario', $_SESSION['id']);

        $this->view->tweets = $tweet->listar();
        $this->render('timeline');

    }

    public function tweet(){
        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');

        //valida o tweet recebido para não cadastrar tweet vazio
        if(isset($_POST['tweet']) && strlen($_POST['tweet']) > 3){
            $tweet->__set('id_usuario', $_SESSION['id']);
            $tweet->__set('tweet', $_POST['tweet']);

            if($tweet->salvar()){
                header('Location: /timeline');

            } else {
                header('Location: /timeline?tweet=erro2');

            }

        } else {
            header('Location: /timeline?tweet=erro');

        }

    }

}
?>