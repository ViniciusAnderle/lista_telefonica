<?php
require_once __DIR__ . '/../classes/Contato.php';

class ContatoController
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

    public function obterTodosContatos()
    {
        try {
            $stmt = $this->conn->query("SELECT * FROM contatos");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao obter contatos: " . $e->getMessage();
            return array();
        }
    }
    public function obterContatosPorNome($nome)
{
    try {
        $sql = "SELECT * FROM contatos WHERE nome_completo LIKE :nome";
        $stmt = $this->conn->prepare($sql);
        $nomeParam = '%' . $nome . '%';
        $stmt->bindParam(':nome', $nomeParam);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Erro ao obter contatos por nome: " . $e->getMessage());
    }
}


    public function validarCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11) {
        return false;
    }
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    $sum = 0;
    for ($i = 0; $i < 9; $i++) {
        $sum += $cpf[$i] * (10 - $i);
    }
    $remainder = $sum % 11;
    $digit1 = ($remainder < 2) ? 0 : (11 - $remainder);
    if ($cpf[9] != $digit1) {
        return false;
    }
    $sum = 0;
    for ($i = 0; $i < 10; $i++) {
        $sum += $cpf[$i] * (11 - $i);
    }
    $remainder = $sum % 11;
    $digit2 = ($remainder < 2) ? 0 : (11 - $remainder);
    if ($cpf[10] != $digit2) {
        return false;
    }

    return true;
}


    public function salvarContato($nomeCompleto, $cpf, $email, $dataNascimento)
    {
        try {
            $dataNascimentoFormatted = date('Y-m-d', strtotime($dataNascimento));
            if (!$this->validarCPF($cpf)) {
                throw new Exception("O CPF informado é inválido.");
            }
                        if ($this->verificarExistenciaCPF($cpf)) {
                            throw new Exception("O CPF informado já está cadastrado.");
                        }
                        if ($this->verificarExistenciaEmail($email)) {
                            throw new Exception("O e-mail informado já está cadastrado.");
                        }
                        $sql = "INSERT INTO contatos (nome_completo, cpf, email, data_nascimento) VALUES (:nome_completo, :cpf, :email, :data_nascimento)";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(':nome_completo', $nomeCompleto);
                        $stmt->bindParam(':cpf', $cpf);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':data_nascimento', $dataNascimentoFormatted);
                        $stmt->execute();
            
                        return $this->conn->lastInsertId();
                    } catch (Exception $e) {
                        throw $e;
                    }
                }
            
                public function verificarExistenciaCPF($cpf)
                {
                    $sql = "SELECT COUNT(*) FROM contatos WHERE cpf = :cpf";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':cpf', $cpf);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();
                    return ($count > 0);
                }
            
                public function verificarExistenciaEmail($email)
                {
                    $sql = "SELECT COUNT(*) FROM contatos WHERE email = :email";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();
                    return ($count > 0);
                }
            
                public function obterContato($id)
                {
                    $sql = "SELECT * FROM contatos WHERE id = :id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $contatoData = $stmt->fetch();
            
                    if ($contatoData) {
                        return new Contato($contatoData['nome_completo'], $contatoData['cpf'], $contatoData['email'], $contatoData['data_nascimento']);
                    } else {
                        return null;
                    }
                }  
                public function excluirContato($id)
                {
                    try {
                        $stmt = $this->conn->prepare("DELETE FROM contatos WHERE id = :id");
                        $stmt->bindParam(':id', $id);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        throw new Exception("Erro ao excluir o contato: " . $e->getMessage());
                    }
                }
            }
            