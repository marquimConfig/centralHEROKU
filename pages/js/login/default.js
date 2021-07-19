$(document).ready(function() {
    setarRadio();
});

function setarRadio() {

};


$('input[type=radio][name=opcaoLogin]').change(function() {

    $("#cpf_cnpj").val("");
    $("#senha").val("");

    if (this.value == '1') {
        $("#cpf_cnpj").attr("placeholder", "CPF");
        $("#cpf_cnpj").attr("onkeypress", "mascara(this, mcpf);");
        $("#cpf_cnpj").attr("maxlength", "14");
    }

    if (this.value == '2') {
        $("#cpf_cnpj").attr("placeholder", "CNPJ");
        $("#cpf_cnpj").attr("onkeypress", "mascara(this, mcnpj);");
        $("#cpf_cnpj").removeAttr("maxlength");
    }

});