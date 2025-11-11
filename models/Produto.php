<?php
class Produto {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getByCategoria($id_categoria) {
        $query = "SELECT * FROM produto WHERE id_categoria = :id_categoria AND ativo = 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
