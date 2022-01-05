<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title><?=TITULO_SISTEMA?> - <?=PAGINA?></title>
  <link rel="apple-touch-icon" href="<?=URL_SISTEMA?>/app-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="./app-assets/images/ico/favicon-32.png">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link href="<?=URL_SISTEMA?>/app-assets/vendors/css/line-awesome/css/line-awesome.min.css" rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/vendors.min.css">
  <?php /*<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/weather-icons/climacons.min.css">*/ ?>
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/fonts/meteocons/style.min.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/charts/morris.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/charts/chartist.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/charts/chartist-plugin-tooltip.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/extensions/toastr.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/extensions/sweetalert.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/plugins/calendars/clndr.min.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/plugins/ladda/ladda.min.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/forms/icheck/icheck.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/forms/icheck/custom.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/forms/selects/select2.min.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/components.min.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/app.min.css">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/core/colors/palette-gradient.min.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/fonts/simple-line-icons/style.min.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/fonts/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/core/colors/palette-gradient.min.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/pages/timeline.min.css">
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/pages/dashboard-ecommerce.min.css">
  <!-- END Page Level CSS-->
  <?php if(CSS != '') { echo CSS; } ?>
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/assets/css/style.css">
  <!-- END Custom CSS-->
  <script>var URL_SISTEMA = "<?=URL_SISTEMA?>";</script>
</head>