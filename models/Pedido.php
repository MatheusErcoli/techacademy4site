<?php 
    class Pedido {
        private $pdo;

        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        public function getPedidos(){
            $sql = 'select *, date_format(data_pedido, "%d/%m/%Y %H:%i") dt
             from pedido where id_cliente = :id_cliente order by data_pedido';
            $consulta = $this->pdo->prepare($sql);
            $consulta->bindParam(':id_cliente', $_SESSION["cliente"]["id"]);
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }

        public function getItens($pedido){
            $sql = 'select p.nome, i.preco_unitario, i.quantidade from itempedido i inner join produto p on (p.id_produto = i.id_produto) where i.id_pedido = :pedido order by p.nome';
             $consulta = $this->pdo->prepare($sql);
            $consulta->bindParam(':pedido', $pedido);
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }
    }

?>