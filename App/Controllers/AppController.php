<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;
class AppController extends Action
{
    public function timeline()
    {
        session_start();

        // se não tiver sessão vinculada, fica na pagina de login
        if(empty($_SESSION['id']) && empty($_SESSION['nome'])) {
            header('Location: /?login=erro');
        } else {
            $this->render('timeline');
        }
    }
}