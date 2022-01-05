<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	//ADICIONA ESTABELECIMENTO
	if($_POST['acao'] == 'novo') {
		$id = addslashes($_POST['id']);
		$cod = mb_convert_case(addslashes($_POST['cod']), MB_CASE_UPPER, 'UTF-8');
		$categoria = mb_convert_case(addslashes($_POST['categoria']), MB_CASE_UPPER, 'UTF-8');
		$servico = mb_convert_case(addslashes($_POST['servico']), MB_CASE_UPPER, 'UTF-8');
		$descricao = mb_convert_case(addslashes($_POST['descricao']), MB_CASE_UPPER, 'UTF-8');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($servico == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o nome do serviço." );
		} else if(contarQueryes("servicos", "servico='$servico'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Esse serviço já está cadastrado no sistema." );
		} else {
		
			$grava = gravar("servicos", "NULL, '$cod', '$categoria', '$servico', '$descricao', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Seriço cadastrado com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//EDITAR ESTABELECIMENTO
	if($_POST['acao'] == 'editar') {
		$id = addslashes($_POST['id']);
		$cod = mb_convert_case(addslashes($_POST['cod']), MB_CASE_UPPER, 'UTF-8');
		$categoria = mb_convert_case(addslashes($_POST['categoria']), MB_CASE_UPPER, 'UTF-8');
		$servico = mb_convert_case(addslashes($_POST['servico']), MB_CASE_UPPER, 'UTF-8');
		$descricao = mb_convert_case(addslashes($_POST['descricao']), MB_CASE_UPPER, 'UTF-8');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($servico == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o nome do serviço" );
		} else if(contarQueryes("servicos", "servico='$servico' and id_servico!='$id'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Esse serviço já está cadastrado no sistema." );
		} else {
			
			$grava = atualizar("servicos", "servico='$servico', id_cat='$categoria', descricao='$descricao'", "id_servico='$id'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "ATUALIZADO", "msg" => "Serviços atualizado com sucesso!.", "ID" => $id);
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
		} else if( excluir("servicos", "id_servico='$cod'") ){
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
		} else if( excluir("servicos", "id_servico IN ($tids)") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	else //ADICIONA ESTABELECIMENTO
	if($_POST['acao'] == 'novaCategoria') {
		$id = addslashes($_POST['id']);
		$categoria = mb_convert_case(addslashes($_POST['categoria']), MB_CASE_UPPER, 'UTF-8');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($categoria == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o nome da categoria." );
		} else if(contarQueryes("servicos_categorias", "categoria='$categoria'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Essa categoria já está cadastrado no sistema." );
		} else {
		
			$grava = gravar("servicos_categorias", "NULL, '$categoria', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADA", "msg" => "Categoria cadastrada com sucesso!.", "ID" => $grava, "CAT" => $categoria);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);