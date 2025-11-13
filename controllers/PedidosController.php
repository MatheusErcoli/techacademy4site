<?php 
    require_once "../config/Conexao.php";
    require_once "../models/Pedido.php";

    class PedidosController{
        private $pedidos;

        public function __construct()
        {
            $db = new Conexao();
            $pdo = $db->conectar();
            $this->pedidos = new Pedido($pdo);

        }

        public function index() {
            require "../views/pedidos/index.php";
        }
    }




?>