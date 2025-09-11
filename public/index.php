<?php
session_start();
if (empty($_SESSION['user'])){
    require_once __DIR__ . '/../src/Views/Auth/Login.php';
    exit;
}
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/assets/css/style.css"> 
</head>
<?php 
require_once __DIR__ . '/../src/Views/Header.php';
?>
<main>
</main>
<?php 
require_once __DIR__ . '/../src/Views/Footer.php';
?>