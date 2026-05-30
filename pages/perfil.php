<?php
require_once '../classes/Database.php';
require_once '../classes/Usuario.php';
require_once '../includes/auth_guard.php';

$depth   = '../';
$usuario = (new Usuario())->buscarPorId((int)$_SESSION['usuario_id']);
$jogos   = (new Usuario())->jogosComprados((int)$_SESSION['usuario_id']);

$pageTitle = 'Perfil | GameXchange';
include '../includes/header.php';
?>

<main style="padding:40px;">
    <section style="margin-bottom:40px;">
        <h2 style="margin-bottom:30px; font-size:50px;">Informações Pessoais</h2>
        <p style="margin-bottom:10px; font-size:25px;"><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome_real']) ?></p>
        <p style="margin-bottom:10px; font-size:25px;"><strong>Nickname:</strong> <?= htmlspecialchars($usuario['nome_perfil']) ?></p>

        <div style="margin-bottom:2rem; display:flex; align-items:center; gap:10px;">
            <input type="checkbox" id="mostrar-email" style="width:18px; height:18px; accent-color:#5ee0c3; cursor:pointer;">
            <label for="mostrar-email" style="font-size:18px; color:#ccc; cursor:pointer;">Mostrar Email</label>
        </div>
        <p id="email-usuario" style="margin-bottom:5rem; font-size:25px; display:none;">
            <strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?>
        </p>

        <?php if ($usuario['tipo'] === 'admin'): ?>
            <p style="margin-bottom:1rem; font-size:25px;"><strong>Tipo:</strong> Administrador</p>
            <a href="jogo_form.php" style="display:inline-block; background-color:#7d68f1; color:white; padding:10px 20px; font-size:16px; border-radius:8px; text-decoration:none; margin-bottom:3rem;">
                Cadastrar Jogos
            </a>
        <?php endif; ?>
    </section>

    <section>
        <h2 style="margin-bottom:30px; font-size:50px;">Meus Jogos</h2>
        <?php if (!empty($jogos)): ?>
            <div style="display:flex; flex-wrap:wrap; gap:20px;">
                <?php foreach ($jogos as $j): ?>
                    <div style="background-color:#2c1e4a; border-radius:10px; padding:10px; width:250px; text-align:center;">
                        <img src="../assets/img/vendas/<?= htmlspecialchars($j['foto0']) ?>"
                             alt="<?= htmlspecialchars($j['nome']) ?>"
                             style="height:200px; width:100%; object-fit:cover; margin-bottom:10px; border-radius:8px;">
                        <p style="font-weight:bold;"><?= htmlspecialchars($j['nome']) ?></p>
                        <p style="font-size:14px; color:#5ee0c3; word-break:break-word; font-family:monospace;">
                            <strong>Chave:</strong> <?= htmlspecialchars($j['chave_ativacao']) ?>
                        </p>
                        <button onclick="copiarChave('<?= htmlspecialchars($j['chave_ativacao']) ?>')"
                                style="margin-top:5px; font-size:13px; background:#3a2c5e; color:white; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;">
                            Copiar Chave
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Você ainda não comprou nenhum jogo.</p>
        <?php endif; ?>
    </section>
</main>

<script>
document.getElementById('mostrar-email').addEventListener('change', function () {
    document.getElementById('email-usuario').style.display = this.checked ? 'block' : 'none';
});
function copiarChave(chave) {
    navigator.clipboard.writeText(chave)
        .then(() => alert('Chave copiada!'))
        .catch(err => alert('Erro ao copiar: ' + err));
}
</script>

<?php include '../includes/footer.php'; ?>
