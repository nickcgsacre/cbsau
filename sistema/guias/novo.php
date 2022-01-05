<?php
define("PAGINA", "NOVA GUIA DE ENCAMINHAMENTO");
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
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/guias/novo.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"
  type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/extensions/block-ui.js" type="text/javascript"></scrip
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/forms/form-repeater.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  ');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");


$FORNECEDORES = listar("fornecedores", "status=1", "nome_fantasia ASC");
$ASSOCIADOS = listar("associados", "status=1", "nome ASC");
$PLANOS = listar("planos", "status=1", "mensalidade ASC");


foreach($PLANOS as $PLANO) {
	$B_PLANO[$PLANO->id_plano] = $PLANO;
}
?>
  
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">NOVA GUIA DE ENCAMINHAMENTO</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/guias/listar">Guias de Encaminhamento</a>
                </li>
                <li class="breadcrumb-item active"> Nova Guia de Encaminhamento
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-550 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/guias/listar" class="btn btn-icon btn-outline-danger"><i class="la la-close"></i> CANCELAR</a>
				  <a href="javascript:gravarForm('formNovo', 'concluir')" class="btn btn-icon btn-outline-success ladda-button"data-style="zoom-in" id="btn-concluir">
					<i class="la la-print"></i> GERAR GUIA
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
					
                      <div role="tabpanel" class="tab-pane active" id="dados" aria-labelledby="dados-tab1"
                      aria-expanded="true">
						<form id="formNovo" class="form" autocomplete="off">
						<input type="hidden" id="cod" name="id" value="" />
						<input type="hidden" id="acao" name="acao" value="novo" />
                        
						  <div class="form-body">
							<div class="row">
							
							  <div class="col-md-10">
								<fieldset  class="form-group">
								  <label for="titular">Titular</label>
								  <select class="ac-combobox" name="titular" id="titular">
									<option value="">Digite o codigo ou nome do titular</option>
									<?php
									foreach($ASSOCIADOS as $ASSOCIADO) {
										echo '<option value="'.$ASSOCIADO->id_associado.'">'.$ASSOCIADO->matricula.' - '.$ASSOCIADO->nome.'</option>';
									}
									?>
								  </select>
								</fieldset >
							  </div>
							  
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="tipo">Atendimento ao titular</label>
								  <select id="tipo" name="tipo" class="form-control" onchange="selecionaTipo(this)">
									<option value="" selected="" disabled="">Selecione o tipo</option>
									<option value="0">Sim</option>
									<option value="1">Não</option>
								  </select>
								</div>
							  </div>
							  
							  <div class="col-md-12" id="div-dependente">
								<div class="form-group">
								  <label for="dependente">Dependente</label>
								  <select id="dependente" name="dependente" class="form-control select2">
									<option value="" selected="" disabled="">Selecione o dependente</option>
									
								  </select>
								</div>
							  </div>
							  
							  <div class="col-md-12">
								<div class="form-group">
								  <label for="fornecedor">Serviço prestado por</label>
								  <select id="fornecedor" name="fornecedor" class="form-control select2">
									<option value="" selected="" disabled="">Selecione o fornecedor</option>
									<?php foreach($FORNECEDORES as $FORNECEDOR) { ?>
										<option value="<?=$FORNECEDOR->cod_fornecedor?>"><?=($FORNECEDOR->nome_fantasia) ? $FORNECEDOR->nome_fantasia : $FORNECEDOR->razao_social?></option>
									<?php } ?>
								  </select>
								</div>
							  </div>
							  <div class="col-md-12">
							  <div class="form-group">
									  <label for="plano">Desconto</label>
									  <select id="plano" name="plano" class="form-control">
										<option value="" selected="" disabled="">Selecione o desconto</option>
										<?php
										foreach($PLANOS as $P) {
											echo "<option value='".$P->id_plano."'"; if($DADOS->plano == $P->id_plano) { echo 'selected'; } echo ">".$P->nome." (R$ ".number_format($P->mensalidade, 2, ',', '.')." MENSAL - DESCONTO DE ".$P->cobrado."%)</option>";
										}
										?>
									  </select>
									</div>
							</div>















							  
							  <div class="col-md-12">
								<div class="form-group">
								  <label for="servicos">Serviço(s)</label>
								  <select id="servicos" name="servicos[]" multiple class="form-control select2">									
								  </select>
								</div>
							  </div>
							  
							</div>
							
						  </div>
						  <div class="form-actions">
							<button type="button" class="btn btn-warning mr-1">
							  <i class="ft-x"></i> LIMPAR
							</button>
							<button type="button" class="btn btn-success ladda-button" data-style="zoom-in" onclick="gravarForm('formNovo', 'salvar1')" id="btn-salvar1">
							  <i class="la la-print"></i> GERAR GUIA
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
