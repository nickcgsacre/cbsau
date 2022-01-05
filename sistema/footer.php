  <iframe src="" id="iImpressao" style="display: none;" width="0px" height="0px"></iframe>
  
  <?php /*<footer class="footer footer-static footer-light navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
      <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"><!-- DESENVOLVIDO POR ACRE SITES --></span>
    </p>
  </footer>*/ ?>
  
  <!-- BEGIN VENDOR JS-->
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/scripts/spin/spin.min.js"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/scripts/ladda/ladda.min.js"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script type="text/javascript" src="<?=URL_SISTEMA?>/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/chartist.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js"
  type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/chart.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/raphael-min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/morris.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/timeline/horizontal-timeline.js" type="text/javascript"></script>
  <!--<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAWJvXZ2T34MFZJIGW5kRcUZjN6WJQHMb8"></script>-->
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/gmaps.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/extensions/sweetalert.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js"
  type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js"
  type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/data/jvector/visitor-data.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/extensions/moment.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/extensions/underscore-min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/extensions/clndr.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/forms/select/select2.full.min.js" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <?=JS?>
  <!-- BEGIN MODERN JS-->
  <script src="<?=URL_SISTEMA?>/app-assets/js/core/app-menu.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/core/app.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/scripts/customizer.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/scripts/ui/scrollable.min.js"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script type="text/javascript" src="<?=URL_SISTEMA?>/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/scripts/forms/select/form-select2.min.js" type="text/javascript"></script>
  
  <script src="<?=URL_SISTEMA?>/app-assets/js/sistema/sistema.js" type="text/javascript"></script>
  <?php if($_SESSION['user'] == 3) { ?>
  <script src="<?=URL_SISTEMA?>/app-assets/js/sistema/home-3.js" type="text/javascript"></script> 
  <?php } else if($ROTA[0] == '') { ?>
  <script src="<?=URL_SISTEMA?>/app-assets/js/sistema/home-3.js" type="text/javascript"></script> 
  <?php } else { ?>
  <script src="<?=URL_SISTEMA?>/app-assets/js/sistema/<?=$ROTA[0]?>.js" type="text/javascript"></script> 
  <?php } ?>
  <!-- END PAGE LEVEL JS-->
</body>
</html>