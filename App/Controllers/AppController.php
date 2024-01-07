<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
class AppController extends Action
{
    public function timeline()
    {
        $this->validAuth();

        $tweetModel= Container::getModel('Tweet');
        $tweetModel->__set('id_usuario', $_SESSION['id']);

        $tweets = $tweetModel->getAll();

        $this->view->tweets = $tweets;

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

    public function seguir()
    {
        $this->validAuth();
        echo '<br/><br/><br/><br/><br/>';

        $pesquisarPor = $_GET['pesquisarPor'] ?? '';

        $usuarios = [];

        if($pesquisarPor) {
            $usuarioModel = Container::getModel('Usuario');
            $usuarioModel->__set('nome', $pesquisarPor);
            $usuarios = $usuarioModel->getUsuarioPorNome();
        }

        $this->view->usuarios = $usuarios;

        $this->render('seguir');

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
}