<?php

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$servidor = $_SERVER['SERVER_NAME'];
$diretorioScript = dirname($_SERVER['SCRIPT_NAME']); 
$urlSomar = $protocolo . '://' . $servidor . $diretorioScript . '/somar.php';
?>
<div class="card" style="margin-top: 40px;">
    <div class="card-header">
        <div class="float-start">
        <h2>Carrinho de Compras</h2>
        </div>
        <?php
         if(isset($_SESSION["cliente"]["id"])){
            echo "<div class='float-end'><h5 class='text-center'>Olá, {$_SESSION["cliente"]["nome"]}! - <a href='carrinho/sair' class='btn btn-danger'>Sair</a></h5></div>";
         }
        ?>
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
                            <input type="number" 
                                   value="<?=$dados["qtde"]?>" 
                                   class="form-control quantidade-produto" 
                                   data-produto-id="<?=$dados['id']?>"
                                   data-produto-valor="<?=$dados["valor"]?>"
                                   min="1">
                        </td>
                        <td><span class="preco-unitario" style="font-size: 18px; font-weight: bold;">R$ <?=number_format($dados["valor"],2,",",".")?></span></td>
                        <td><span class="preco-total-item" data-produto-id="<?=$dados['id']?>" style="font-size: 18px; font-weight: bold;">R$ <?=number_format($dados["valor"] * $dados["qtde"],2,",",".")?></span></td>
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
    function formatarMoeda(valor) {
        return valor.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    
    function calcularTotalCarrinho() {
        let totalCarrinho = 0;
        
        const inputsQuantidade = document.querySelectorAll('.quantidade-produto');
        inputsQuantidade.forEach(function(input) {
            const valorUnitario = parseFloat(input.dataset.produtoValor);
            const quantidade = parseInt(input.value) || 0;
            
            if (quantidade > 0) {
                totalCarrinho += valorUnitario * quantidade;
            }
        });
        
        return totalCarrinho;
    }

    function atualizarTotalCarrinhoNaInterface() {
        const totalCarrinho = calcularTotalCarrinho();
        const elementoValor = document.querySelector('.valor');
        
        if (elementoValor) {
            elementoValor.textContent = 'R$ ' + formatarMoeda(totalCarrinho);
        }
    }

    function atualizarPrecoItem(input) {
        const produtoId = input.dataset.produtoId;
        const valorUnitario = parseFloat(input.dataset.produtoValor);
        let quantidade = parseInt(input.value) || 0;
        
        if (quantidade < 1) {
            quantidade = 1;
            input.value = 1;
        }
        
        const novoTotalItem = valorUnitario * quantidade;
        
        const spanTotalItem = document.querySelector(`.preco-total-item[data-produto-id="${produtoId}"]`);
        if (spanTotalItem) {
            spanTotalItem.textContent = 'R$ ' + formatarMoeda(novoTotalItem);
        }
        
        atualizarTotalCarrinhoNaInterface();
    }


    const URL_SOMAR = '<?php echo $urlSomar; ?>';
    

    function atualizarTotalCarrinho(produtoId, quantidade) {
        $.get(URL_SOMAR, {qtde: quantidade, id: produtoId}, function(dados){
            if (dados.includes("inválido")) {
                alert(dados);
                location.reload();
            } else {
                $('.valor').text('R$ ' + dados);
            }
        }).fail(function() {
            alert('Erro ao atualizar o carrinho. Por favor, recarregue a página.');
            location.reload();
        });
    }

    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('quantidade-produto')) {
            const input = event.target;
            const produtoId = input.dataset.produtoId;
            const quantidade = parseInt(input.value) || 1;

            if (quantidade < 1) {
                input.value = 1;
            }

            atualizarPrecoItem(input);

            atualizarTotalCarrinho(produtoId, quantidade);
        }
    });

    document.addEventListener('input', function(event) {
        if (event.target.classList.contains('quantidade-produto')) {
            const input = event.target;
            const quantidade = parseInt(input.value) || 0;
            
           
            if (quantidade >= 1) {
                atualizarPrecoItem(input);
            } else if (quantidade === 0 || isNaN(quantidade)) {
                atualizarTotalCarrinhoNaInterface();
            }
        }
    });
</script>