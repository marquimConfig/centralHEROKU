<?php
session_start();
include __DIR__ . "/../vendor/autoload.php";

use App\Api\Source\Cliente;

//verificar session da página
if (isset($_SESSION['login'])) {
    $codcli = $_SESSION['codClinte'];
    $request = (new Cliente)->getDadosCliente($codcli);
    $codcliente = "";
    $cliente = $request[0];
    $cod = $cliente->codcli;
    $nome = $cliente->nome_cli;
    $endereco = $cliente->endereco;
    $celular = $cliente->celular;
    $email = $cliente->e_mail;
    $bairro = $cliente->bairro;
    $cep = $cliente->cep;
} else {
    header('location: logout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include('../widget/scripts-head.php'); ?>
</head>

<body>
    <div id="app">
        <?php include('../widget/menu.php'); ?>


        <h2>Minha Conta</h2>
        <br>

        <?php
        echo "<br>
                <div class='card'>
                <div class='card-content'>
                    <div class='card-body'>
                        <h4 class='card-title'>Informações da Conta</h4>
                            <div class='form-body'>
                                <div class='form-group'>
                                    <label class='sr-only'>Código</label>
                                    <input type='text' class='form-control' disabled='disabled' value='$cod' >
                                </div>
                                <div class='form-group'>
                                    <label class='sr-only'>Nome</label>
                                    <input type='text' disabled='disabled' class='form-control' value='$nome' >
                                </div>
                                
                            </div>
                    </div>
                </div>
                </div>
                </div>
"
        ?>;

    </div>
    </div>
    <?php include('../widget/scripts-footer.php'); ?>
</body>

</html>








<!-- <div class='form-group'>
<label class='sr-only'>Endereço</label>
<input type='text' disabled='disabled' class='form-control' value='$endereco'>
</div>
<div class='form-group'>
<label class='sr-only'>Telefone</label>
<input type='text' disabled='disabled' class='form-control' value='$celular'>
</div>
<div class='form-group'>
<label class='sr-only'>Email</label>
<input type='text' disabled='disabled' class='form-control' value='$email'>
</div>
<div class='form-group'>
<label class='sr-only'>Bairro</label>
<input type='text' disabled='disabled' class='form-control'  value='$bairro'>
</div>
<div class='form-group'>
<label class='sr-only'>Cep</label>
<input type='text' disabled='disabled' class='form-control'  value='$cep'>
</div> -->