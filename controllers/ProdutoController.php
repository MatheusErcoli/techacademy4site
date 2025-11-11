<?php
class ProdutoController {
    public function index($id, $img) {
        require "../views/produto/index.php";
    }

    public function detalhes($id, $img) {
        require "../views/produto/detalhes.php";
    }
}
?>
