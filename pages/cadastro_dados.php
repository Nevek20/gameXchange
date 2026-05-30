<?php
require_once '../classes/Database.php';
require_once '../classes/Usuario.php';
require_once '../includes/guest_guard.php';

if (empty($_SESSION['data_nascimento'])) {
    header('Location: cadastro.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email      = trim($_POST['email'] ?? '');
    $nomeReal   = trim($_POST['nome_real'] ?? '') . ' ' . trim($_POST['sobrenome'] ?? '');
    $nomePerfil = trim($_POST['nome_perfil'] ?? '');
    $senha      = $_POST['senha'] ?? '';

    if (empty($email) || empty($nomePerfil) || empty($senha)) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } else {
        $usuario = new Usuario();
        if ($usuario->emailExiste($email)) {
            $erro = 'Este e-mail já está cadastrado.';
        } elseif ($usuario->cadastrar($email, trim($nomeReal), $nomePerfil, $senha, $_SESSION['data_nascimento'])) {
            $_SESSION['recem_cadastrado'] = true;
            header('Location: cadastro_concluido.php');
            exit;
        } else {
            $erro = 'Erro ao criar conta. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameXchange - Criar Conta</title>
    <link rel="stylesheet" href="../assets/css/login3.css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <script src="../assets/js/login3.js" defer></script>
</head>
<body>
<div class="container">
    <div class="form-container">
        <div class="text-center mb-6">
            <img src="../assets/img/Logo.png" alt="GameXchange Logo" class="logo">
        </div>
        <h2 class="subtitle">Criar conta</h2>

        <?php if ($erro): ?>
            <p class="erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Endereço de e-mail" class="input-field" required>
            </div>
            <div class="input-group flex">
                <input type="text" name="nome_real"  placeholder="Nome"      class="input-field half" required>
                <input type="text" name="sobrenome"  placeholder="Sobrenome" class="input-field half" required>
            </div>
            <div class="input-group">
                <input type="text" name="nome_perfil" placeholder="Nome de exibição" class="input-field" required>
            </div>
            <div class="input password-input">
                <input type="password" name="senha" placeholder="Criar senha" id="password" required>
            </div>
            <div class="input-group">
                <label class="checkbox-container">
                    <input type="checkbox" required>
                    <span class="checkbox-text">Confirmo que li e aceito os <a href="#" class="link">Termos de serviço</a>.</span>
                </label>
            </div>
            <div class="input-group">
                <label class="checkbox-container">
                    <input type="checkbox">
                    <span class="checkbox-text">Receber novidades e ofertas da GameXchange (opcional)</span>
                </label>
            </div>
            <button type="submit" class="submit-button">Continuar</button>
        </form>

        <div class="text-center mt-6">
            <p class="footer-text">Já tem uma conta? <a href="login.php" class="link">Entrar</a></p>
        </div>
    </div>
</div>
</body>
</html>
