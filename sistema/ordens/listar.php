<?php
define("PAGINA", "FICHA MÉDICA");
define("CSS", '
<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/vendors/css/tables/datatable/datatables.min.css">');
define("JS", '
  <!-- BEGIN PAGE VENDOR JS-->
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js"
  type="text/javascript"></script>
   <script src="'.URL_SISTEMA.'/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/ordens/listar.js"></script>
  <!-- END PAGE VENDOR JS-->');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");

$ORDENS = listar("ordens", NULL, "data_emissao DESC");
$L_ASSOCIADOS = listar("associados");
$L_DEPENDENTES = listar("dependentes");
$L_FORNECEDORES = listar("fornecedores");

foreach($L_ASSOCIADOS as $ITEM) {
	$ASSOCIADOS[$ITEM->id_associado] = $ITEM;
}
foreach($L_DEPENDENTES as $ITEM) {
	$DEPENDENTES[$ITEM->id_dependente] = $ITEM;
}
foreach($L_FORNECEDORES as $ITEM) {
	$FORNECEDORES[$ITEM->cod_fornecedor] = $ITEM;
}
?>

  
  <!-- END VENDOR CSS-->


  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">FICHAS MÉDICAS</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Fichas Médicas
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-500 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <button type="button" class="btn btn-icon btn-outline-danger" onclick="removerEmMassa()"><i class="la la-trash"></i> EXCLUÍR SELECIONADOS</button>
				  <a href="<?=URL_SISTEMA?>/ordens/novo" class="btn btn-icon btn-outline-primary"><i class="la la-plus"></i> NOVA FICHA</a>
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
                  <h4 class="card-title">Listar Fichas Médica</h4>
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
                  <div class="card-body card-dashboard">
				  
				  
					<div class="table-responsive">
						<table id="invoices-list" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
						  <thead>
							<tr>
							  <th>Nº GUIA</th>
							  <th>TITULAR/BENEFICIÁRIO</th>
							  <th>FORNECEDOR</th>
							  <th>VALOR</th>
							  <th>DATA EMISSÃO</th>
							  <th>STATUS</th>
							  <th>DATA PAGAMENTO</th>
							  <th>AÇÕES</th>
							</tr>
						  </thead>
						  <tbody>
							<!-- PAID -->
							<?php 
							foreach($ORDENS as $ORDEM) {
							?>
							<tr id="fatura-<?=$ORDEM->id_ordem?>">
							  <td><?=str_pad($ORDEM->id_ordem, 6, 0, STR_PAD_LEFT)?></td>
							  <td>
								<?=($ORDEM->titular > 0) ? $ASSOCIADOS[$ORDEM->titular]->nome : "NÃO CADASTRADO"?><br/>
								<small><?=($ORDEM->associado == 1) ? $DEPENDENTES[$ORDEM->dependente]->nome : $ASSOCIADOS[$ORDEM->titular]->nome?></small>
							  </td>
							  <td><?=$FORNECEDORES[$ORDEM->fornecedor]->nome_fantasia?></td>
							  <td>
								<small class="text-tachado text-danger">R$ <?=number_format($ORDEM->valor,2,",",".")?></small><br/>
								<strong class="text-success">R$ <?=number_format($ORDEM->pagar,2,",",".")?></strong>
							  </td>							  
							  <td><?=date("d/m/Y", strtotime($ORDEM->data_emissao))?></td>
							  <td>
								
								<?php
								if($ORDEM->status == 1) {
									echo '<span class="badge badge-default badge-success badge-lg">NOVA</span>';
								} else if($ORDEM->status == 7) {
									echo '<span class="badge badge-default badge-danger badge-lg">ATENDIDO</span>';
								} else if($ORDEM->status == 8) {
									echo '<span class="badge badge-default badge-warning badge-lg">FATURADO</span>';
								} else if($ORDEM->status == 9) {
									echo '<span class="badge badge-default badge-success badge-lg">PAGO</span>';
								} else {
									echo '<span class="badge badge-default badge-success badge-lg">CANCELADA</span>';
								}
								?>												
								</span>
							  </td>
							  <td><?php if($ORDEM->status == 9) { echo date("d/m/Y", strtotime($ORDEM->data_pagamento)); } else { echo '---'; }?></td>
							  <td>
								<span class="dropdown">
								  <button id="btnSearchDrop<?=$ORDEM->id_ordem?>" type="button" data-toggle="dropdown" aria-haspopup="true"
								  aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right"><i class="ft-settings"></i></button>
								  <span aria-labelledby="btnSearchDrop<?=$ORDEM->id_ordem?>" class="dropdown-menu mt-1 dropdown-menu-right">
									<?PHP /*<a href="javascript:gerarGuia(<?=$ORDEM->id_ordem?>)" class="dropdown-item"><i class="la la-print"></i> IMPRIMIR</a>*/ ?>
									<?php if($ORDEM->status == 1) { ?>
									<a href="javascript:statusGuia(<?=$ORDEM->id_ordem?>, 0)" class="dropdown-item"><i class="la la-ban"></i> CANCELAR</a>
									<a href="<?=URL_SISTEMA?>/ordens/novo&acao=editar&ordem=<?=$ORDEM->id_ordem?>&key=true" class="dropdown-item"><i class="fa fa-edit"></i> EDITAR</a>
									<a href="javascript:statusGuia(<?=$ORDEM->id_ordem?>, 7)" class="dropdown-item"><i class="la la-check"></i> ATENDIDO</a>
									<?php } ?>
									<?php if($ORDEM->status == 7) { ?>
									<a href="javascript:statusGuia(<?=$ORDEM->id_ordem?>, 0)" class="dropdown-item"><i class="la la-ban"></i> CANCELAR</a>
									<a href="javascript:statusGuia(<?=$ORDEM->id_ordem?>, 8)" class="dropdown-item"><i class="fa fa-cash"></i> FATURAR</a>
									<?php } ?>
									<a class="dropdown-item"><i class="la la-close"></i> FECHAR</a>
								  </span>
								</span>
							  </td>
							</tr>
							<?php } ?>
						  </tbody>
						  <tfoot>
							<tr>
							  <th>Nº GUIA</th>
							  <th>TITULAR</th>
							  <th>FORNECEDOR</th>
							  <th>VALOR</th>
							  <th>DATA EMISSÃO</th>
							  <th>STATUS</th>
							  <th>DATA PAGAMENTO</th>
							  <th>AÇÕES</th>
							</tr>
						  </tfoot>
						</table>
					  </div>
				  
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
 
 
  
<?php include_once(__DIR__."/../footer.php"); ?>