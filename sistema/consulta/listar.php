<?php
define("PAGINA", "RESULTAOD CONSULTA CPF");
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
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/associados/novo.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"
  type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  ');
// include_once(__DIR__."/../header.php");

$postcpf = $_POST['cpf'];
function checkCPF($cpf){
    if(isset($_POST['cpf'])){
        $cpf_filter = filter_var($_POST['cpf'], FILTER_SANITIZE_NUMBER_INT);
        $cpf_replace = preg_replace("/[^0-9]/", "", $cpf_filter);
        $cpf = intval($cpf_replace);
        $tamanho = strlen($cpf);
		echo $tamanho;
        if($tamanho != 11){
            header('HTTP/1.1 404 Not Found');
            return false;
        }
        if(filter_var($cpf, FILTER_VALIDATE_INT) == true){
            return true;
        }else{
            header('HTTP/1.1 404 Not Found');
            return false;
        }
    }else{
        header('HTTP/1.1 404 Not Found');
        return false;
    }
}

if (checkCPF($postcpf) == false) {
    header('Location: HTTP/1.1 404 Not Found');
}
$associado = listar("associados", "cpf = '$postcpf'");
if($associado == NULL){
    header('Location: HTTP/1.1 404 Not Found');
}
var_dump($associado);


?>


  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">

      <div class="content-body">


        <!-- Tabs with Icons start -->
        <section id="justified-tabs-with-icons">
		
          <div class="row match-height">
			<div class="col-xl-12 col-lg-12">
              <div class="card">
                <div class="card-content">
                  <div class="card-body">
						
                        <div class="form-body">
							
							<div class="col-12">
								<div class="card bg-gradient-x-info">
									<div class="card-content">
										<div class="row">
											<div class="col-lg-4 col-md-6 col-sm-12 border-right-info border-right-lighten-3">
												<div class="card-body text-center">
												<span class="text-white">TOTAL DE ATENDIMENTOS</span>
													<h1 class="display-4 text-white">
														<i class="feather ft-activity font-large-2"></i> <?=contarQueryes("guias", "titular='".$DADOS->id_associado."' AND fornecedor>='1'") + contarQueryes("ordens", "titular='".$DADOS->id_associado."'")?></h1>
													
												</div>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12 border-right-info border-right-lighten-3">
												<div class="card-body text-center">
												<span class="text-white">PROXIMA FATURA</span>
													<h1 class="display-4 text-white">
														<i class="feather ft-clipboard font-large-2"></i> <small>R$</small> <?=number_format(somar("pagar", "ordens", "titular='".$DADOS->id_associado."' AND status='8'") + proximaFatura($DADOS->id_associado), 2, ",", ".")?>
													</h1>
												
												</div>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="card-body text-center">
												<span class="text-white">SALDO DEVEDOR</span>
														<h1 class="display-4 text-white">
														<i class="icon-wallet font-large-2"></i> <small>R$</small> <?=number_format(somar("pagar", "ordens", "titular='".$DADOS->id_associado."' AND (status='7' OR status='8')") + saldoDevedor($DADOS->id_associado), 2, ",", ".")?>
													</h1>
													<a href="javascript:informarPagamento(<?=$DADOS->id_associado?>)" class="badge badge-pill bg-blue-grey">DESCONTAR PAGAMENTO</a>
													<a href="javascript:parcelarGuias(<?=$DADOS->id_associado?>)" class="badge badge-pill bg-blue-grey">PARCELAR SALDO</a> &nbsp;
													<!--<a href="javascript:informarPagamento(<?=$DADOS->id_associado?>)" class="badge badge-pill bg-blue-grey">INFORMAR PAGAMENTO</a>-->
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
																	
							
							<div class="content-body">
								<section class="card">
									<div class="card-body" id="invoice-template">
										<div class="pt-2" id="invoice-items-details">
											<form class="form-body" id="buscarExtrato">
												<input type="hidden" name="acao" value="extrato" />
												<input type="hidden" name="id_associado" value="<?=$DADOS->id_associado?>" />
												<div class="row">
																									  
												  <div class="col-md-2">
													<div class="form-group">
													  <label for="extrato-inicio">Ano</label>
														<select class="form-control form-control" id="selecionaAno" name="ano">
															<option value="">Selecione o ano</option>
															<?php for($i= date('Y'); $i >= date('Y') - 5;$i--) { ?>
															<option value="<?=$i?>"><?=$i?></option>
															<?php } ?>
														</select>
													</div>
												  </div>									  
												  <div class="col-md-2">
													<div class="form-group">
														<label for="extrato-final">Mês</label>
														<select class="form-control form-control" id="selecionaMes" name="mes">
															<option value="">Selecione um mês</option>
															<option value="1">Janeiro</option>
															<option value="2">Fevereiro</option>
															<option value="3">Março</option>
															<option value="4">Abril</option>
															<option value="5">Maio</option>
															<option value="6">Junho</option>
															<option value="7">Julho</option>
															<option value="8">Agosto</option>
															<option value="9">Setembro</option>
															<option value="10">Outubro</option>
															<option value="11">Novembro</option>
															<option value="12">Dezembro</option>
														</select>
													</div>
												  </div>
												  
												  <div class="col-md-2">
													<div class="form-group">
													  <label for="extrato-tipo">Tipo</label>
													  <select id="extrato-tipo" name="tipo" class="form-control">
														<option value="x" selected="">Todos</option>
														<option value="1">Guias</option>
														<option value="2">Mensalidades</option>
														
													  </select>
													</div>
												  </div>
												  
												  <div class="col-md-2">
													<div class="form-group">
													  <label for="extrato-status">Status</label>
													  <select id="extrato-status" name="status" class="form-control">
														<option value="x" selected="" >Todos</option>
														<option value="1">Novo</option>
														<option value="7">Atendido</option>
														<option value="8">Faturado</option>
														<option value="9">Pago</option>
														<option value="0">Cancelado</option>
													  </select>
													</div>
												  </div>
												  
												  <div class="col-md-2">
													<div class="form-group">
													  <label for="extrato-atendimento">Beneficiário</label>
													  <select id="extrato-atendimento" name="atendimento" class="form-control">
														<option value="x" selected="" selected="">Todos</option>
														<option value="0">Titular</option>
														<option value="1">Dependentes</option>
														
													  </select>
													</div>
												  </div>
												  
												  <div class="col-md-2">
													<div class="form-group">
														<label class="text-white"> ....... </label>
														<button type="submit" class="btn btn-success btn-block ladda-button" data-style="zoom-in" id="btn-buscarExtrato">
														<i class="fa fa-filter"></i> FILTRAR
														</button>
													</div>
												  </div>
												  
												</div>
												
											</form>
											
											<div class="exbirExtrato printable">
											</div>
											
										</div>
										<div id="invoice-footer">
											<div class="row">
												<div class="col-md-7 col-sm-12">
												</div>
												<div class="col-md-5 col-sm-12 text-center">
													<button class="btn btn-info btn-lg my-1" onclick="window.print()" type="button"><i class="la la-print"></i> IMPRIMIR</button>
												</div>
											</div>
										</div>
									</div>
								</section>
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
			  <?php /*<iframe src="off.pdf" class="visualizar" id="iframeVerArquivo" width="100%" height="500px"></iframe>*/ ?>
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
	
	<?php /*<iframe src="off.pdf" id="imprimirPDF" width="0px" height="0px"></iframe>*/ ?>
  

<?php include_once(__DIR__."/../footer.php"); ?>