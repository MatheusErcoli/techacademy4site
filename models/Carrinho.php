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
    public function logar($email){
        $sql = "select * from cliente where email = :email limit 1";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":email", $email);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    public function salvarPedido($preference_id){
        $sqlPedido = "insert into pedido values (null, :id_cliente, null, now(), :preference_id)";
        $consulta = $this->pdo->prepare($sqlPedido);
        $consulta->bindParam(":id_cliente", $_SESSION["cliente"]["id"]);
        $consulta->bindParam(":preference_id", $preference_id);

        if($consulta->execute()){
            
            $id_pedido = $this->pdo->lastInsertId();

            foreach($_SESSION["carrinho"] as $produto){
                $sqlItem = "insert into itempedido values (null, :id_pedido, :id_produto, :quantidade, :preco_unitario)";
                $consultaItem = $this->pdo->prepare($sqlItem);
                $consultaItem->bindParam(":id_pedido", $id_pedido);
                $consultaItem->bindParam(":id_produto", $produto["id"]);
                $consultaItem->bindParam(":quantidade", $produto["qtde"]);
                $consultaItem->bindParam(":preco_unitario", $produto["valor"]);
                $consultaItem->execute();

                if(!$consultaItem->execute()){
                    return 0; // erro ao salvar item do pedido
                }
            }
            unset($_SESSION["carrinho"]);
            return 1; // pedido salvo com sucesso
        } else {
            return 0; 
        }
    }
}