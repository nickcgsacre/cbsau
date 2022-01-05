<?php


$MES = $_POST['mes'];
$ANO = $_POST['ano'];

$MESES = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novmebro", 12 => "Dezembro");

/*$ASSOCIADOS = listar("associados", "data_cadastro<='".$ANO."-".$MES."-31' AND (status='1' OR data_cancelamento>='".$ANO."-".$MES."-01')");*/

$total = contarQueryes("mensalidades", "mes='$MES'");

$L_PLANOS = listar("planos");
$PLANOS = [];
foreach($L_PLANOS as $DADOS) {
	$PLANOS[$DADOS->id_plano] = $DADOS;
}


if($total == 0) {
	$AGORA = date('Y-m-d');
	$ASSOCIADOS = listar("associados", "data_cadastro<='".$ANO."-".$MES."-31' AND (status='1' OR data_cancelamento>='".$ANO."-".$MES."-01') ORDER BY nome ASC");
	
	foreach($ASSOCIADOS as $DADOS) {
		$TP = [];
		$DEPENDENTES = listar("dependentes", "id_associado='".$DADOS->id_associado."' AND data_cadastro<='".$ANO."-".$MES."-01' AND (status='1' OR data_cancelamento>='".$ANO."-".$MES."-01')");
		$SB = $PLANOS[$DADOS->plano]->mensalidade;
		$TP[] = array("tipo" => "associado", "id" => $DADOS->id_associado, "plano" => $DADOS->plano, "valor" => $PLANOS[$DADOS->plano]->mensalidade);
		foreach($DEPENDENTES as $DP) {
			$SB += $PLANOS[$DP->plano]->mensalidade;
			$TP[] = array("tipo" => "dependente", "id" => $DP->id_dependente, "plano" => $DP->plano, "valor" => $PLANOS[$DP->plano]->mensalidade);
		}
		
		gravar("mensalidades", "'', '".$DADOS->id_associado."', '".count($DEPENDENTES)."', '".json_encode($TP)."', '$SB', '$MES', '$ANO', '$AGORA', NULL, NULL, '', '".$DADOS_USUARIO->id."', '0'");
	}
}

$MENSALIDADES = listar("mensalidades", "mes='$MES' AND ano='$ANO'");
?>
  
	<div class="printable">
		<!-- Invoice Company Details -->
		<div id="invoice-company-details" class="row">
		  <div class="col-sm-12 col-12 text-center text-sm-left">
			<div class="media row">
			  <div class="col-12 col-sm-3 col-xl-3">
				<img src="<?=URL_SISTEMA?>/app-assets/images/logo.png" style="max-width: 100%" class="mb-1 mb-sm-0">
			  </div>
			  <div class="col-12 col-sm-9 col-xl-9">
				<div class="media-body">
				  <ul class="ml-2 px-0 list-unstyled">
					<li class="text-bold-800"><h3>CBSAÚDE</h3></li>
					<li><h5>Relatório de Mensalidades</h5></li>
					<li><h6><?=$MESES[$MES]?> de <?=$ANO?></h6></li>
				  </ul>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<!-- Invoice Company Details -->

		<!-- Invoice Items Details -->
		<div id="invoice-items-details" class="pt-2">
		  <div class="row">
			<div class="table-responsive col-12">
			  <table class="table">
				<thead>
				  <tr>
					<th class="text-center" style="width: 10%!important">SEG.</th>
					<th class="text-center" style="width: 15%!important">MATRÍCULA</th>
					<th class="text-center" style="width: 50%!important">ASSOCIADO</th>
					<th class="text-center" style="width: 10%!important">DEPENDENTES</th>
					<th class="text-center" style="width: 15%!important">VALOR (R$)</th>
				  </tr>
				</thead>
				<tbody>
					<?php $TOTAL = 0; $seg = 1; 
					foreach($MENSALIDADES as $DADOS) {
						$ASSOCIADO = buscar("associados", "id_associado='".$DADOS->associado."'");						
					?>
					<tr>
						<td class="text-center" style="width: 10%!important"><strong><?=$seg++?></strong></td>
						<td class="text-center" style="width: 15%!important"><?=($ASSOCIADO->matricula)?$ASSOCIADO->matricula:'N/A'?></td>
						<td style="width: 50%!important"><?=$ASSOCIADO->nome?></td>
						<td style="width: 10%!important"><?=$DADOS->dependentes?></td>
						<td class="text-center" style="width: 15%!important">R$ <?=number_format($DADOS->valor, 2, ",", ".")?></td>
					</tr>
					<?php $TOTAL += $DADOS->valor; } ?>
				</tbody>
			  </table>
			</div>
		  </div>
		  <div class="row">
			<div class="col-sm-7 col-12 text-center text-sm-left">
			</div>
			<div class="col-sm-5 col-12">
			  <p class="lead">Total</p>
			  <div class="table-responsive">
				<table class="table">
				  <tbody>
					<tr>
					  <td style="width: 50%!important">Sub Total</td>
					  <td style="width: 50%!important" class="text-right">R$ <?=number_format($TOTAL, 2, ",", ".")?></td>
					</tr>
					<tr>
					  <td style="width: 50%!important" class="text-bold-800">Total</td>
					  <td style="width: 50%!important" class="text-bold-800 text-right"> <strong>R$ <?=number_format($TOTAL, 2, ",", ".")?></strong></td>
					</tr>
				  </tbody>
				</table>
			  </div>
			  <p class="text-center">Documento impresso em <?=date('d/m/Y')?> às <?=date('H:i:s')?></p>
			</div>
		  </div>
		</div>
	
	</div>
	<!-- Invoice Footer -->
	<div id="invoice-footer">
	  <div class="row">
		<div class="col-sm-7 col-12 text-center text-sm-left">
		  
		</div>
		<div class="col-sm-5 col-12 text-center">
			<button onclick="window.print()" type="button" class="btn btn-info btn-print btn-lg my-1">
				<i class="la la-print mr-50"></i>
				IMPRIMIR
			</button>
		</div>
	  </div>
	</div>
    <!-- Invoice Footer -->
