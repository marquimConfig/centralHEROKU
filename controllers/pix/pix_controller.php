<?php
include __DIR__ . "/../../vendor/autoload.php";

use App\Api\Source\Fatura;

/**
 * Switch para definir qual função usar via $_GET.
 */
switch ($_GET['f']) {
    case "pv":
        valueInvoice($_POST['codFat'],$_POST['codCli']);
        break;
    case "qr":
        genereteQrCode($_POST['codFat'],$_POST['codCli']);
        break;
}

/**
 * Função de envio para o Ajax no Location: default.js.
 */

function valueInvoice($codFat,$codCli)
{
    $fat = new Fatura();
    $invoice = $fat->amountPayable($codFat);
    $invoice = $invoice + [
        "idCliente"=>$codCli,
        "codFatura"=>$codFat
        ];
    echo json_encode($invoice);
}

/**
 * genereteQrCode - Função designada á buscar o base64 do QRCode, e envialo para o JavaScript.
 */
function genereteQrCode($codFat, $codCli){
    $params = array(
        "codcli"=>  $codCli,
        "codfat" => $codFat
    );

    $http = curl_init('https://api-pix.megalink.net.br/mppix/pixmp.php');
    curl_setopt($http,CURLOPT_CUSTOMREQUEST,'POST');
    curl_setopt($http,CURLOPT_POSTFIELDS, $params);
    curl_setopt($http,CURLOPT_RETURNTRANSFER,true);
    $response = curl_exec($http);

    echo $response;
    curl_close($http);
}