<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	//ADICIONA ESTABELECIMENTO
	if($_POST['acao'] == 'novo') {
		$id = addslashes($_POST['id']);
		$tipo = addslashes($_POST['tipo']);
		$permissao = addslashes($_POST['permissao']);
		$cargo = addslashes($_POST['cargo']);
		$nome = addslashes($_POST['nome']);
		$email = addslashes($_POST['email']);
		$telefone = addslashes($_POST['telefone']);
		$celular = addslashes($_POST['celular']);
		$login = addslashes($_POST['login']);
		$senha = md5($_POST['senha']);
		$r_senha = md5($_POST['r_senha']);
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if(contarQueryes("usuarios", "login='$login'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Este login já está em uso por outro usuário." );
		} else if($cargo == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o cargo do usuário." );
		} else if($nome == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o nome do usuário." );
		} else if($login == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o login do usuário." );
		} else if($senha == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar a senha de acesso ao sistema." );
		} else if($senha != $r_senha) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "A confirmação da senha está diferente da senha digitada." );
		} else {
		
			$grava = gravar("usuarios", "'', '$tipo', '$permissao', '$cargo', '$nome', '$email', '$telefone', '$celular', '$login', '$senha', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Usuário cadastrado com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//EDITAR ESTABELECIMENTO
	if($_POST['acao'] == 'editar') {
		$id = addslashes($_POST['id']);
		$permissao = addslashes($_POST['permissao']);
		$cargo = addslashes($_POST['cargo']);
		$nome = addslashes($_POST['nome']);
		$email = addslashes($_POST['email']);
		$telefone = addslashes($_POST['telefone']);
		$celular = addslashes($_POST['celular']);
		$login = addslashes($_POST['login']);
		$senha = $_POST['senha'];
		$r_senha = $_POST['r_senha'];
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if(contarQueryes("usuarios", "login='$login' and id!='$id'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "CNPJ já cadastrado", "msg" => "Esse cnpj já está cadastrado no sistema." );
		} else if($cargo == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o cargo do usuário." );
		} else if($nome == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o nome do usuário." );
		} else if($login == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o login do usuário." );
		} else if($senha != $r_senha and $senha == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "A confirmação da senha está diferente da senha digitada." );
		} else {
			
			if($senha == '') {
				$senha = buscar("usuarios", "id='".$id."'")->senha;
			} else {
				$senha = md5($senha);
			}
			
			$grava = atualizar("usuarios", "permissao='$permissao', cargo='$cargo', nome='$nome', email='$email', telefone='$telefone', celular='$celular', login='$login', senha='$senha'", "id='$id'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "ATUALIZADO", "msg" => "Usuário atualizado com sucesso!.", "ID" => $id);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//LISTAR
	else if($ROTA[2] == 'listar') {
		
		$listar =  listar("usuarios", "", "nome ASC");
		
		foreach($listar as $item) {
			$Json[] = array($item->nome, $item->cargo, $item->telefone, $item->celular, $item->email, $item->login);
		}
		
	}
	//REMOVE O USUÁRIO
	else if($_POST['acao'] == 'removerUsuario') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("usuarios", "id='$cod'") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	//REMOVE USUÁRIOS EM MASSA
	else if($_POST['acao'] == 'removerUsuariosEmMassa') {
		$ids = $_POST['ids'];
		$tids = implode(",", $ids);
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("usuarios", "id IN ($tids)") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);