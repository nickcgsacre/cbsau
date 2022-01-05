<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	if($_POST['acao'] == 'estabelecimentos') {
		
		$ESTABELECIMENTOS = listar("estabelecimentos", "status=1");
		$Json = array("ESTABELECIMENTOS" => $ESTABELECIMENTOS);
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);