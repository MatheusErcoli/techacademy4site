<?php
$urlCategoria = "http://localhost/techAcademy4/public/apis/categoria.php?id={$id_categoria}";
$dadosCategoria = json_decode(file_get_contents($urlCategoria));

// Garantir que $dadosCategoria seja sempre o objeto da categoria
if (is_array($dadosCategoria)) {
    $dadosCategoria = $dadosCategoria[0];
}


$urlProduto = "http://localhost/techAcademy4/public/apis/produto.php";
$dadosProduto = json_decode(file_get_contents($urlProduto));
?>


<div class="card" style="margin-top: 40px;">
    <div class="card-header">
            <h2><?= $categoria->nome ?></h2>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="row mt-4">
                    <?php foreach ($produtos as $p): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card text-center">
                                <img src="<?= $img . $p->imagem ?>" class="card-img-top" alt="<?= $p->nome ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $p->nome ?></h5>
                                    <p class="card-text">R$ <?= number_format($p->valor, 2, ",", ".") ?></p>
                                    <a href="produto/detalhes/<?= $p->id_produto ?>" class="btn btn-formulario">
                                        <i class="fas fa-search"></i> Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
            </div>


        </div>
    </div>
</div>