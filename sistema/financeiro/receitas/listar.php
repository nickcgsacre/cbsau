<?php
define("PAGINA", "EXTRATO FINANCEIRO | RECEITAS");
define("CSS", '
<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/vendors/css/tables/datatable/datatables.min.css">');
define("JS", '
  <!-- BEGIN PAGE VENDOR JS-->
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js?v=1.0.1"
  type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/financeiro/receitas/listar.js"></script>
  <!-- END PAGE VENDOR JS-->');
include_once(__DIR__."/../../header.php");
include_once(__DIR__."/../../menu.php");

?>

  
  <!-- END VENDOR CSS-->


  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">RECEITAS</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Extrato Financeiro
                </li>
                <li class="breadcrumb-item active">Receitas
                </li>
              </ol>
            </div>
          </div>
        </div>
		
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-500 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/financeiro/receitas/novo" class="btn btn-icon btn-outline-primary"><i class="la la-plus"></i> NOVA RECEITA</a>
				</div>
			  
			  
            </div>
          </div>
        </div> 
		
      </div>
      <div class="content-body">
	  
        <!-- Ajax sourced data -->
        <section id="ajax">
          <div class="row">
            
			<div class="col-12 col-xl-12">
				<div class="row">
					<div class="col-12">
					
						<div class="card">
						  <div class="card-header">
							<h4 class="card-title"><i class="fa fa-search"></i> BUSCA AVANÇADA</h4>
						  </div>
						  <div class="card-content">
							<div class="card-body">
							 
							 
								<div class="row">
									<div class="col-12">
									  
									  <form class="form form-horizontal" id="b1" onsubmit="financeiro.receitas(this); return false;">
											<input type="hidden" name="acao" value="busca" />
										  <div class="row">
											<div class="col-2">
											  <fieldset class="form-group position-relative">
												<input type="text" class="form-control form-control-xl input-xl" onkeyup="formatar.data(this)" name="inicio" placeholder="Data Inicial" />
											  </fieldset>
											</div>
											<div class="col-2">
											  <fieldset class="form-group position-relative">
												<input type="text" class="form-control form-control-xl input-xl" onkeyup="formatar.data(this)" name="final" placeholder="Data Final" />
											  </fieldset>
											</div>
											<div class="col-3">
											  <fieldset class="form-group position-relative">
												<select class="form-control form-control-xl input-xl" id="parametro" name="parametro">
													<option value="" selected disabled>Parâmetro</option>
													<option value="emissao">Data Emissão</option>
													<option value="vencimento">Data Vencimento</option>
													<option value="pagamento">Data Pagamento</option>
											    </select>
											  </fieldset>
											</div>
											<div class="col-3">
											  <fieldset class="form-group position-relative">
												<select class="form-control form-control-xl input-xl" id="status" name="status">
													<option value="" selected disabled>Status</option>
													<option value="all">TODOS STATUS</option>
													<option value="0">CANCELADA</option>
													<option value="1">LIQUIDADA</option>
													<option value="2">NÃO PAGA</option>
											    </select>
											  </fieldset>
											</div>
											<div class="col-2 text-center">
											  <button type="submit" class="btn btn-primary btn-block btn-lg">
												<i class="fa fa-filter"></i>  FILTRAR
											  </button>
											</div>
										  </div>
									  
									  </form>
									</div>
									
								  </div>
							 
							</div>
						  </div>
						</div>
					
					</div>
				</div>
			
          </div>
        </section>
        <!--/ Ajax sourced data -->
		
		
		<!-- Ajax sourced data -->
        <section id="ajax">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Listar receitas</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collpase show">
                  <div class="card-body card-dashboard imprime-resultado">
					<?php include_once(__DIR__."/extrato.php"); ?>
				  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--/ Ajax sourced data -->
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
 
  
<?php include_once(__DIR__."/../../footer.php"); ?>