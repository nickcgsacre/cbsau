<?php

if(URL_SISTEMA AND $_SESSION['user']) {
	
	$B = buscar("estabelecimentos_boletos", "id='".$_GET['id']."'");
	$E = buscar("estabelecimentos", "id='".$B->estabelecimento."'");
	
	if(strlen($E->cnpj) == 14) {
		$Tipodoc = 1;
		$Documento = preg_replace("/[^0-9]/", "", $E->cnpj);
	} else if(strlen($E->cnpj) == 18) {
		$Tipodoc = 2;
		$Documento = preg_replace("/[^0-9]/", "", $E->cnpj);
	} else {
		$Tipodoc = 4;
		$Documento = preg_replace("/[^0-9]/", "", $grava);
	}

	include(__DIR__."/funcoes.php"); 
	include(__DIR__."/layout.php");
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
	echo json_encode($Json);
}
