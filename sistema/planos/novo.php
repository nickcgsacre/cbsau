<?php
define("PAGINA", "NOVO PLANO");
define("CSS", '
	<!-- BEGIN Page Level CSS-->
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/core/colors/palette-gradient.min.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/plugins/ui/jqueryui.css">
	<!-- END Page Level CSS-->');
define("JS", '
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="'.URL_SISTEMA.'/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js"
  type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/forms/extended/form-inputmask.min.js" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/navs/navs.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/jquery-ui/autocomplete.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/planos/novo.js"></script>
  <!-- END PAGE LEVEL JS-->
  ');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");
?>
  
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">NOVO PLANO</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/planos/listar">Planos</a>
                </li>
                <li class="breadcrumb-item active"> Novo Plano
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-550 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/planos/listar" class="btn btn-icon btn-outline-danger"><i class="la la-close"></i> CANCELAR</a>
				  <a href="javascript:gravarForm('formNovo', 'salvar')" class="btn btn-icon btn-outline-primary ladda-button" data-style="zoom-in" id="btn-salvar">
					<i class="la la-save"></i> SALVAR
				  </a>
				  <a href="javascript:gravarForm('formNovo', 'novo')" class="btn btn-icon btn-outline-info ladda-button" data-style="zoom-in" id="btn-novo">
					<i class="la la-plus-circle"></i> SALVAR E NOVO
				  </a>
				  <a href="javascript:gravarForm('formNovo', 'concluir')" class="btn btn-icon btn-outline-success ladda-button"data-style="zoom-in" id="btn-concluir">
					<i class="la la-check-circle"></i> CONCLUÍR
				  </a>
				</div>
				
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
	

        <section id="justified-tabs-with-icons">
		
          <div class="row match-height">
			<div class="col-xl-12 col-lg-12">
              <div class="card">
                <div class="card-content">
                  <div class="card-body">
				  
                    <div class="tab-content px-1 pt-1">
					
                      <div role="tabpanel" class="tab-pane active" id="empresa" aria-labelledby="empresa-tab1"
                      aria-expanded="true">
						<form id="formNovo" class="form" autocomplete="off">
						<input type="hidden" id="cod" name="id" value="" />
						<input type="hidden" id="acao" name="acao" value="novo" />
                        
						  <div class="form-body">
							<div class="row">
							  <div class="col-md-8">
								<div class="form-group">
								  <label for="nome">Nome do Plano*</label>
								  <input type="text" id="nome" class="form-control" required name="nome" autocomplete="off">
								</div>
							  </div>
							  
							  
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="mensalidade">Mensalidade*</label>
								  <input type="text" id="mensalidade" onkeyup="formataMoeda(this)" class="form-control" required name="mensalidade" autocomplete="off">
								</div>
							  </div>
							  
							  
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="desconto">Desconto*</label>
								  <input type="text" id="desconto" class="form-control" onkeyup="formataDesconto(this)" required name="desconto" autocomplete="off">
								</div>
							  </div>
							  
							  
							</div>
						  </div>
						  <div class="form-actions">
							<button type="button" class="btn btn-success ladda-button" data-style="zoom-in" onclick="gravarForm('formNovo', 'salvar1')" id="btn-salvar1">
							  <i class="la la-save"></i> SALVAR
							</button>
						  </div>
						
						</form>
                      </div>
					  
                      
					</div>
					
					
                  </div>
                </div>
              </div>
            </div>
            
		  </div>
        </section>
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  
<?php include_once(__DIR__."/../footer.php"); ?>
