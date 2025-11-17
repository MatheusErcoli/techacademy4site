<?php

?>
<div class="card mt-5">
    <div class="card-header text-center">
        <img src="images/mercado-pago-logo.png" alt="Mercado pago" width="350px">
    </div>
    <div class="card-body">
        <p class="text-center">
            <!-- Botão de pagamento -->
            <script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
                data-preference-id="<?php echo htmlspecialchars($preferenceId); ?>"
                data-button-label="Pagar com Mercado Pago (Boleto, Cartão de Crédito ou Débito)">
            </script>
        </p>
    </div>
</div>
<?php 
if($msg == 0){
    echo "<script>alert('Erro ao salvar pedido!');history.back();</script>";
    exit;
}
?>