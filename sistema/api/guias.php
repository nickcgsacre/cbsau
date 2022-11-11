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
		$PARCELAS = 1;
		$TOTAL = 0;
		$status = 1;
		$plano = $_POST['plano'];

		
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
				$L = explode("-", $servico);
				$valor = implode(".", explode(",", implode("", explode(".", $L[1]))));
				$pagar = $valor - (($valor * $DADOS_PLANO->desconto) / 100);
				$TOTAL += $valor;
				
				$L_SERVICOS[] = array('id_servico' => $L[0], 'qtd' => 1, 'valor' => $valor, 'pagar'=> $pagar, 'desconto' => $DADOS_PLANO->desconto);
			}
			
			$SERVICOS = json_encode($L_SERVICOS);
			$PAGAR = number_format($TOTAL - (($TOTAL * $DADOS_PLANO->desconto) / 100), 2, ".", "");
		
			$grava = gravar("guias", "NULL, '$titular', '$plano', '$associado', '$dependente', '$fornecedor', '$SERVICOS', '$TOTAL', '$PARCELAS', '$PAGAR', '$PAGAR', '$data_emissao', NULL, NULL, NULL, NULL, NULL, NULL, '', '$operador', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "SUCESSO", "msg" => "Guia gerada com sucesso!.", "ID" => $grava);
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
			$grava = atualizar("guias", "data_retorno='$data', data_atendimento='$data_consulta', status='$status'", "id_guia='$id'");
			$retorno['titulo'] = 'ATENDIDO';
			$retorno['msg'] = 'Guia marcada como atendida!';
		} else if($status == '8') {
			$grava = atualizar("guias", "data_cobranca='$data', status='$status'", "id_guia='$id'");
			$retorno['titulo'] = 'AGUARDANDO PAGAMENTO';
			$retorno['msg'] = 'Guia marcada como aguardando pagamento!';
		}  else if($status == '9') {
			$data_pagamento = $_POST['data'];
			$VALOR_PAGO = number_format(implode(".", explode(",", implode("", explode('.', $_POST['valor'])))),2);
			$DADOS = buscar("guias", "id_guia='$id'");
			
			if($DADOS->parcelas > 1) {
				$PAGAMENTOS = json_decode($DADOS->pagamento_parcelas);
				$PAGAMENTOS[] = array("data" => $data_pagamento, "valor" => $VALOR_PAGO);
				
				/*$tt = 0;
				foreach($PAGAMENTOS as $PG) {
					$tt += $PG->valor;
				}*/
				
				$tt = $DADOS->saldo - $VALOR_PAGO;
				
				//if($tt >= ($DADOS->pagar/$DADOS->parcelas)) {
				if($tt <= 0) {
					$PAGAMENTOS = json_encode($PAGAMENTOS);
					$grava = atualizar("guias", "data_pagamento='$data_pagamento', pagamento_parcelas='$PAGAMENTOS', saldo='$tt', status='$status'", "id_guia='$id'");
					$retorno['titulo'] = 'PAGO';
					$retorno['msg'] = 'Guia marcada liquidada!';
				} else {
					$PAGAMENTOS = json_encode($PAGAMENTOS);
					$grava = atualizar("guias", "pagamento_parcelas='$PAGAMENTOS', saldo='$tt'", "id_guia='$id'");
					$retorno['titulo'] = 'PARCELA PAGA';
					$retorno['msg'] = 'Parcela da guia marcada como paga!';
				}
				
			} else {
				$grava = atualizar("guias", "data_pagamento='$data_pagamento', saldo='0', status='$status'", "id_guia='$id'");
				$retorno['titulo'] = 'PAGO';
				$retorno['msg'] = 'Guia marcada liquidada!';
			}
		} else {
			$grava = atualizar("guias", "status='$status'", "id_guia='$id'");
			$retorno['titulo'] = 'CANCELADA';
			$retorno['msg'] = 'Guia marcada como cancelada!';
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
	else if($_POST['acao'] == 'parcelar') {
		$id = $_POST['id'];
		$parcelas = $_POST['parcelas'];
		
		$grava = atualizar("guias", "parcelas='$parcelas'", "id_guia='$id'");
		
		if($grava) {
			$Json = array("resposta" => 1, "titulo" => "PARCELADO", "msg" => "Guia parcelada com sucesso", "ID" => $id);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
		}
	}
	else if($_POST['acao'] == 'informacoes') {
		$id = $_POST['id'];
		
		$DADOS = buscar("guias", "id_guia='$id'");
		
		
		$exibir = '<table class="table table-striped table-bordered sourced-data dataTable"><thead><tr><th scope="col">DATA</th><th scope="col">VALOR</th></tr></thead><tbody>';
		
		if($DADOS->parcelas > 1) {
			$PAGAMENTOS = json_decode($DADOS->pagamento_parcelas);
			foreach($PAGAMENTOS as $PG) {
				$exibir .= '<tr><td>'.date("d/m/Y", strtotime($PG->data)).'</td><td>R$ '.number_format($PG->valor, 2, ",", ".").'</td></tr>';
			}
			
			if(count($PAGAMENTOS) == 0) {
				$exibir .= '<tr><td colspan="2">NENHUM PAGAMENTO ATÉ O MOMENTO!</td></tr>';
			}
			
		} else {
			$exibir .= '<tr><td>'.date("d/m/Y", strtotime($DADOS->data_pagamento)).'</td><td>'.number_format($DADOS->pagar, 2, ",", ".").'</td></tr>';
			
			if(!$DADOS->data_pagamento) {
				$exibir .= '<tr><td colspan="2">NENHUM PAGAMENTO ATÉ O MOMENTO!</td></tr>';
			}
		}
		
		
		$exibir .= '</tbody></table>';
		
		$Json = $exibir;
		
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);

// function salvarMensalidade($associado, ) {
// 	$mensalidade = gravar("mensalidades", )
// }