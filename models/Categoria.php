<?php
class Categoria {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getById($id_categoria) {
        $sql = "SELECT * FROM categoria WHERE id_categoria = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id_categoria, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
