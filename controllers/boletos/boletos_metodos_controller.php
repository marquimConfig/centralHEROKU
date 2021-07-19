<?php
session_start();
include __DIR__ . "/../../vendor/autoload.php";

use App\Api\Elitesoft\ISPIntegrator;
use App\Api\Source\Fatura;

header('Content-Type: application/json');

$codFat = $_POST["codFat"];
$metodo = $_POST["metodo"];

if($metodo == 1){
    CodigoDeBarras($codFat);
}

if($metodo == 2){
    SegundaViaBoleto($codFat);
}



function CodigoDeBarras($codFat)
{
    $request = (new Fatura)->barCode($codFat);
    echo  $request;
}



function SegundaViaBoleto($codFat)
{
    $request = (new Fatura)->segundaVia($codFat);
    echo  $request;
}
// $isp = new ISPIntegrator();
//$stmt =  ISPIntegrator->verBoleto($codFat);
