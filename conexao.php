<?php

// conexao.php

// Verifica se as constantes já foram definidas
if (!defined('HOST')) define('HOST', 'localhost');
if (!defined('USER')) define('USER', 'root');
if (!defined('PASSWORD')) define('PASSWORD', '');  // Defina a senha correta, se necessário
if (!defined('DATABASE')) define('DATABASE', 'cadastro');

try {
  // Conexão usando PDO
  $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASSWORD);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Erro na conexão: " . $e->getMessage();
  die(); // Para a execução se houver um erro de conexão
}
