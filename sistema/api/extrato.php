<?php
$TITULAR = $_POST['id_associado'];

$ASSOCIADO = buscar("associados", "id_associado='$TITULAR'");
$PLANO = buscar("planos", "id_plano='".$ASSOCIADO->plano."'");

$ANO = $_POST['ano'];
$MES = $_POST['mes'];

$MESES = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novmebro", 12 => "Dezembro");

if($_POST['atendimento'] != 'x') { $TIPO = "AND associado='".$_POST['atendimento']."'"; } else { $TIPO = ''; }
if($_POST['status'] != 'x') { $STATUS = "AND status='".$_POST['status']."'"; } else { $STATUS = ''; }

if($_POST['tipo'] == 'x' or $_POST['tipo'] == 1) {
	$GUIAS = listar("guias", "titular='$TITULAR' AND ((data_cobranca<='$ANO-$MES-31') OR ((data_pagamento>='$ANO-$MES-31') or data_pagamento=NULL)) $TIPO $STATUS");
	foreach($GUIAS as $DADOS) {
		$DADOS->tipo = 'guia';
		$DADOS->id = $DADOS->id_guia;
		$ITENS[] = $DADOS;
	}
}

if($_POST['tipo'] == 'x' or $_POST['tipo'] == 2) {
	$MENSALIDADES = listar("mensalidades", "mes='$MES' AND ano='$ANO' AND associado='$TITULAR'");
	foreach($MENSALIDADES as $DADOS) {
		$DADOS->tipo = 'mensalidade';
		$DADOS->id = $DADOS->id_mensalidade;
		$ITENS[] = $DADOS;
	}
}


$TT_PERIODO = 0;
$TT_PERIODO_DESC = 0;
//ORGANIZA POR DATA
foreach ($ITENS as $T) {
	$ORGANIZA[] = $T->data_emissao;
}

array_multisort($ORGANIZA, $ITENS);


$L_FORNECEDORES = listar("fornecedores");
foreach($L_FORNECEDORES as $FORNECEDOR) {
	$FORNECEDORES[$FORNECEDOR->cod_fornecedor] = $FORNECEDOR;
}
$L_PLANOS = listar("planos");
foreach($L_PLANOS as $PLANO) {
	$PLANOS[$PLANO->id_plano] = $PLANO;
}

$L_DEPENDENTES = listar("dependentes", "id_associado='$TITULAR'");
foreach($L_DEPENDENTES as $DEPENDENTE) {
	$DEPENDENTES[$DEPENDENTE->id_dependente] = $DEPENDENTE;
}


/*$INICIO = implode("-", array_reverse( explode( "/", $_POST['inicio'] ) ) );
$FINAL = implode("-", array_reverse( explode( "/", $_POST['final'] ) ) );

$ASSOCIADO = buscar("associados", "id_associado='$TITULAR'");
$L_DEPENDENTES = listar("dependentes", "id_associado='$TITULAR'");
foreach($L_DEPENDENTES as $DEPENDENTE) {
	$DEPENDENTES[$DEPENDENTE->id_dependente] = $DEPENDENTE;
}
$L_FORNECEDORES = listar("fornecedores");
foreach($L_FORNECEDORES as $FORNECEDOR) {
	$FORNECEDORES[$FORNECEDOR->cod_fornecedor] = $FORNECEDOR;
}
$PLANO = buscar("planos", "id_plano='".$ASSOCIADO->plano."'");



if($_POST['atendimento'] != 'x') { $TIPO = "AND associado='".$_POST['atendimento']."'"; } else { $TIPO = ''; }
if($_POST['status'] != 'x') { $STATUS = "AND status='".$_POST['status']."'"; } else { $STATUS = ''; }

$GUIAS = listar("guias", "titular='$TITULAR' AND ((data_emissao>='$INICIO' AND data_emissao<='$FINAL') OR (data_cobranca>='$INICIO' AND data_cobranca<='$FINAL') OR (data_pagamento>='$INICIO' AND data_pagamento<='$FINAL') OR (data_retorno>='$INICIO' AND data_retorno<='$FINAL')) $TIPO $STATUS");

$FICHAS = listar("ordens", "titular='$TITULAR' AND ((data_emissao>='$INICIO' AND data_emissao<='$FINAL') OR (data_cobranca>='$INICIO' AND data_cobranca<='$FINAL') OR (data_pagamento>='$INICIO' AND data_pagamento<='$FINAL')) $TIPO $STATUS");

if($_POST['tipo'] == 'x' or $_POST['tipo'] == 1) {
	foreach($GUIAS as $GUIA) {
		$GUIA->id = $GUIA->id_guia;
		$ITENS[] = $GUIA;
	}
}
if($_POST['tipo'] == 'x' or $_POST['tipo'] == 2) {
	foreach($FICHAS as $FICHA) {
		$FICHA->id = $FICHA->id_ordem;
		$ITENS[] = $FICHA;
	}
}
$TT_DEP = 0;
$TT_PERIODO = 0;
$TT_PERIODO_DESC = 0;
//ORGANIZA POR DATA
foreach ($ITENS as $T) {
	$ORGANIZA[] = $T->data_emissao;
	$TT_PERIODO += $T->valor;
	$TT_PERIODO_DESC += $T->pagar;
	if($T->associado == 1) { $TT_DEP++; }
}

array_multisort($ORGANIZA, $ITENS);*/
?>

												<div class="row pt-2" id="invoice-customer-details">
													<div class="col-sm-12 text-center text-md-left">
														<p class="text-muted"><strong>DADOS DO ASSOCIADO</strong></p>
													</div>
													<div class="col-md-6 col-sm-12 text-center text-md-left">
														<ul class="px-0 list-unstyled">
															<li class="text-bold-800 text-uppercase">
																<strong><?=$ASSOCIADO->nome?></strong> <small>(<?=$PLANO->nome?>)</small>
															</li>
															<li><?=($ASSOCIADO->endereço) ? $ASSOCIADO->endereço : 'ENDEREÇO NÃO CADASTRADO'?><?=($ASSOCIADO->numero) ? ', '.$ASSOCIADO->numero : ''?> - <?=($ASSOCIADO->bairro) ? $ASSOCIADO->bairro : 'BAIRRO NÃO CADASTRADO'?></li>
															<li><?=($ASSOCIADO->telefone) ? $ASSOCIADO->telefone : 'TELEFONE NÃO CADASTRADO'?></li>
														</ul>
													</div>
													<div class="col-md-6 col-sm-12 text-center text-md-right">
														<p>
															<span class="text-muted">ANO:</span> <?=$_POST['ano']?><BR/>
															<span class="text-muted">MÊS:</span> <?=$_POST['mes']?><BR/>
															<span class="text-muted">DATA IMPRESSÃO:</span> <?=date('d/m/Y')?>
														</p>
													</div>
												</div>
												
												<div class="row">
													<div class="table-responsive col-sm-12">
														<table class="table">
															<thead>
																<tr>
																	<th>COD.</th>
																	<th class="text-right">EMISSÃO</th>
																	<th class="text-right">DESCRIÇÃO</th>
																	<th class="text-right">DATA</th>
																	<th class="text-right">VALOR</th>
																	<th class="text-right">STATUS</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach($ITENS as $ITEM) { ?>
																<?php if($ITEM->tipo == 'mensalidade') { ?>
																<?php 
																$TT_PERIODO += $ITEM->valor;
																$TT_PERIODO_DESC += $ITEM->valor;
																$MSDS = json_decode($ITEM->planos);
																$MS = 1;
																foreach($MSDS as $DADOS) { ?>
																<tr>
																	<th scope="row">Mens-<?=str_pad($ITEM->id, 6, 0, STR_PAD_LEFT)?>/<?=$MS++?></th>
																	<td>
																		<i class="fa fa-calendar"></i> 
																		<?=date('d/m/Y', strtotime($ITEM->data_emissao))?>
																	</td>
																	<td class="text-left">
																		<strong class="text-uppercase">Mensalidade <?=$PLANOS[$DADOS->plano]->nome?> <?=str_pad($ITEM->mes, 2, 0, STR_PAD_LEFT)?>/<?=$ITEM->ano?></strong>
																		<br/>
																		<small class="text-uppercase"><?=($DADOS->tipo == 'dependente')? $DEPENDENTES[$DADOS->id]->nome : $ASSOCIADO->nome?></small>
																	</td>
																	<td class="text-left">
																		<strong><i class="fa fa-credit-card-alt"></i> <?=($ITEM->data_pagamento)? date('d/m/Y', strtotime($ITEM->data_pagamento)) : 'NÃO PAGO'?></strong>
																	</td>
																	<td class="text-left">
																		<strong class="text-success">R$ <?=number_format($DADOS->valor , 2, ",", ".")?></strong>
																	</td>
																	<td class="text-right">
																		<?php
																		if($ITEM->status == 1) {
																			echo '<div class="badge badge-secondary">PAGO</div>';
																		} else  {
																			echo '<div class="badge badge-warning">FATURADO</div>';
																		}
																		?>
																	</td>
																</tr>
																<?php } ?>
																<?php } else { ?>
																<tr>
																	<th scope="row"><?=$ITEM->tipo?>-<?=str_pad($ITEM->id, 6, 0, STR_PAD_LEFT)?></th>
																	<td><i class="fa fa-calendar"></i> <?=date('d/m/Y', strtotime($ITEM->data_emissao))?></td>
																	<td class="text-left">
																		<strong class="text-uppercase">
																			<?=($ITEM->fornecedor == -1)? $ITEM->obs : '' ?>
																			<?=($FORNECEDORES[$ITEM->fornecedor]->nome_fantasia) ? $FORNECEDORES[$ITEM->fornecedor]->nome_fantasia : $FORNECEDORES[$ITEM->fornecedor]->razao_social?>
																		</strong>
																		<br/>
																		<small class="text-uppercase"><?=($ITEM->associado == 1)? $DEPENDENTES[$ITEM->dependente]->nome : $ASSOCIADO->nome?></small>
																	</td>
																	<td class="text-left">
																		<i class="fa fa-heartbeat"></i> <?=($ITEM->data_atendimento)? date('d/m/Y', strtotime($ITEM->data_atendimento)) : 'NÃO ATENDIMENTO'?><br/>
																		<small><i class="fa fa-credit-card-alt"></i> <?=($ITEM->data_pagamento)? date('d/m/Y', strtotime($ITEM->data_pagamento)) : 'NÃO PAGO'?></small>
																	</td>
																	<td class="text-left">
																		<?php if($ITEM->parcelas > 1) { 
																		
																		$TT_PERIODO += $ITEM->valor / $ITEM->parcelas; 
																		$TT_PERIODO_DESC += $ITEM->pagar / $ITEM->parcelas; 
																		?>
																		<small class="text-tachado text-danger">R$ <?=number_format($ITEM->valor, 2, ",", ".")?></small>
																		<small class="text-success">R$ <?=number_format($ITEM->pagar, 2, ",", ".")?></small>
																		<br/>
																		<?php //$parcelas =  json_decode($ITEM->pagamento_parcelas);
																		$MES_COBRADO = date('m', strtotime($ITEM->data_cobranca));
																		$parcela = 0;
																		for($x=intval($MES_COBRADO); $x <= $MES; $x++) {
																			$parcela++;
																		}
																		?>
																		<strong class="text-success"><?=$parcela?>/<?=$ITEM->parcelas?>x R$ <?=number_format($ITEM->pagar / $ITEM->parcelas, 2, ",", ".")?></strong>
																		<?php } else { ?>
																		<small class="text-tachado text-danger">R$ <?=number_format($ITEM->valor, 2, ",", ".")?></small>
																		<br/>
																		<strong class="text-success">R$ <?=number_format($ITEM->pagar , 2, ",", ".")?></strong>
																		<?php } ?>
																	</td>
																	<td class="text-right">
																		<?php
																		if($ITEM->status == 1) {
																			echo '<div class="badge badge-secondary">NOVO</div>';
																		}
																		else if($ITEM->status == 7) {
																			echo '<div class="badge badge-info">ATENDIDO</div>';
																		}
																		else if($ITEM->status == 8) {
																			echo '<div class="badge badge-warning">FATURADO</div>';
																		}
																		else if($ITEM->status == 9) {
																			echo '<div class="badge badge-success">PAGO</div>';
																		}
																		else if($ITEM->status == 10) {
																			echo '<div class="badge badge-success">PARCELADO</div>';
																		}
																		else {
																			echo '<div class="badge badge-danger">CANCELADO</div>';
																		}
																		?>
																	</td>
																</tr>
																<?php } ?>
																<?php } ?>
															</tbody>
														</table>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 col-sm-12 text-center text-md-left">
													</div>
													<div class="col-md-6 col-sm-12">
														<div class="table-responsive">
															<table class="table">
																<tbody >
																	<tr>
																		<td>TOTAL NO PERIODO</td>
																		<td class="text-right">
																			<small class="text-tachado text-danger">R$ <?=number_format($TT_PERIODO, 2, ",", ".")?></small><br/>
																			<strong class="text-success">R$ <?=number_format($TT_PERIODO_DESC, 2, ",", ".")?></strong>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											