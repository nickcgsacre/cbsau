<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	//ADICIONA ESTABELECIMENTO
	if($_POST['acao'] == 'novo') {
		$id = addslashes($_POST['id']);
		$parentesco = mb_convert_case(addslashes($_POST['parentesco']), MB_CASE_UPPER, 'UTF-8');
		$limite = $_POST['limite'];
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($parentesco == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o parentesco." );
		} else if(contarQueryes("parentesco", "parentesco='$parentesco'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Esse parentesco já está cadastrado no sistema." );
		} else {
		
			$grava = gravar("parentesco", "NULL, '$parentesco', '$limite', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Parentesco cadastrado com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//EDITAR ESTABELECIMENTO
	if($_POST['acao'] == 'editar') {
		$id = addslashes($_POST['id']);
		$parentesco = mb_convert_case(addslashes($_POST['parentesco']), MB_CASE_UPPER, 'UTF-8');
		$limite = $_POST['limite'];
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($parentesco == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o parentesco" );
		} else if(contarQueryes("parentesco", "parentesco='$parentesco' and id_parentesco!='$id'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Esse parentesco já está cadastrado no sistema." );
		} else {
			
			$grava = atualizar("parentesco", "parentesco='$parentesco', limite='$limite'", "id_parentesco='$id'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "ATUALIZADO", "msg" => "Parentesco atualizado com sucesso!.", "ID" => $id);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//REMOVE O USUÁRIO
	else if($_POST['acao'] == 'remover') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("parentesco", "id_parentesco='$cod'") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	//REMOVE USUÁRIOS EM MASSA
	else if($_POST['acao'] == 'removerEmMassa') {
		$ids = $_POST['ids'];
		$tids = implode(",", $ids);
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("parentesco", "id_parentesco IN ($tids)") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);