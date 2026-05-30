<?php
require_once '../includes/guest_guard.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dia = (int)($_POST['dia'] ?? 0);
    $mes = (int)($_POST['mes'] ?? 0);
    $ano = (int)($_POST['ano'] ?? 0);

    if (!checkdate($mes, $dia, $ano) || $ano < 1900) {
        $erro = 'Data inválida.';
    } else {
        $idade = (new DateTime())->diff(new DateTime("$ano-$mes-$dia"))->y;
        if ($idade < 18) {
            $erro = 'Você precisa ter 18 anos ou mais para se cadastrar.';
        } else {
            $_SESSION['data_nascimento'] = sprintf('%04d-%02d-%02d', $ano, $mes, $dia);
            header('Location: cadastro_dados.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameXchange - Criar Conta</title>
    <link rel="stylesheet" href="../assets/css/login2.css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
</head>
<body>
<div class="login2-container">
    <div class="form-box">
        <img src="../assets/img/Logo.png" alt="GameXchange" class="logo">
        <h2>Criar conta</h2>
        <p>Insira sua data de nascimento</p>

        <?php if ($erro): ?>
            <div class="erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form action="cadastro.php" method="POST">
            <div class="dob-inputs">
                <select name="dia" required>
                    <option value="">Dia</option>
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <select name="mes" required>
                    <option value="">Mês</option>
                    <?php foreach (['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] as $i => $nome): ?>
                        <option value="<?= $i + 1 ?>"><?= $nome ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="ano" placeholder="Ano" min="1900" max="<?= date('Y') ?>" required>
            </div>
            <button type="submit" class="continuar">Continuar</button>
        </form>

        <p class="login-text">Já tem uma conta? <a href="login.php" class="Registrar">Entrar</a></p>
    </div>
</div>
</body>
</html>
