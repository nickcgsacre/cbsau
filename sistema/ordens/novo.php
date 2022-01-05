<?php
define("PAGINA", "NOVA FICHA MÉDICA");
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
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/ordens/novo.js"></script>
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

if($_GET['acao'] == 'editar') {
	$ID = $_GET['ordem'];
	$DADOS = buscar("ordens", "id_ordem='$ID'");
}


$FORNECEDORES = listar("fornecedores", "status=1", "nome_fantasia ASC");
$ASSOCIADOS = listar("associados", "status=1", "nome ASC");
?>
  <script>
	var selecionaDependente = '<?=$DADOS->dependente?>';
	var get_Acao = '<?=$_GET['acao']?>';
  </script>
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">NOVA FICHA MÉDICA</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/ordens/listar">Fichas Médica</a>
                </li>
                <li class="breadcrumb-item active"> Nova Ficha Médica
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-550 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/ordens/listar" class="btn btn-icon btn-outline-danger"><i class="la la-close"></i> CANCELAR</a>
				  <a href="javascript:gravarForm()" class="btn btn-icon btn-outline-success ladda-button"data-style="zoom-in" id="btn-concluir">
					<i class="la la-print"></i> IMPRIMIR FICHA MÉDICA
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
						<input type="hidden" id="cod" name="id" value="<?=$DADOS->id_ordem?>" />
						<input type="hidden" id="acao" name="acao" value="novo" />
                        
						  <div class="form-body">
							<div class="row">
							
							  <div class="col-md-10">
								<fieldset  class="form-group">
								  <label for="titular">Titular</label>
								  <select class="form-control select2" name="titular" id="titular" onchange="gerar.titular(this.value)">
									<option value="">Digite o codigo ou nome do titular</option>
									<?php
									foreach($ASSOCIADOS as $ASSOCIADO) {
										echo '<option value="'.$ASSOCIADO->id_associado.'"'; if($DADOS->titular == $ASSOCIADO->id_associado) { echo 'selected'; } echo '>'.$ASSOCIADO->matricula.' - '.$ASSOCIADO->nome.'</option>';
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
									<option value="0" <?=($DADOS->associado == 0)? 'selected="selected"':'' ?> >Sim</option>
									<option value="1" <?=($DADOS->associado == 1)? 'selected="selected"':'' ?> >Não</option>
								  </select>
								</div>
							  </div>
							  
							  <div class="col-md-12" id="div-dependente">
								<div class="form-group">
								  <label for="dependente">Dependente</label>
								  <select id="dependente" name="dependente" class="form-control" onchange="gerar.dependente(this.value)">
									<option value="" selected="" disabled="">Selecione o dependente</option>
									
								  </select>
								</div>
							  </div>
							  
							  <div class="col-md-12">
								<div class="form-group">
								  <label for="fornecedor">Serviço prestado por</label>
								  <select id="fornecedor" name="fornecedor" class="form-control select2" onchange="gerar.fornecedor(this.value)">
									<option value="" selected="" disabled="">Selecione o fornecedor</option>
									<?php foreach($FORNECEDORES as $FORNECEDOR) { ?>
										<option value="<?=$FORNECEDOR->cod_fornecedor?>" <?=($DADOS->fornecedor == $FORNECEDOR->cod_fornecedor)? 'selected="selected"':'' ?> ><?=$FORNECEDOR->nome_fantasia?></option>
									<?php } ?>
								  </select>
								</div>
							  </div>
							  
							  <div class="col-md-10">
								<div class="form-group">
								  <label for="servicos">Serviço(s)</label>
								  <input type="text" id="servicos" class="form-control" />
								</div>
							  </div>
							  
							  <div class="col-md-2">
								<div class="form-group">
									<label class="text-white"> ....... </label>
									<button type="button" class="btn btn-success btn-block ladda-button" data-style="zoom-in" onclick="gerar.inserir()">
									<i class="la la-plus"></i> INSERIR
									</button>
								</div>
							  </div>
							  
							</div>
						
						</div>
						
						<div id="painel" style="display: none">
							<div class="printable">
								<h3 class="text-center">COOPERATIVA DE SAÚDE DOS SERVIDORES PÚBLICOS DO</h3>
								<h3 class="text-center">CORPO DE BOMBEIROS DO ESTADO DO ACRE</h3>
								<h3 class="text-center">CBSAUDE</h3>
								<h1 class="text-center">FICHA MÉDICA</h1>
								
								<div class="col-md-8 left"><strong>NOME:</strong> <span id="orden-nome"></span></div>
								<div class="col-md-4 left"><strong>PLANO:</strong> <span id="orden-plano"></span></div>
								<div class="col-md-7 left"><strong>ENDEREÇO:</strong> <span id="orden-endereco"></span></div>
								<div class="col-md-5 left"><strong>BAIRRO:</strong> <span id="orden-bairro"></span></div>
								<div class="col-md-6 left"><strong>TELEFONE:</strong> <span id="orden-telefone"></span></div>
								<div class="col-md-6 left"><strong>DATA NASCIMENTO:</strong> <span id="orden-nascimento"></span></div>
								<div class="col-md-6 left"><strong>NATURALIDADE:</strong> <span id="orden-naturalidade"></span></div>
								<div class="col-md-6 left"><strong>ESTADO CÍVIL:</strong> <span id="orden-estado-civil"></span></div>
								<div class="col-md-12 left"><strong>PROFISSÃO:</strong> <span id="orden-profissao"></span></div>
								<div class="col-md-12 left"><strong>NOME DO TITULAR:</strong> <span id="orden-titular"></span></div>
								<div class="col-md-12 left"><strong>FORNECEDOR:</strong> <span id="orden-fornecedor"></span></div>
								
								<div>
									<h3 class="text-center">ASSITÊNCIA MÉDICA</h3>
									<table class="table table-bordered table-striped">
										<thead class="thead-dark">
											<tr>
												<th>DATA CONSULTA</th>
												<th>CONSULTA - DIAGNÓSTICO - PRESCRIÇÕES - OUTROS</th>
												<th>VALOR</th>
												<th>ASSINATURA DO MÉDICO</th>
											</tr>
										</thead>
										<tbody><?php 
											$SERVICOS = json_decode($DADOS->servicos);
											$i = 0;
											foreach($SERVICOS as $SERVICO) {
											?>
											<tr>
												<th scope="row" id="dt-<?=$i?>" ondblclick="gerar.editar.campo(this, 'data')"><?=$SERVICO->data?></th>
												<th scope="row" id="desc-<?=$i?>" ondblclick="gerar.editar.campo(this, 'descricao')"><?=$SERVICO->descricao?></th>
												<th scope="row" id="vlr-<?=$i?>" ondblclick="gerar.editar.campo(this, 'valor')">R$ <?=number_format($SERVICO->valor, 2, ",", ".")?></th>
												<th scope="row"></th>
											</tr>
											<?php $i++; } ?></tbody>
									</table>
								</div>
							</div>
						
							  <div class="form-actions">
								<button type="button" class="btn btn-warning mr-1">
								  <i class="ft-x"></i> LIMPAR
								</button>
								<button type="button" class="btn btn-success mr-1" onclick="gravarForm()">
								  <i class="fa fa-save"></i> SALVAR & IMPRIMIR
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
        </section>
        <!-- Tabs with Icons end -->
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  
  
  
<?php include_once(__DIR__."/../footer.php"); ?>
