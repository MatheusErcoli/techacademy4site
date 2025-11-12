<?php
if (!isset($_SESSION["carrinho"])) {
    echo "<script>alert('Carrinho vazio!');history.back();</script>";
    exit;
} else if (!isset($_SESSION["cliente"]["id"])) {
    echo "<script>alert('Você precisa estar logado para finalizar a compra!');history.back();</script>";
    exit;
}

$token = "APP_USR-2396278221985791-111214-c9fb4686f4db392642ecef5d5aa7f40c-1700403052";
require "vendor/autoload.php";

MercadoPago\SDK::setAccessToken($token);

$preference = new MercadoPago\Preference();

use MercadoPago\Payer;

$payer = new Payer();
$payer->name = $_SESSION["cliente"]["nome"];
$payer->email = $_SESSION["cliente"]["email"];

$preference->payer = $payer;

$itens = [];

foreach ($_SESSION["carrinho"] as $produto) {

    $itens[] = array(
        "title" => $produto["nome"],
        "quantity" => (int)$produto["qtde"],
        "currency_id" => "BRL",
        "unit_price" => (float)$produto["valor"]
    );
}

$preference->items = $itens;

$preference->back_urls = array(
    "success" => "https://www.techacademy-4-site.com.br/meli/sucesso.php",
    "failure" => "https://www.techacademy-4-site.com.br/meli/falha.php",
    "pending" => "https://www.techacademy-4-site.com.br/meli/pendente.php"
);

$preference->notification_url = "https://www.techacademy-4-site.com.br/meli/notificacao.php";

$preference->auto_return = "approved"; // Retorno automático quando aprovado

$preference->save();


?>
<div class="card mt-5">
    <div class="card-header text-center">
        <img src="images/mercado-pago-logo.png" alt="Mercado pago" width="350px">
    </div>
    <div class="card-body">
        <p class="text-center">
            <!-- Botão de pagamento -->
            <script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
                data-preference-id="<?php echo $preference->id; ?>"
                data-button-label="Pagar com Mercado Pago (Boleto, Cartão de Crédito ou Débito)">
            </script>
        </p>
    </div>
</div>