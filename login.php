<?php

include __DIR__ . "/vendor/autoload.php";

use App\Api\Source\Cliente;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central do Assinante - SAC</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/centralteste/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/centralteste/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <!--    <link rel="stylesheet" href="/CENTRAL-MEGA/assets/css/app.css">-->
    <!--    <link rel="stylesheet" href="/CENTRAL-MEGA/assets/css/auth.css">-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <style>
        input[type="radio"] {
            -ms-transform: scale(5); /* IE 9 */
            -webkit-transform: scale(5); /* Chrome, Safari, Opera */
            transform: scale(1);
        }

        .form-check-label {
            font-size: 20px;
            font-weight: bold;
        }
    </style>

</head>

<body>
<?php
if (isset($_POST['logar'])) {

    $login = ($_POST['loginForm']);
    //var_dump($login);
    //$senha = ($_POST['senhaForm']);

    if ($login == "") {
        $msgLogin = "<div class='col-5 alert alert-danger alert-dismissible show fade'>Insira seu CPF.<button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button></div>";
    }

    // if ($senha == "") {
    //     $msgSenha = "<div class='col-5 alert alert-danger alert-dismissible show fade'>Insira sua senha .<button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button></div>
    //             ";
    // }

    $login = preg_replace('/[^0-9]/', '', $login);
    if ($login != "" && (strlen($login) >= 11)) {
        if (is_numeric($login) && ((strlen($login) == 11) || (strlen($login) == 14))) {
            $login = (new Cliente)->formatCnpjCpf($login);
        }

        $request = (new Cliente)->LogarCpFCnpj($login);
        if (count($request) == 0) {
            $msgLogin = "<div class='col-5 alert alert-danger alert-dismissible show fade'>LOGIN E/OU SENHA INCORRETOS<button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button></div>";
        } else {
            $_SESSION['codClinte'] = $request[0]->codcli;
            $_SESSION['login'] = true;
            header('location: home.php');
        }
    }
    // if ($login != "") {
    //     //$login = preg_replace('/[^0-9]/', '', $login);
    //     $request = (new Cliente)->LogarCpFCnpj($login);
    //     //var_dump($request[0]->codcli);
    //     //die();
    //     if (count($request) == 0) {
    //         $msgLogin = "<div class='col-5 alert alert-danger alert-dismissible show fade'>LOGIN E/OU SENHA INCORRETOS<button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button></div>
    //                 ";
    //     } else {
    //         $_SESSION['codClinte'] = $request[0]->codcli;
    //         $_SESSION['login'] = true;
    //         header('location: home.php');
    //     }
    // }
}
?>
<!--######################### INICIO FORM DE LOGIN #############################-->

<!--IMAGEM MEGALINK-->
<div class="row justify-content-center">
    <div class="col-auto text-center">
        <div class="mt-5">
            <a href="#"><img class="w-25" src="./assets/images/logo/logo_mega_login.png"
                                      alt="Logo"></a>
        </div>
    </div>
</div>

<!--TITULO DA PAGINA-->
<div class="row justify-content-center">
    <div class="col-auto ">
        <p class=" mb-5">Central do assinante</p>
    </div>
</div>

<!--FORM DA PAGINA-->
<form class="form" method="post">

    <!--  Abertura do php Para Mensagens Flutuantes -->
    <?php
    /**
     * Envio de mensagens flutuantes.
     */
    if (isset($msgLogin)) {
        echo('<div class="row justify-content-center">' . $msgLogin . '</div>');
    }
    // if (isset($msgSenha)) {
    //     echo('<div class="row justify-content-center">' . $msgSenha . '</div>');
    // }
    ?>

    <!--  Radios Check CPF OU CNPJ -->
    <div class="row justify-content-center mb-3">
        <div class="col-auto">
            <div class="form-check">
                <input class="form-check-input form-check-Success" type="radio" name="opcaoLogin"
                       id="radioCpf" value="1" checked="">
                <label class="form-check-label" for="customColorCheck1">CPF</label>
            </div>
        </div>
        <div class="col-auto">
            <div class="custom-control custom-checkbox">
                <input class="form-check-input form-check-Success" type="radio" name="opcaoLogin"
                       id="radioCnpj" value="2">
                <label class="form-check-label" for="customColorCheck2">CNPJ</label>
            </div>
        </div>
    </div>

    <!--    Inputs de Entrada -->
    <div class="row justify-content-center">
        <div class="col-auto form-control-icon">
            <i class="bi-person align-middle"></i>
        </div>
        <div class="col-5 form-group position-relative has-icon-left mb-4">
            <input type="text" name="loginForm" id="cpf_cnpj" onkeypress="mascara(this, mcpf);"
                   maxlength="14" class="form-control form-control-xl" placeholder="CPF">
        </div>
    </div>

    <!-- <div class="row justify-content-center">
        <div class="col-auto form-control-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <div class="col-5 form-group position-relative has-icon-left mb-4">
            <input type="password" name="senhaForm" id="senha" class="form-control form-control-xl"
                   placeholder="SENHA">
        </div>
    </div> -->

    <!--    Botão entrar -->
    <div class="row justify-content-center">
        <div class="col-auto">
            <button class="btn btn-success btn-block btn-lg mt-3" name="logar">Entrar
            </button>
        </div>
    </div>


    <br>
</form>
<!-- <div class="text-center mb-5">
    <h4><a class="text-secondary font-bold" href="#" style="text-decoration: none;">Esqueci minha senha</a></h4>
</div> -->
<!--######################### FINAL FORM DE LOGIN #############################-->


<!-- CODIGOS ANTIGOS-->
<!--<div id="auth">-->

<!--        <div class="col-lg-4 col-md-2 col-sm-2 col-1 d-none d-lg-block">-->
<!--        </div>-->
<!--        <div class="col-lg-4 col-md-8 col-sm-12 col-md-12">-->

<!--    CODIGOS ANTIGOS-->
<!-- <div class="form-check form-check-lg d-flex align-items-end">
    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label text-gray-600" for="flexCheckDefault">
        Me manter conectado
    </label>
</div> -->
<!--        <div class="col-lg-4 col-md-2 col-xs-2 col-sm-2 col-1 d-none d-lg-block">-->
<!--        </div>-->
<!--</div>-->


<script src="/centralteste/assets/js/mascaras.js"></script>
<script src="/centralteste/assets/js/jquery.mask.js"></script>
<script src="/centralteste/assets/js/bootstrap.bundle.min.js"></script>
<script src="/centralteste/pages/js/login/default.js"></script>
</body>

</html>