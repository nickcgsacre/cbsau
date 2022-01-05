<?php
define("PAGINA", "NOVA CONTA BANCARIA");
define("CSS", '
	<!-- BEGIN Page Level CSS-->
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/core/colors/palette-gradient.min.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/plugins/ui/jqueryui.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
	<!-- END Page Level CSS-->');
define("JS", '
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="'.URL_SISTEMA.'/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js"
  type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/forms/extended/form-inputmask.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"
  type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/navs/navs.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/jquery-ui/autocomplete.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"
  type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/extensions/block-ui.js" type="text/javascript"></scrip
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/forms/form-repeater.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/sistema/financeiro/contas/novo.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  ');
include_once(__DIR__."/../../header.php");
include_once(__DIR__."/../../menu.php");

if($_GET['acao'] == 'editar') {
	$ID = $_GET['ordem'];
	$DADOS = buscar("ordens", "id_ordem='$ID'");
}


$BANCOS = listar("bancos", "status=1", "nome ASC");
?>
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">NOVA CONTA BANCARIA</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item">Extrato Financeiro</li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/financeiro/contas/listar">Contas Bancarias</a>
                </li>
                <li class="breadcrumb-item active"> Nova Conta Bancaria
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-550 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/financeiro/contas/listar" class="btn btn-icon btn-outline-danger"><i class="la la-close"></i> CANCELAR</a>
				</div>
				
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
	


        <!-- Tabs with Icons start -->
        <section id="justified-tabs-with-icons">
		
          <form class="row match-height" id="cadastrar" method="post" enctype="multipart/form-data">
			<div class="col-xl-12 col-lg-12">
              <div class="card">
                <div class="card-content">
                  <div class="card-body">
					
                    <div class="tab-content px-1 pt-1">
					
                      <div role="tabpanel" class="tab-pane active" id="dados" aria-labelledby="dados-tab1"
                      aria-expanded="true">
						<input type="hidden" id="cod" name="id" value="<?=$DADOS->id_ordem?>" />
						<input type="hidden" id="acao" name="acao" value="novaConta" />
                        
						  <div class="form-body">
							<div class="row">
							  
							  <div class="col-md-12">
								<div class="form-group">
								  <label for="banco">Banco</label>
								  <select id="banco" name="banco" class="form-control select2">
									<option value="" selected="" disabled="">Selecione o banco</option>
									<?php foreach($BANCOS as $BANCO) { ?>
										<option value="<?=$BANCO->id_banco?>" <?=($DADOS->id_banco == $BANCO->id_banco)? 'selected="selected"':'' ?> ><?=$BANCO->nome?></option>
									<?php } ?>
								  </select>
								</div>
							  </div>
							  
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="tipo">Tipo</label>
								  <select type="text" id="tipo" name="tipo" class="form-control select2">
									<option value="0">Conta Corrente</option>
									<option value="1">Conta Poupança</option>
								  </select>
								</div>
							  </div>
							  
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="agencia">Agência</label>
								  <input type="text" id="agencia" name="agencia" class="form-control agencia-inputmask" />
								</div>
							  </div>
							  
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="conta">Conta</label>
								  <input type="text" id="conta" name="conta" class="form-control conta-inputmask" />
								</div>
							  </div>
							  
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="variacao">Variação</label>
								  <input type="text" id="variacao" name="variacao" class="form-control" />
								</div>
							  </div>
							
							  
							  
							  <div class="col-md-12">
								<div class="form-group">
									<button type="submit" id="gravar" class="btn btn-success btn-block ladda-button" data-style="zoom-in">
									<i class="la la-save"></i> INSERIR CONTA
									</button>
								</div>
							  </div>
							  
							</div>
						
						</div>
						
						
					  </div>
					  
					 
					</div>
					
					
                  </div>
                </div>
              </div>
            </div>
            
		  </form>
        </section>
        <!-- Tabs with Icons end -->
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  
  
  
<?php include_once(__DIR__."/../../footer.php"); ?>
