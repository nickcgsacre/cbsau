<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	//ADICIONA ESTABELECIMENTO
	if($_POST['acao'] == 'novo') {
		$id = addslashes($_POST['id']);
		$nome = mb_convert_case(addslashes($_POST['nome']), MB_CASE_UPPER, 'UTF-8');
		$mensalidade = implode(".", explode(",", implode("", explode(".", $_POST['mensalidade']))));
		$desconto = implode(".", explode(",", implode("", explode(".", $_POST['desconto']))));
		$cobrado = $desconto;
		$desconto = 100 - $desconto;
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($nome == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o nome do plano." );
		} else if(contarQueryes("planos", "nome='$nome'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Já existe um plano com essa mesmo nome." );
		} else {
		
			$grava = gravar("planos", "NULL, '$nome', '$mensalidade', '$desconto', '$cobrado', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Plano cadastrado com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//EDITAR ESTABELECIMENTO
	if($_POST['acao'] == 'editar') {
		$id = addslashes($_POST['id']);
		$nome = mb_convert_case(addslashes($_POST['nome']), MB_CASE_UPPER, 'UTF-8');
		$mensalidade = implode(".", explode(",", implode("", explode(".", $_POST['mensalidade']))));
		$desconto = implode(".", explode(",", implode("", explode(".", $_POST['desconto']))));
		$cobrado = $desconto;
		$desconto = 100 - $desconto;
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($nome == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o nome do plano." );
		} else if(contarQueryes("planos", "nome='$nome' and id!='$id'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Já existe um plano com essa mesmo nome." );
		} else {
			
			$grava = atualizar("planos", "nome='$nome', mensalidade='$mensalidade', desconto='$desconto', cobrado='$cobrado'", "id_plano='$id'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "ATUALIZADO", "msg" => "Plano atualizado com sucesso!.", "ID" => $id);
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
		} else if( excluir("planos", "id_plano='$cod'") ){
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
		} else if( excluir("planos", "id_plano IN ($tids)") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);