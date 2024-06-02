<?php
require_once '../config/database.php';
require_once '../controllers/EnderecoController.php';

if (isset($_GET['contato_id'])) {
    $contato_id = $_GET['contato_id'];
    $enderecoController = new EnderecoController();
    $endereco = $enderecoController->obterEnderecoPorContato($contato_id);
    if ($endereco) {
        $response = array(
            'cep' => $endereco->getCep(),
            'endereco' => $endereco->getEndereco(),
            'numero_residencia' => $endereco->getNumeroResidencia(),
            'bairro' => $endereco->getBairro(),
            'cidade' => $endereco->getCidade(),
            'uf' => $endereco->getUf()
        );
    } else {
        $response = null;
    }
    echo json_encode($response);
} else {
    echo json_encode(null);
}
?>
