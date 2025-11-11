<?php
class CategoriaController {

    public function index($id_categoria, $img) {

        require_once "../config/Conexao.php";
        $pdo = Conexao::conectar();
        
        require_once "../models/Produto.php";
        require_once "../models/Categoria.php";

        $produtoModel = new Produto($pdo);
        $categoriaModel = new Categoria($pdo);

        $produtos = $produtoModel->getByCategoria($id_categoria);
        $categoria = $categoriaModel->getById($id_categoria);

        require "../views/categoria/index.php";
    }
}
