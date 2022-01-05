<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	$DADOS = buscar("sessoes", "chave='".$_SESSION['user']."'");
	
	$limit = ($DADOS->validade - time("d/m/Y G:i:s")) / 60;
	
	$Json = array("resposta" => 1, "limite" => $limit);
	
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);