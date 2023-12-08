<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

    public function index() {

        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
        $this->render('index');
    }

    public function inscreverse() {
        $this->view->erroCadastro = false;
        $this->view->erroEmailJaCadastrado = false;
        $this->view->usuario = array('nome' => '',
                	'email' =>'',
                	'senha' =>'',
            );
        $this->render('inscreverse');
    }

    public function registrar() {
       $this->view->erroCadastro = false;
        $this->view->erroEmailJaCadastrado = false;

        $usuario = Container::getModel('Usuario');

        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('senha', md5($_POST['senha']));

        $erros = [];

        if ($usuario->validarCadastro()) {
            // Adicionado o parêntese que estava faltando na condição
            if (count($usuario->getUsuario()) == 0) {
                $usuario->salvar();
                $this->render('cadastro');
            } else {
                $erros['erroEmailJaCadastrado'] = 'Este email já está cadastrado!';
                $this->view->usuario = array('nome' => $_POST['nome'],
                	'email' => $_POST['email'],
                	'senha' => $_POST['senha'],
            );

            }
        } else {
            $erros['erroCadastro'] = 'Por favor, preencha todos os campos corretamente.';
            $this->view->usuario = array('nome' => $_POST['nome'],
                	'email' => $_POST['email'],
                	'senha' => $_POST['senha'],
            );
        }

        // Verifica se há erros antes de definir as variáveis de erro
        if (!empty($erros)) {
            foreach ($erros as $erro => $mensagem) {
                $this->view->$erro = true;
            }
            $this->render('inscreverse');
        }
    }
}
?>