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

$ID_CONTA = $_GET['id_conta'];
$CONTA = buscar("contas_bancarias", "id_conta='$ID_CONTA'");
$BANCO = buscar("bancos", "id_banco='".$CONTA->id_banco."'");

$ENTRADAS = somar("valor", "despesas", "tipo='1' AND caixa='$ID_CONTA' AND status='1'");
$SAIDAS = somar("valor", "despesas", "tipo='0' AND caixa='$ID_CONTA' AND status='1'");
$SALDO = $ENTRADAS - $SAIDAS;


?>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">EXTRATO - <?=($ID_CONTA == 0)? 'CAIXA GERAL' : $BANCO->nome?></h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Extrato Financeiro
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/financeiro/contas/listar">Contas Bancárias</a>
                </li>
                <li class="breadcrumb-item active">Extrato - <?=($ID_CONTA == 0)? 'CAIXA GERAL' : $BANCO->nome?>
                </li>
              </ol>
            </div>
          </div>
        </div>
		
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-500 float-right">
            <div class="media-body media-right text-right">
              
			  <!-- <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/financeiro/contas/novo" class="btn btn-icon btn-outline-primary"><i class="la la-plus"></i> NOVA CONTA</a>
				</div>
			   -->
			  
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
                  <h4 class="card-title">Movimentações</h4>
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
				
					<div class="col-12">
						<div class="card bg-gradient-x-info">
							<div class="card-content">
								<div class="row">
									<div class="col-lg-4 col-md-6 col-sm-12 border-right-info border-right-lighten-3">
										<div class="card-body text-center">
											<h1 class="display-4 text-white">
												<i class="feather ft-activity font-large-2"></i> <small>R$</small> <?=number_format($ENTRADAS,2,",",".")?>
											</h1>
											<span class="text-white">ENTRADAS</span>
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-12 border-right-info border-right-lighten-3">
										<div class="card-body text-center">
											<h1 class="display-4 text-white">
												<i class="feather ft-clipboard font-large-2"></i> <small>R$</small> <?=number_format($SAIDAS,2,",",".")?>
											</h1>
											<span class="text-white">SAÍDAS</span>
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-12">
										<div class="card-body text-center">
											<h1 class="display-4 text-white">
												<i class="icon-wallet font-large-2"></i> <small>R$</small> <?=number_format($SALDO,2,",",".")?>
											</h1>
											<span class="text-white">SALDO</span>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
							
				
				
                  <div class="card-body card-dashboard imprime-resultado">

					<table class="table table-striped table-bordered sourced-data" id="listar">
                      <thead>
                        <tr>
                          <th>Data Movimentação</th>
                          <th>Tipo</th>
                          <th>Descriminação</th>
                          <th>Valor</th>
                          <th>Status</th>
                          <th>Ações</th>
                        </tr>
                      </thead>
					  <tbody>	
						<?php
						$LISTAR = listar("despesas", "status='1' AND caixa='$ID_CONTA'", "pagamento DESC");
						
						foreach($LISTAR as $ITEM) {
						?>
                        <tr id="Iten-<?=$ITEM->id?>">
                          <td><?=($ITEM->pagamento) ? strftime("%d/%m/%Y", strtotime( $ITEM->vencimento )) : "N/A";?></td>
                          <td><?=($ITEM->tipo == 0) ? "SAÍDA" : "ENTRADA";?></td>
                          <td><?=($ITEM->descriminacao) ? $ITEM->descriminacao : "NÃO INFORMADO";?></td>
                          <td class="<?=($ITEM->tipo == 0)? 'pink' : 'teal text-bold-600'?>">
							
							<?=($ITEM->valor) ? "R$ ".number_format($ITEM->valor,2,",",".") : "N/A";?>
						  </td>
                          <td><?php if($ITEM->status == 1) {
							  echo '<span class="notification-tag badge badge-default badge-success float-right m-0">LIQUIDADA</span>';
						  } else if ($ITEM->status == 2){ 
							if($ITEM->vencimento == $hoje) {
								echo '<span class="notification-tag badge badge-default badge-warging float-right m-0">VENCENDO</span>';
							} else if($ITEM->vencimento < $hoje) {
								echo '<span class="notification-tag badge badge-default badge-danger float-right m-0">EM ATRASO</span>';
							} else {
								echo '<span class="notification-tag badge badge-default badge-info float-right m-0">NÃO PAGO</span>';
							}
						  } else {
							  echo '<span class="notification-tag badge badge-default badge-danger float-right m-0">CANCELADA</span>';
						  }?></td>
                          <td>
							<?php if($ITEM->status == 2) { ?>
							<button type="button" onclick="financeiro.cancelar(<?=$ITEM->id?>)" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-times-rectangle-o"></i>
							</button>
							<a href="javascript:financeiro.liquidar(<?=$ITEM->id?>)" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-check-square-o"></i>
							</a>
							<?php } ?>
							<?php if($ITEM->comprovante) { ?>
							<a href="javascript:financeiro.comprovante(<?=$ITEM->id?>)" class="btn btn-outline-info mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-ticket"></i>
							</a>
							<?php } ?>
							<?php if($ITEM->boleto) { ?>
							<a href="<?=URL_SISTEMA?>/arquivos/despesas/<?=$ITEM->boleto?>" target="_new" class="btn btn-outline-info mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-barcode"></i>
							</a>
							<?php } ?>
						  </td>
                        </tr>
						<?php } ?>
					  </tbody>
                      <tfoot>
                        <tr>
                          <th>Data Movimentação</th>
                          <th>Tipo</th>
                          <th>Descriminação</th>
                          <th>Valor</th>
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