<?php
require_once __DIR__ . '/../classes/Endereco.php';

class EnderecoController
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

    public function obterEnderecoPorContato($contato_id)
    {
        try {
            $sql = "SELECT * FROM endereco WHERE contato_id = :contato_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':contato_id', $contato_id);
            $stmt->execute();
            $enderecoData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($enderecoData) {
                return new Endereco($enderecoData['cep'], $enderecoData['endereco'], $enderecoData['numero_residencia'], $enderecoData['bairro'], $enderecoData['cidade'], $enderecoData['uf']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erro ao obter endereço: " . $e->getMessage();
        }
    }
    
    public function cadastrarEndereco($contato_id, $cep, $endereco, $numero_residencia, $bairro, $cidade, $uf)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO endereco (contato_id, cep, endereco, numero_residencia, bairro, cidade, uf) VALUES (:contato_id, :cep, :endereco, :numero_residencia, :bairro, :cidade, :uf)");
            $stmt->bindParam(':contato_id', $contato_id);
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':numero_residencia', $numero_residencia);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':uf', $uf);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao cadastrar endereço: " . $e->getMessage());
        }
    }

    public function editarEndereco($contato_id, $cep, $endereco, $numero_residencia, $bairro, $cidade, $uf)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE endereco SET cep = :cep, endereco = :endereco, numero_residencia = :numero_residencia, bairro = :bairro, cidade = :cidade, uf = :uf WHERE contato_id = :contato_id");
            $stmt->bindParam(':contato_id', $contato_id);
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':numero_residencia', $numero_residencia);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':uf', $uf);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao editar endereço: " . $e->getMessage());
        }
    }
}
?>
