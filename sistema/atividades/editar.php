<?php
define("PAGINA", "EDITAR ATIVIDADE");
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
  <script src="https://asprise.azureedge.net/scannerjs/scanner.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/atividades/novo.js"></script>
  <!-- END PAGE LEVEL JS-->
  ');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");

$DADOS = buscar("atividades", "id='".$_GET['id']."'");
?>
  
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">EDITAR ATIVIDADE</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/atividades/listar">Atividades</a>
                </li>
                <li class="breadcrumb-item active"> Editar Atividade
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-550 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/atividades/listar" class="btn btn-icon btn-outline-danger"><i class="la la-close"></i> CANCELAR</a>
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
	


        <!-- Tabs with Icons start -->
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
						<input type="hidden" id="cod" name="id" value="<?=$DADOS->id?>" />
						<input type="hidden" id="acao" name="acao" value="editar" />
                        
						  <div class="form-body">
							<div class="row">
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="cod">Cod*</label>
								  <input type="text" id="cod" class="form-control" required name="cod" value="<?=$DADOS->cod?>" autocomplete="off">
								</div>
							  </div>
							  <div class="col-md-10">
								<div class="form-group">
								  <label for="atividade">Atividade*</label>
								  <input type="text" id="atividade" class="form-control" required name="atividade" value="<?=$DADOS->atividade?>" autocomplete="off">
								</div>
							  </div>
							</div>
							<div class="row">
							  <div class="col-md-6">
								<div class="form-group">
								  <label for="upf">UPF*</label>
								  <input type="text" class="form-control decimal-inputmask" id="upf" name="upf" value="<?=$DADOS->upf?>">
								</div>
							  </div>
							  <div class="col-md-6">
								<div class="form-group">
								  <label for="ciclo">Ciclo de pagamento*</label>
								  <select id="ciclo" name="ciclo" class="form-control">
									<option value="">Selecione o ciclo de pagamento</option>
									<option value="1" <?php if($DADOS->ciclo == 1) { echo 'selected="selected"'; } ?>>Pagamento Único</option>
									<option value="2" <?php if($DADOS->ciclo == 2) { echo 'selected="selected"'; } ?>>Pagamento Mensal</option>
									<option value="3" <?php if($DADOS->ciclo == 3) { echo 'selected="selected"'; } ?>>Pagamento Anual</option>
								  </select>
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
        <!-- Tabs with Icons end -->
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->



<?php include_once(__DIR__."/../footer.php"); ?>