<?php
class CategoriaController {

    public function index($id_categoria, $img) {

        require_once "../config/Conexao.php";
        $pdo = Conexao::conectar();
        
        require_once "../models/Produto.php";
        require_once "../models/Categoria.php";

        $produto = new Produto($pdo);
        $categoria = new Categoria($pdo);

        $produtos = $produto->getByCategoria($id_categoria);
        $categoria = $categoria->getById($id_categoria);

        require "../views/categoria/index.php";
    }
}
