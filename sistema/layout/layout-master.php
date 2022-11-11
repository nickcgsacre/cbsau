<?php
    define("PAGINA", "GUIAS DE ENCAMINHAMENTO");
    define("CSS", '
    <link rel="stylesheet" type="text/css" href="' . URL_SISTEMA . '/app-assets/vendors/css/tables/datatable/datatables.min.css">');
    define("JS", '
      <!-- BEGIN PAGE VENDOR JS-->
      <script type="text/javascript" src="' . URL_SISTEMA . '/app-assets/vendors/js/ui/jquery.sticky.js"></script>
      <script type="text/javascript" src="' . URL_SISTEMA . '/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
      <script src="' . URL_SISTEMA . '/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
      <script type="text/javascript" src="' . URL_SISTEMA . '/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
      <script src="' . URL_SISTEMA . '/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js"
      type="text/javascript"></script>
       <script src="' . URL_SISTEMA . '/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
      <script type="text/javascript" src="' . URL_SISTEMA . '/sistema/guias/listar.js"></script>
      <!-- END PAGE VENDOR JS-->');
    include_once(__DIR__ . "/../header.php");
    include_once(__DIR__ . "/../menu.php");
?>