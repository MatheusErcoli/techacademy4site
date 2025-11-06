<?php
    session_start();

    $id = $_GET['id'] ?? null;
    $qtde = $_GET['qtde'] ?? null;

    $id = (int)$id;
    $qtde = (int)$qtde;

    if(empty($id)){
        echo "<h2>Produto inválido!</h2>";
    } else if($qtde < 1){
        echo "<h2>Quantidade inválida!</h2>";
    } else {
        $_SESSION["carrinho"][$id]["qtde"] = $qtde;
        
       
        $total = 0;
        foreach ($_SESSION['carrinho'] as $dados) {
            $total += $dados["valor"] * $dados["qtde"];
        }
        
       
        echo number_format($total, 2, ",", ".");
    }
?>