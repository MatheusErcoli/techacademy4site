<div class="card" style="margin-top: 40px;">
    <div class="card-header">
        <h2>Carrinho de Compras</h2>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <td>Imagem</td>
                    <td>Nome do Produto</td>
                    <td>Quantidade</td>
                    <td>Unitário</td>
                    <td>Total</td>
                    <td>Excluir</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                if(!empty($_SESSION['carrinho'])){
                foreach ($_SESSION['carrinho'] as $dados) {
                    $total = $total + ($dados["valor"] * $dados["qtde"]);
                ?>
                   <tr>
                        <td><img src="<?=$img?><?=$dados["imagem"]?>" alt="<?=$dados["nome"]?>" width="130px"></td>
                        <td><?=$dados["nome"]?></td>
                        <td>
                            <input type="number" value="<?=$dados["qtde"]?>" class="form-control" onblur="somarQuantidade(this.value, <?=$dados['id']?>)">
                        </td>
                        <td><span style="font-size: 18px; font-weight: bold;">R$ <?=number_format($dados["valor"],2,",",".")?></span></td>
                        <td><span style="font-size: 18px; font-weight: bold;">R$ <?=number_format($dados["valor"] * $dados["qtde"],2,",",".")?></span></td>
                        <td>
                            <a href="carrinho/excluir/<?=$dados["id"]?>" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Excluir
                            </a>
                        </td>
                   </tr>
                <?php
                }
            }
                ?>
                
            </tbody>
        </table>
        <p class="float-start">
            <a href="carrinho/limpar" class="btn btn-formulario">
                Limpar Carrinho de Compras
            </a>
            <a href="carrinho/finalizar" class="btn btn-formulario">
                Finalizar Compra
            </a>
        </p>
        <p class="float-end valor" style="font-size: 24px; font-weight: bold;">
            R$ <?=number_format($total,2,",",".")?>
        </p>
    </div>
</div>
<script>
    somarQuantidade = function(qtde, id){
        $.get("somar.php", {qtde: qtde, id: id}, function(dados){
            if (dados.includes("inválido")) {
                alert(dados);
            } else {
                // Atualiza o valor total do item
                const valorUnitario = parseFloat($('tr').find(`input[onblur*="${id}"]`).closest('tr').find('td:eq(3)').text().replace('R$ ', '').replace('.', '').replace(',', '.'));
                const novoTotalItem = valorUnitario * qtde;
                $('tr').find(`input[onblur*="${id}"]`).closest('tr').find('td:eq(4) span').text('R$ ' + novoTotalItem.toLocaleString('pt-BR', {minimumFractionDigits: 2}));
                
                // Atualiza o valor total do carrinho
                $('.valor').text('R$ ' + dados);
            }
        });
    }
</script>