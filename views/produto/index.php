<div class="card" style="margin-top: 40px;">
    <div class="card-header">
        <h2>Todos os Produtos</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            $urlProduto = "http://localhost/techacademy4/public/apis/produto.php";
            $dadosProduto = json_decode(file_get_contents($urlProduto));
            foreach ($dadosProduto as $dados) {
                if ($dados->ativo == 1) {
            ?>
                    <div class="col-12 col-md-3">
                        <div class="card text-center">
                            <img src="<?= $img ?><?= $dados->imagem ?>" alt="<?= $dados->nome ?>">
                            <p>
                                <strong><?= $dados->nome ?></strong>
                            <p class="card-text mb-4">R$ <?= number_format($dados->valor, 2, ",", ".") ?></p>
                            </p>
                            <p>
                                <a href="produto/detalhes/<?= $dados->id_produto ?>" class="btn btn-formulario">
                                    <i class="fas fa-search"></i> Detalhes do produto
                                </a>
                            </p>
                        </div>
                    </div>
            <?php
                } else {
                }
            }
            ?>
        </div>
    </div>
</div>
</div>
</div>