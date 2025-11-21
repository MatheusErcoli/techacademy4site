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

    /**
     * Verifica o estoque de um produto
     * @param int $id_produto ID do produto
     * @return int 1 se tem estoque, 0 se não tem
     */
    public function verificarEstoque($id_produto) {
        $query = "SELECT verificar_estoque(:id_produto) as estoque";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id_produto", $id_produto, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_OBJ);
        return (int)($resultado->estoque ?? 0);
    }
}
