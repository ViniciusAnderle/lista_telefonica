<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once '../config/database.php';
    require_once '../controllers/EnderecoController.php';
    $enderecoController = new EnderecoController();
    $contato_id = $_POST['contato_id'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $numero_residencia = $_POST['numero_residencia'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];

    try {
        $enderecoExistente = $enderecoController->obterEnderecoPorContato($contato_id);

        if ($enderecoExistente) {
            $enderecoController->editarEndereco($contato_id, $cep, $endereco, $numero_residencia, $bairro, $cidade, $uf);
            echo "Endereço atualizado com sucesso!";
        } else {
            $enderecoController->cadastrarEndereco($contato_id, $cep, $endereco, $numero_residencia, $bairro, $cidade, $uf);
            echo "Endereço cadastrado com sucesso!";
        }
        
        header("Location: ../views/home.php");
    } catch (Exception $e) {
        echo "Erro ao cadastrar endereço: " . $e->getMessage();
    }
} else {
    echo "Erro: Método não permitido!";
}
?>
