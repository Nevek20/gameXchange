<?php
require_once '../classes/Database.php';
require_once '../classes/Jogo.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$id    = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$jogoClass = new Jogo();
$jogo  = $jogoClass->buscarPorId($id);

// Adiciona ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_jogo'])) {
    $idJogo = (int)$_POST['id_jogo'];
    $_SESSION['carrinho'] = $_SESSION['carrinho'] ?? [];
    if (!in_array($idJogo, $_SESSION['carrinho'])) {
        $_SESSION['carrinho'][] = $idJogo;
    }
    header('Location: carrinho.php');
    exit;
}

$depth     = '../';
$pageTitle = $jogo ? htmlspecialchars($jogo['nome']) . ' - GameXchange' : 'Jogo não encontrado';
$cssExtra  = ['vendas.css'];
include '../includes/header.php';
?>

<main>
<?php if ($jogo): ?>
    <h1 style="font-size:60px; font-weight:bold; padding-left:30px; margin-bottom:-2rem;"><?= htmlspecialchars($jogo['nome']) ?></h1>
    <br>
    <h1 style="padding-left:30px; margin-bottom:3rem;">Nota: <?= htmlspecialchars($jogo['nota']) ?>/100</h1>
    <h6 style="margin-left:15rem; font-size:20px; font-weight:bold; padding-top:10px;">Data de lançamento: <?= htmlspecialchars($jogo['data_lancamento']) ?></h6>
    <h6 style="margin-left:15rem; font-size:20px; font-weight:bold; padding-top:10px;">Classificação indicativa: <?= htmlspecialchars($jogo['classificacao_indicativa']) ?></h6>

    <section class="imagens-principais">
        <div class="main-wrapper">
            <div class="main-image">
                <img class="main-image-img" style="height:31rem; width:30rem;"
                     src="../assets/img/vendas/<?= htmlspecialchars($jogo['foto0']) ?>" alt="foto principal">
            </div>
            <div class="grid-images">
                <?php foreach (['foto1','foto2','foto3','foto4'] as $f): ?>
                    <img class="grid-image" src="../assets/img/vendas/<?= htmlspecialchars($jogo[$f]) ?>" alt="<?= $f ?>">
                <?php endforeach; ?>
            </div>
        </div>
        <h4 style="font-size:37px; font-weight:bold;">R$ <?= htmlspecialchars($jogo['preco']) ?>,00</h4>
    </section>

    <section class="comprar" style="display:flex; justify-content:center; align-items:center; flex-direction:column; margin-top:3rem;">
        <ul style="list-style:none; padding:0; display:flex; flex-direction:column; align-items:center; gap:1rem;">
            <li>
                <a href="finalizar_venda.php?id=<?= $jogo['id_jogos'] ?>"
                   style="border:2px solid black; text-decoration:none; padding:10px; border-radius:8px; width:372px; height:45px; display:flex; justify-content:center; align-items:center;">
                    Comprar agora
                </a>
            </li>
            <li>
                <form action="jogo.php" method="POST">
                    <input type="hidden" name="id_jogo" value="<?= $jogo['id_jogos'] ?>">
                    <button type="submit"
                            style="cursor:pointer; border:2px solid black; font-size:16px; background-color:#6300aa; color:white; padding:10px; border-radius:8px; width:372px; height:45px; display:flex; justify-content:center; align-items:center;"
                            onmouseover="this.style.backgroundColor='#48156d'"
                            onmouseout="this.style.backgroundColor='#6300aa'">
                        Adicionar ao Carrinho
                    </button>
                </form>
            </li>
            <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin'): ?>
            <li>
                <a href="jogo_form.php?id=<?= $jogo['id_jogos'] ?>"
                   style="border:2px solid black; color:whitesmoke; text-decoration:none; padding:10px; border-radius:8px; width:372px; height:45px; display:flex; justify-content:center; align-items:center;">
                    Editar
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </section>

    <section id="infos">
        <div class="palavras">
            <h3 style="font-size:larger; margin-left:8rem; font-weight:bolder;">Descrição do jogo</h3>
            <br>
            <h4 style="font-weight:100; margin-left:8rem; font-size:20px;">
                <?= nl2br(htmlspecialchars($jogo['descricao'])) ?>
            </h4>
        </div>
    </section>

    <div style="max-width:1200px; margin:0 auto; padding:2rem;">
        <h3 style="font-size:large; font-weight:bolder; padding:25px 0 15px; margin-left:5.5rem;">Você também pode gostar</h3>
        <div style="display:flex; gap:2rem; overflow-x:hidden; padding:1rem 0; margin-left:5rem;">
            <?php foreach ($jogoClass->buscarSimilares($id) as $s): ?>
                <div style="background-color:#2c1e4a; border-radius:10px; padding:10px; min-width:200px; text-align:center;"
                     onmouseover="this.style.transform='scale(1.05)'; this.style.backgroundColor='#3d2e60';"
                     onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='#2c1e4a';">
                    <a href="jogo.php?id=<?= $s['id_jogos'] ?>" style="text-decoration:none; color:inherit;">
                        <img src="../assets/img/vendas/<?= htmlspecialchars($s['foto0']) ?>"
                             alt="<?= htmlspecialchars($s['nome']) ?>"
                             style="width:180px; height:200px; object-fit:cover; border-radius:8px; margin-bottom:10px; display:block;">
                        <p style="font-weight:bold; color:#fff;"><?= htmlspecialchars($s['nome']) ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php else: ?>
    <h1 style="text-align:center; margin-top:50px;">Jogo não encontrado.</h1>
<?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>
