<?php
$conn = new mysqli("127.0.0.1", "root", "minhasenha123", "sistema_compras", 3306);

if ($conn->connect_error) {
    die("❌ Falha na conexão: " . $conn->connect_error);
}

echo "✅ Conectado com sucesso!";
?>
