<?php
require_once __DIR__ . '/../classes/Telefone.php';

class TelefoneController
{
    private $conn;

    public function __construct()
    {
        $host = 'localhost';  
        $db = 'testebackend';
        $user = 'root';       
        $pass = '';           

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function obterTelefonesPorContato($contato_id)
    {
        try {
            $sql = "SELECT * FROM telefone WHERE contato_id = :contato_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':contato_id', $contato_id);
            $stmt->execute();
            $telefoneData = $stmt->fetch(PDO::FETCH_ASSOC);
            $telefones = [];
            if ($telefoneData) {
                return [
                    'telefone_comercial' => $telefoneData['telefone_comercial'],
                    'telefone_residencial' => $telefoneData['telefone_residencial'],
                    'telefone_celular' => $telefoneData['telefone_celular']
                ];
            } else {
                return null;
            }
            while ($telefoneData = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $telefone = new Telefone(
                    $telefoneData['contato_id'],
                    $telefoneData['telefone_comercial'],
                    $telefoneData['telefone_residencial'],
                    $telefoneData['telefone_celular']
                );
                $telefones[] = $telefone;
            }

            return $telefones;
            
        } catch (PDOException $e) {
            throw new Exception("Erro ao obter telefones: " . $e->getMessage());
        }
        
    }
    public function getNumeroTelefoneDisponivel($telefones)
{
    foreach ($telefones as $telefone) {
        if ($telefone->getTelefoneCelular() !== null) {
            return $telefone->getTelefoneCelular();
        }
    }
    foreach ($telefones as $telefone) {
        if ($telefone->getTelefone() !== null) {
            return $telefone->getTelefone();
        }
    }
    foreach ($telefones as $telefone) {
        if ($telefone->getTelefoneResidencial() !== null) {
            return $telefone->getTelefoneResidencial();
        }
    }
    return null;
}




    public function salvarOuAtualizarTelefone($contato_id, $telefone_comercial, $telefone_residencial, $telefone_celular)
    {
        try {
            $sql = "SELECT * FROM telefone WHERE contato_id = :contato_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':contato_id', $contato_id);
            $stmt->execute();
            $telefoneData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($telefoneData) {
                $sql = "UPDATE telefone SET telefone_comercial = :telefone_comercial, telefone_residencial = :telefone_residencial, telefone_celular = :telefone_celular WHERE contato_id = :contato_id";
            } else {
                $sql = "INSERT INTO telefone (contato_id, telefone_comercial, telefone_residencial, telefone_celular) VALUES (:contato_id, :telefone_comercial, :telefone_residencial, :telefone_celular)";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':contato_id', $contato_id);
            $stmt->bindParam(':telefone_comercial', $telefone_comercial);
            $stmt->bindParam(':telefone_residencial', $telefone_residencial);
            $stmt->bindParam(':telefone_celular', $telefone_celular);
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { 
                throw new Exception("O telefone indicado já está cadastrado para outro contato!");
            } else {
                throw new Exception("Erro ao salvar telefone: " . $e->getMessage());
            }
        }
    }
}
?>