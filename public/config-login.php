<?php
// Configurações do banco de dados
$host = 'localhost'; 
$db = 'mais_autonomia';
$user = 'root';

try {
    // Cria uma nova conexão PDO sem senha
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Trata o erro caso não consiga conectar
    echo "Não foi possível conectar ao banco de dados: " . $e->getMessage();
}
?>

