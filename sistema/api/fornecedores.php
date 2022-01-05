<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	//ADICIONA FORNECEDOR
	if($_POST['acao'] == 'novo') {
		$id = strip_tags($_POST['id']);
		$cod = strip_tags($_POST['cod']);
		$tipo = strip_tags($_POST['tipo']);
		$nome_fantasia = strip_tags($_POST['nome_fantasia']);
		$razao_social = strip_tags($_POST['razao_social']);
		$cpf = strip_tags($_POST['cpf']);
		$rg = strip_tags($_POST['rg']);
		$expedidor = strip_tags($_POST['expedidor']);
		$especialidade = strip_tags($_POST['especialidade']);
		$observacoes = strip_tags($_POST['observacoes']);
		$email = strip_tags($_POST['email']);
		$telefone = strip_tags($_POST['telefone']);
		$celular = strip_tags($_POST['celular']);
		$fax = strip_tags($_POST['fax']);
		$admissao = implode("-", array_reverse(explode("/", $_POST['admissao'])));
		$endereco = strip_tags($_POST['endereco']);
		$numero = strip_tags($_POST['numero']);
		$bairro = strip_tags($_POST['bairro']);
		$cidade = strip_tags($_POST['cidade']);
		$estado = strip_tags($_POST['uf']);
		$cep = strip_tags($_POST['cep']);
		$conta_banco = strip_tags($_POST['conta_banco']);
		$conta_tipo = strip_tags($_POST['conta_tipo']);
		$conta_agencia = strip_tags($_POST['conta_agencia']);
		$conta_conta = strip_tags($_POST['conta_conta']);
		$conta_variacao = strip_tags($_POST['conta_variacao']);
		$data_cadastro = date('Y-m-d H:i:s');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if( (contarQueryes("fornecedores", "cpf='$cpf'") >= 1 and $cpf != '') or (contarQueryes("fornecedores", "co='$cod'") >= 1 and $cod != '')) {
			$Json = array("resposta" => 2, "titulo" => "Fornecedor já cadastrado", "msg" => "Esse fornecedor já está cadastrado no sistema." );
		} else {
		
			$grava = gravar("fornecedores", "'', '$cod', '$tipo', '$razao_social', '$nome_fantasia', '$cpf', '$rg', '$expedidor', '$email', '$telefone', '$celular', '$fax', '$endereco', '$numero', '$bairro', '$cidade', '$estado', '$cep', '$especialidade', '$observacoes', '$conta_banco', '$conta_tipo', '$conta_agencia', '$conta_conta', '$conta_variacao', '$logomarca', '$data_cadastro', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Fornecedor cadastrado com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//EDITAR FORNECEDOR
	if($_POST['acao'] == 'editar') {
		$id = strip_tags($_POST['id']);
		$cod = strip_tags($_POST['cod']);
		$tipo = strip_tags($_POST['tipo']);
		$nome_fantasia = strip_tags($_POST['nome_fantasia']);
		$razao_social = strip_tags($_POST['razao_social']);
		$cpf = strip_tags($_POST['cpf']);
		$rg = strip_tags($_POST['rg']);
		$expedidor = strip_tags($_POST['expedidor']);
		$especialidade = strip_tags($_POST['especialidade']);
		$observacoes = strip_tags($_POST['observacoes']);
		$email = strip_tags($_POST['email']);
		$telefone = strip_tags($_POST['telefone']);
		$celular = strip_tags($_POST['celular']);
		$fax = strip_tags($_POST['fax']);
		$admissao = implode("-", array_reverse(explode("/", $_POST['admissao'])));
		$endereco = strip_tags($_POST['endereco']);
		$numero = strip_tags($_POST['numero']);
		$bairro = strip_tags($_POST['bairro']);
		$cidade = strip_tags($_POST['cidade']);
		$estado = strip_tags($_POST['uf']);
		$cep = strip_tags($_POST['cep']);
		$conta_banco = strip_tags($_POST['conta_banco']);
		$conta_tipo = strip_tags($_POST['conta_tipo']);
		$conta_agencia = strip_tags($_POST['conta_agencia']);
		$conta_conta = strip_tags($_POST['conta_conta']);
		$conta_variacao = strip_tags($_POST['conta_variacao']);
		$data_cadastro = date('Y-m-d H:i:s');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if( (contarQueryes("fornecedores", "cpf='$cpf' and cod_fornecedor!='$id'") >= 1 and $cpf != '') or (contarQueryes("fornecedores", "cod='$cod' and cod_fornecedor!='$id'") >= 1 and $cod != '') ) {
			$Json = array("resposta" => 2, "titulo" => "Fornecedor já cadastrado", "msg" => "Esse fornecedor já está cadastrado no sistema." );
		} else {
			
			$grava = atualizar("fornecedores", "cod='$cod', tipo='$tipo', nome_fantasia='$nome_fantasia', razao_social='$razao_social', cpf='$cpf', rg='$rg', expedidor='$expedidor', especialidade='$especialidade', email='$email', telefone='$telefone', celular='$celular', fax='$fax', endereco='$endereco', numero='$numero', bairro='$bairro', cidade='$cidade', estado='$estado', cep='$cep', observacoes='$observacoes', conta_banco='$conta_banco', conta_tipo='$conta_tipo', conta_agencia='$conta_agencia', conta_conta='$conta_conta', conta_variacao='$conta_variacao', status='$status'", "cod_fornecedor='$id'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "ATUALIZADO", "msg" => "Fornecedor atualizado com sucesso!.", "ID" => $id);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//REMOVE O FORNECEDOR
	else if($_POST['acao'] == 'removerFornecedor') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;
	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("fornecedores", "cod_fornecedor='$cod'") ){
			excluir("fornecedores_servicos", "fornecedor='$cod'");
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	//REMOVE O FORNECEDOR EM MASSA
	else if($_POST['acao'] == 'removerFornecedorEmMassa') {
		$ids = $_POST['ids'];
		$tids = implode(",", $ids);
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("fornecedores", "cod_fornecedor IN ($tids)") ){
			excluir("fornecedores_servicos", "fornecedor IN ($tids)");
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	//SALVA DEPENDENTE
	else if($_POST['acao'] == 'addServico') {
		$id = $_POST['id'];
		$fornecedor = $_POST['fornecedor'];
		$cod_servico = addslashes($_POST['cod_servico']);
		$valor = implode(".", explode(",", implode("", explode(".",$_POST['valor']))));
		$observacoes = strip_tags($_POST['observacoes']);
		$data_cadastro = date('Y-m-d H:i:s');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if( contarQueryes("fornecedores_servicos", "codigo_servico='$cod_servico' AND fornecedor='$fornecedor'") >= 1 ) {
			$Json = array("resposta" => 2, "titulo" => "Duplicidade", "msg" => "Esse serviço já está cadastrado para esse fornecedor." );
		} else if( $fornecedor == ''  ) {
			$Json = array("resposta" => 2, "titulo" => "Erro interno", "msg" => "Tente salvar o fornecedor, depois tenta inserir o serviço" );
		} else if( $cod_servico == ''  ) {
			$Json = array("resposta" => 2, "titulo" => "ATENÇÃO", "msg" => "Selecione um serviço" );
		} else if( $valor == ''  ) {
			$Json = array("resposta" => 2, "titulo" => "ATENÇÃO", "msg" => "Você deve informar o valor do serviço" );
		} else {
		
			
			if($id){ 
				$grava = atualizar("fornecedores_servicos", "codigo_servico='$cod_servico', fornecedor='$fornecedor', valor='$valor', obs='$observacoes' ", "id_fs='$id'");
			} else {
				$grava = gravar("fornecedores_servicos", "'', '$cod_servico', '$fornecedor', '$valor', '$atendimento', '$observacoes', '$data_cadastro', '$status'");
				
				$_POST['id'] = $grava;
				$_POST['servico'] = buscar("servicos","id_servico='$cod_servico'")->servico;
			}
			
			if($grava) {
				if($id){
					$Json = array("resposta" => 1, "titulo" => "ATUALIZADO!", "msg" => "Serviço atualizado com sucesso!", "item" => $_POST );
				} else {
					$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Serviço inserido com sucesso!", "item" => $_POST );
				}
			} else {
				$Json = array("resposta" => 0, "titulo" => "ATENÇÃO", "msg" => "Ocorreu um erro interno. Tente novamente" );
			}
			
		}
	}
	//BUSCAR SERVIÇO
	else if($_POST['acao'] == 'buscarServico') {
		$id = $_POST['id'];
		
		$DADOS = buscar("fornecedores_servicos", "id_fs='$id'");
		
		$DADOS->valor = number_format($DADOS->valor, 2, ',', '.');
		
		$Json = array("dados" => $DADOS);
	}
	//REMOVE O SERVIÇO
	else if($_POST['acao'] == 'removerServico') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;
	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("fornecedores_servicos", "id_fs='$cod'") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	//LISTAR
	else if($ROTA[2] == 'listar') {
		
		$listar =  listar("fornecedores", "", "nome_fantasia ASC");
		
		foreach($listar as $item) {
			$Json[] = array($item->nome_fantasia, $item->cnpj, $item->telefone1, $item->celular1, $item->email, $item->cidade);
		}
		
	}
	
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);