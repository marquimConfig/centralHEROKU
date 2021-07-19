<?php
session_start();
include __DIR__ . "/../../vendor/autoload.php";

use App\Api\Source\Cliente;

header('Content-Type: application/json');

//1-verificar senha atual
$metodo = $_POST["metodo"];


//verificar session da página
if (isset($_SESSION['codClinte'])) {
    $codcli = $_SESSION['codClinte'];
} else {
    echo  "<h1>FAÇA LOGIN NO SISTEMA NOVAMENTE.</h1>";
    exit();
}

if ($metodo == 1) {
    $codcli = $_SESSION['codClinte'];
    $hash = $_POST["hash"];
    $request = (new Cliente)->GetSenhaAtualPorCodCli($codcli);
    $senha = $request[0]->senha;
    if ($senha != $hash) {
        echo "0";
    } else {
        echo "1";
    }
}

if ($metodo == 2) {
    $codcli = $_SESSION['codClinte'];
    $hash = $_POST["hash"];
    $request = (new Cliente)->AlterarSenhaClient($codcli,$hash);
    echo $request;
}


function SalvarSenha($codCli, $hash)
{

}
