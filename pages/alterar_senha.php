<?php
set_time_limit(10000);
session_start();
include __DIR__ . "/../vendor/autoload.php";

//verificar session da página
if (isset($_SESSION['login'])) {
    $codcli = $_SESSION['codClinte'];
} else {
    header('location: logout.php');
    exit();
}

// if (isset($_POST['salvarSenha'])) {

//     $senhaAtual = ($_POST['senhaAtual']);
//     $novaSenha = ($_POST['novaSenha']);

//     $text = "";

//     if ($senhaAtual == "") {
//         $msgSenhaAtual = "<div class='alert alert-danger alert-dismissible show fade' style='text-align:center'>INSIRA SENHA ATUAL.<button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button></div>";
//     }

//     if ($novaSenha == "") {
//         $msgNovaSenha = "<div class='alert alert-danger alert-dismissible show fade' style='text-align:center'>INSIRA NOVA SENHA.<button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button></div>";
//     }

//     if(true){
//         $msgConclusao = "<div class='alert alert-success alert-dismissible show fade' style='text-align:center'>SENHA ALTERADA COM SUCESSO.<button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button></div>";
//     }

//     // if ($login != "" && $senha != "") {
//     //     $login = preg_replace('/[^0-9]/', '', $login);
//     //     $request = (new Cliente)->Logar($login, $senha);

//     //     if (count($request) == 0) {
//     //         $msgLogin = "<div class='alert alert-danger alert-dismissible show fade'>LOGIN E/OU SENHA INCORRETOS<button type='button' class='btn-close' data-bs-dismiss='alert'aria-label='Close'></button></div>
//     //             ";
//     //     } else {
//     //         $_SESSION['codClinte'] = $request[0]->codCli;
//     //         $_SESSION['login'] = true;
//     //         header('location: home.php');
//     //     }
//     // }
// }



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include('../widget/scripts-head.php'); ?>
    <link rel="stylesheet" href="https://central.megalink.net.br/assets/vendors/toastify/toastify.css">
    <link rel="stylesheet" href="https://central.megalink.net.br/assets/vendors/sweetalert2/sweetalert2.min.css">
</head>

<body>
    <div id="app">
        <?php include('../widget/menu.php'); ?>
        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Alterar Senha</h4>
                    </div>
                    
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6>Insira sua senha atual: </h6>
                                    <input class="form-control form-control-lg" name="senhaAtual" id="senhaAtual" type="password" placeholder="Senha Atual">
                                </div>
                                <div class="col-sm-3">
                                    <h6>Nova Senha: </h6>
                                    <input class="form-control form-control-lg" name="novaSenha" id="novaSenha"  type="password" placeholder="Nova Senha">
                                </div>
                                <div class="col-sm-3">
                                    <h6>Confirme Nova Senha: </h6>
                                    <input class="form-control form-control-lg" name="confirmarNovaSenha" id="confirmarNovaSenha" type="password" placeholder="Nova Senha">
                                </div>
                                <div class="col-sm-3">
                                    <h6> &nbsp &nbsp </h6>
                                    <!-- <button class="btn btn-lg btn-success" name="salvarSenha">Salvar</button> -->
                                    <input type="button" class="btn btn-lg btn-success" id="btn-salvar" onclick="SalvarSenha();" value="Salvar">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-8">

                                    <?php

                                    // if (isset($msgSenhaAtual)) {
                                    //     echo ($msgSenhaAtual);
                                    // }
                                   
                                    // if (isset($msgNovaSenha)) {
                                    //     echo ($msgNovaSenha);
                                    // }

                                    // if (isset($msgConclusao)) {
                                    //     echo ($msgConclusao);
                                    // }

                                    ?>

                                </div>
                                <div class="col-sm-2">
                                </div>
                            </div>
                        </div>

                  
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php

    include('../widget/scripts-footer.php'); ?>
     <script src="https://central.megalink.net.br/pages/js/minha_conta/alterar_senha.js"></script>
     <script src="https://central.megalink.net.br/assets/vendors/toastify/toastify.js"></script>
     <script src="https://central.megalink.net.br/assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
</body>

</html>