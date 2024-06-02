<?php
require_once '../init.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda | Home</title>
    <link rel="icon" href="../assets/images/contacts.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
        <h1>Bem vindo à sua agenda telefônica!</h1>
    </div>
    <div class="container">
        <div class="container-btn">
            <p>Veja seus contatos cadastrados clicando no botão abaixo:</p>
        </div>
    </div>
    <div class="container">
        <div class="container-btn">
            <a href="contatos.php"><button>Contatos</button></a>
        </div>
    </div>
</body>

</html>