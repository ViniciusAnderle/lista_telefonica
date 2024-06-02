<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once '../config/database.php';
    require_once '../controllers/TelefoneController.php';
    $telefoneController = new TelefoneController();
    $contato_id = $_POST['contato_id'];
    $telefone_comercial = isset($_POST['telefone_comercial']) ? $_POST['telefone_comercial'] : '';
    $telefone_residencial = isset($_POST['telefone_residencial']) ? $_POST['telefone_residencial'] : '';
    $telefone_celular = $_POST['telefone_celular'];

    try {
        $telefoneController->salvarOuAtualizarTelefone($contato_id, $telefone_comercial, $telefone_residencial, $telefone_celular);
        echo "Telefone cadastrado/atualizado com sucesso!";
        header("Location: ../views/home.php");
    } catch (Exception $e) {
        echo "Erro ao cadastrar telefone: " . $e->getMessage();
    }
} else {
    echo "Erro: Método não permitido!";
}
?>
