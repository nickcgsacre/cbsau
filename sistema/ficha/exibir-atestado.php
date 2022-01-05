<?php


$ID_USUARIO = $_POST['usuario'];
$TIPO = $_POST['tipo'];
$OPTS = $_POST['opts'];
$MOTIVO = $_POST['motivo'];
$DIAS = $_POST['dias'];
$CLINICA = $_POST['clinica'];

if($TIPO == 'associado') {
	$PACIENTE = buscar("associados", "id_associado='$ID_USUARIO'");
} else {
	$PACIENTE = buscar("dependentes", "id_dependente='$ID_USUARIO'");
}

?>
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
					
	<div class="tab-content px-1 pt-1">

		<div role="tabpanel" class="tab-pane active" id="dados" aria-labelledby="dados-tab1"
		aria-expanded="true">

			<div id="painel">
				<div class="row atestado printable">
					<table style="width: 100%;">
						<tr style="width: 100%!important;">
							<td colspan="12">
								<div style="border: 2px solid #000!important; border-radius: 5px; width: 49.75%!important; margin-right: 0.5%; float: left">
									<div style="width: 40%!important; float: left">
										<img src="<?=URL_SISTEMA?>/app-assets/images/logo.png" style="max-width: 100%"/>
									</div>
									<div style="width: 60%!important; float: left">
										<br><br>
										<h3>CORPO DE BOMBEIROS</h3>
										<h5>DIRETORIA DE SAÚDE</h5>
										<h6>SERVIÇO MÉDICO</h6>
									</div>
								</div>
								<div style="border: 2px solid #000!important; border-radius: 5px; width: 49.75%!important; float: left;height: 100%;">
								
								</div>
							</td>
						</tr>
						<tr style="width: 100%!important;">
							<td colspan="10" style="width: 100%!important; padding-left: 5px">
								ATESTO para os fins necessários que o(a)
							</td>
						</tr>
						<tr style="width: 100%!important;">
							<td colspan="10">
								<div style="border: 2px solid #000!important; border-radius: 5px; width: 69.5%!important; margin-right: 0.5%; padding: 0px 8px 5px; line-height: 14px; float: left;">
									<small>Nome:</small><br/>
									<strong><?=$PACIENTE->nome?></strong>
								</div>
								<div style="border: 2px solid #000!important; border-radius: 5px; width: 30%!important; padding: 0px 8px 5px; line-height: 14px; float: left;">
									<small>Matrícula:</small><br/>
									<strong><?=($PACIENTE->matricula)? $PACIENTE->matricula : 'NÃO INFORMADO'?></strong>
								</div>
							</td>
						</tr>
						<tr style="width: 100%!important;">
							<td colspan="10" style="width: 100%!important;">
							</td>
						</tr>
						<tr style="width: 100%!important;">
							<td colspan="10">
								<div style="border: 2px solid #000!important; border-radius: 5px; width: 69.5%!important; margin-right: 0.5%; padding: 0px 8px 5px; line-height: 14px; float: left;">
									<small>Unidade:</small><br/>
									<strong><?=($PACIENTE->unidade)? $PACIENTE->unidade : 'NÃO INFORMADO'?></strong>
								</div>
								<div style="border: 2px solid #000!important; border-radius: 5px; width: 30%!important; padding: 0px 8px 5px; line-height: 14px; float: left;">
									<small>Posto/Graduação:</small><br/>
									<strong><?=($PACIENTE->graduacao)? $PACIENTE->graduacao : 'NÃO INFORMADO'?></strong>
								</div>
							</td>
						</tr>
						<tr style="width: 100%!important;">
							<td colspan="10" style="width: 100%!important; padding-left: 5px">
								COMPARECEU à policlinica / CBMAC-AC sendo:
							</td>
						</tr>
						<tr style=" width: 100%!important;">
							<td colspan="10" >
								<div style="width: 100%!important; border: 2px solid #000!important; border-radius: 5px; float: left; padding: 15px 0px 15px; line-height: 14px;">
									<div style="width: 20%!important; float: left">
										<h5 style="text-align: initial;">
											<div style="border: 2px solid #000; width: 15px!important;height: 15px!important; float: left;border-radius: 2px; margin-left: 20px;  margin-right: 10px; box-shadow: 1px 1px;"><?=($OPTS == 0 OR $OPTS == 1)? 'X' : ''?></div> ATENDIDO(A)
										</h5>
										<h5 style="text-align: initial;">
											<div style="border: 2px solid #000; width: 15px!important;height: 15px!important; float: left;border-radius: 2px; margin-left: 20px;  margin-right: 10px; box-shadow: 1px 1px; text-align: center; font-size: 12px;"><?=($OPTS == 0 OR $OPTS == 2)? 'X' : ''?></div> MEDICADO(A)
										</h5>
									</div>
									<div style="width: 80%!important; float: left;">
										<br><br>
										<strong>Na Clínica: <?=$CLINICA?></strong>
									</div>
								</div>
							</td>
						</tr>
						<tr style="width: 100%!important;">
							<td colspan="10" style="width: 100%!important; padding-left: 5px">
								CONVÉM ser dispensado(a) <?=$MOTIVO?>
							</td>
						</tr>
						<tr style="width: 100%!important;">
							<td colspan="10" style="width: 100%!important; padding-left: 5px">
								Por <strong><?=$DIAS?></strong> dias, a partir de <strong><?=date('d/m/Y')?></strong>
							</td>
						</tr>
						<tr style="width: 100%!important;">
							<td colspan="4" style="width: 40%!important;">
								<br>
								<br>
								<br>
								RIO BRANCO-AC <?=date('d/m/Y')?>
							</td>
							<td colspan="2" style="width: 20%!important;">
							</td>
							<td colspan="4" style="border: 2px solid #fff!important; width: 40%!important;">
								<div style="border: 2px solid #000!important; border-radius: 5px; width: 100%!important; padding: 5px;">
								
									<br>
									<br>
									<br>
									<strong>Médico e C.R.M</strong>
								</div>
							</td>
						</tr>
					</table>
					
				</div>				
			</div>
		</div>


	</div>
					
			