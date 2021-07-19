<?php
set_time_limit(10000);
session_start();
include __DIR__ . "/vendor/autoload.php";

//verificar session da página
if (isset($_SESSION['login'])) {
    $codcli = $_SESSION['codClinte'];
} else {
    header('location: pages/logout.php');
    exit();
}
include('pages/layout/head.php');
include('widget/menu.php');
?>
    <div id="app" class="container">
        <section>
            <div class="row">
                <div class="col-md-4">
                    <a class="" href="/centralteste/pages/ativar_internet.php">
                        <div class="card">
                            <div class="card-body py-2 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <img src="/centralteste/assets/images/faces/wifi.jpg" alt="Face 1">
                                    </div>
                                    <div class="ms-4">
                                        <h5 class="font-bold">Ativar Internet</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!--<div class="col-md-4">-->
                <!--    <a href="/pages/nota_fiscal.php">-->
                <!--        <div class="card">-->
                <!--            <div class="card-body py-2 px-4 d-flex align-items-center">-->
                <!--                <div class="avatar">-->
                <!--                    <img src="assets/images/faces/nota_fiscal.jpg" alt="Face 1">-->
                <!--                </div>-->
                <!--                <div class="ms-4 name">-->
                <!--                    <h5 class="font-bold">Nota Fiscal</h5>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </a>-->
                <!--</div>-->
                <div class="col-md-4">
                    <a href="/centralteste/pages/boletos.php">
                        <div class="card">
                            <div class="card-body py-2 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <img src="/centralteste/assets/images/faces/cash.jpg" alt="Face 1">
                                    </div>
                                    <div class="ms-4 name">
                                        <h5 class="font-bold">Boletos</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </div>
<?php include('pages/layout/footer.php'); ?>