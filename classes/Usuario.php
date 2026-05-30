<?php
require_once __DIR__ . '/Database.php';

class Usuario {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function cadastrar(string $email, string $nomeReal, string $nomePerfil, string $senha, string $dataNascimento): bool {
        if ($this->emailExiste($email)) return false;

        $stmt = $this->db->prepare(
            "INSERT INTO tb_usuario (email, nome_perfil, nome_real, senha, data_nascimento, qtd_jogos, tipo)
             VALUES (:email, :nome_perfil, :nome_real, :senha, :data_nascimento, 0, 'comum')"
        );
        return $stmt->execute([
            ':email'           => $email,
            ':nome_perfil'     => $nomePerfil,
            ':nome_real'       => $nomeReal,
            ':senha'           => password_hash($senha, PASSWORD_BCRYPT),
            ':data_nascimento' => $dataNascimento,
        ]);
    }

    public function autenticar(string $email, string $senha): array|false {
        $stmt = $this->db->prepare("SELECT * FROM tb_usuario WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();
        return ($usuario && password_verify($senha, $usuario['senha'])) ? $usuario : false;
    }

    public function buscarPorId(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM tb_usuario WHERE id_usuario = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function emailExiste(string $email): bool {
        $stmt = $this->db->prepare("SELECT id_usuario FROM tb_usuario WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->rowCount() > 0;
    }

    public function jogosComprados(int $usuarioId): array {
        $stmt = $this->db->prepare(
            "SELECT j.nome, j.foto0, c.chave_ativacao
             FROM tb_compras c
             INNER JOIN tb_jogos j ON c.id_jogos = j.id_jogos
             WHERE c.id_usuario = :id"
        );
        $stmt->execute([':id' => $usuarioId]);
        return $stmt->fetchAll();
    }
}
