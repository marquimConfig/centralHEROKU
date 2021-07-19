function loadingQr(time){
    let timerInterval
    Swal.fire({
        title: 'Gerando seu QR code !',
        html: 'Aguarde um instante &#128521;',
        timer: time,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
                const content = Swal.getHtmlContainer()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                        b.textContent = Swal.getTimerLeft()
                    }
                }
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
    }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
    })
}

function BaixarFatura(codFat) {
    $.ajax({
        type: 'POST',
        dataType: 'text',
        url: 'https://central.megalink.net.br/controllers/boletos/boletos_metodos_controller.php',
        data: {codFat: codFat, metodo: 2},
        success: function (response) {
            window.open(response, '_blank');
        }
    }).done(function (result) {
    });
}

function CodigoBarras(codFat) {
    $("#codigo_barras_modal_body").text("");
    $.ajax({
        type: 'POST',
        dataType: 'text',
        url: 'https://central.megalink.net.br/controllers/boletos/boletos_metodos_controller.php',
        data: {codFat: codFat, metodo: 1},
        success: function (response) {
            let resposta = response;
            $("#codigo_barras_modal_body").text(resposta);
            $("#codigoBarrasInput").val(resposta);
            $("#modal-codigo-barras").modal('show');
            navigator.clipboard.writeText(resposta);
        }
    }).done(function (result) {
    });
};

function CopiarCodigoBarras() {
};

/**
 * openModalPix:
 * está recebendo os valores HTML e enviando para o pix_controller com todos
 * os objetos necessarios 'f = Função utilizada via get' e 'codFat = Codigo da fatura enviado via post para
 * captura de informações de valores'.
 */

function openModalPix(codFat, codCli) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'https://central.megalink.net.br/controllers/pix/pix_controller.php?f=pv',
        data: {codFat: codFat, codCli: codCli},
        success: function (response) {
            // console.log(response);
            $.each(response, function (i, resp) {
                switch (i) {
                    case 'Valor Total':
                        $("#paymentTitle").text(i)
                        $("#paymentValue").text(resp)
                        break;
                    case 'Juros':
                        $("#feesTitle").text(i)
                        $("#feesValue").text(resp)
                        break;
                    case 'Multa':
                        $("#penaltyTitle").text(i)
                        $("#penaltyValue").text(resp)
                        break;
                }
            })
            $("#modal-pix").modal('show');
        }
    }).done(function (result) {
    });
}

function gerarQRCODE(codFat, codCli) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'https://central.megalink.net.br/controllers/pix/pix_controller.php?f=qr',
        data: {codFat: codFat, codCli: codCli},
        success: function (response) {
            // console.log(response[0]['qr_code'])
            var qr_code = response[0]['qr_code'];
            var qr_base64 = response[0]['qr_code_base64'];

            let qr = `<div class="col-6" id="qrCodeArea">
                            <img src="data:image/png;base64, ` + qr_base64 + `" class="img-thumbnail">
                      </div>
                      <div class="col mt-5" data-tooltip="Clique para copiar" id="divqr">
                            <div class="row text-center">
                                <span>Clique abaixo para copiar codigo Pix</span>
                            </div>
                            <div class="row text-center m-2 copyitenqr" onclick="copyQrCode();" data-tooltip="Clique para copiar">
                                <input type="text" class="inputrtext form-control btn btn-primary bg-secondary"
                                readonly id="textqr" value="` + qr_code + `">
                            </div>
                      </div>`;
            $("#rowQr").prepend(qr);
            $("#gerapix").remove()

        },
        error: function (textStatus, errorThrown) {
            console.log(textStatus, errorThrown)
        }
    }).done(function (response) {
    });
}

function copyQrCode() {
    const textInput = document.getElementById('textqr');

    textInput.select();
    document.execCommand('copy');
}