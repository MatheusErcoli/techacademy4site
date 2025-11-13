<div class="card mt-5">
    <div class="card-header">
        <h1>Seus Pedidos</h1>
    </div>
    <div class="card-body">
        <?php 
        $dadosPedido = $this->pedidos->getPedidos();
        foreach($dadosPedido as $dados){
            ?>
            <p>
                <strong>Pedido: <?=$dados->id_pedido?></strong>
                Data: <?=$dados->dt?>
            </p>
            <table class="table table-bordered table-striped">
                <?php
                    $dadosProdutos = $this->pedidos->getItens($dados->id_pedido);
                    foreach($dadosProdutos as $produto){
                        ?>
                        <tr>
                            <td><?=$produto->nome?></td>
                            <td><?=$produto->quantidade?></td>
                            <td><?=$produto->preco_unitario?></td>
                        </tr>
                        <?php 
                    }
                ?>
            </table>
            <?php 
        }
        ?>
    </div>
</div>