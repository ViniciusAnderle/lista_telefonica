<?php
session_start();
$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : null;
unset($_SESSION['errorMessage']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda | Cadastro de contato</title>
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
        <h1>Cadastro de Contato</h1>
    </div>
    <?php if ($errorMessage) : ?>
        <div class="container">
        <p style="color: red;"><?php echo $errorMessage; ?></p>
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="form-container">
            <form id="contactForm" action="../index.php" method="POST">
                <label for="nomeCompleto">Nome Completo:</label><br>
                <input type="text" id="nomeCompleto" name="nomeCompleto" placeholder="Nome do contato"><br><br>

                <label for="cpf">CPF:</label><br>
                <input type="text" id="cpf" name="cpf" placeholder="CPF do contato" required maxlength="14"><br><br>

                <label for="email">E-mail:</label><br>
                <input type="email" id="email" name="email" placeholder="E-mail do contato" required><br><br>

                <label for="dataNascimento">Data de Nascimento:</label><br>
                <input type="date" id="dataNascimento" name="dataNascimento" required><br><br>

                <input type="submit" value="Cadastrar" class="button">
            </form>
        </div>
    </div>
    <script>
        const cpfInput = document.getElementById('cpf');
        cpfInput.addEventListener('input', function(e) {
            let cpf = e.target.value.replace(/\D/g, '');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = cpf;
        });
    </script>
</body>

</html>