<?php
define("PAGINA", "EDITAR FORNECEDOR");
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
  <script src="'.URL_SISTEMA.'/app-assets/js/sistema/cidade.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/navs/navs.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/jquery-ui/autocomplete.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/fornecedores/novo.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"
  type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  <script>
  $(document).ready(function(){
		$("#tipo").trigger(\'change\');
  });
  </script>

  ');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");

$DADOS = buscar("fornecedores", "cod_fornecedor='".$_GET['id']."'");
$FORNECEDOR_SERVICOS = listar("fornecedores_servicos", "status=1", "id_fs ASC");
$SERVICOS = listar("servicos", "status=1", "servico ASC");
$HOJE = date('Y-m-d');
?>
  
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">EDITAR FORNECEDOR</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/fornecedores/listar">Fornecedores</a>
                </li>
                <li class="breadcrumb-item active"> Editar Fornecedor
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
						<input type="hidden" id="cod" name="id" value="<?=$DADOS->cod_fornecedor?>" />
						<input type="hidden" id="acao" name="acao" value="editar" />
                        
						  <div class="form-body">
							<div class="row">
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="codigo">COD.</label>
								  <input type="text" id="codigo" class="form-control" required name="cod" autocomplete="off"value="<?=$DADOS->cod?>">
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="tipo">Tipo</label>
								  <select id="tipo" name="tipo" class="form-control" onchange="selecionaTipo(this)">
									<option value="" selected="" disabled="">Selecione o tipo</option>
									<option value="0" <?php if($DADOS->tipo == 0) { echo "selected"; } ?>>Pesso Física</option>
									<option value="1" <?php if($DADOS->tipo == 1) { echo "selected"; } ?>>Pessoa Jurídica</option>
								  </select>
								</div>
							  </div>
							  <div class="col-md-8">
								<div class="form-group">
								  <label for="nome_fantasia" id="label_nome_fantasia">Nome*</label>
								  <input type="text" id="nome_fantasia" class="form-control" required name="nome_fantasia" autocomplete="off" value="<?=$DADOS->nome_fantasia?>">
								</div>
							  </div>
							  
							  <div class="col-md-12" id="div_razao_social" style="display: none;">
								<div class="form-group">
								  <label for="razao_social" id="label_razao_social">Razão Social*</label>
								  <input type="text" id="razao_social" class="form-control" required name="razao_social" autocomplete="off" value="<?=$DADOS->razao_social?>">
								</div>
							  </div>
							  
							</div>
							
							<div class="row">
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="cpf" id="label_cpf">CPF</label>
								  <input type="text" id="cpf" class="form-control cpf-inputmask" name="cpf" value="<?=$DADOS->cpf?>">
								</div>
							  </div>
							  
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="rg" id="label_rg">RG</label>
								  <input type="text" id="rg" class="form-control" name="rg" value="<?=$DADOS->rg?>">
								</div>
							  </div>
							  
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="expedidor" id="label_expedidor">Orgão Expedidor</label>
								  <input type="text" id="expedidor" class="form-control" name="expedidor" value="<?=$DADOS->expedidor?>">
								</div>
							  </div>
							  
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="especialidade">Especialidade</label>
								  <input type="text" id="especialidade" class="form-control" name="especialidade" value="<?=$DADOS->especialidade?>">
								</div>
							  </div>
							  
							  <div class="col-md-8">
								<div class="form-group">
								  <label for="observacoes">Observações</label>
								  <input type="text" id="observacoes" class="form-control" name="observacoes" value="<?=$DADOS->observacoes?>">
								</div>
							  </div>
							</div>
							
							<h4 class="form-section"><i class="la la-phone"></i> Contato</h4>
							<div class="row">
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="telefone">Telefone</label>
								  <input type="text" id="telefone" class="form-control phone-inputmask" name="telefone" value="<?=$DADOS->telefone?>">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="celular">Celular</label>
								  <input type="text" id="celular" class="form-control xphone-inputmask" name="celular" value="<?=$DADOS->celular?>">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="fax">Fax</label>
								  <input type="text" id="fax" class="form-control phone-inputmask" name="fax" value="<?=$DADOS->fax?>">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="email">E-mail</label>
								  <input type="text" id="email" class="form-control" name="email" value="<?=$DADOS->email?>">
								</div>
							  </div>
							  
							</div>
							
							<h4 class="form-section"><i class="la la-map-marker"></i> Endereço</h4>
							<div class="row">
							  
							  <div class="col-md-10">
								<div class="form-group">
								  <label for="endereco">Endereço</label>
								  <input type="text" id="endereco" class="form-control" name="endereco" value="<?=$DADOS->endereco?>">
								</div>
							  </div>
							
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="numero">Número</label>
								  <input type="text" id="numero" class="form-control" name="numero" value="<?=$DADOS->numero?>">
								</div>
							  </div>
							
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="bairro">Bairro</label>
								  <input type="text" id="bairro" class="form-control" name="bairro" value="<?=$DADOS->bairro?>">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="cep">CEP</label>
								  <input type="text" id="cep" class="form-control cep-inputmask" name="cep" value="<?=$DADOS->cep?>">
								</div>
							  </div>
							  
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="uf">Estado</label>
								  <select id="uf" name="uf" class="form-control select2" value="<?=$DADOS->estado?>" onchange="listarCidades(this, 'cidade')">
									<option value="" selected="" disabled="">Selecione o estado</option>
									
								  </select>
								</div>
							  </div>
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="cidade">Cidade</label>
								  <select id="cidade" name="cidade" value="<?=$DADOS->cidade?>" class="form-control select2">
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
							<input type="hidden" id="servico-fornecedor" name="fornecedor" value="<?=$DADOS->cod_fornecedor?>" />
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
							  
							  <div class="col-md-12" id="div-btn-salvarServico">
								<div class="form-group" id="btnSubmit">
								  <button type="submit" class="btn btn-success btn-min-width mr-1 mb-1 btn-block ladda-button" data-style="zoom-in" id="btn-salvarServico"><i class="fa fa-save"></i> SALVAR DEPENDENTE</button>
								</div>
							  </div>
							  <div class="col-md-2" id="div-btn-cancelarServico" style="display: none;">
								<div class="form-group">
								  <button type="button" class="btn btn-danger btn-min-width mr-1 mb-1 btn-block ladda-button" data-style="zoom-in" id="btn-cancelarServico"><i class="fa fa-close"></i> CANCELAR</button>
								</div>
							  </div>
							  
							</div>
							
							
							</form>
							
							<h4 class="form-section"><i class="la la-archive"></i> Lista de serviços</h4>
							
							<div class="row text-center">
								<div class="col-md-12" id="exibeServicos">
									<?php if(count($FORNECEDOR_SERVICOS) >= 1) { ?>
									<ul class="list-group">
										<?php foreach($FORNECEDOR_SERVICOS as $SERVICO) { ?>
										<li class="list-group-item" id="servico-<?=$SERVICO->id_fs?>">
											<button type="button" onclick="editarServico(<?=$SERVICO->id_fs?>)" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in" id="btn-editarServico-<?=$SERVICO->id_fs?>">
											<i class="la la-edit"></i>
											</button>
											<button type="button" onclick="removeServico(<?=$SERVICO->id_fs?>)" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in" id="btn-removeServico-<?=$SERVICO->id_fs?>">
											<i class="la la-trash"></i>
											</button>
											<h2 class="float-left">
												<?=buscar("servicos","id_servico='".$SERVICO->codigo_servico."'")->servico?> - <small> R$ <?=number_format($SERVICO->valor, 2, ",", ".")?><small>
											</h2>
										</li>
										<?php } ?>
									</ul>
									<?php } else { ?>
									<h1 class="display-1" align="center"><i class="ft-alert-triangle"></i></h1>
									<h3 align="center">NENHUM SERVIÇO NO MOMENTO!!</h3>
									<?php } ?>
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


	<!-- Modal -->
	<div class="modal fade text-left" id="verPdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title" id="myModalLabel1">Visualizar PDF</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			  <iframe src="off.pdf" class="visualizar" id="iframeVerArquivo" width="100%" height="500px"></iframe>
			</div>
		  </div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade text-left" id="verImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title" id="myModalLabel1">Visualizar Imagem</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body" id="exibeImg">
			</div>
		  </div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade text-left" id="addBoleto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title" id="myModalLabel1">Nova Fatura</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				<form id="addFatura" class="form-body" >
					<input type="hidden" name="acao" value="gerarboleto"/>
					<div class="row">
					  <div class="col-md-3">
						<div class="form-group">
						  <label for="vencimento">VENCIMENTO</label>
						  <input type="text" id="vencimento" class="form-control date-inputmask" name="vencimento">
						</div>
					  </div>
					  <div class="col-md-3">
						<div class="form-group">
						  <label for="valor">VALOR</label>
						  <input type="text" id="valor" class="form-control" onkeyup="formatoMoeda(this)" name="valor">
						</div>
					  </div>
					  <div class="col-md-3">
						<div class="form-group">
						  <label for="juros">JUROS</label>
						  <input type="text" id="juros" class="form-control" onkeyup="formatoMoeda(this)" name="juros">
						</div>
					  </div>
					  <div class="col-md-3">
						<div class="form-group">
						  <label for="multa">MULTA</label>
						  <input type="text" id="multa" class="form-control" onkeyup="formatoMoeda(this)" name="multa">
						</div>
					  </div>
					  <div class="col-md-12">
						<div class="form-group">
						  <label for="inst1">INSTRUÇÕES DE PAGAMENTO (Linha 1)</label>
						  <input type="text" id="inst1" class="form-control" name="inst1">
						</div>
					  </div>
					  <div class="col-md-12">
						<div class="form-group">
						  <label for="inst2">INSTRUÇÕES DE PAGAMENTO (Linha 2)</label>
						  <input type="text" id="inst2" class="form-control" name="inst2">
						</div>
					  </div>
					  <div class="col-md-12">
						<div class="form-group">
						  <label for="inst3">INSTRUÇÕES DE PAGAMENTO (Linha 3)</label>
						  <input type="text" id="inst3" class="form-control" name="inst3">
						</div>
					  </div>
					  <div class="col-md-12">
						<div class="form-group">
						  <button type="submit" class="btn btn-success btn-min-width mr-1 mb-1"><i class="la la-check"></i> Inserir</button>
						</div>
					  </div>
					</div>
				</form>
			</div>
		  </div>
		</div>
	</div>
	
	<iframe src="off.pdf" id="imprimirPDF" width="0px" height="0px"></iframe>
  

<?php include_once(__DIR__."/../footer.php"); ?>