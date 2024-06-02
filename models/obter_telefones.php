<?php
require_once '../config/database.php';
require_once '../controllers/TelefoneController.php';

if (isset($_GET['contato_id'])) {
    $contato_id = $_GET['contato_id'];
    $telefoneController = new TelefoneController();
    $telefones = $telefoneController->obterTelefonesPorContato($contato_id);

    if ($telefones) {
        echo json_encode([
            'telefone_comercial' => $telefones['telefone_comercial'],
            'telefone_residencial' => $telefones['telefone_residencial'],
            'telefone_celular' => $telefones['telefone_celular']
        ]);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}
?>
