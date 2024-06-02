<?php
session_start();
require_once __DIR__ . '/../controllers/ContatoController.php';

if (!isset($_GET['id'])) {
    die("ID do contato não fornecido.");
}

$controller = new ContatoController();
$contato = $controller->obterContato($_GET['id']);

if ($contato) {
    $nomeCompleto = $contato->getNomeCompleto();
    $cpf = $contato->getCpf();
    $email = $contato->getEmail();
    $dataNascimento = $contato->getDataNascimento();
} else {
    die("Contato não encontrado.");
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda | Cadastro concluído</title>
    <link rel="icon" href="../assets/images/contacts.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <div class="navbar">
        <a href="home.php"><span class="material-symbols-outlined">home</span></a>
        <a href="contatos.php">Contatos cadastrados</a>
        <a href="form.php">Cadastrar novo contato</a>
        <a href="form-endereco.php">Cadastrar endereço</a>
        <a href="form-telefone.php">Cadastrar telefone</a>
    </div>
    <div class="container">
        <h1>Contato cadastrado com sucesso!</h1>
    </div>
    <div class="container">
        <div class="data-container">
            <p><strong>Nome Completo:</strong> <?= htmlspecialchars($nomeCompleto) ?></p>
            <p><strong>CPF:</strong> <?= htmlspecialchars($cpf) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($dataNascimento)) ?></p>
            <a href="contatos.php"><button>Voltar</button></a>
        </div>
    </div>
</body>

</html>