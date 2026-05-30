<?php
require_once '../classes/Database.php';
require_once '../classes/Usuario.php';
require_once '../includes/guest_guard.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $usuario = (new Usuario())->autenticar($email, $senha);

    if ($usuario) {
        $_SESSION['usuario_id']          = $usuario['id_usuario'];
        $_SESSION['usuario_nome_perfil'] = $usuario['nome_perfil'];
        $_SESSION['usuario_nome_real']   = $usuario['nome_real'];
        $_SESSION['usuario_email']       = $usuario['email'];
        $_SESSION['usuario_tipo']        = $usuario['tipo'];
        header('Location: ../index.php');
        exit;
    }
    $erro = 'Email ou senha incorretos.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameXchange - Entrar</title>
    <link rel="stylesheet" href="../assets/css/login1.css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <script src="../assets/js/login1.js" defer></script>
</head>
<body>
<main>
    <div class="login1-container">
        <div class="logo"><img src="../assets/img/Logo.png" alt="Logo"></div>
        <h2>Entrar</h2>

        <?php if ($erro): ?>
            <p class="erro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="input">
                <input type="email" name="email" placeholder="Endereço de e-mail" required>
            </div>
            <div class="input password-input">
                <input type="password" name="senha" placeholder="Senha" id="password" required>
                <span class="mostrar_senha" onclick="togglePassword()">
                    <img id="eye"      src="../assets/img/olhoFechado.png" alt="Olho fechado" class="eye-icon">
                    <img id="eye-open" src="../assets/img/olhoAberto.png"  alt="Olho aberto"  class="eye-icon" style="display:none;">
                </span>
            </div>
            <a href="esqueci_senha.php" class="esqueci_senha" style="font-size:12px;">Esqueci minha senha</a>
            <button type="submit" class="btn-login">Entrar</button>
            <p>ou</p>
            <a href="cadastro.php" class="Registrar">Registre-se</a>
        </form>
    </div>
</main>
</body>
</html>
