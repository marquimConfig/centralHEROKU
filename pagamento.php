<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximun-scale=1.0, user-scalabre=no">
        <title>Pagina de pagamento MEGALINK - CARTÂO</title>
    </head>
<body>
        <form id="form-checkout" >
            <input type="text" name="cardNumber"  id="form-checkout__cardNumber" /><br>
            <input type="text" name="cardExpirationMonth" id="form-checkout__cardExpirationMonth" /><br>
            <input type="text" name="cardExpirationYear" id="form-checkout__cardExpirationYear" /><br>
            <input type="text" name="cardholderName" id="form-checkout__cardholderName"/><br>
            <input type="email" name="cardholderEmail" id="form-checkout__cardholderEmail"/><br>
            <input type="text" name="securityCode" id="form-checkout__securityCode" /><br>
            <select name="issuer" id="form-checkout__issuer"></select><br>
            <select name="identificationType" id="form-checkout__identificationType"></select><br>
            <input type="text" name="identificationNumber" id="form-checkout__identificationNumber"/><br>
            <select name="installments" id="form-checkout__installments"></select><br>
            <button type="submit" id="form-checkout__submit">Pagar</button><br>
            <progress value="0" class="progress-bar">Carregando...</progress><br>
        </form>
        <script src="https://sdk.mercadopago.com/js/v2"></script>
        <script>
            const mp = new MercadoPago('Public_Tokem', {locale: 'pt-BR'});
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

                            // Animate progress bar
                            const progressBar = document.querySelector(".progress-bar");
                            progressBar.removeAttribute("value");
                        
                            return () => {
                                progressBar.setAttribute("value", "0");
                            };
                        },
                    },
                });
            </script>
</body>
</html>