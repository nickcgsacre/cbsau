<?php
    define("PAGINA", "NOVA - GUIAS DE ENCAMINHAMENTO");
    define("CSS", '
    <link rel="stylesheet" type="text/css" href="' . URL_SISTEMA . '/app-assets/vendors/css/tables/datatable/datatables.min.css">');
    // define("JS", '
    // <!-- BEGIN PAGE VENDOR JS-->
    // <script type="text/javascript" src="' . URL_SISTEMA . '/app-assets/vendors/js/ui/jquery.sticky.js"></script>
    // <script type="text/javascript" src="' . URL_SISTEMA . '/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    // <script src="' . URL_SISTEMA . '/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
    // <script type="text/javascript" src="' . URL_SISTEMA . '/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
    // <script src="' . URL_SISTEMA . '/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js"
    // type="text/javascript"></script>
    // <script src="' . URL_SISTEMA . '/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
    // <script type="text/javascript" src="' . URL_SISTEMA . '/sistema/guias/listar.js"></script>
    // <!-- END PAGE VENDOR JS-->');
    include_once(__DIR__ . "/../header.php");
    include_once(__DIR__ . "/../menu.php");

    $mesFiltrado = !empty($_GET['mes']) ? $_GET['mes'] : date('m');
    $anoFiltrado = !empty($_GET['ano']) ? $_GET['ano'] : date('Y');

    $planos = listar("planos");

    $sql = "true=true ";

    if ($_POST['numero']) {
        $numero = $_POST['numero'];
        $sql .= "AND id_plano = '$numero' ";
    }

    if ($_POST['titular']) {
        $titular = $_POST['titular'];
        $sql .= "AND titular = '$titular' ";
    }

    if ($_POST['data_emissao'] && !$_POST['data_emissao_final']) {
        $dataEmissao = $_POST['data_emissao'];
        $sql .= "AND data_emissao >= '$dataEmissao' ";
    }

    if (!$_POST['data_emissao'] && $_POST['data_emissao_final']) {
        $dataEmissaoFinal = $_POST['data_emissao_final'];
        $sql .= "AND data_emissao <= $dataEmissaoFinal ";
    }

    if ($_POST['plano']) {
        $plano = $_POST['plano'];
        $sql .= "AND plano = '$plano' ";
    }

    if (!$_POST['data_emissao'] && !$_POST['data_emissao_final']) {
        $sql .= "AND YEAR(data_emissao) = 2021 AND MONTH(data_emissao) = 02 ";
    }

    if ($_POST['data_emissao'] && $_POST['data_emissao_final']) {
        $sql .= "AND data_emissao >= $dataEmissao AND data_emissao <= $dataEmissaoFinal";
    }

    $guias = listar("guias", $sql);
?>

<div class="app-content content">
    <div class="content-wrapper">
        <?php include_once(__DIR__ . "./header-guias.php"); ?>
        <div class="content-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <h4 class="card-title">
                                        Listagem das guias de <?=$mesFiltrado?> de <?=$anoFiltrado?>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-success float-right">Nova guia</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!$_POST['data_emissao'] && !$_POST['data_emissao_final']) { ?>
                            <div class="alert alert-warning mb-2">
                                <i class="fa fa-info-circle"></i> Atenção! está listagem é referente as guias cadastradas no mês e ano atual, para buscar guias anteriores, utilize os filtros de emissão
                            </div>
                            <?php } ?>
                            <div class="table-responsive">
                                
                                <?php include_once(__DIR__ . "./filtros.php"); ?>
                                <?php include_once(__DIR__ . "./tabela-listage.php"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once(__DIR__ . "/../footer.php"); ?>