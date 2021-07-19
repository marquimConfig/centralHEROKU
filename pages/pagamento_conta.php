<?php
set_time_limit(10000);
session_start();
include __DIR__ . "/../vendor/autoload.php";

use App\Api\Source\Fatura;
use App\Api\Source\Cliente;

//verificar session da página
if (isset($_SESSION['login'])) {
    $codcli = $_SESSION['codClinte'];
} else {
    header('location: logout.php');
    exit();
}


if(isset($_GET['np'])){
    $codFat = $_GET['np'];
    $request = (new Fatura)->getFatura($codFat);
    
    $dateVencimento = date('d/m/Y', strtotime($request[0]->data_ven));
    $valorFormatado = 'R$ ' . number_format($request[0]->valor_lan, 2, ',', '.');
    $valorApi = $request[0]->valor_lan;
}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include('../widget/scripts-head.php'); ?>
</head>

<body>
    <div id="app">
        <?php include('../widget/menu.php');?>

        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pagamento Fatura</h4><br>
                        <?php 
                        echo "<h4>Data Vencimento: $dateVencimento / Valor: $valorFormatado </h4>" ;
                        ?>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form id="form-checkout" class="row">

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <input type="text" name="cardNumber" class="form-control" id="form-checkout__cardNumber" />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <input type="text" name="cardExpirationMonth" class="form-control" id="form-checkout__cardExpirationMonth" />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <input type="text" name="cardExpirationYear" class="form-control" id="form-checkout__cardExpirationYear" />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <input type="text" name="cardholderName" class="form-control" id="form-checkout__cardholderName" />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <input type="email" name="cardholderEmail" class="form-control" id="form-checkout__cardholderEmail" />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <input type="text" name="securityCode" class="form-control" id="form-checkout__securityCode" />
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <select name="issuer" class="form-control" id="form-checkout__issuer"></select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <select name="identificationType" class="form-control" id="form-checkout__identificationType"></select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <input type="text" name="identificationNumber" class="form-control" id="form-checkout__identificationNumber" />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <select name="installments" class="form-control" id="form-checkout__installments"></select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <button class="btn btn-success" id="btn-progress-indicator" type="button" disabled="">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            <span class="visually-hidden">Loading...</span>
                                        </button>
                                    <button type="submit" id="form-checkout__submit" class="btn btn-success">Pagar</button><br>
                                    </div>
                                </div>
                                
                              
                                <!-- <progress value="0" class="progress-bar !important">Carregando...</progress><br> -->

                            </form>

                            <script src="https://sdk.mercadopago.com/js/v2"></script>

                            <script>
                                
                                const mp = new MercadoPago('Public_Tokem', {
                                    locale: 'pt-BR'
                                });
                                // Add step #3
                                
                                const cardForm = mp.cardForm({
                                    amount: "100.5",
                                    autoMount: true,
                                    form: {
                                        id: "form-checkout",
                                        cardholderName: {
                                            id: "form-checkout__cardholderName",
                                            placeholder: "Titular do cartão",
                                        },
                                        cardholderEmail: {
                                            id: "form-checkout__cardholderEmail",
                                            placeholder: "E-mail",
                                        },
                                        cardNumber: {
                                            id: "form-checkout__cardNumber",
                                            placeholder: "Número do cartão",
                                        },
                                        cardExpirationMonth: {
                                            id: "form-checkout__cardExpirationMonth",
                                            placeholder: "Mês de vencimento",
                                        },
                                        cardExpirationYear: {
                                            id: "form-checkout__cardExpirationYear",
                                            placeholder: "Ano de vencimento",
                                        },
                                        securityCode: {
                                            id: "form-checkout__securityCode",
                                            placeholder: "Código de segurança",
                                        },
                                        installments: {
                                            id: "form-checkout__installments",
                                            placeholder: "Parcelas",
                                        },
                                        identificationType: {
                                            id: "form-checkout__identificationType",
                                            placeholder: "Tipo de documento",
                                        },
                                        identificationNumber: {
                                            id: "form-checkout__identificationNumber",
                                            placeholder: "Número do documento",
                                        },
                                        issuer: {
                                            id: "form-checkout__issuer",
                                            placeholder: "Banco emissor",
                                        },
                                    },
                                    callbacks: {
                                        onFormMounted: error => {
                                            if (error) return console.warn("Form Mounted handling error: ", error);
                                            console.log("Form mounted");
                                        },
                                        onSubmit: event => {
                                            event.preventDefault();

                                            const {
                                                paymentMethodId: payment_method_id,
                                                issuerId: issuer_id,
                                                cardholderEmail: email,
                                                amount,
                                                token,
                                                installments,
                                                identificationNumber,
                                                identificationType,
                                            } = cardForm.getCardFormData();

                                            fetch("hhtp://localhost/controllers/PaymentController.php", {
                                                method: "POST",
                                                headers: {
                                                    "Content-Type": "application/json",
                                                },
                                                body: JSON.stringify({
                                                    token,
                                                    issuer_id,
                                                    payment_method_id,
                                                    transaction_amount: Number(amount),
                                                    installments: Number(installments),
                                                    description: "Descrição do produto",
                                                    payer: {
                                                        email,
                                                        identification: {
                                                            type: identificationType,
                                                            number: identificationNumber,
                                                        },
                                                    },
                                                }),
                                            });
                                        },
                                        onFetching: (resource) => {
                                            console.log("Fetching resource: ", resource);
                                            // const progressBar = document.querySelector(".progress-bar");
                                            // progressBar.removeAttribute("value");                                           
                                            $("#btn-progress-indicator").show();         
                                            return () => {
                                                //progressBar.setAttribute("value", "0");
                                                $("#btn-progress-indicator").hide();
                                            };
                                        },
                                    },
                                });

                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>


















    </div>
    <?php include('../widget/scripts-footer.php'); ?>
</body>

</html>