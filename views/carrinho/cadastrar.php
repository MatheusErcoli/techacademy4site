<?php
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $senha = trim($_POST['senha']);
    $cep = trim($_POST['cep']);
    $endereco = trim($_POST['endereco']);
    $bairro = trim($_POST['bairro']);
    $cidade = trim($_POST['cidade']);
    $numero = trim($_POST['numero']);
    $estado = trim($_POST['estado']);
    if(empty($nome)){
        echo "<script>mensagem('Digite o seu nome','carrinho','error');</script>";
        exit;
    } else if (empty($email)){
        echo "<script>mensagem('Digite o seu email','carrinho','error');</script>";
        exit;
    } else if (empty($telefone)){
        echo "<script>mensagem('Digite o seu telefone','carrinho','error');</script>";
        exit;
    } else if (empty($senha)){
        echo "<script>mensagem('Digite a sua senha','carrinho','error');</script>";
        exit;
    }else if (empty($cep)){
        echo "<script>mensagem('Digite o seu CEP','carrinho','error');</script>";
        exit;
    } else if (empty($endereco)){
        echo "<script>mensagem('Digite o seu endereço','carrinho','error');</script>";
        exit;
    } else if (empty($numero)){
        echo "<script>mensagem('Digite o número do seu endereço','carrinho','error');</script>";
        exit;
    } else if (empty($bairro)){
        echo "<script>mensagem('Digite o seu bairro','carrinho','error');</script>";
        exit;
    } else if (empty($cidade)){
        echo "<script>mensagem('Digite a sua cidade','carrinho','error');</script>";
        exit;
    } else if (empty($estado)){
        echo "<script>mensagem('Digite o seu estado','carrinho','error');</script>";
        exit;
    }
    $msg = $this->carrinho->salvar($_POST);

    echo "<br>";

    if($msg == 0){ //certo
       ?>
        <p class="alert alert-success text-center">
            <strong>Pronto!</strong> Seu cadastro foi realizado com sucesso.<br>
            <a href="carrinho/finalizar" class="btn btn-formulario">Clique aqui e faça seu login</a>
        </p>


        <?php
    } else if ($msg == 1){ //erro
        ?>
        <p class="text-center alert alert-danger">
            Ops! Erro ao cadastrar! Verifique seus dados e tente novamente.<br>
            <a href="javascript:history.back()" class="btn btn-formulario">Voltar a tela de cadastro</a>
        </p>

        <?php
    } else { // email já cadastrado
        ?>
        <p class="text-center alert alert-danger">
            Ops! Este email <?=$email?> já está cadastrado!<br>
            <a href="javascript:history.back()" class="btn btn-formulario">Voltar a tela de cadastro</a>
        </p>

        <?php
    }