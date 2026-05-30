<?php
require_once '../classes/Database.php';
require_once '../classes/Jogo.php';
require_once '../includes/auth_guard.php';

$id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$jogo = (new Jogo())->buscarPorId($id);

if (!$jogo) {
    die('Jogo não encontrado.');
}

$preco      = (float)$jogo['preco'];
$desconto   = 0;
$precoFinal = $preco - $desconto;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra - <?= htmlspecialchars($jogo['nome']) ?></title>
    <link rel="stylesheet" href="../assets/css/finalizar-venda.css">
</head>
<body>
<section id="principal">
    <img src="../assets/img/Logo.png" alt="Logo" class="logo">
    <div class="barra"></div>
    <div class="itens">
        <h1>Finalizar Compra</h1>
        <img src="../assets/img/vendas/<?= htmlspecialchars($jogo['foto0']) ?>" alt="<?= htmlspecialchars($jogo['nome']) ?>" class="logo_game">
        <h4 class="nome-jogo"><?= htmlspecialchars($jogo['nome']) ?></h4>

        <div class="precos">
            <ul>
                <li><h4>Preço base:</h4></li>
                <li><h4>Descontos:</h4></li>
                <li><h4>Preço final:</h4></li>
            </ul>
            <ul>
                <li><h4 id="preco-base">R$ <?= number_format($preco, 2, ',', '.') ?></h4></li>
                <li><h4 id="preco-desconto">R$ <?= number_format($desconto, 2, ',', '.') ?></h4></li>
                <li><h4 id="preco-final">R$ <?= number_format($precoFinal, 2, ',', '.') ?></h4></li>
            </ul>
        </div>

        <input class="promocional" type="text" id="campo-cupom" placeholder="Insira o código promocional...">
        <div class="barra2"></div>
        <div class="email">
            <input type="checkbox" name="email_promocional" id="email">
            <label for="email">Ao marcar esta opção eu concordo com os Termos de licença, receber a via pelo Email e as políticas de privacidade do site e do produto.</label>
        </div>

        <div class="comprar_btn">
            <button class="confirmar" onclick="confirmarCompra()">Confirmar compra!</button>
            <button class="cancelar" onclick="window.location.href='../index.php'">Cancelar compra</button>
        </div>
    </div>
</section>

<script>
const precoOriginal = <?= $preco ?>;

document.getElementById('campo-cupom').addEventListener('input', function () {
    const cupom = this.value.trim();
    if (!cupom) { atualizarPrecos(0); return; }
    fetch(`../assets/php/cupom.php?cupom=${encodeURIComponent(cupom)}`)
        .then(r => r.json())
        .then(data => atualizarPrecos(data.desconto || 0));
});

function atualizarPrecos(descontoPercentual) {
    const desconto   = precoOriginal * (descontoPercentual / 100);
    const precoFinal = precoOriginal - desconto;
    document.getElementById('preco-desconto').innerText = 'R$ ' + desconto.toFixed(2).replace('.', ',');
    document.getElementById('preco-final').innerText    = 'R$ ' + precoFinal.toFixed(2).replace('.', ',');
}

function confirmarCompra() {
    fetch('../assets/php/finalizar_compra.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id_jogo=<?= $id ?>`
    })
    .then(r => r.json())
    .then(data => {
        if (data.sucesso) {
            alert('Compra confirmada! Chave: ' + data.chave);
            window.location.href = 'perfil.php';
        } else {
            alert('Erro ao finalizar compra.');
        }
    })
    .catch(() => alert('Erro ao processar a compra.'));
}
</script>
</body>
</html>
