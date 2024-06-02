<?php
session_start();
require_once 'init.php';
require_once __DIR__ . '/./controllers/ContatoController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeCompleto = $_POST['nomeCompleto'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $dataNascimento = $_POST['dataNascimento'];

    try {
        $controller = new ContatoController();
        $cpfExistente = $controller->verificarExistenciaCPF($cpf);
        $emailExistente = $controller->verificarExistenciaEmail($email);

        if ($cpfExistente || $emailExistente) {
            $_SESSION['errorMessage'] = "O CPF ou e-mail informado já está cadastrado.";
            header('Location: ./views/form.php');
            exit();
        } else {
            $contatoId = $controller->salvarContato($nomeCompleto, $cpf, $email, $dataNascimento);
            header('Location: ./views/success.php?id=' . $contatoId);
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['errorMessage'] = $e->getMessage();
        header('Location: ./views/form.php');
        exit();
    }
}
?>
