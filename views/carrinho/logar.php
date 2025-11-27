<?php 
    $email = $_POST['email'] ?? NULL;
    $senha = $_POST['senha'] ?? NULL;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Digite um e-mail válido');history.back();</script>";
        exit;
    }

    $dados = $this->carrinho->logar($email);

    if(empty($dados->id_cliente)){
        echo "<script>alert('Usuário ou senha incorreta');history.back();</script>";
        exit;
    } else if (!password_verify($senha, $dados->senha)){
        echo "<script>alert('Usuário ou senha incorreta');history.back();</script>";
        exit;
    }

    $_SESSION["cliente"] = array(
        'id' => $dados->id_cliente,
        'nome' => $dados->nome,
        'email' => $dados->email,
        'telefone' => $dados->telefone
    );

    header('Location: index');
    exit;