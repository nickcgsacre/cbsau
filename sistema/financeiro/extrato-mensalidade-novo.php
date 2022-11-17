<?php
$MES = $_POST['mes'];
$ANO = $_POST['ano'];
$ASSOCIADO = $_POST['associado'];

$query = "associado IS NOT NULL ";

if ($ASSOCIADO) {
    $query = $query . "AND associado = $ASSOCIADO ";
}

if (!empty($MES)) {
    if (count($MES) > 1) {
        $meses = implode(", ", $MES);
        $query = $query . "AND mes IN($meses)";
    } else {
        $primeiroMes = $MES[0];
        $query = $query . "AND mes = $primeiroMes ";
    }
}

if (!empty($ANO)) {
    if (count($ANO) > 1) {
        $anos = implode(", ", $ANO);
        $query = $query . " AND ano IN($anos) ";
    } else {
        $primeiroAno = $ANO[0];
        $query = $query . " AND ano = $primeiroAno ";
    }
}

$MENSALIDADES = listar("mensalidades", $query);
?>
	<div class="printable">
		<!-- Invoice Company Details -->
		<div id="invoice-company-details" class="row">
		  <div class="col-sm-12 col-12 text-center text-sm-left">
			<div class="media row">
			  <div class="col-12 col-sm-3 col-xl-3">
				<img src="<?=URL_SISTEMA?>/app-assets/images/logo.png" style="max-width: 100%" height="170" class="mb-1 mb-sm-0">
			  </div>
			  <div class="col-12 col-sm-9 col-xl-9">
				<div class="media-body">
				  <ul class="px-0 list-unstyled">
					<li class="text-bold-800"><h3>CBSAÚDE</h3></li>
					<li><h5>Relatório de Mensalidades dos Associados</li>
				  </ul>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<!-- Invoice Company Details -->

		<!-- Invoice Items Details -->
		<div id="invoice-items-details" class="pt-2">
            <div class="table-responsive">
                <table class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th>QTD. PLANOS</th>
                            <th>VALOR</th>
                            <th>Associado</th>
                            <th>Valor Mes anterior</th>
                            <th>DATA DA EMISSAO</th>
                            <th>DATA DO REPASSE</th>
                            <th>DATA DO PAGAMENTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($MENSALIDADES) > 0) { ?>
                            <?php $valorTotal = 0?>
                            <?php foreach($MENSALIDADES as $mensalidade) { ?>
                                <tr>
                                    <?php
                                        $dataEmissao = date_create($mensalidade->data_emissao);
                                        $dataRepasse = date_create($mensalidade->data_repasse);
                                        $dataPagamento = date_create($mensalidade->data_pagamento);
                                        $associado = buscar('associados', 'id_associado = '.$mensalidade->associado);

                                        $mensalidadeAnterior = null;

                                        if ($mensalidade->mes == 1) {
                                            $anoAnterior = $mensalidade->ano - 1;
                                            $mensalidadeAnterior = buscar('mensalidades', "associado = '$mesalidade->associado' and ano = '$anoAnterior' and mes = 12");
                                        } else {
                                            $mesAnterior = $mensalidade->mes - 1;
                                            $mensalidadeAnterior = buscar('mensalidades', "associado = '$mesalidade->associado' and mes = $mesAnterior");
                                        }
                                    ?>
                                    <td><?=count($mensalidade->planos)?></td>
                                    <td>R$ <?=$mensalidade->valor?></td>
                                    <td><?= $associado->nome ?></td>
                                    <td><?= $mensalidadeAnterior->valor ? $mensalidadeAnterior->valor : 'Nenhum valor registrado' ?></td>
                                    <td><?=date_format($dataEmissao, 'd/m/Y')?></td>
                                    <td><?=date_format($dataRepasse, 'd/m/Y')?></td>
                                    <td><?=date_format($dataPagamento, 'd/m/Y')?></td>
                                </tr>
                                <?php $valorTotal += $mensalidade->valor ?>
                            <?php } ?>
                            
                            <tr>
                                <td colspan="7" class="bg-secondary text-white">
                                    <strong>Valor total: R$ <?=$valorTotal?></strong>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhuma mensalidade encontrada</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
		</div>
	
	</div>
	<!-- Invoice Footer -->
	<!-- <div id="invoice-footer">
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
	</div> -->
    <!-- Invoice Footer -->
