<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

session_start();

class AuthController extends Action {

   public function sair() {

   session_destroy();	

   header('location:/');

   }

    public function autenticar()
    {
        
        $usuario = Container::getModel('Usuario');

$usuario->__set('email', $_POST['email']);
$usuario->__set('senha', md5($_POST['senha']));	

        $usuario->autenticar();
        

        
        if ($usuario->id != '' && $usuario->nome != '') {


	$_SESSION['id'] = $usuario->__get('id');
	$_SESSION['nome'] = $usuario->__get('nome');

	header('location:/timeline');

        } else {
           header('location:/?login=erro');

            echo 'falha';
           
        }
    }
}
?>