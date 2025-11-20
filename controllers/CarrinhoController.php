<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/Conexao.php';
require_once __DIR__ . '/../models/Carrinho.php';
require_once __DIR__ . '/../public/vendor/autoload.php';
class CarrinhoController {

    /** @var \PDO */
    private $pdo;
    /** @var \Carrinho */
    private $carrinho;

    public function __construct() {
        $db = new Conexao();
        $pdo = $db->conectar();
        $this->pdo = $pdo;
        $this->carrinho = new Carrinho($pdo);
    }
    public function index($id = null, $img = null){
        require "../views/carrinho/index.php";
    }

    public function adicionar($id = null, $img = null){
        require "../views/carrinho/adicionar.php";
    }

    public function excluir($id, $img = null){
        unset($_SESSION['carrinho'][$id]);
        require "../views/carrinho/index.php";
    }

    public function limpar(){
        unset($_SESSION['carrinho']);
        require "../views/carrinho/index.php";
    }

    public function cadastrar(){
        require "../views/carrinho/cadastrar.php";
    }
    public function cadastro(){
        require "../views/carrinho/cadastro.php";
    }

    public function logar(){
        require "../views/carrinho/logar.php";
    }

    public function sair($id, $img){
        unset($_SESSION["cliente"]);
        require "../views/carrinho/index.php";
    }

    public function finalizar(){
        $this->carrinho->finalizar();
    }
}
