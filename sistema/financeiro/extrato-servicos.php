<?php


$MES = $_POST['mes'];
$ANO = $_POST['ano'];

$MESES = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novmebro", 12 => "Dezembro");
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
					<li><h5>Relatório Serviços Prestados</h5></li>
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
					<th class="text-center" style="width: 60%!important">ASSOCIADO</th>
					<th class="text-center" style="width: 15%!important">VALOR PAGO (R$)</th>
					<th class="text-center" style="width: 15%!important">VALOR A PAGAR (R$)</th>
					<th class="text-center" style="width: 15%!important">VALOR TOTAL (R$)</th>
				  </tr>
				</thead>
				<tbody>
					<?php $TOTAL = 0; $seg = 1; 
					$ASSOCIADOS = listar("associados");
					foreach($ASSOCIADOS as $ASSOCIADO) { 
						$SERVICOS = listar("guias", "data_emissao BETWEEN '$ANO-$MES-01' AND '$ANO-$MES-31' AND titular = '".$ASSOCIADO->id_associado."'");
						
						
						$PAGO = 0;
						$PAGAR = 0;
						$TOTALPAGAR = 0;
						foreach($SERVICOS as $DADOS) {
							if($DADOS->obs == "PAGAMENTO DESCONTADO"){
								$PAGO += $DADOS->valor;
							}else{
								$TOTALPAGAR += $DADOS->valor;
							}

							if($DADOS->parcelas > 1) { 
								$DADOS->pagar = $DADOS->pagar / $DADOS->parcelas;
							}
							$PAGAR += $DADOS->pagar;

						}

						
						if($PAGAR > 0) {
					?>
					<tr>
						<td class="text-center" style="width: 10%!important"><strong><?=$seg++?></strong></td>
						<td class="text-center" style="width: 15%!important"><?=($ASSOCIADO->matricula)?$ASSOCIADO->matricula:'N/A'?></td>
						<td style="width: 60%!important"><?=$ASSOCIADO->nome?></td>


						<td class="text-center" style="width: 15%!important">R$ <?=number_format(abs($PAGO), 2, ",", ".")?></td>
						<td class="text-center" style="width: 15%!important">R$ <?=number_format($PAGAR, 2, ",", ".")?></td>
						<td class="text-center" style="width: 15%!important">R$ <?=number_format(abs($PAGO)+$PAGAR, 2, ",", ".")?></td>
					</tr>
					<?php $TOTAL += abs($PAGO)+$PAGAR;  } } ?>
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
