<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {

    public function Autenticar() {
        $usuario = Container::getModel('Usuario');

        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', md5($_POST['senha']));

        $usuario->autenticar();

        //se digitar as info corretas, entra na aplicação
        if($usuario->__get('nome') && $usuario->__get('nome')) {
            session_start();
            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['nome'] = $usuario->__get('nome');
            header('Location: /timeline');
        } else {
            header('Location: /?login=erro');
        }
    }

    public function Sair()
    {
        session_start();
        session_destroy();
        header('Location: /');
    }
}

?>