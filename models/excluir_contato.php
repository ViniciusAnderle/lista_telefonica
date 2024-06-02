<?php
require_once __DIR__ . '/../controllers/ContatoController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $controller = new ContatoController();
    try {
        $controller->excluirContato($id);
        header('Location: ../views/contatos.php?successMessage=Contato excluído com sucesso.');
        exit();
    } catch (Exception $e) {
        header('Location: ../views/contatos.php?errorMessage=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: ../views/contatos.php');
    exit();
}
?>
