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

        $usuario = Container::getModel('Usuario');
        $usuario->__set('id', $_SESSION['id']);

        //paginação
        $total_registros_pagina = 10;
        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
        $deslocamento = ($pagina -1) * $total_registros_pagina;
        $totTweets = $tweet->totTweets();
        $totPaginas = ceil($totTweets / $total_registros_pagina);

        //busca informações do usuário
        $infoUsuario = $usuario->infoUsuario();

        //dados para paginação
        $this->view->paginaAtiva = $pagina;
        $this->view->totPaginas = $totPaginas;

        //tweets que serão exibidos na timeline
        $this->view->tweets = $tweet->listar($total_registros_pagina, $deslocamento);

        //dados do usuário para exibir no peril
        $this->view->nomeUsuario = $infoUsuario['nome'];
        $this->view->totTweets = $usuario->totTweets();
        $this->view->totSeguindo = $usuario->totSeguindo();
        $this->view->totSeguidores = $usuario->totSeguidores();

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

        //busca informações do usuário
        $infoUsuario = $usuario->infoUsuario();

        //dados do usuário para exibir no peril
        $this->view->nomeUsuario = $infoUsuario['nome'];
        $this->view->totTweets = $usuario->totTweets();
        $this->view->totSeguindo = $usuario->totSeguindo();
        $this->view->totSeguidores = $usuario->totSeguidores();

        //listagem de usuários que será exibida
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