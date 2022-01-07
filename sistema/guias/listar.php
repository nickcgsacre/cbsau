<?php
define("PAGINA", "GUIAS DE ENCAMINHAMENTO");
define("CSS", '
<link rel="stylesheet" type="text/css" href="' . URL_SISTEMA . '/app-assets/vendors/css/tables/datatable/datatables.min.css">');
define("JS", '
  <!-- BEGIN PAGE VENDOR JS-->
  <script type="text/javascript" src="' . URL_SISTEMA . '/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="' . URL_SISTEMA . '/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="' . URL_SISTEMA . '/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="' . URL_SISTEMA . '/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="' . URL_SISTEMA . '/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js"
  type="text/javascript"></script>
   <script src="' . URL_SISTEMA . '/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="' . URL_SISTEMA . '/sistema/guias/listar.js"></script>
  <!-- END PAGE VENDOR JS-->');
include_once(__DIR__ . "/../header.php");
include_once(__DIR__ . "/../menu.php");

$GUIAS = listar("guias", NULL, "id_guia DESC");
$L_ASSOCIADOS = listar("associados");
$L_DEPENDENTES = listar("dependentes");
$L_FORNECEDORES = listar("fornecedores");

foreach ($L_ASSOCIADOS as $ITEM) {
	$ASSOCIADOS[$ITEM->id_associado] = $ITEM;
}
foreach ($L_DEPENDENTES as $ITEM) {
	$DEPENDENTES[$ITEM->id_dependente] = $ITEM;
}
foreach ($L_FORNECEDORES as $ITEM) {
	$FORNECEDORES[$ITEM->cod_fornecedor] = $ITEM;
}

?>
<?php if ($_GET['guia']) { ?>
	<script>
		var imprimirGuia = '<?= $_GET['guia'] ?>'
	</script>
<?php } ?>
<!-- END VENDOR CSS-->

<!-- ////////////////////////////////////////////////////////////////////////////-->

<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-2">
				<h3 class="content-header-title">GUIAS DE ENCAMINHAMENTO</h3>
				<div class="row breadcrumbs-top">
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= URL_SISTEMA ?>">Dashboard</a>
							</li>
							<li class="breadcrumb-item active">Guias de Encaminhamento
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
							<a href="<?= URL_SISTEMA ?>/guias/novo" class="btn btn-icon btn-outline-primary"><i class="la la-plus"></i> NOVA GUIA</a>
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
								<h4 class="card-title">Listar Guias de Encaminhamento</h4>
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
									<nav>
										<div class="nav nav-tabs" id="nav-tab" role="tablist">
											<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-news" role="tab" aria-controls="nav-news" aria-selected="true">NOVAS GUIAS</a>
											<a class="nav-item nav-link" id="nav-aguardando-atendimento-tab" data-toggle="tab" href="#nav-aguardando-atendimento" role="tab" aria-controls="nav-aguardando-atendimento" aria-selected="true">AGUARDANDO ATENDIMENTO</a>
											<a class="nav-item nav-link" id="nav-atendido-tab" data-toggle="tab" href="#nav-atendido" role="tab" aria-controls="nav-atendido" aria-selected="true">ATENDIDO</a>
											<a class="nav-item nav-link" id="nav-aguardando-pagamento-tab" data-toggle="tab" href="#nav-aguardando-pagamento" role="tab" aria-controls="nav-aguardando-pagamento" aria-selected="true">AGUARDANDO PAGAMENTO</a>
											<a class="nav-item nav-link" id="nav-parcelado-tab" data-toggle="tab" href="#nav-parcelado" role="tab" aria-controls="nav-parcelado" aria-selected="false">PARCELADO</a>
											<a class="nav-item nav-link" id="nav-pago-tab" data-toggle="tab" href="#nav-pago" role="tab" aria-controls="nav-pago" aria-selected="false">PAGO</a>
											<a class="nav-item nav-link" id="nav-cancelado-tab" data-toggle="tab" href="#nav-cancelado" role="tab" aria-controls="nav-cancelado" aria-selected="false">CANCELADA</a>
										</div>
									</nav>
									<div class="tab-content" id="nav-tabContent">
										<div class="tab-pane fade show active" id="nav-news" role="tabpanel" aria-labelledby="nav-news-tab">
											<script>
												let clicks = 0;

												function addClick() {
													clicks = clicks + 1;
													document.querySelector('.total-clicks').textContent = clicks;
												}

												function clickButton() {
													click_event = new CustomEvent('click');
													btn_element = document.querySelector('#n_guia');
													btn_element.dispatchEvent(click_event);
												}

												setTimeout(() => {
													clickButton();
												}, 1000);
											</script>
											<div class="table-responsive">
												<table id="invoices-list" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
													<thead>
														<tr>
															<th id="n_guia">Nº GUIA</th>
															<th>TITULAR/BENEFICIARIO</th>
															<th>FORNECEDOR</th>
															<th>VALOR</th>
															<th>PLANO</th>
															<th>DATA EMISSÃO</th>
															<th>STATUS</th>
															<th>DATA PAGAMENTO</th>
															<th>AÇÕES</th>
														</tr>
													</thead>
													<tbody>
														<!-- PAID -->
														<?php
														foreach ($GUIAS as $GUIA) {
															$plano = listar("planos", "id_plano = " . $GUIA->plano);
														?>
															<tr id="fatura-<?= $GUIA->id_guia ?>">
																<td><?= str_pad($GUIA->id_guia, 6, 0, STR_PAD_LEFT) ?></td>
																<td>
																	<?= ($GUIA->titular > 0) ? $ASSOCIADOS[$GUIA->titular]->nome : "NÃO CADASTRADO" ?><br />
																	<small><?= ($GUIA->associado == 1) ? $DEPENDENTES[$GUIA->dependente]->nome : $ASSOCIADOS[$GUIA->titular]->nome ?></small>
																</td>
																<td><?= ($GUIA->fornecedor == -1) ? $GUIA->obs : '' ?><?= ($FORNECEDORES[$GUIA->fornecedor]->nome_fantasia) ? $FORNECEDORES[$GUIA->fornecedor]->nome_fantasia : $FORNECEDORES[$GUIA->fornecedor]->razao_social ?></td>
																<td>

																	<?php if ($GUIA->parcelas > 1) { ?>
																		<small class="text-tachado text-danger">R$ <?= number_format($GUIA->valor, 2, ",", ".") ?></small>
																		<small class="text-success">R$ <?= number_format($GUIA->pagar, 2, ",", ".") ?></small>
																		<br />
																		<strong class="text-success"><?= $GUIA->parcelas ?>x R$ <?= number_format($GUIA->pagar / $GUIA->parcelas, 2, ",", ".") ?></strong>
																		<small class="text-danger">(R$ -<?= number_format($GUIA->saldo, 2, ",", ".") ?>)</small>
																	<?php } else { ?>
																		<small class="text-tachado text-danger">R$ <?= number_format($GUIA->valor, 2, ",", ".") ?></small>
																		<br />
																		<strong class="text-success">R$ <?php

																										if ($plano[0]->cobrado < 100) {
																											$valorcomdesconto = $GUIA->valor - ($GUIA->valor * $plano[0]->cobrado / 100);
																											echo number_format($valorcomdesconto, 2, ",", ".");
																										}
																										if ($plano[0]->cobrado == 100) {
																											echo number_format($GUIA->valor, 2, ",", ".");
																										}
																										if ($plano[0]->cobrado > 100) {
																											$juros = $plano[0]->cobrado / 100;
																											$valor = $GUIA->valor;
																											$valorcomacrescimo = ($valor * $juros);
																											echo number_format($valorcomacrescimo, 2, ",", ".");
																										}


																										?></strong>
																	<?php } ?>

																</td>
																<td>
																	<?= $plano[0]->nome; ?>
																</td>
																<td><?= date("d/m/Y", strtotime($GUIA->data_emissao)) ?></td>
																<td>

																	<?php
																	if ($GUIA->status == 1) {
																		echo '<span class="badge badge-default badge-success badge-lg">NOVA</span>';
																	} else if ($GUIA->status == 7) {
																		echo '<span class="badge badge-default badge-danger badge-lg">ATENDIDO</span>';
																	} else if ($GUIA->status == 8) {
																		echo '<span class="badge badge-default badge-warning badge-lg">AGUARDANDO PAGAMENTO</span>';
																	} else if ($GUIA->status == 9) {
																		echo '<span class="badge badge-default badge-success badge-lg">PAGO</span>';
																	} else if ($GUIA->status == 10) {
																		echo '<span class="badge badge-default badge-success badge-lg">PARCELADO</span>';
																	} else {
																		echo '<span class="badge badge-default badge-default badge-lg">CANCELADA</span>';
																	}
																	?>
																	</span>
																</td>
																<td><?php if ($GUIA->status == 9) {
																		echo date("d/m/Y", strtotime($GUIA->data_pagamento));
																	} else {
																		echo '---';
																	} ?></td>
																<td>
																	<span class="dropdown">
																		<button id="btnSearchDrop<?= $GUIA->id_guia ?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right"><i class="ft-settings"></i></button>
																		<span aria-labelledby="btnSearchDrop<?= $GUIA->id_guia ?>" class="dropdown-menu mt-1 dropdown-menu-right">
																			<?php if ($GUIA->fornecedor != -1) { ?>
																				<a href="javascript:gerarGuia(<?= $GUIA->id_guia ?>)" class="dropdown-item"><i class="la la-print"></i> IMPRIMIR</a>
																			<?php } ?>
																			<?php if ($GUIA->status == 1) { ?>
																				<a href="javascript:statusGuia(<?= $GUIA->id_guia ?>, 0)" class="dropdown-item"><i class="la la-ban"></i> CANCELAR</a>
																				<a href="javascript:statusGuia(<?= $GUIA->id_guia ?>, 7)" class="dropdown-item"><i class="la la-check"></i> ATENDIDO</a>
																			<?php } ?>
																			<?php if ($GUIA->status == 7) { ?>
																				<a href="javascript:statusGuia(<?= $GUIA->id_guia ?>, 0)" class="dropdown-item"><i class="la la-ban"></i> CANCELAR</a>
																				<a href="javascript:statusGuia(<?= $GUIA->id_guia ?>, 8)" class="dropdown-item"><i class="fa fa-money"></i> FATURADO</a>
																			<?php } ?>
																			<?php if ($GUIA->status == 8 and $GUIA->parcelas == 1) { ?>
																				<a href="javascript:statusGuia(<?= $GUIA->id_guia ?>, 0)" class="dropdown-item"><i class="la la-ban"></i> CANCELAR</a>
																				<!--<a href="javascript:parcelarGuia(<?= $GUIA->id_guia ?>, 9)" class="dropdown-item"><i class="fa fa-object-ungroup"></i> PARCELAR</a>-->
																				<a href="javascript:statusGuia(<?= $GUIA->id_guia ?>, 9)" class="dropdown-item"><i class="fa fa-check-square"></i> PAGO</a>
																			<?php } ?>
																			<?php if ($GUIA->status == 8 and $GUIA->parcelas > 1) { ?>
																				<a href="javascript:statusGuia(<?= $GUIA->id_guia ?>, 0)" class="dropdown-item"><i class="la la-ban"></i> CANCELAR</a>
																				<a href="javascript:informacoesGuia(<?= $GUIA->id_guia ?>)" class="dropdown-item"><i class="fa fa-info-circle"></i> INFORMAÇÕES</a>
																				<a href="javascript:statusGuia(<?= $GUIA->id_guia ?>, 9)" class="dropdown-item"><i class="fa fa-check-square"></i> PAGAR PARCELA</a>
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
											...
										</div>
										<div class="tab-pane fade" id="nav-aguardando-atendimento" role="tabpanel" aria-labelledby="nav-aguardando-atendimento-tab">
											Aguardando Atendimento
										</div>
										<div class="tab-pane fade" id="nav-atendido" role="tabpanel" aria-labelledby="nav-atendido-tab">
											Atendido
										</div>
										<div class="tab-pane fade" id="nav-aguardando-pagamento" role="tabpanel" aria-labelledby="nav-aguardando-pagamento-tab">
											Aguardando Pagamento
										</div>
										<div class="tab-pane fade" id="nav-parcelado" role="tabpanel" aria-labelledby="nav-parcelado-tab">
											Parcelado
										</div>
										<div class="tab-pane fade" id="nav-pago" role="tabpanel" aria-labelledby="nav-pago-tab">
											Pago
										</div>
										<div class="tab-pane fade" id="nav-cancelado" role="tabpanel" aria-labelledby="nav-cancelado-tab">
											Cancelado
										</div>
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

<?php include_once(__DIR__ . "/../footer.php"); ?>