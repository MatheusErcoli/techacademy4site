<?php
    require_once "../config/Conexao.php";
    require_once "../models/Carrinho.php";
class CarrinhoController {

    private $pdo;
    private $carrinho;

    public function __construct() {
        $db = new Conexao();
        $pdo = $db->conectar();
        $this->pdo = $pdo;
        $this->carrinho = new Carrinho($pdo);
    }
    public function index($id, $img){
        require "../views/carrinho/index.php";
    }

    public function adicionar($id, $img){
        require "../views/carrinho/adicionar.php";
    }

    public function excluir($id, $img){
        unset($_SESSION['carrinho'][$id]);
        require "../views/carrinho/index.php";
    }

    public function limpar(){
        unset($_SESSION['carrinho']);
        require "../views/carrinho/index.php";
    }

    public function finalizar(){
        if(isset($_SESSION["cliente"]["id"])){
        require "../views/carrinho/finalizar.php";
        } else {
            require "../views/carrinho/login.php"; 
        }
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
        unset($_SESSION["clientelogado"]);
        require "../views/carrinho/index.php";
}
}