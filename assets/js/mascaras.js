/* Máscaras ER */
function mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}

function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}

function mtel(v) {
    v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
    v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v = v.replace(/(\d)(\d{4})$/, "$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

function mcpf(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
        //de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

function mcnpj(v) {
    var x = v.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
    x = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
    return x;
}

function mdinheiro(v) {
    v = v.replace(/\D/g, "");
    v = new String(Number(v));
    var len = v.length;
    if (1 == len)
        v = v.replace(/(\d)/, "0,0$1");
    else if (2 == len)
        v = v.replace(/(\d)/, "0,$1");
    else if (len > 2) {
        v = v.replace(/(\d{1})(\d{1,2})$/, "$1,$2") // coloca virgula antes dos ultimos 2 digitos
    }
    return v;
}


function money(v) {
    v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito

    //v = new String(Number(v));
    //var len = v.length;
    //if (1 == len)
    //    v = v.replace(/(\d)/, "0,0$1");
    //else if (2 == len)
    //    v = v.replace(/(\d)/, "0,$1");
    //else if (len > 2) {
    //    v = v.replace(/(\d{1})(\d{1,2})$/, "$1,$2"); // coloca virgula antes dos ultimos 2 digitos
    //}

    //v = v.replace(/(\d{3})(\d)/, "$1,$2");    //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2"); //Coloca um ponto entre o terceiro e o quarto dígitos
    //de novo (para o segundo bloco de números)
    //v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v;
}


function money2(v) {
    v = v.replace(/\D/g, "");
    v = new String(Number(v));

    var len = v.length;

    //Coloca a virgula após os dois digitos
    if (1 == len)
        v = v.replace(/(\d)/, "0,0$1");
    else if (2 == len)
        v = v.replace(/(\d)/, "0,$1");
    else if (len > 2) {
        v = v.replace(/(\d{2})$/, ',$1');
    }
    return v;
}


function money3(tmp) {
    tmp = tmp.replace(/\D/g, "");
    tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
    if (tmp.length > 6)
        tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

    if (tmp.length > 9)
        tmp = tmp.replace(/([0-9]{3}).([0-9]{3}),([0-9]{2}$)/g, ".$1.$2,$3");

    if (tmp.length > 12)
        tmp = tmp.replace(/([0-9]{3}).([0-9]{3}).([0-9]{3}),([0-9]{2}$)/g, ".$1.$2.$3,$4");

    if (tmp.indexOf(".") == 0) tmp = tmp.replace(".", "");
    if (tmp.indexOf(",") == 0) tmp = tmp.replace(",", "0,");

    return tmp;
}


function mdata(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1/$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{2})(\d)/, "$1/$2") //Coloca um ponto entre o terceiro e o quarto dígitos
        //de novo (para o segundo bloco de números)
        //v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

function mhora(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1:$2") //Coloca um ponto entre o terceiro e o quarto dígitos
        //v = v.replace(/(\d{2})(\d)/, "$1/$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
        //de novo (para o segundo bloco de números)
        //v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

function mcep(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1-$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    return v
}

function mrgmilitar(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

function mpis(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{5})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
        //de novo (para o segundo bloco de números)
    v = v.replace(/(\d{2})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

function mctps(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{1})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    return v
}

function mrgcivil(v) {
    v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
    v = v.replace(/(\d)(\d{6})$/, "$1.$2"); //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
    v = v.replace(/(\d)(\d{3})$/, "$1.$2"); //Coloca o . antes dos últimos 3 dígitos, e antes do verificador
    return v;
}

function mplaca(fild) {

    // regra
    function placa() {
        var v = fild.value;
        v = v.replace(/-/g, "");
        var pr = v.match(/-/); // XXX revendo isso
        var v1 = v.substring(0, 3);
        var v2 = v.substring(3, 7);
        v1 = v1.replace(/\d|\W/g, "");
        v1 = v1.toUpperCase();
        v2 = v2.replace(/\D/g, "");
        v = v1;
        if (v2 != "")
            v += "-" + v2;
        fild.value = v;
    }

    _AbstractMask.call(this, fild, placa, 8);

    return fild;
}

function mctpsserie(v) {
    v = v.replace(/\D/g, "") //Remove tudo o que não é dígito
    v = v.replace(/(\d{2})(\d)/, "$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
    return v
}

function mnumeros(v) {
    v = v.replace(/[^0-9]/g, ""); //Remove tudo o que não é número 
    return v;
}

function mletras(v) {
    v = v.replace(/[^a-zA-Z]/g, ""); //Remove tudo o que não é letra 
    return v;
}

function _AbstractMask(fild, regra, tamanho) {

    // validações em tempo de codificação
    if (!fild)
        throw new Error("infore o campo");

    if (!regra)
        throw new Error("informe a regra");

    // devido ao controle da posição do caractere temos que cuidar do foco
    // do campo também, pra não cair em laços eternos de roubo de foco...
    var fused;

    function fusin() {
        fused = true;
    }

    function fusout() {
        fused = false;
    }



    // wrapper que nos permite salvar a posição do cursor.
    function regrawrapper() {

        if (fild.createTextRange) { // TODO fazer pros IE's da vida

            // 2 ranges no IE pra achar a posição, :]
            var r1 = document.selection.createRange();
            var r2 = fild.createTextRange();
            var pos = 0;

            if (fused) {
                while (r1.compareEndPoints("StartToStart", r2)) {
                    r2.moveStart("character", 1);
                    pos++;
                }
            }

            var tamIni = fild.value.length;

            regra.call(this);

            var tamFim = fild.value.length;

            var dif = tamFim - tamIni;
            if (fused) {
                r2 = fild.createTextRange();
                r2.moveStart("character", pos + dif);
                r2.collapse();
                r2.select();
            }

        } else if (fild.selectionStart >= 0) {
            var pos = fild.selectionStart;
            var tamIni = fild.value.length;

            regra.call(this);

            var tamFim = fild.value.length;

            var dif = tamFim - tamIni;

            if (fused) {
                fild.selectionStart = pos + dif;
                fild.selectionEnd = pos + dif;
            }
        }
    }

    function executar() {
        setTimeout(regrawrapper, 1);
    }

    if (fild.addEventListener) {
        fild.addEventListener("focus", fusin, true);
        fild.addEventListener("keypress", executar, true);
        fild.addEventListener("blur", fusout, true); // tomara q baste
        fild.addEventListener("blur", executar, true);
    } else if (fild.attachEvent) {
        fild.attachEvent("onfocus", fusin);
        fild.attachEvent("onkeypress", executar);
        fild.attachEvent("onblur", fusout);
        fild.attachEvent("onblur", executar);
    }

    var maxlength;
    if (tamanho) {
        maxlength = document.createAttribute("maxlength");
        maxlength.nodeValue = tamanho;
        fild.setAttributeNode(maxlength);
    }

    // meio de encontrar essa máscara depois
    fild.mascara = this;

    // utilitário para removermos a máscara
    this.desinstalar = function() {
        if (fild.removeEventListener) {
            fild.removeEventListener("focus", fusin, true);
            fild.removeEventListener("keypress", executar, true);
            fild.removeEventListener("blur", fusout, true);
            fild.removeEventListener("blur", executar, true);
        } else if (fild.detachEvent) {
            fild.detachEvent("onfocus", fusin);
            fild.detachEvent("onkeypress", executar);
            fild.detachEvent("onblur", fusout);
            fild.detachEvent("onblur", executar);
        }
        fild.mascara = undefined;
        if (tamanho) {
            fild.removeAttributeNode(maxlength);
        }
        delete this;
    };
}