<?php
$urlProduto = "http://localhost/techacademy4/public/apis/produto.php?id={$id}";
$dadosProduto = json_decode(file_get_contents($urlProduto));

    if(!empty($dadosProduto->id_produto)){
        //Adicionar o produto ao carrinho
       $qtde = $_SESSION['carrinho'][$id]['qtde'] ?? 0;
       $qtde++;
       $_SESSION['carrinho'][$id] = array(
            "id" => $dadosProduto->id_produto,
            "nome" => $dadosProduto->nome,
            "qtde" => $qtde,
            "valor" => $dadosProduto->valor,
            "imagem" => $dadosProduto->imagem
       );
       echo "<script>location.href='carrinho';</script>";
    } else {
        echo "<h2>Produto inválido!</h2>";
    }
?>