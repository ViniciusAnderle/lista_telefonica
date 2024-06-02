<?php
require_once '../controllers/ContatoController.php';
require_once '../controllers/TelefoneController.php';

$contatoController = new ContatoController();
$telefoneController = new TelefoneController();
$contatos = $contatoController->obterTodosContatos();
$mensagem_sucesso = "";
$mensagem_erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['contato_id']) && isset($_POST['telefone_comercial']) && isset($_POST['telefone_residencial']) && isset($_POST['telefone_celular'])) {
        $contato_id = $_POST['contato_id'];
        $telefone_comercial = $_POST['telefone_comercial'];
        $telefone_residencial = $_POST['telefone_residencial'];
        $telefone_celular = $_POST['telefone_celular'];

        try {
            $telefoneController->salvarOuAtualizarTelefone($contato_id, $telefone_comercial, $telefone_residencial, $telefone_celular);
            $mensagem_sucesso = "Telefone cadastrado com sucesso.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensagem_erro = "Telefone celular já está cadastrado para outro contato!";
            } else {
                $mensagem_erro = "Erro ao cadastrar telefone: " . $e->getMessage();
            }
        } catch (Exception $e) {
            $mensagem_erro = "Erro ao cadastrar telefone: " . $e->getMessage();
        }
    } else {
        $mensagem_erro = "Preencha todos os campos obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda | Cadastro de telefone</title>
    <link rel="icon" href="../assets/images/contacts.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
        <h1>Cadastro de telefone</h1>
    </div>
    <?php if ($mensagem_sucesso) : ?>
        <?php if ($mensagem_sucesso) : ?>
            <div class="container">
                <div class="alert alert-success">
                    <p style="color: green;"><?php echo $mensagem_sucesso; ?></p>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($mensagem_erro) : ?>
        <div class="container">
            <div class="alert alert-danger">
                <p style="color: red;"><?php echo $mensagem_erro; ?></p>
            </div>
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="form-container">
            <form action="form-telefone.php" method="POST">
                <div class="row form-group">
                    <div class="col-sm-6">
                        <select class="form-control" name="contato_id" id="contato_id" required onchange="carregarTelefones(this.value)">
                            <option value="">Selecione um contato</option>
                            <?php foreach ($contatos as $contato) : ?>
                                <option value="<?php echo $contato['id']; ?>"><?php echo $contato['nome_completo']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="Telefone Comercial" name="telefone_comercial" id="telefone_comercial">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="Telefone Residencial" name="telefone_residencial" id="telefone_residencial">
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="Telefone Celular" name="telefone_celular" id="telefone_celular" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">Salvar Telefone</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function carregarTelefones(contatoId) {
            if (contatoId) {
                $.ajax({
                    url: '../models/obter_telefones.php',
                    type: 'GET',
                    data: {
                        contato_id: contatoId
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            $('#telefone_comercial').val(data.telefone_comercial);
                            $('#telefone_residencial').val(data.telefone_residencial);
                            $('#telefone_celular').val(data.telefone_celular);
                        } else {
                            $('#telefone_comercial').val('');
                            $('#telefone_residencial').val('');
                            $('#telefone_celular').val('');
                        }
                        aplicarMascara();
                    }
                });
            } else {
                $('#telefone_comercial').val('');
                $('#telefone_residencial').val('');
                $('#telefone_celular').val('');
                aplicarMascara();
            }
        }

        function aplicarMascara() {
            $('#telefone_comercial').mask('(00) 0 0000-0000');
            $('#telefone_residencial').mask('(00) 0 0000-0000');
            $('#telefone_celular').mask('(00) 0 0000-0000');
        }

        $(document).ready(function() {
            aplicarMascara();
        });
    </script>
</body>

</html>