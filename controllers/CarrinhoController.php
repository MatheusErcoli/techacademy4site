<?php

class CarrinhoController {
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
}