<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	//ADICIONA ESTABELECIMENTO
	if($_POST['acao'] == 'novo') {
		$id = addslashes($_POST['id']);
		$cargo = mb_convert_case(addslashes($_POST['cargo']), MB_CASE_UPPER, 'UTF-8');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($cargo == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o cargo." );
		} else if(contarQueryes("cargos", "cargo LIKE '%$cargo%'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Já existe um cargo idêntico a essa." );
		} else {
		
			$grava = gravar("cargos", "'', '$cargo', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Cargo cadastrado com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//EDITAR ESTABELECIMENTO
	if($_POST['acao'] == 'editar') {
		$id = addslashes($_POST['id']);
		$cargo = mb_convert_case(addslashes($_POST['cargo']), MB_CASE_UPPER, 'UTF-8');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($cargo == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o cargo." );
		} else if(contarQueryes("cargos", "cargo LIKE '%$cargo%' and id!='$id'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Já existe um cargo idêntico a essa." );
		} else {
			
			$grava = atualizar("cargos", "cargo='$cargo'", "id='$id'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "ATUALIZADO", "msg" => "Cargo atualizado com sucesso!.", "ID" => $id);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//LISTAR
	else if($ROTA[2] == 'listar') {
		
		$listar =  listar("cargo", "", "cargo ASC");
		
		foreach($listar as $item) {
			$Json[] = array($item->nome, $item->cargo, $item->telefone, $item->celular, $item->email, $item->login);
		}
		
	}
	//REMOVE O USUÁRIO
	else if($_POST['acao'] == 'remover') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("cargos", "id='$cod'") ){
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
		} else if( excluir("cargos", "id IN ($tids)") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);