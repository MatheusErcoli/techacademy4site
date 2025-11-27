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
        $sqlPedido = "insert into pedido (id_pedido, id_cliente, id_funcionario, data_pedido, preference_id, ativo) values (null, :id_cliente, null, now(), :preference_id, 1)";
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
     public function finalizar(){
        if(isset($_SESSION["cliente"]["id"])){
            // Verificar estoque usando a function do banco via model Produto
            require_once __DIR__ . '/../models/Produto.php';
            $produtoModel = new Produto($this->pdo);
            $semEstoqueNomes = [];
            foreach ($_SESSION["carrinho"] as $item) {
                $idProduto = $item["id"];
                $tem = $produtoModel->verificarEstoque($idProduto); // 1 ou 0
                if ($tem === 0) {
                    $semEstoqueNomes[] = $item['nome'];
                }
            }
            if (!empty($semEstoqueNomes)) {
                $lista = implode("\\n - ", $semEstoqueNomes);
                echo "<script>alert('Produto(s) sem estoque: \\n+ - $lista');window.location.href='carrinho/index';</script>";
                return;
            }
            // Processar preferência do Mercado Pago
            \MercadoPago\SDK::setAccessToken("APP_USR-2396278221985791-111214-c9fb4686f4db392642ecef5d5aa7f40c-1700403052");
            
            $preference = new \MercadoPago\Preference();
            $payer = new \MercadoPago\Payer();
            $payer->name = $_SESSION["cliente"]["nome"];
            $payer->email = $_SESSION["cliente"]["email"];
            
            $preference->payer = $payer;
            
            $itens = [];
            foreach ($_SESSION["carrinho"] as $produto) {
                $itens[] = [
                    "title" => $produto["nome"],
                    "quantity" => (int)$produto["qtde"],
                    "currency_id" => "BRL",
                    "unit_price" => (float)$produto["valor"]
                ];
            }
            
            $preference->items = $itens;
            $preference->back_urls = [
                "success" => "https://www.techacademy-4-site.com.br/meli/sucesso.php",
                "failure" => "https://www.techacademy-4-site.com.br/meli/falha.php",
                "pending" => "https://www.techacademy-4-site.com.br/meli/pendente.php"
            ];
            $preference->notification_url = "https://www.techacademy-4-site.com.br/meli/notificacao.php";
            $preference->auto_return = "approved";
            $preference->save();
           
            $preferenceId = $preference->id;
            $msg = $this->salvarPedido($preferenceId);
            
            require "../views/carrinho/finalizar.php";
        } else {
            require "../views/carrinho/login.php"; 
        }
    }
}