<?php
define("PAGINA", "NOVO FORNECEDOR");
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
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/navs/navs.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/jquery-ui/autocomplete.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/sistema/cidade.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/fornecedores/novo.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"
  type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  ');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");


$SERVICOS = listar("servicos", "status=1", "servico ASC");
$BANCOS = listar("bancos", "status=1", "cod ASC");
?>
  
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">NOVO FORNECEODR</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/fornecedores/listar">Fornecedores</a>
                </li>
                <li class="breadcrumb-item active"> Novo Fornecedores
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-550 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/fornecedores/listar" class="btn btn-icon btn-outline-danger"><i class="la la-close"></i> CANCELAR</a>
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
                    <ul class="nav nav-tabs nav-linetriangle nav-justified">
                      <li class="nav-item">
                        <a class="nav-link active" id="dados-tab1" data-toggle="tab" href="#dados"
                        aria-controls="dados" aria-expanded="true"><i class="fa fa-user"></i> Dados do Fornecedor</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="servicos-tab1" data-toggle="tab" href="#servicos" aria-controls="servicos"
                        aria-expanded="false"><i class="fa fa-tags"></i> Serviços</a>
                      </li>
                    </ul>
					
                    <div class="tab-content px-1 pt-1">
					
                      <div role="tabpanel" class="tab-pane active" id="dados" aria-labelledby="dados-tab1"
                      aria-expanded="true">
						<form id="formNovo" class="form" autocomplete="off">
						<input type="hidden" id="cod" name="id" value="" />
						<input type="hidden" id="acao" name="acao" value="novo" />
                        
						  <div class="form-body">
							<div class="row">
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="codigo">COD.</label>
								  <input type="text" id="codigo" class="form-control" required name="cod" autocomplete="off">
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="tipo">Tipo</label>
								  <select id="tipo" name="tipo" class="form-control" onchange="selecionaTipo(this)">
									<option value="" selected="" disabled="">Selecione o tipo</option>
									<option value="0">Pesso Física</option>
									<option value="1">Pessoa Jurídica</option>
								  </select>
								</div>
							  </div>
							  <div class="col-md-8">
								<div class="form-group">
								  <label for="nome_fantasia" id="label_nome_fantasia">Nome*</label>
								  <input type="text" id="nome_fantasia" class="form-control" required name="nome_fantasia" autocomplete="off">
								</div>
							  </div>
							  
							  <div class="col-md-12" id="div_razao_social" style="display: none;">
								<div class="form-group">
								  <label for="razao_social" id="label_nome_fantasia">Razão Social*</label>
								  <input type="text" id="razao_social" class="form-control" required name="razao_social" autocomplete="off">
								</div>
							  </div>
							  
							</div>
							
							<div class="row">
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="cpf" id="label_cpf">CPF</label>
								  <input type="text" id="cpf" class="form-control cpf-inputmask" name="cpf">
								</div>
							  </div>
							  
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="rg" id="label_rg">RG</label>
								  <input type="text" id="rg" class="form-control" name="rg">
								</div>
							  </div>
							  
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="expedidor" id="label_expedidor">Orgão Expedidor</label>
								  <input type="text" id="expedidor" class="form-control" name="expedidor">
								</div>
							  </div>
							  
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="especialidade">Especialidade</label>
								  <input type="text" id="especialidade" class="form-control" name="especialidade">
								</div>
							  </div>
							  
							  <div class="col-md-8">
								<div class="form-group">
								  <label for="observacoes">Observações</label>
								  <input type="text" id="observacoes" class="form-control" name="observacoes">
								</div>
							  </div>
							</div>
							
							<h4 class="form-section"><i class="la la-bank"></i> Dados Bancarios</h4>
							<div class="row">
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="conta_banco">Banco</label>
								  <select id="conta_banco" name="conta_banco" class="form-control select2">
									<option value="" selected="" disabled="">Selecione um banco</option>
									<?php foreach($BANCOS as $B) { ?>
									<option value="<?=$B->id_banco?>"><?=$B->cod?> - <?=$B->nome?></option>
									<?php } ?>
								  </select>
								</div>
							  </div>
							
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="conta_tipo">Tipo</label>
								  <select id="conta_tipo" name="conta_tipo" class="form-control select2">
									<option value="" selected="" disabled="">Selecione um tipo</option>
									<option value="0">Conta Corrente</option>
									<option value="1">Conta Poupança</option>
								  </select>
								</div>
							  </div>
							
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="conta_agencia">Agência</label>
								  <input type="text" id="conta_agencia" class="form-control agencia-inputmask" name="conta_agencia">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="conta_conta">Conta</label>
								  <input type="text" id="conta_conta" class="form-control conta-inputmask" name="conta_conta">
								</div>
							  </div>
							
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="conta_variacao">Variação</label>
								  <input type="text" id="conta_variacao" class="form-control" name="conta_variacao">
								</div>
							  </div>
							  
							</div>
							
							<h4 class="form-section"><i class="la la-phone"></i> Contato</h4>
							<div class="row">
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="telefone">Telefone</label>
								  <input type="text" id="telefone" class="form-control phone-inputmask" name="telefone">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="celular">Celular</label>
								  <input type="text" id="celular" class="form-control xphone-inputmask" name="celular">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="fax">Fax</label>
								  <input type="text" id="fax" class="form-control phone-inputmask" name="fax">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="email">E-mail</label>
								  <input type="text" id="email" class="form-control" name="email">
								</div>
							  </div>
							  
							</div>
							
							<h4 class="form-section"><i class="la la-map-marker"></i> Endereço</h4>
							<div class="row">
							  
							  <div class="col-md-10">
								<div class="form-group">
								  <label for="endereco">Endereço</label>
								  <input type="text" id="endereco" class="form-control" name="endereco">
								</div>
							  </div>
							
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="numero">Número</label>
								  <input type="text" id="numero" class="form-control" name="numero">
								</div>
							  </div>
							
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="bairro">Bairro</label>
								  <input type="text" id="bairro" class="form-control" name="bairro">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="cep">CEP</label>
								  <input type="text" id="cep" class="form-control cep-inputmask" name="cep">
								</div>
							  </div>
							  
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="uf">Estado</label>
								  <select id="uf" name="uf" class="form-control select2" onchange="listarCidades(this, 'cidade')">
									<option value="" selected="" disabled="">Selecione o estado</option>
									
								  </select>
								</div>
							  </div>
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="cidade">Cidade</label>
								  <select id="cidade" name="cidade" class="form-control select2">
									<option value="0" selected="" disabled="">Selecione o estado</option>
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
							  <i class="la la-save"></i> SALVAR
							</button>
						  </div>
						
						</form>
                      </div>
					  
					  
                      <div class="tab-pane" id="servicos" role="tabpanel" aria-labelledby="servicos-tab1"
                      aria-expanded="false">
                        <div class="form-body">
							<form id="formSaveServico" name="formServico" class="form" autocomplete="off">
							<input type="hidden" id="servico-acao" name="acao" value="addServico" />
							<input type="hidden" id="servico-fornecedor" name="fornecedor" value="" />
							<input type="hidden" id="servico-id" name="id" value="" />
							<div class="row">
							
							  <div class="col-md-10">
								<fieldset  class="form-group">
								  <label for="cod_servico">Serviço</label>
								  <select class="ac-combobox" name="cod_servico" id="servico-cod_servico">
									<option value="">Digite o codigo ou nome do serviço</option>
									<?php
									foreach($SERVICOS as $SERVICO) {
										echo '<option value="'.$SERVICO->id_servico.'">'.$SERVICO->cod.' - '.$SERVICO->servico.'</option>';
									}
									?>
								  </select>
								</fieldset >
							  </div>
							  
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="servico-valor">Valor</label>
								  <input type="text" id="servico-valor" class="form-control" name="valor" onkeyup="formataMoeda(this)">
								</div>
							  </div>
							  
							  <div class="col-md-12">
								<div class="form-group">
								  <input type="text" id="servico-observacoes" class="form-control" name="observacoes" placeholder="Observações">
								</div>
							  </div>
							  
							  <div class="col-md-12">
								<div class="form-group" id="btnSubmit">
								  <button type="submit" class="btn btn-success btn-min-width mr-1 mb-1 btn-block ladda-button" data-style="zoom-in" id="btn-salvarServico"><i class="fa fa-save"></i> SALVAR SERVIÇO</button>
								</div>
							  </div>
							</div>
							
							
							</form>
							
							<h4 class="form-section"><i class="la la-archive"></i> Lista de serviços</h4>
							
							<div class="row text-center">
								<div class="col-md-12" id="exibeServicos">
									<h1 class="display-1" align="center"><i class="ft-alert-triangle"></i></h1>
									<h3 align="center">NENHUM SERVIÇO NO MOMENTO!!</h3>
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
        </section>
        <!-- Tabs with Icons end -->
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  
  
  
<?php include_once(__DIR__."/../footer.php"); ?>
