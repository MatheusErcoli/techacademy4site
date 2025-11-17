<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/Conexao.php';
require_once __DIR__ . '/../models/Carrinho.php';
require_once __DIR__ . '/../public/vendor/autoload.php';
class CarrinhoController {

    /** @var \PDO */
    private $pdo;
    /** @var \Carrinho */
    private $carrinho;

    public function __construct() {
        $db = new Conexao();
        $pdo = $db->conectar();
        $this->pdo = $pdo;
        $this->carrinho = new Carrinho($pdo);
    }
    public function index($id = null, $img = null){
        require "../views/carrinho/index.php";
    }

    public function adicionar($id = null, $img = null){
        require "../views/carrinho/adicionar.php";
    }

    public function excluir($id, $img = null){
        unset($_SESSION['carrinho'][$id]);
        require "../views/carrinho/index.php";
    }

    public function limpar(){
        unset($_SESSION['carrinho']);
        require "../views/carrinho/index.php";
    }

    public function finalizar(){
        if(isset($_SESSION["cliente"]["id"])){
            
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
            
            // Passar dados para a view
            $preferenceId = $preference->id;
            $msg = $this->carrinho->salvarPedido($preferenceId);
            
            require "../views/carrinho/finalizar.php";
        } else {
            require "../views/carrinho/login.php"; 
        }
    }

    public function cadastrar(){
        require "../views/carrinho/cadastrar.php";
    }
    public function cadastro(){
        require "../views/carrinho/cadastro.php";
    }

    public function logar(){
        require "../views/carrinho/logar.php";
    }

    public function sair($id, $img){
        unset($_SESSION["cliente"]);
        require "../views/carrinho/index.php";
}
}