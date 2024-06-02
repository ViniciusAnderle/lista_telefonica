<?php
require_once __DIR__ . '/../controllers/ContatoController.php';


$controller = new ContatoController();


if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $contatos = $controller->obterContatosPorNome($searchTerm);
} else {
    $contatos = $controller->obterTodosContatos();
}

if (isset($_GET['successMessage'])) {
    echo '<div class="container" style="color: green;">' . $_GET['successMessage'] . '</div>';
}
if (isset($_GET['errorMessage'])) {
    echo '<div class="container" style="color: red;">' . $_GET['errorMessage'] . '</div>';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda | Contatos</title>
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
        <h1>Contatos Cadastrados</h1>
    </div>
    <div class="container">
        <div class="form-container">
            <form action="contatos.php" method="get">
                <label for="search">Pesquisar por nome:</label>
                <input type="text" id="search" name="search" placeholder="Nome do contato">
                <button type="submit">Pesquisar</button>
            </form>
        </div>
    </div>
    <div class="container">
        <table>
            <tr>
                <th>Nome Completo</th>
                <th>CPF</th>
                <th>E-mail</th>
                <th>Data de Nascimento</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($contatos as $contato) : ?>
                <tr>
                    <td><?php echo $contato['nome_completo']; ?></td>
                    <td><?php echo $contato['cpf']; ?></td>
                    <td><?php echo $contato['email']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($contato['data_nascimento'])); ?></td>
                    <td>
                        <a href="exibir_contato.php?id=<?php echo $contato['id']; ?>">Exibir mais informacoes</a>
                        <form action="../models/excluir_contato.php" method="post" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $contato['id']; ?>">
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>