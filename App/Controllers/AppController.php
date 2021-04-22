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

    public function excluirTweet(){
        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');

        if(isset($_POST['tweet_id'])) {
            $tweet->__set('id_usuario', $_SESSION['id']);
            $tweet->__set('id', $_POST['tweet_id']);
            $tweet->excluir();

            header('Location: /timeline');
        }
    }

    public function quemSeguir(){
        $this->validaAutenticacao();

        $procurado = isset($_GET['termo']) ? $_GET['termo'] : '';
        $usuario = Container::getModel('usuario');

        $usuariosEncontrados = array();
        $usuario->__set('nome', $procurado);
        $usuario->__set('id', $_SESSION['id']);

        if($procurado != ''){
            $usuariosEncontrados = $usuario->procurarPor();

        } else {
            $usuariosEncontrados = $usuario->listarTodos();

        }

        $this->view->usuariosEncontrados = $usuariosEncontrados;

        $this->render('quemSeguir');

    }

    public function acao(){
        $this->validaAutenticacao();

        $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
        $id_usuario_seguindo = isset($_GET['id']) ? $_GET['id'] : '';

        $usuario = Container::getModel('usuario');
        $usuario->__set('id', $_SESSION['id']);

        if($acao == 'seguir'){
            if($usuario->seguindo($id_usuario_seguindo) == 0){
                $usuario->seguir($id_usuario_seguindo);

            }

        }

        if($acao == "deixar_de_seguir"){
            if($usuario->seguindo($id_usuario_seguindo) == 1){
                $usuario->deixarDeSeguir($id_usuario_seguindo);

            }

        }

        header('Location: /quem_seguir');
    }

}
?>