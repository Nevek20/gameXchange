<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$usuarioLogado = $_SESSION['usuario_nome_perfil'] ?? null;

// $pageTitle e $cssAdicional devem ser definidos antes de incluir este arquivo
$depth = $depth ?? '';  // páginas em /pages/ precisam de '../'
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'GameXchange') ?></title>
    <link rel="stylesheet" href="<?= $depth ?>assets/css/style.css">
    <?php foreach ($cssExtra ?? [] as $css): ?>
        <link rel="stylesheet" href="<?= $depth ?>assets/css/<?= $css ?>">
    <?php endforeach; ?>
    <?php foreach ($jsExtra ?? [] as $js): ?>
        <script src="<?= $depth ?>assets/js/<?= $js ?>" defer></script>
    <?php endforeach; ?>
    <link rel="shortcut icon" href="<?= $depth ?>favicon.ico" type="image/x-icon">
</head>
<body>

<header>
    <img src="<?= $depth ?>assets/img/Logo.png" alt="Logo GameXchange">
    <nav class="opcoes1">
        <ul>
            <li><a href="<?= $depth ?>index.php">Store</a></li>
            <li><a href="<?= $depth ?>pages/sobre.php">Sobre</a></li>
            <li><a href="<?= $depth ?>pages/suporte.php">Suporte</a></li>
        </ul>
        <div class="user-menu">
            <?php if ($usuarioLogado): ?>
                <a href="<?= $depth ?>pages/perfil.php" class="user-text"><?= htmlspecialchars($usuarioLogado) ?></a>
                <a href="<?= $depth ?>pages/logout.php" class="btn-login logout-btn">Sair</a>
            <?php else: ?>
                <a href="<?= $depth ?>pages/login.php" class="btn-login">Entrar</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
