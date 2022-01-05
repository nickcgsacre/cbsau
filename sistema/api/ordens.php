<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	//ADICIONA ESTABELECIMENTO
	if($_POST['acao'] == 'novo') {
		$id = addslashes($_POST['id']);
		$titular = mb_convert_case(addslashes($_POST['titular']), MB_CASE_UPPER, 'UTF-8');
		$associado = mb_convert_case(addslashes($_POST['tipo']), MB_CASE_UPPER, 'UTF-8');
		$dependente = $_POST['dependente'];
		$fornecedor = mb_convert_case(addslashes($_POST['fornecedor']), MB_CASE_UPPER, 'UTF-8');
		$servicos = $_POST['servicos'];
		$data_emissao = date('Y-m-d');
		$TOTAL = 0;
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if($titular == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar o titular." );
		} else if($associado == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa informar se o atendimento será para o titular ou dependente." );
		} else if($fornecedor == '') {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa selecionar o fornecedor." );
		} else if(count($servicos) == 0) {
			$Json = array("resposta" => 2, "titulo" => "INVÁLIDO", "msg" => "Você precisa selecionar pelo menos 1 serviço." );
		} else {
			
			if($associado == 1) {
				$DADOS_TITULAR = buscar("dependentes", "id_dependente='$dependente'");
				$DADOS_PLANO = buscar("planos", "id_plano='".$DADOS_TITULAR->plano."'");
			} else {
				$DADOS_TITULAR = buscar("associados", "id_associado='$titular'");
				$DADOS_PLANO = buscar("planos", "id_plano='".$DADOS_TITULAR->plano."'");
			}
			
			foreach($servicos as $servico) {
				$valor = implode("", explode("R$ ", $servico['valor']));
				$valor = implode(".", explode(",", implode("", explode(".", $valor))));
				$pagar = $valor - (($valor * $DADOS_PLANO->desconto) / 100);
				$TOTAL += $valor;
				
				$L_SERVICOS[] = array('data' => $servico['data'], 'descricao' => $servico['descricao'], 'valor' => $valor, 'pagar' => $pagar, 'desconto' => $DADOS_PLANO->desconto);
			}
			
			$SERVICOS = json_encode($L_SERVICOS);
			$PAGAR = number_format($TOTAL - (($TOTAL * $DADOS_PLANO->desconto) / 100), 2, ".", "");
		
			if($id > 0) {
				$grava = atualizar("ordens", "titular='$titular', associado='$associado', dependente='$dependente', fornecedor='$fornecedor', servicos='$SERVICOS', valor='$TOTAL', pagar='$PAGAR'", "id_ordem='$id'");
				$msg = "Ficha atualizada com sucesso!.";
				if($grava) {
					$grava = $id;
				}
			} else {
				$grava = gravar("ordens", "NULL, '$titular', '$associado', '$dependente', '$fornecedor', '$SERVICOS', '$TOTAL', '$PAGAR', '$data_emissao', NULL, NULL, NULL, NULL, NULL, '', '$operador', '$status'");
				$msg = "Ficha gerada com sucesso!.";
			}
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "SUCESSO", "msg" => $msg, "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		} 
	}
	//EDITAR ESTABELECIMENTO
	if($_POST['acao'] == 'editar') {
		$id = addslashes($_POST['id']);
		$data = date('Y-m-d');
		$status = $_POST['status'];
		
		if($status == '7') {
			$data_consulta = $_POST['data'];
			$grava = atualizar("ordens", "data_retorno='$data', data_atendimento='$data_consulta', status='$status'", "id_ordem='$id'");
			$retorno['titulo'] = 'ATENDIDO';
			$retorno['msg'] = 'Ficha marcada como atendida!';
		} else if($status == '8') {
			$grava = atualizar("ordens", "data_cobranca='$data', status='$status'", "id_ordem='$id'");
			$retorno['titulo'] = 'AGUARDANDO PAGAMENTO';
			$retorno['msg'] = 'Ficha marcada como faturado!';
		}  else if($status == '9') {
			$grava = atualizar("ordens", "data_pagamento='$data', status='$status'", "id_ordem='$id'");
			$retorno['titulo'] = 'PAGO';
			$retorno['msg'] = 'Ficha marcada como paga!';
		} else {
			$grava = atualizar("ordens", "status='$status'", "id_ordem='$id'");
			$retorno['titulo'] = 'CANCELADA';
			$retorno['msg'] = 'Ficha marcada como cancelada!';
		} 
		
		
		if($grava) {
			$Json = array("resposta" => 1, "titulo" => $retorno['titulo'], "msg" => $retorno['msg'], "ID" => $id);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
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
	//BUSCAR TITULAR
	else if($_POST['acao'] == 'buscarTitular') {
		$id = $_POST['id'];
		
		$DADOS = buscar("associados", "id_associado='$id'");
		$PLANO = buscar("planos", "id_plano='".$DADOS->plano."'");
		
		$DADOS->nascimento = strftime("%d/%m/%Y", strtotime( $DADOS->nascimento ));
		
		$Json = array("dados" => $DADOS, "plano" => $PLANO);
	}
	//BUSCAR DEPENDENTE
	else if($_POST['acao'] == 'buscarDependente') {
		$id = $_POST['id'];
		
		$DADOS = buscar("dependentes", "id_dependente='$id'");
		
		$DADOS->nascimento = strftime("%d/%m/%Y", strtotime( $DADOS->nascimento ));
		
		$Json = array("dados" => $DADOS);
	}
	//BUSCAR FORNECEDOR
	else if($_POST['acao'] == 'buscarFornecedor') {
		$id = $_POST['id'];
		
		$DADOS = buscar("fornecedores", "cod_fornecedor='$id'");
		
		$Json = array("dados" => $DADOS);
	}
	//BUSCAR DEPENDENTES
	else if($_POST['acao'] == 'buscarDependentes') {
		$id = $_POST['id'];
		
		$LISTAR = listar("dependentes", "id_associado='$id' AND status='1'", "nome ASC");
		
		$Json = array("dados" => $LISTAR);
	}
	//BUSCAR SERVIÇOS
	else if($_POST['acao'] == 'buscarServicos') {
		$id = $_POST['id'];
		
		$LISTAR = listar("fornecedores_servicos as fs LEFT JOIN servicos as s ON s.id_servico=fs.codigo_servico", "fs.fornecedor='$id' AND fs.status='1' AND s.status", "s.servico ASC");
		
		for($i = 0; $i < count($LISTAR); $i++) {
			$LISTAR[$i]->valor = number_format($LISTAR[$i]->valor, 2, ",", ".");
		}
		
		$Json = array("dados" => $LISTAR);
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);