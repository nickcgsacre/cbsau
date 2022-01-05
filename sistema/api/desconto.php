<?php 

if($_POST['acao'] == 'pagamento') {

	$ASSOCIADO = $_POST['associado'];
	$VALOR = $_POST['valor'];
	$HOJE = date('Y-m-d');
	$MES = date('m');
	$ANO = date('Y');
	$STATUS = 8;
	$OPERADOR = 0;
	$VALOR = $VALOR;
	$OBS = "PAGAMENTO DESCONTADO";
	//PERCORRE TODAS AS GUIAS DO USUÁRIO

	if($VALOR > 0) {
		//DESCREVE A OBSERVAÇÃO
		//$OBS = "Parcelamento da(s) guia(s) nº ".implode(", ", $PARCELAMENTO_GUIAS);
		
		//CRIA UMA NOVA FATURA COM O PAGAMENTO
		//$DEPENDENTES = listar("dependentes", "id_associado='".$ASSOCIADO."'");
		//$grava = gravar("mensalidades", "'', '".$ASSOCIADO."', ".count($DEPENDENTES)."', '', '', '$MES', '$ANO', '$HOJE', NULL, NULL, '', '".$DADOS_USUARIO->id."', '0'");
		//$grava = atualizar("guias", "data_pagamento='$HOJE', saldo='$VALOR'", "titular IN ($ASSOCIADO) AND status=18");
		$grava = gravar("guias", "NULL, '$ASSOCIADO', '0', '0', '-1', '', '-$VALOR', '1', '-$VALOR', '-$VALOR', '$HOJE', '$HOJE', NULL, '$HOJE', '$HOJE', '$HOJE', NULL, '$OBS', '$OPERADOR', '$STATUS'");
		
		$grava = true;
		if($grava) {
			$Json = array("resposta" => 1, "titulo" => "Desconto Realizado", "msg" => "Pagameto com sucesso", "ID" => $id);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
		}
	} else {
		$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Valor invalido", "obs" =>$grava );
	}
}

echo json_encode($Json);