<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	//ADICIONA ESTABELECIMENTO
	if($_POST['acao'] == 'novo') {
		$id = addslashes($_POST['id']);
		$cod = addslashes($_POST['cod']);
		$atividade = mb_convert_case(addslashes($_POST['atividade']), MB_CASE_UPPER, 'UTF-8');
		$upf = addslashes($_POST['upf']);
		$ciclo = addslashes($_POST['ciclo']);
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if(contarQueryes("atividades", "cod='$cod'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Este código já está em uso em outra atividade." );
		} else if($cod == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o código da atividade." );
		} else if($atividade == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar a atividade." );
		} else if($upf == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar a taxa de UPF da atividade." );
		} else if($ciclo == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o ciclo de pagamento da atividade." );
		} else if(contarQueryes("atividades", "atividade LIKE '%$atividade%'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Já existe uma atividade idêntica a essa." );
		} else {
		
			$grava = gravar("atividades", "'', '$cod', '$atividade', '$upf', '$ciclo', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Atividade cadastrada com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//EDITAR ESTABELECIMENTO
	if($_POST['acao'] == 'editar') {
		$id = addslashes($_POST['id']);
		$cod = addslashes($_POST['cod']);
		$atividade = mb_convert_case(addslashes($_POST['atividade']), MB_CASE_UPPER, 'UTF-8');
		$upf = addslashes($_POST['upf']);
		$ciclo = addslashes($_POST['ciclo']);
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if(contarQueryes("atividades", "cod='$cod' and id!='$id'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "CNPJ já cadastrado", "msg" => "Esse cnpj já está cadastrado no sistema." );
		} else if($cod == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o código da atividade." );
		} else if($atividade == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar a atividade." );
		} else if($upf == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar a taxa de UPF da atividade." );
		} else if($ciclo == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o ciclo de pagamento da atividade." );
		} else if(contarQueryes("atividades", "atividade LIKE '%$atividade%' and id!='$id'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Já existe uma atividade idêntica a essa." );
		} else {
			
			$grava = atualizar("atividades", "cod='$cod', atividade='$atividade', upf='$upf', ciclo='$ciclo'", "id='$id'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "ATUALIZADO", "msg" => "Atividade atualizada com sucesso!.", "ID" => $id);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//LISTAR
	else if($ROTA[2] == 'listar') {
		
		$listar =  listar("atividades", "", "nome ASC");
		
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
		} else if( excluir("atividades", "id='$cod'") ){
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
		} else if( excluir("atividades", "id IN ($tids)") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);