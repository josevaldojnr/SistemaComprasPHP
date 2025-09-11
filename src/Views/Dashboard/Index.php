<?php
if (session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
if (empty($_SESSION['user'])){
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>
    <?php require __DIR__ . '/../Header.php'; ?>

    <main>
        <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['user']); ?></h1>
    </main>

    <?php require __DIR__ . '/../Footer.php'; ?>
</body>
</html>