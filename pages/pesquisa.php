<?php
require_once '../classes/Database.php';
require_once '../classes/Jogo.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$termo      = trim($_GET['q'] ?? '');
$resultados = $termo ? (new Jogo())->buscar($termo) : [];

$depth     = '../';
$pageTitle = 'Pesquisa - GameXchange';
include '../includes/header.php';
?>

<main>
    <h1 style="margin-left:6.5rem; margin-bottom:3.5rem; color:#fff;">
        Resultados para "<?= htmlspecialchars($termo) ?>"
    </h1>

    <?php if (!empty($resultados)): ?>
        <div class="lista_resultados" style="display:grid; grid-template-columns:repeat(auto-fit,250px); gap:1rem; justify-content:center;">
            <?php foreach ($resultados as $j): ?>
                <div class="jogo" style="background-color:#2c1e4a; border-radius:20px; padding:1rem; width:250px; display:flex; flex-direction:column; align-items:center; transition:transform 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-5px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <a href="jogo.php?id=<?= (int)$j['id_jogos'] ?>" style="text-decoration:none; color:inherit; display:flex; flex-direction:column; align-items:center; width:100%;">
                        <img src="../assets/img/banners/<?= htmlspecialchars($j['foto0']) ?>"
                             alt="<?= htmlspecialchars($j['nome']) ?>"
                             style="width:100%; height:350px; object-fit:cover; border-radius:15px;">
                        <h2 style="font-size:1.2rem; margin-top:1rem; color:#fff; text-align:center;"><?= htmlspecialchars($j['nome']) ?></h2>
                        <p style="color:#ccc; font-size:0.95rem; text-align:center;"><?= nl2br(htmlspecialchars($j['descricao'])) ?></p>
                        <p style="color:green; font-size:20px;">R$ <?= number_format((float)$j['preco'], 2, ',', '.') ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="margin-left:6.5rem; color:#fff;">Nenhum jogo encontrado.</p>
    <?php endif; ?>
</main>

<?php include '../includes/footer.php'; ?>
