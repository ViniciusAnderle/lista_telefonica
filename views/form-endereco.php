<?php
require_once '../controllers/ContatoController.php';
require_once '../controllers/EnderecoController.php';

$contatoController = new ContatoController();
$enderecoController = new EnderecoController();
$contatos = $contatoController->obterTodosContatos();
$mensagem_sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['contato_id']) && isset($_POST['cep']) && isset($_POST['endereco']) && isset($_POST['numero_residencia']) && isset($_POST['bairro']) && isset($_POST['cidade']) && isset($_POST['uf'])) {
        $contato_id = $_POST['contato_id'];
        $cep = $_POST['cep'];
        $endereco = $_POST['endereco'];
        $numero_residencia = $_POST['numero_residencia'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        $enderecos = $enderecoController->obterEnderecoPorContato($contato_id);
        if ($enderecos) {
            $enderecoController->editarEndereco($contato_id, $cep, $endereco, $numero_residencia, $bairro, $cidade, $uf);
        } else {
            $enderecoController->cadastrarEndereco($contato_id, $cep, $endereco, $numero_residencia, $bairro, $cidade, $uf);
        }
        $mensagem_sucesso = "Endereço cadastrado com sucesso.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda | Cadastro de endereço</title>
    <link rel="icon" href="../assets/images/contacts.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
        <h1>Cadastro de endereço</h1>
    </div>
    <?php if ($mensagem_sucesso) : ?>
        <div class="container">
            <div class="alert alert-success">
                <p style="color: green;"><?php echo $mensagem_sucesso; ?></p>
            </div>
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="form-container">
            <form action="form-endereco.php" method="POST">
                <div class="row form-group">
                    <div class="col-sm-6">
                        <select class="form-control" name="contato_id" id="contato_id" required onchange="carregarEndereco()">
                            <option value="">Selecione um contato</option>
                            <?php foreach ($contatos as $contato) : ?>
                                <option value="<?php echo $contato['id']; ?>"><?php echo $contato['nome_completo']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-3">
                            <input type="text" class="form-control" placeholder="CEP" onblur="getDadosEnderecoPorCEP(this.value)" name="cep" id="cep" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="Rua" name="endereco" id="endereco" required>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" placeholder="Número" name="numero_residencia" id="numero_residencia" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="Bairro" name="bairro" id="bairro" required>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Cidade" name="cidade" id="cidade" required>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="uf" id="uf" required>
                                <option value="">Selecione um estado</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Salvar Endereço</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#cep').mask('00000-000');
        });

        document.getElementById('contato_id').addEventListener('change', function() {
            const contato_id = this.value;
            if (contato_id) {
                fetch('../models/obter_endereco.php?contato_id=' + contato_id)
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            document.getElementById('cep').value = data.cep;
                            document.getElementById('endereco').value = data.endereco;
                            document.getElementById('numero_residencia').value = data.numero_residencia;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.cidade;
                            document.getElementById('uf').value = data.uf;
                        } else {
                            document.getElementById('cep').value = '';
                            document.getElementById('endereco').value = '';
                            document.getElementById('numero_residencia').value = '';
                            document.getElementById('bairro').value = '';
                            document.getElementById('cidade').value = '';
                            document.getElementById('uf').value = '';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        function getDadosEnderecoPorCEP(cep) {
            let url = 'https://viacep.com.br/ws/' + cep + '/json/';

            let xmlHttp = new XMLHttpRequest();
            xmlHttp.open('GET', url);

            xmlHttp.onreadystatechange = () => {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    let dadosJSONText = xmlHttp.responseText;
                    let dados = JSON.parse(dadosJSONText);
                    document.getElementById('endereco').value = dados.logradouro;
                    document.getElementById('bairro').value = dados.bairro;
                    document.getElementById('cidade').value = dados.localidade;
                    document.getElementById('uf').value = dados.uf;
                }
            }

            xmlHttp.send()
        }
    </script>
</body>

</html>