<?php
require_once __DIR__ . '/Database.php';

class Jogo {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function listarTodos(?int $limite = null): array {
        $sql = "SELECT * FROM tb_jogos";
        if ($limite !== null) {
            $sql .= " LIMIT :limite";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->db->query($sql);
        }
        return $stmt->fetchAll();
    }

    public function listarAleatorios(int $limite = 6): array {
        $stmt = $this->db->prepare("SELECT * FROM tb_jogos ORDER BY RAND() LIMIT :limite");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarMaisVendidos(int $limite = 5): array {
        $stmt = $this->db->prepare("SELECT * FROM tb_jogos LIMIT :limite");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarEscolhasEditor(int $limite = 5): array {
        $stmt = $this->db->prepare("SELECT * FROM tb_jogos ORDER BY nota DESC LIMIT :limite");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarLancamentos(int $limite = 5): array {
        $stmt = $this->db->prepare("SELECT * FROM tb_jogos ORDER BY data_lancamento DESC LIMIT :limite");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM tb_jogos WHERE id_jogos = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function buscarSimilares(int $idAtual, int $limite = 5): array {
        $stmt = $this->db->prepare(
            "SELECT * FROM tb_jogos WHERE id_jogos != :id ORDER BY RAND() LIMIT :limite"
        );
        $stmt->bindValue(':id', $idAtual, PDO::PARAM_INT);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function buscar(string $termo): array {
        $stmt = $this->db->prepare("SELECT * FROM tb_jogos WHERE nome LIKE :termo");
        $stmt->execute([':termo' => '%' . $termo . '%']);
        return $stmt->fetchAll();
    }
}
