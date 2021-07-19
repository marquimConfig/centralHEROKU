<?php
session_start();
include __DIR__ . "/../vendor/autoload.php";

use App\Api\Source\Fatura;
use App\Api\Source\Cliente;

//verificar session da página
if (isset($_SESSION['login'])) {
    $codcli = $_SESSION['codClinte'];
    $request = (new Cliente)->getNotasFiscais($codcli);
    $teste = $request;
} else {
    header('location: logout.php');
    exit();
}
?>;


<?php
include('layout/head.php');
include('../widget/menu.php');
?>



        <div class="row" id="basic-table">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Minha Notas Fiscais</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text"></p>
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Modelo</th>
                                            <th>valor</th>
                                            <th>Nota</th>
                                            <th>XML/Documento</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($request as $row) {
                                            $date = date('d/m/Y', strtotime($row->data_lan));
                                            $valor = 'R$ ' . number_format($row->valor_nf, 2, ',', '.');
                                            echo "
                                            <tr>
                                            <td>{$date}</td>
                                            <td>{$row->codnf}</td>
                                            <td>{$valor}</td>
                                            <td><a href='javascript:BaixarNota({$row->codnf})' class='btn btn-success'>Ver Nota</div></a></td>";

                                            if ($row->xml != "") {
                                                echo ("<td><a href='javascript:BaixarXml({$row->codnf})' class='btn btn-primary'>XML/Documento</div></a></td>");
                                            } else {
                                                echo ("<td></td>");
                                            }
                                            echo "</tr>";
                                        }
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>"


    </div>
    </div>
    <?php include('layout/footer.php'); ?>