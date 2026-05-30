<?php
require_once 'classes/Database.php';
require_once 'classes/Jogo.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$jogo       = new Jogo();
$aleatorios = $jogo->listarAleatorios(6);
$vendidos   = $jogo->listarMaisVendidos(5);
$editor     = $jogo->listarEscolhasEditor(5);
$lancamentos = $jogo->listarLancamentos(5);

$pageTitle = 'GameXchange - Store';
include 'includes/header.php';
?>

<main>
    <section id="descobrir">
        <form class="search-container" action="pages/pesquisa.php" method="GET">
            <input type="text" name="q" placeholder="Pesquisar na loja..." required>
            <button type="submit" class="search-button">
                <img src="assets/img/lupa.png" alt="Buscar">
            </button>
        </form>
        <ul>
            <li><a href="#mais_vendidos">Mais vendidos</a></li>
            <li><a href="#escolhas_Do_Editor">Escolhas do editor</a></li>
            <li><a href="#lancamentos">Lançamentos</a></li>
        </ul>
    </section>

    <section id="carrosel">
        <img src="assets/img/Banner_GOW.png" alt="Banner God Of War: Ragnarok">
        <ul class="lista-produtos">
            <?php foreach ($aleatorios as $j): ?>
                <li>
                    <a href="pages/jogo.php?id=<?= (int)$j['id_jogos'] ?>">
                        <img src="assets/img/banners/<?= htmlspecialchars($j['foto0']) ?>" alt="<?= htmlspecialchars($j['nome']) ?>">
                        <br><?= htmlspecialchars($j['nome']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section id="mais_vendidos">
        <ul><li><a href="#">Mais vendidos</a></li></ul>
    </section>
    <section class="vendidos">
        <nav>
            <ul class="vendidos">
                <?php foreach ($vendidos as $j): ?>
                    <li>
                        <a href="pages/jogo.php?id=<?= (int)$j['id_jogos'] ?>">
                            <img src="assets/img/banners/<?= htmlspecialchars($j['banner']) ?>" alt="<?= htmlspecialchars($j['nome']) ?>">
                            <h3><?= htmlspecialchars($j['nome']) ?></h3>
                            <h4>R$ <?= number_format($j['preco'], 2, ',', '.') ?></h4>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </section>

    <section id="escolhas_Do_Editor">
        <ul><li><a href="#">Escolhas Do Editor</a></li></ul>
    </section>
    <section class="escolhasDoEditor">
        <nav>
            <ul class="escolhasDoEditor">
                <?php foreach ($editor as $j): ?>
                    <li>
                        <a href="pages/jogo.php?id=<?= (int)$j['id_jogos'] ?>">
                            <img src="assets/img/banners/<?= htmlspecialchars($j['foto0']) ?>" alt="<?= htmlspecialchars($j['nome']) ?>">
                            <h3><?= htmlspecialchars($j['nome']) ?></h3>
                            <h4>R$ <?= number_format($j['preco'], 2, ',', '.') ?></h4>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </section>

    <section id="lancamentos">
        <ul><li><a href="#">Lançamentos</a></li></ul>
    </section>
    <section class="lancamentos">
        <nav>
            <ul class="lancamentos">
                <?php foreach ($lancamentos as $j): ?>
                    <li>
                        <a href="pages/jogo.php?id=<?= (int)$j['id_jogos'] ?>">
                            <img src="assets/img/banners/<?= htmlspecialchars($j['foto0']) ?>" alt="<?= htmlspecialchars($j['nome']) ?>">
                            <h3><?= htmlspecialchars($j['nome']) ?></h3>
                            <h4>R$ <?= number_format($j['preco'], 2, ',', '.') ?></h4>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
