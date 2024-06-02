<?php
$lockFile = __DIR__ . '/sql/.db_initialized';

if (!file_exists($lockFile)) {
    $host = 'localhost'; 
    $user = 'root';       
    $pass = '';           
    $db = 'testebackend'; 

    try {
        $conn = new PDO("mysql:host=$host", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $conn->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db'");
        if ($result->fetchColumn() == 0) {
            $conn->exec("CREATE DATABASE $db");
            echo "<div class='container'><p style='color: green;'>Banco de dados $db criado com sucesso!<p></div><br>";
            $conn->exec("USE $db");
            $sql = file_get_contents(__DIR__ . '/sql/testebackend.sql');
            if ($sql === false) {
                throw new Exception("Não foi possível ler o arquivo SQL.");
            }
            $conn->exec($sql);
            echo "<div class='container'><p style='color: green;'>Script SQL executado com sucesso!<p></div><br>";
        }
        file_put_contents($lockFile, 'Database initialized');
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    } catch (Exception $e) {
        die("Erro: " . $e->getMessage());
    }
}
?>
