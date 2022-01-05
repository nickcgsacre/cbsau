<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
		//ADICIONA ESTABELECIMENTO
	if($_POST['acao'] == 'novo') {
		$id = strip_tags($_POST['id']);
		$matricula = strip_tags($_POST['matricula']);
		$nome = strip_tags($_POST['nome']);
		$nascimento = implode("-", array_reverse(explode("/", $_POST['nascimento'])));
		$tipo_sanguineo = strip_tags($_POST['tipo_sanguineo']);
		$situacao = strip_tags($_POST['situacao']);
		$matricula_sold = strip_tags($_POST['matricula_sold']);
		$graduacao = strip_tags($_POST['graduacao']);
		$unidade = strip_tags($_POST['unidade']);
		$fator_rh = strip_tags($_POST['fator_rh']);
		$naturalidade = strip_tags($_POST['naturalidade']);
		$nacionalidade = strip_tags($_POST['nacionalidade']);
		$cpf = strip_tags($_POST['cpf']);
		$rg = strip_tags($_POST['rg'])."/".strip_tags($_POST['expedidor']);
		$sexo = strip_tags($_POST['sexo']);
		$estado_civil = strip_tags($_POST['estado_civil']);
		$email = strip_tags($_POST['email']);
		$telefone = strip_tags($_POST['telefone1']);
		$celular = strip_tags($_POST['celular1']);
		$admissao = implode("-", array_reverse(explode("/", $_POST['admissao'])));
		$endereco = strip_tags($_POST['endereco']);
		$numero = strip_tags($_POST['numero']);
		$bairro = strip_tags($_POST['bairro']);
		$cidade = strip_tags($_POST['cidade']);
		$estado = strip_tags($_POST['uf']);
		$cep = strip_tags($_POST['cep']);
		$plano = strip_tags($_POST['plano']);
		$observacoes = strip_tags($_POST['observacoes']);
		$data_cadastro = date('Y-m-d H:i:s');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if( (contarQueryes("associados", "cpf='$cpf'") >= 1 and $cpf != '') or (contarQueryes("associados", "matricula='$matricula'") >= 1 and $matricula != '')) {
			$Json = array("resposta" => 2, "titulo" => "Associado já cadastrado", "msg" => "Esse associado já está cadastrado no sistema." );
		} else if($plano == '') {
			$Json = array("resposta" => 2, "titulo" => "Atenção", "msg" => "Você deve selecionar um plano." );
		} else {
		
			$grava = gravar("associados", "'', '$matricula', '$nome', '$nascimento', '$tipo_sanguineo', '$fator_rh', '$naturalidade', '$nacionalidade', '$cpf', '$rg', '$sexo', '$situacao', '$matricula_sold', '$graduacao', '$unidade', '$estado_civil', '$email', '$telefone', '$celular', '$admissao', '$endereco', '$numero', '$bairro', '$cidade', '$estado', '$cep', '$plano', '$observacoes', '$foto', '$data_cadastro', NULL, '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Associado cadastrado com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//EDITAR ASSOCIADO
	if($_POST['acao'] == 'editar') {
		$id = strip_tags($_POST['id']);
		$matricula = strip_tags($_POST['matricula']);
		$nome = strip_tags($_POST['nome']);
		$nascimento = implode("-", array_reverse(explode("/", $_POST['nascimento'])));
		$tipo_sanguineo = strip_tags($_POST['tipo_sanguineo']);
		$fator_rh = strip_tags($_POST['fator_rh']);
		$naturalidade = strip_tags($_POST['naturalidade']);
		$nacionalidade = strip_tags($_POST['nacionalidade']);
		$cpf = strip_tags($_POST['cpf']);
		$rg = strip_tags($_POST['rg'])."/".strip_tags($_POST['expedidor']);
		$sexo = strip_tags($_POST['sexo']);
		$situacao = strip_tags($_POST['situacao']);
		$matricula_sold = strip_tags($_POST['matricula_sold']);
		$graduacao = strip_tags($_POST['graduacao']);
		$unidade = strip_tags($_POST['unidade']);
		$estado_civil = strip_tags($_POST['estado_civil']);
		$email = strip_tags($_POST['email']);
		$telefone = strip_tags($_POST['telefone1']);
		$celular = strip_tags($_POST['celular1']);
		$admissao = implode("-", array_reverse(explode("/", $_POST['admissao'])));
		$endereco = strip_tags($_POST['endereco']);
		$numero = strip_tags($_POST['numero']);
		$bairro = strip_tags($_POST['bairro']);
		$cidade = strip_tags($_POST['cidade']);
		$estado = strip_tags($_POST['uf']);
		$cep = strip_tags($_POST['cep']);
		$plano = strip_tags($_POST['plano']);
		$observacoes = strip_tags($_POST['observacoes']);
		$data_cadastro = date('Y-m-d H:i:s');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if( (contarQueryes("associados", "cpf='$cpf' and id!='$id'") >= 1 and $cpf != '') or (contarQueryes("associados", "matricula='$matricula' and id!='$id'") >= 1 and $matricula != '') ) {
			$Json = array("resposta" => 2, "titulo" => "Associado já cadastrado", "msg" => "Esse associado já está cadastrado no sistema." );
		} else if($plano == '') {
			$Json = array("resposta" => 2, "titulo" => "Atenção", "msg" => "Você deve selecionar um plano." );
		} else {
			
			$grava = atualizar("associados", "matricula='$matricula', nome='$nome', nascimento='$nascimento', tipo_sanguineo='$tipo_sanguineo', fator_rh='$fator_rh', naturalidade='$naturalidade', nacionalidade='$nacionalidade', cpf='$cpf', rg='$rg', sexo='$sexo', situacao='$situacao', matricula_sold='$matricula_sold', graduacao='$graduacao', unidade='$unidade', estado_civil='$estado_civil', email='$email', telefone='$telefone', celular='$celular', admissao='$admissao', endereco='$endereco', numero='$numero', bairro='$bairro', cidade='$cidade', estado='$estado', cep='$cep', plano='$plano', observacoes='$observacoes', status='$status'", "id_associado='$id'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "ATUALIZADO", "msg" => "Associado atualizado com sucesso!.", "ID" => $id);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//SALVA DEPENDENTE
	else if($_POST['acao'] == 'addDependente') {
		$id = $_POST['id'];
		$associado = $_POST['associado'];
		$nome = addslashes($_POST['nome']);
		$sexo = addslashes($_POST['sexo']);
		$nascimento = implode("-", array_reverse(explode("/", $_POST['nascimento'])));
		$fator_rh = addslashes($_POST['fator_rh']);
		$tipo_sanguineo = addslashes($_POST['tipo_sanguineo']);
		$mae = addslashes($_POST['mae']);
		$pai = addslashes($_POST['pai']);
		$naturalidade = addslashes($_POST['naturalidade']);
		$nacionalidade = addslashes($_POST['nacionalidade']);
		$cpf = addslashes($_POST['cpf']);
		$rg = addslashes($_POST['rg']);
		$profissao = addslashes($_POST['profissao']);
		$local_trabalho = addslashes($_POST['local_trabalho']);
		$parentesco = addslashes($_POST['parentesco']);
		$plano = addslashes($_POST['plano']);
		$observacoes = addslashes($_POST['observacoes']);
		$data_cadastro = date('Y-m-d H:i:s');
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if( contarQueryes("dependentes", "cpf='$cpf'") >= 1 and $cpf != '' and $id != ''  ) {
			$Json = array("resposta" => 2, "titulo" => "Dependente já cadastrado", "msg" => "Esse dependente já está cadastrado no sistema." );
		} else if( $sexo == ''  ) {
			$Json = array("resposta" => 2, "titulo" => "ATENÇÃO", "msg" => "Você deve informar o sexo do dependente" );
		} else if( $parentesco == ''  ) {
			$Json = array("resposta" => 2, "titulo" => "ATENÇÃO", "msg" => "Você deve informar o parentesco do dependente" );
		} else if( $nome == ''  ) {
			$Json = array("resposta" => 2, "titulo" => "ATENÇÃO", "msg" => "Você deve informar o nome do dependente" );
		}  else if( $nascimento == ''  ) {
			$Json = array("resposta" => 2, "titulo" => "ATENÇÃO", "msg" => "Você deve informar a data de nascimento do dependente" );
		} else {
		
			
			if($id){ 
				$grava = atualizar("dependentes", "id_associado='$associado', nome='$nome', nascimento='$nascimento', sexo='$sexo', fator_rh='$fator_rh', tipo_sanguineo='$tipo_sanguineo', mae='$mae', pai='$pai', naturalidade='$naturalidade', nacionalidade='$nacionalidade', cpf='$cpf', rg='$rg', profissao='$profissao', local_trabalho='$local_trabalho', parentesco='$parentesco', plano='$plano', observacoes='$observacoes', status='$status'", "id_dependente='$id'");
			} else {
				$grava = gravar("dependentes", "'', '$associado', '$nome', '$nascimento', '$sexo', '$fator_rh', '$tipo_sanguineo', '$mae', '$pai', '$naturalidade', '$nacionalidade', '$cpf', '$rg', '$profissao', '$local_trabalho', '$parentesco', '$plano', '$observacoes', '$data_cadastro', NULL, '$status'");
				
				$_POST['id'] = $grava;
				
			}
			
			$_POST['parentesco'] = buscar("parentesco", "id_parentesco='$parentesco'")->parentesco;
			
			if($grava) {
				if($id){
					$Json = array("resposta" => 1, "titulo" => "ATUALIZADO!", "msg" => "Dependente atualizado com sucesso!", "item" => $_POST );
				} else {
					$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Dependente inserido com sucesso!", "item" => $_POST );
				}
			} else {
				$Json = array("resposta" => 0, "titulo" => "ATENÇÃO", "msg" => "Ocorreu um erro interno. Tente novamente" );
			}
			
		}
	}
	//BUSCAR DEPENDENTE
	else if($_POST['acao'] == 'buscarDependente') {
		$id = $_POST['id'];
		
		$DADOS = buscar("dependentes", "id_dependente='$id'");
		
		$DADOS->nascimento = implode("/", array_reverse( explode("-", $DADOS->nascimento) ) );
		
		$Json = array("dados" => $DADOS);
	}
	//REMOVE O DEPENDENTE
	else if($_POST['acao'] == 'removerDependente') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( atualizar("dependentes", "status='0', data_cancelamento='".date('Y-m-d')."'", "id_dependente='$cod'") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	//LISTAR
	else if($ROTA[2] == 'listar') {
		
		$listar =  listar("associados", "", "nome ASC");
		
		foreach($listar as $item) {
			$Json[] = array($item->nome_fantasia, $item->cnpj, $item->telefone1, $item->celular1, $item->email, $item->cidade);
		}
		
	}
	//REMOVE O ASSOCIADO
	else if($_POST['acao'] == 'removerAssociado') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( atualizar("associados", "data_cancelamento='".date('Y-m-d')."', status='0'", "id_associado='$cod'") ){
			atualizar("dependentes", "data_cancelamento='".date('Y-m-d')."', status='0'", "id_associado IN ($cod)");
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}

	//REMOVE O ASSOCIADO EM MASSA
	else if($_POST['acao'] == 'removerAssociadosEmMassa') {
		$ids = $_POST['ids'];
		$tids = implode(",", $ids);
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;c

		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( atualizar("associados", "data_cancelamento='".date('Y-m-d')."', status='0'", "id_associado IN ($tids)") ){
			atualizar("dependentes", "data_cancelamento='".date('Y-m-d')."', status='0'", "id_associado IN ($tids)");
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}

	else if($_POST['acao'] == 'descontar') {
		$ASSOCIADO = $_POST['associado'];
		$PARCELAS = $_POST['parcelas'];
		$HOJE = date('Y-m-d');
		$Json = array("resposta" => 1);
	}

	else if($_POST['acao'] == 'parcelar') {
		$ASSOCIADO = $_POST['associado'];
		$PARCELAS = $_POST['parcelas'];
		$DESCONTO = $_POST['plano'];
		$HOJE = date('Y-m-d');
		$STATUS = 8;
		$OPERADOR = 0;
		
		//PERCORRE TODAS AS GUIAS DO USUÁRIO
		$GUIAS = listar("guias", "titular='$ASSOCIADO' AND status='8'");
		$PARCELAMENTO_PAGAR = 0.0;
		$PARCELAMENTO_VALOR = 0.0;
		$PARCELAMENTO_GUIAS = [];
		
		foreach($GUIAS as $dados) {
			if(atualizar("guias", "status='10', data_pagamento='$HOJE', saldo='0'", "id_guia='".$dados->id_guia."'")) {
				$PARCELAMENTO_GUIAS[] = $dados->id_guia;
				$PARCELAMENTO_PAGAR += number_format($dados->pagar,2);
				$PARCELAMENTO_VALOR += number_format($dados->valor,2);
			}
		}
		if($PARCELAMENTO_PAGAR > 0) {
			//DESCREVE A OBSERVAÇÃO
			$OBS = "Parcelamento da(s) guia(s) nº ".implode(", ", $PARCELAMENTO_GUIAS);
			
			//CRIA UMA NOVA FATURA COM O PARCELAMENTO
			$grava = gravar("guias", "NULL, '$ASSOCIADO', '$DESCONTO' , '0', '0', '-1', '', '$PARCELAMENTO_VALOR', '$PARCELAS', '$PARCELAMENTO_PAGAR', '$PARCELAMENTO_PAGAR', '$HOJE', '$HOJE', NULL, '$HOJE', NULL, NULL, NULL, '$OBS', '$OPERADOR', '$STATUS'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "PARCELADO", "msg" => "Guia parcelada com sucesso", "ID" => $id);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} else {
			$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Não existe nenhuma guia para parcelar", "obs" =>$grava );
		}
	} 
	
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);