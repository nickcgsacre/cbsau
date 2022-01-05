<?php


$ID = $_POST['id'];
$TIPO = $_POST['tipo'];
$AREA = $_POST['area'];

if($TIPO == 'associado') {
	$PACIENTE = buscar("associados", "id_associado='$ID'");
	$FICHA = listar("ficha_medica", "area='$AREA' AND tipo='0' AND paciente='".$PACIENTE->id_associado."' AND status='1'");
} else {
	$PACIENTE = buscar("dependentes", "id_dependente='$ID'");
	$FICHA = listar("ficha_medica", "area='$AREA' AND tipo='1' AND paciente='".$PACIENTE->id_dependente."' AND status='1'");
}

$ESPECIALIDADE = buscar("ficha_medica_areas", "id_area='$AREA'");

?>
  <style>
	  .th{
    white-space: inherit !important;
	  }
	  </style>

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
					
                    <div class="tab-content px-1 pt-1">
					
                    <div role="tabpanel" class="tab-pane active" id="dados" aria-labelledby="dados-tab1"
                      aria-expanded="true">
						
						<div id="painel">
							<div class="printable">
								<h3 class="text-center">COOPERATIVA DE SAÚDE DOS SERVIDORES PÚBLICOS DO</h3>
								<h3 class="text-center">CORPO DE BOMBEIROS DO ESTADO DO ACRE</h3>
								<h3 class="text-center">CBSAUDE</h3>
								<h1 class="text-center">FICHA MÉDICA</h1>
								
								<div class="col-md-8 left"><strong>NOME:</strong> <?=$PACIENTE->nome?></div>
								<div class="col-md-4 left"><strong>PLANO:</strong> <?=$PACIENTE->plano?></div>
								<div class="col-md-7 left"><strong>ENDEREÇO:</strong> <?=$PACIENTE->endereco?></div>
								<div class="col-md-5 left"><strong>BAIRRO:</strong> <?=$PACIENTE->bairro?></div>
								<div class="col-md-6 left"><strong>TELEFONE:</strong> <?=$PACIENTE->telefone?></div>
								<div class="col-md-6 left"><strong>DATA NASCIMENTO:</strong> <?=$PACIENTE->nascimento?></div>
								<div class="col-md-6 left"><strong>NATURALIDADE:</strong> <?=$PACIENTE->naturalidade?></div>
								<div class="col-md-6 left"><strong>ESTADO CÍVIL:</strong> <?=$PACIENTE->estado_civil?></div>
								<div class="col-md-12 left"><strong>PROFISSÃO:</strong> <?=$PACIENTE->profissao?></div>
								<?php if($TIPO == 'dependente') { ?>
								<div class="col-md-12 left"><strong>NOME DO TITULAR:</strong> </div>
								<?php } ?>
								<div class="col-md-12 left"><strong>ESPECIALIDADE:</strong> <?=$ESPECIALIDADE->area?></div>
								
								<div>
									<h3 class="text-center">ASSITÊNCIA MÉDICA</h3>
									<div class="table-responsive">
									<table class="table table-bordered table-striped">
										<thead class="thead-dark">
											<tr>
												<th>DATA CONSULTA</th>
												<th>CONSULTA - DIAGNÓSTICO - PRESCRIÇÕES - OUTROS</th>
												<th>MÉDICO RESPONSÁVEL</th>
											</tr>
										</thead>
										<tbody><?php 
											foreach($FICHA as $DADOS) {
											?>
											<tr>
												<th scope="row" id="dt-<?=$DADOS->id_ficha?>" ondblclick="ficha.guia.editar.campo(this, 'data')"><?=strftime('%d/%m/%Y', strtotime($DADOS->data))?></th>
												<th scope="row" id="desc-<?=$DADOS->id_ficha?>" style="white-space: inherit !important;" ondblclick="ficha.guia.editar.campo(this, 'descricao')"><?=$DADOS->descricao?></th>
												<th scope="row" id="vlr-<?=$DADOS->id_ficha?>" style="widh:40%" ondblclick="ficha.guia.editar.campo(this, 'medico')"><?=$DADOS->medico?></th>
											</tr>
											<?php } ?>
										</tbody>
									</table>
											</div>
								</div>
							</div>
						
							  <div class="form-actions">
								<button type="button" class="btn btn-info mr-1" onclick="window.print();">
								  <i class="fa fa-print"></i> IMPRIMIR
								</button>
								<button type="button" onclick="ficha.guia.add()" class="btn btn-success mr-1" onclick="gravarForm()">
								  <i class="fa fa-plus"></i> NOVA CONSULTA
								</button>
							  </div>
						  </div>
                    </div>
					  
					 
					</div>
					
			