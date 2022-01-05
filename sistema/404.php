<?php
define("PAGINA", "PAGINA NÃO ENCONTRADA");
define("CSS", '<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/pages/error.min.css">');
define("JS", '');

include_once(__DIR__."/header.php");
include_once(__DIR__."/menu.php");
?>
  
   <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 p-0">
              <div class="card-header bg-transparent border-0">
                <h2 class="error-code text-center mb-2">404</h2>
                <h3 class="text-uppercase text-center">CONTEÚDO NÃO ENCONTRADO!</h3>
              </div>
			</div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
 <?php include_once(__DIR__."/footer.php"); ?>