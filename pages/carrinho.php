<?php
require_once '../classes/Database.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$carrinho   = $_SESSION['carrinho'] ?? [];
$listaJogos = [];

if (!empty($carrinho)) {
    $db           = Database::getInstance();
    $placeholders = implode(',', array_fill(0, count($carrinho), '?'));
    $stmt = $db->prepare("SELECT * FROM tb_jogos WHERE id_jogos IN ($placeholders)");
    $stmt->execute($carrinho);
    $listaJogos = $stmt->fetchAll();
}

$depth     = '../';
$pageTitle = 'Meu Carrinho - GameXchange';
include '../includes/header.php';
?>

<main>
    <h1 style="padding:20px; margin-left:1rem;">Seu Carrinho</h1>

    <?php if (empty($listaJogos)): ?>
        <p style="padding:20px; margin-left:1rem;">Seu carrinho está vazio.</p>
    <?php else: ?>
        <div class="carrinho-itens">
            <?php foreach ($listaJogos as $j): ?>
                <div class="item-carrinho">
                    <img src="../assets/img/vendas/<?= htmlspecialchars($j['foto0']) ?>"
                         alt="<?= htmlspecialchars($j['nome']) ?>"
                         style="width:150px; height:150px; margin-bottom:0.5rem;">
                    <h2><?= htmlspecialchars($j['nome']) ?></h2>
                    <p>Nota: <?= htmlspecialchars($j['nota']) ?>/100</p>
                    <p>Classificação: <?= htmlspecialchars($j['classificacao_indicativa']) ?></p>
                    <div style="margin-top:1rem;">
                        <form action="finalizar_venda.php" method="GET">
                            <input type="hidden" name="id" value="<?= $j['id_jogos'] ?>">
                            <button type="submit" style="padding:8px 16px; background-color:green; color:white; border:none; border-radius:5px; cursor:pointer;">
                                Comprar este jogo
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <a href="../index.php" style="display:inline-block; padding:10px 20px; background-color:#007bff; color:white; font-size:18px; border-radius:5px; text-decoration:none; margin-right:10px;">
                Continuar Comprando
            </a>
            <a href="finalizar_venda_jogos.php" style="display:inline-block; padding:10px 20px; background-color:#28a745; color:white; font-size:18px; border-radius:5px; text-decoration:none;">
                Finalizar Compra
            </a>
        </div>
    <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>
