<?php
class Database
{
    private static $conn;
    public static function getConnection()
    {
        if (!isset(self::$conn)) {
            $host = 'localhost';  
            $db = 'testebackend';
            $user = 'root';       
            $pass = '';          

            try {
                self::$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
?>
