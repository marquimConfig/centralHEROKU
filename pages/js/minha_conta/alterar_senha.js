$(document).ready(function() {});

function SubmitSalvarSenha() {
    $.ajax({
        type: 'POST',
        aync: false,
        dataType: 'text',
        url: 'https://central.megalink.net.br/controllers/minha_conta/minha_conta_controller.php',
        data: { metodo: 2, hash: $("#novaSenha").val() },
        success: function(response) {
            if (response == 1) {
                msgInformacao("PARABENS, SUA SENHA FOI ALTERADA COM SUCESSO.", "#4AA245");
                $("#senhaAtual").val("");
                $("#novaSenha").val("");
                $("#confirmarNovaSenha").val("");
                Swal.fire({
                    icon: "success",
                    title: "Senha alterada com sucesso"
                })
            }
        }
    });
};


function SalvarSenha() {

    if (VerificarCampos() == true) {
        let repostaSenhaAtual = 0;
        $.ajax({
            type: 'POST',
            aync: false,
            dataType: 'text',
            url: 'https://central.megalink.net.br/controllers/minha_conta/minha_conta_controller.php',
            data: { metodo: 1, hash: $("#senhaAtual").val() },
            success: function(response) {
                if (response == 0) {
                    msgInformacao("Sua senha atual não esta correta, tente novamente.");
                } else {
                    SubmitSalvarSenha();
                }
            }
        });
    }
}


function VerificarCampos() {
    let senhaAtual = $("#senhaAtual").val();
    let novaSenha = $("#novaSenha").val();
    let confirmarNovaSenha = $("#confirmarNovaSenha").val();
    let erros = 0;
    if (senhaAtual == "") {
        msgInformacao("Insira sua senha atual");
        erros++;
    }

    if (novaSenha == "") {
        msgInformacao("Insira sua nova senha");
        erros++;
    }

    if (confirmarNovaSenha == "") {
        msgInformacao("Insira a confirmação da sua nova senha");
        erros++;
    }

    if (senhaAtual != "" && novaSenha != "" && confirmarNovaSenha != "") {
        if (novaSenha != confirmarNovaSenha) {
            msgInformacao("A nova senha não esta igual a confirmação da nova senha.");
            erros++;
        }
    }

    if (erros == 0)
        return true;
    else
        return false;

};

function msgInformacao(msgInformacao, cor = "#EC0404") {
    Toastify({
        text: msgInformacao,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "center",
        backgroundColor: cor,
    }).showToast();
};