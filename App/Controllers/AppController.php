<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
class AppController extends Action
{
    public function timeline()
    {
        $this->validAuth();

        $this->infoAccount(); // nome_usuario, total_tweets, total_seguidores, total_seguindo

        $tweetModel= Container::getModel('Tweet');

        $tweetModel->__set('id_usuario', $_SESSION['id']);

        $this->view->tweets = $tweetModel->getAll();

        $this->render('timeline');
    }

    public function tweet()
    {
        $this->validAuth();

        $tweetModel = Container::getModel('Tweet');
        $tweetModel->__set('tweet', $_POST['tweet']);
        $tweetModel->__set('id_usuario', $_SESSION['id']);

        $tweetModel->saveTweet();

        header('Location: /timeline');
    }

    public function deleteTweet()
    {
        $this->validAuth();

        $idTweet = $_GET['id_tweet'] ?? '';

        $tweetModel = Container::getModel('Tweet');
        $tweetModel->removeTweet($idTweet);

        header('Location: /timeline');
    }

    public function seguir()
    {
        $this->validAuth();

        $pesquisarPor = $_GET['pesquisarPor'] ?? '';

        $usuarios = [];

        if($pesquisarPor) {
            $usuarioModel = Container::getModel('Usuario');
            $usuarioModel->__set('nome', $pesquisarPor);
            $usuarioModel->__set('id', $_SESSION['id']);
            $usuarios = $usuarioModel->getUsuarioPorNome();
        } else {
            $usuarioModel = Container::getModel('Usuario');
            $usuarioModel->__set('id', $_SESSION['id']);
            $usuarios = $usuarioModel->getAll();
        }

        $this->view->usuarios = $usuarios;

        $this->infoAccount(); // nome_usuario, total_tweets, total_seguidores, total_seguindo

        $this->render('seguir');

    }

    public function acao() {

        $this->validAuth();

        $acao = $_GET['acao'] ?? '';
        $idUsuarioSeguindo = $_GET['id_usuario'] ?? '';

        $usuarioSeguidorModel = Container::getModel('UsuarioSeguidor');
        $usuarioSeguidorModel->__set('id_usuario', $_SESSION['id']);

        if($acao == 'seguir') {
            $usuarioSeguidorModel->seguirUsuario($idUsuarioSeguindo);

        } elseif ($acao == 'deixar_de_seguir') {
            $usuarioSeguidorModel->deixarSeguirUsuario($idUsuarioSeguindo);
        }

        header('Location: /seguir');
    }

    private function validAuth()
    {
        session_start();

        if(empty($_SESSION['id']) && empty($_SESSION['nome'])) {
            header('Location: /?login=erro');
        } else {
            return true;
        }
    }

    private function infoAccount() {

        $tweetModel= Container::getModel('Tweet');
        $usuarioModel= Container::getModel('Usuario');
        $usuarioSeguidorModel= Container::getModel('UsuarioSeguidor');

        $tweetModel->__set('id_usuario', $_SESSION['id']);
        $usuarioModel->__set('id', $_SESSION['id']);
        $usuarioSeguidorModel->__set('id_usuario', $_SESSION['id']);

        $nomeUsuario = $usuarioModel->getNomeUsuario();
        $totalTweets = $tweetModel->getTotalTweets();
        $totalSeguidores = $usuarioSeguidorModel->getTotalSeguidores();
        $totalSeguindo = $usuarioSeguidorModel->getTotalSeguindo();

        $this->view->nome_usuario = $nomeUsuario['nome'];
        $this->view->total_tweets = $totalTweets['total_tweets'];
        $this->view->seguidores = $totalSeguidores['seguidores'];
        $this->view->seguindo = $totalSeguindo['seguindo'];
    }
}