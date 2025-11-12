<?php

class Carrinho {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function salvar($dados){
    // Seleciona o id do cliente (mapeando para 'id') para verificar se o email já existe
    $sqlVerifica = "select id_cliente AS id from cliente where email = :email limit 1";
        $consultaVerifica = $this->pdo->prepare($sqlVerifica);
        $consultaVerifica->bindParam(":email", $dados['email']);
        $consultaVerifica->execute();

        $dadosVerifica = $consultaVerifica->fetch(PDO::FETCH_OBJ);

        if(empty($dadosVerifica->id)){

            $senha = password_hash($dados['senha'], PASSWORD_BCRYPT);

            // Inserção explícita de colunas evita erro quando a tabela tem outras colunas
            $sqlCliente = "insert into cliente (nome, email, telefone, senha) values (:nome, :email, :telefone, :senha)";
            $consultaCliente = $this->pdo->prepare($sqlCliente);
            $consultaCliente->bindParam(":nome", $dados['nome']);
            $consultaCliente->bindParam(":email", $dados['email']);
            $consultaCliente->bindParam(":telefone", $dados['telefone']);
            $consultaCliente->bindParam(":senha", $senha);
            $consultaCliente->execute();

            $idCliente = $this->pdo->lastInsertId();

            $sqlEndereco = "insert into endereco (id_cliente, cep, endereco, numero, complemento, bairro, cidade, estado) values (:id_cliente, :cep, :endereco, :numero, :complemento, :bairro, :cidade, :estado)";
            $consultaEndereco = $this->pdo->prepare($sqlEndereco);
            $consultaEndereco->bindParam(":id_cliente", $idCliente);
            $consultaEndereco->bindParam(":cep", $dados['cep']);
            $consultaEndereco->bindParam(":endereco", $dados['endereco']);
            $consultaEndereco->bindParam(":numero", $dados['numero']);
            $consultaEndereco->bindParam(":complemento", $dados['complemento']);
            $consultaEndereco->bindParam(":bairro", $dados['bairro']);
            $consultaEndereco->bindParam(":cidade", $dados['cidade']);
            $consultaEndereco->bindParam(":estado", $dados['estado']);
            $consultaEndereco->execute();

        } else {
            return 2; // email já cadastrado
        }
    }

}