<?php
set_time_limit(10000);
session_start();
include __DIR__ . "/../vendor/autoload.php";

use App\Api\Source\Fatura;
use App\Api\Source\Cliente;

//verificar session da página
if (isset($_SESSION['login'])) {
    $codcli = $_SESSION['codClinte'];
    
} else {
    header('location: logout.php');
    exit();
}

include('layout/head.php');
include('../widget/menu.php');
?>
    <div class="row form-control">
        <div>
            <h5 class="card-title">Minha faturas em aberto</h5>
        </div>
        <div class="table-responsive-md">
            <table class="table table-bordered table-striped" cellspacing="0">
                <p class="card-text">Abaixo estão as próximas faturas em aberto.</p>
                <thead>
                <tr>
                    <th scope="col">Dt. Venc.</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Boleto</th>
                    <th scope="col">C. de Barras</th>
                    <th scope="col">Pagar</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $request = (new Fatura)->codFatura($codcli);
                
                if(!$request == NULL){
                    
                foreach ($request as $row) {
                    // $date = date('d/m/Y', strtotime($row->data_ven));
                    // $valor = 'R$ ' . number_format($row->valor_lan, 2, ',', '.');
                    echo "
                        <tr class=\"text-center\">
                        <td scope=\"row\"><label class=\" fs-6 \">{$row->data_ven}</label></td>
                        <td><label class=\" fs-6 \">{$row->valor_lan}</label></td>
                        
                        <td>
                            <a href='javascript:BaixarFatura(\"{$row->codfat}\")' class='btn btn-success'>
                                <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-file-earmark-arrow-down\" viewBox=\"0 0 16 16\">
                                  <path d=\"M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z\"/>
                                  <path d=\"M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z\"/>
                                </svg>
                            </a>
                        </td>
                        
                        <td>
                            <a href='javascript:CodigoBarras(\"{$row->codfat}\")' class='btn btn-primary'>
                                <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-files\" viewBox=\"0 0 16 16\">
                                  <path d=\"M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z\"/>
                                </svg>
                            </a>
                        </td>
                        <td>
                            <a href='#' class='btn btn-warning'>
                                <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-credit-card\" viewBox=\"0 0 16 16\">
                                  <path d=\"M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z\"/>
                                  <path d=\"M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z\"/>
                                </svg>
                            </a>
                        
                            <button data-id='{$row->codfat}' data-cliente='{$codcli}' class='anchorID btn btn-outline-primary '>
                                <img height=\"16\" width=\"16\" src=\" ../assets/images/logo/pixpix.png \" />
                            </button>
                        </td>
                        </tr>            
                        ";
                        }
                    
                    } else{
                        echo "<h3>Não existe boletos em aberto</h3>";
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>



    <div class="modal fade text-left" id="modal-codigo-barras" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">
                        Código de Barras
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" id="codigo_barras_modal_body">

                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" data-bs-dismiss="modal" value="Sair"
                           onclick="CopiarCodigoBarras();">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade text-left" id="modal-pix" tabindex="-1" data-bs-backdrop="false" role="dialog"
         aria-labelledby="myModalLabel160" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title white" id="myModalLabel160">
                        PAGAMENTO PIX
                    </h5>
                </div>
                <div class="modal-body" id="codigo_barras_modal_body">
                    <div class="row" id="rowQr">
                        <!--                        <div class="col-md-7">-->
                        <!--                            <img src="/CENTRAL-MEGA/assets/images/qr_code.png" class="img-thumbnail" alt="Minha Figura">-->
                        <!--                        </div>-->
                        <div class="row">
                            <div class="col-6">
                                <p style="text-align: center; font-weight: bold;">ESSE QRCODE FICARA DISPONÍVEL
                                    POR 30 MINUTOS .</p>
                            </div>
                            <div class="col">
                                <div class="row" id="rowValues">
                                    <div class="col-sm-7">
                                        <h6 id="paymentTitle"></h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <h5 id="paymentValue"></h5>
                                    </div>
                                </div>
                                <div class="row" id="rowValues">
                                    <div class="col-sm-7">
                                        <h6 id="feesTitle"></h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <h5 id="feesValue"></h5>
                                    </div>
                                </div>
                                <div class="row" id="rowValues">
                                    <div class="col-sm-7">
                                        <h6 id="penaltyTitle"></h6>
                                    </div>
                                    <div class="col-sm-3">
                                        <h5 id="penaltyValue"></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="divModal">
                    <input type="button" class="btn btn-primary" data-bs-dismiss="modal" value="Sair"
                           onclick="CopiarCodigoBarras();">
                </div>
            </div>
        </div>
    </div>
    <script src="https://central.megalink.net.br/pages/js/boletos/default.js"></script>
<?php include('layout/footer.php'); ?>