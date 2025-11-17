<?php
$urlProduto = "http://localhost/techacademy4/public/apis/produto.php?id={$id}";
$dadosProduto = json_decode(file_get_contents($urlProduto));

?>

<div class="card" style="margin-top: 40px;">
    <div class="card-header">
        <?php
        if (empty($dadosProduto->id_produto)) {
            echo "<h2>Produto inválido!</h2>";
        } else {
            echo "<h2>{$dadosProduto->nome}</h2>";
        }
        ?>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4">
                <img src="<?=$img?><?=$dadosProduto->imagem?>" class="w-100" alt="<?=$dadosProduto->nome?>">
            </div>
            <div class="col-12 col-md-8 d-flex flex-column">
                <p><strong>Dados do Produto:</strong></p>
                <?=$dadosProduto->descricao?>

                <div class="mt-auto">
                <p class="float-start valor">
                    R$ <?=number_format($dadosProduto->valor, 2, ",", ".")?>
                </p>
                <p class="float-end">
                    <a href="carrinho/adicionar/<?=$dadosProduto->id_produto?>" class="btn btn-formulario">
                        <i class="fas fa-plus"></i> Adicionar ao carrinho
                    </a>
                </p>
                </div>
            </div>
        </div>
    </div>
</div>
