<?php
define("PAGINA", "EXTRATO FINANCEIRO | CONTAS BANCARIAS");
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
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/financeiro/contas/listar.js"></script>
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
          <h3 class="content-header-title">CONTAS BANCARIAS</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Extrato Financeiro
                </li>
                <li class="breadcrumb-item active">Contas Bancárias
                </li>
              </ol>
            </div>
          </div>
        </div>
		
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-500 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/financeiro/contas/novo?tipo=conta" class="btn btn-icon btn-outline-primary"><i class="la la-plus"></i> NOVA CONTA</a>
				</div>
			  
			  
            </div>
          </div>
        </div> 
		
      </div>
      <div class="content-body">
		
		<!-- Ajax sourced data -->
        <section id="ajax">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Listar contas bancaria</h4>
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
					
					<table class="table table-striped table-bordered sourced-data" id="listar">
                      <thead>
                        <tr>
                          <th>Banco</th>
                          <th>Tipo</th>
                          <th>Agência</th>
                          <th>Conta</th>
                          <th>Variação</th>
                          <th>Status</th>
                          <th>Ações</th>
                        </tr>
                      </thead>
					  <tbody>	
                        <tr id="Iten-<?=$ITEM->id_conta?>">
                          <td>CAIXA GERAL</td>
                          <td>N/A</td>
                          <td>N/A</td>
                          <td>N/A</td>
                          <td>N/A</td>
                          <td><span class="notification-tag badge badge-default badge-sucess float-right m-0">ATIVO</span></td>
                          <td>
							<a href="<?=URL_SISTEMA?>/financeiro/contas/extrato&id_conta=0&key=true" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-ticket"></i> EXTRATO
							</a>
						  </td>
                        </tr>
						<?php
						$LISTAR = listar("contas_bancarias");
						
						foreach($LISTAR as $ITEM) {
							$BANCO = buscar("bancos", "id_banco='".$ITEM->id_banco."'");
						?>
                        <tr id="Iten-<?=$ITEM->id_conta?>">
                          <td><?=($BANCO->nome) ? $BANCO->nome : "NÃO INFORMADO";?></td>
                          <td><?=($ITEM->tipo) ? "CONTA POUPANÇA" : "CONTA CORRENTE";?></td>
                          <td><?=($ITEM->agencia) ? $ITEM->agencia : "NÃO INFORMADA";?></td>
                          <td><?=($ITEM->conta) ? $ITEM->conta : "NÃO INFORMADA";?></td>
                          <td><?=($ITEM->variacao) ? $ITEM->variacao : "N/A";?></td>
                          <td><?php if($ITEM->status == 1) {
							  echo '<span class="notification-tag badge badge-default badge-sucess float-right m-0">ATIVO</span>';
						  } else {
							  echo '<span class="notification-tag badge badge-default badge-danger float-right m-0">CANCELADA</span>';
						  }?></td>
                          <td>
							<a href="<?=URL_SISTEMA?>/financeiro/contas/extrato&id_conta=<?=$ITEM->id_conta?>&key=true" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-ticket"></i> EXTRATO
							</a>
						  </td>
                        </tr>
						<?php } ?>
					  </tbody>
                      <tfoot>
                        <tr>
                          <th>Banco</th>
                          <th>Tipo</th>
                          <th>Agência</th>
                          <th>Conta</th>
                          <th>Variação</th>
                          <th>Status</th>
                          <th>Ações</th>
                        </tr>
                      </tfoot>
                    </table>
					
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