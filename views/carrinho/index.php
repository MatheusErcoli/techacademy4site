<?php
// Define o caminho absoluto para requisições AJAX
// Constrói a URL base: protocolo + servidor + diretório do script
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$servidor = $_SERVER['SERVER_NAME'];
$diretorioScript = dirname($_SERVER['SCRIPT_NAME']); // Retorna o diretório onde está index.php (public/)
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
    // Função para formatar valor em Real brasileiro
    function formatarMoeda(valor) {
        return valor.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Função para calcular o total do carrinho somando todos os itens
    function calcularTotalCarrinho() {
        let totalCarrinho = 0;
        
        // Percorre todos os inputs de quantidade
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

    // Função para atualizar o valor total do carrinho na interface
    function atualizarTotalCarrinhoNaInterface() {
        const totalCarrinho = calcularTotalCarrinho();
        const elementoValor = document.querySelector('.valor');
        
        if (elementoValor) {
            elementoValor.textContent = 'R$ ' + formatarMoeda(totalCarrinho);
        }
    }

    // Função para atualizar o preço do item individual
    function atualizarPrecoItem(input) {
        const produtoId = input.dataset.produtoId;
        const valorUnitario = parseFloat(input.dataset.produtoValor);
        let quantidade = parseInt(input.value) || 0;
        
        // Garante que a quantidade seja pelo menos 1
        if (quantidade < 1) {
            quantidade = 1;
            input.value = 1;
        }
        
        // Calcula o novo total do item
        const novoTotalItem = valorUnitario * quantidade;
        
        // Atualiza o span do total do item
        const spanTotalItem = document.querySelector(`.preco-total-item[data-produto-id="${produtoId}"]`);
        if (spanTotalItem) {
            spanTotalItem.textContent = 'R$ ' + formatarMoeda(novoTotalItem);
        }
        
        // Atualiza o total do carrinho em tempo real
        atualizarTotalCarrinhoNaInterface();
    }

    // URL para o arquivo somar.php (definida pelo PHP)
    const URL_SOMAR = '<?php echo $urlSomar; ?>';
    
    // Função para atualizar o total do carrinho via AJAX
    function atualizarTotalCarrinho(produtoId, quantidade) {
        $.get(URL_SOMAR, {qtde: quantidade, id: produtoId}, function(dados){
            if (dados.includes("inválido")) {
                alert(dados);
                // Recarrega a página em caso de erro
                location.reload();
            } else {
                // Atualiza o valor total do carrinho
                $('.valor').text('R$ ' + dados);
            }
        }).fail(function() {
            alert('Erro ao atualizar o carrinho. Por favor, recarregue a página.');
            location.reload();
        });
    }

    // Event Listener usando event delegation para capturar mudanças nos inputs de quantidade
    // Quando o usuário termina de editar (sai do campo), salva no servidor
    document.addEventListener('change', function(event) {
        // Verifica se o elemento que disparou o evento é um input de quantidade
        if (event.target.classList.contains('quantidade-produto')) {
            const input = event.target;
            const produtoId = input.dataset.produtoId;
            const quantidade = parseInt(input.value) || 1;
            
            // Garante quantidade mínima
            if (quantidade < 1) {
                input.value = 1;
            }
            
            // Atualiza o preço do item (já foi atualizado em tempo real, mas garante consistência)
            atualizarPrecoItem(input);
            
            // Atualiza o total do carrinho no servidor via AJAX
            // O servidor retornará o valor correto e atualizará a interface
            atualizarTotalCarrinho(produtoId, quantidade);
        }
    });

    // Event Listener para capturar mudanças em tempo real (input event)
    // Isso atualiza o preço enquanto o usuário digita
    document.addEventListener('input', function(event) {
        if (event.target.classList.contains('quantidade-produto')) {
            const input = event.target;
            const quantidade = parseInt(input.value) || 0;
            
            // Atualiza o preço do item e o total do carrinho em tempo real (sem fazer requisição ao servidor)
            if (quantidade >= 1) {
                atualizarPrecoItem(input);
            } else if (quantidade === 0 || isNaN(quantidade)) {
                // Se a quantidade for 0 ou inválida, ainda atualiza o total (será 0 para esse item)
                atualizarTotalCarrinhoNaInterface();
            }
        }
    });
</script>