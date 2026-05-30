<?php
$depth     = '../';
$pageTitle = 'Suporte - GameXchange';
$cssExtra  = ['suporte.css'];
include '../includes/header.php';
?>

<main class="suporte">
    <div style="display:flex; justify-content:center; padding-bottom:40px;">
        <h1>Encontrou algum problema? Nos conte para podermos corrigir o mais rápido possível!</h1>
    </div>
    <div class="barra"></div>
    <form action="form_suporte.php" method="POST" class="form-suporte">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" required></textarea>

        <label for="gravidade">Gravidade:</label>
        <input type="number" id="gravidade" name="gravidade" min="1" max="10" required>

        <button type="submit">Enviar</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>
