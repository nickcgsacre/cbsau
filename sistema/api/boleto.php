<?php 
if(URL_SISTEMA AND $_SESSION['user']) {
	if($_POST['acao'] == 'gerarboleto') {
		$estabelecimento = $_POST['cod'];
		$vencimento = $_POST['vencimento'];
		$vencimento = str_replace("/", "-", $vencimento);
		$vencimento = date('Y-m-d', strtotime($vencimento));
		$valor = $_POST['valor'];
		$juros = $_POST['juros'];
		$multa = $_POST['multa'];
		$descricao = $_POST['inst1']."<br/>";
		$descricao .= $_POST['inst2']."<br/>";
		$descricao .= $_POST['inst3'];
		$agora = date('Y-m-d H:i:s');
		
		if(!$vencimento) {
			$Json = array("resposta" => 2, "titulo" => "Oops!", "msg" => "Você precisa informar a data de vencimento do documento");
		} else if(!$valor) {
			$Json = array("resposta" => 2, "titulo" => "Oops!", "msg" => "Você precisa informar o valor do documento");
		} else {
			$grava = gravar("estabelecimentos_boletos", "'', '$estabelecimento', '$descricao', '$vencimento', '$valor', '$desconto', '$juros', '$multa', '$acrescimos', '', '', '$agora', '1', '1'");
			
			if($grava) {
				
				$BOLETO = array("COD" => str_pad($grava, 12, 0, STR_PAD_LEFT),
								"DATA" => date("d/m/Y", strtotime($agora)),
								"VALOR" => number_format($valor,2,",","."),
								"JUROS" => number_format($juros,2,",","."),
								"MULTA" => number_format($multa,2,",","."),
								"STATUS" => '<span class="badge badge-default badge-info badge-lg">NÃO PAGA</span>',
								"VENCIMENTO" => date("d/m/Y", strtotime($vencimento)),
								"PAGAMENTO" => '--',
								"ID" => $grava,
								);
				
				$Json = array("resposta" => 1, "ID" => $grava, "BOLETO" => $BOLETO);
			} else {
				$Json = array("resposta" => 2, "titulo" => "Oops!", "msg" => "Deu erro aqui parçak kkk");
			}
		}
		
	} else 
		
	if($_POST['acao'] == 'alteraStatus') {
		$ID = $_POST['fatura'];
		$STATUS = $_POST['situacao'];
		$HOJE = date('Y-m-d');
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;
		
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 0);
		} else {
			$atualiza = atualizar('estabelecimentos_boletos', "status='$STATUS', pagamento='$HOJE'", 'id="'.$ID.'"');
			
			if($atualiza) {
				$DADOS = buscar("estabelecimentos_boletos", "id='".$ID."'");
				
				if($DADOS->status == 0) {
					$STATUS = '<span class="badge badge-default badge-warning badge-lg">CANCELADA</span>';
					$PAGAMENTO = '--';
				} else if($DADOS->status == 1) {
					$STATUS = '<span class="badge badge-default badge-info badge-lg">NÃO PAGA</span>';
					$PAGAMENTO = '--';
				} else {
					$STATUS = '<span class="badge badge-default badge-success badge-lg">PAGA</span>';
					$PAGAMENTO = date("d/m/Y", strtotime($HOJE));
				}
				
				$BOLETO = array("COD" => str_pad($DADOS->id, 12, 0, STR_PAD_LEFT),
								"DATA" => date("d/m/Y", strtotime($DADOS->criacao)),
								"VALOR" => number_format($DADOS->valor,2,",","."),
								"JUROS" => number_format($DADOS->juros,2,",","."),
								"MULTA" => number_format($DADOS->multa,2,",","."),
								"STATUS" => $STATUS,
								"VENCIMENTO" => date("d/m/Y", strtotime($DADOS->vencimento)),
								"PAGAMENTO" => $PAGAMENTO,
								"ID" => $DADOS->id,
								);
				
				$Json = array("resposta" => 1, "BOLETO" => $BOLETO);
			} else {
				$Json = array("resposta" => 2, "titulo" => "Oops!", "msg" => "Deu erro aqui parçak kkk");
			}
		}
	} else 
		
	if ($_POST['acao'] == 'verificarPagamento') {
		$ID = $_POST['fatura'];
		$HOJE = date('Y-m-d');
		$DADOS = buscar("estabelecimentos_boletos", "id='".$ID."'");
		$PAGO = false;
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;
		
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 0);
		} else {
		
		
			$clientSoap = new SoapClient("http://sefaznet.ac.gov.br:8080/sefazonline/servlet/aarrecadacaofluxo?wsdl");
			$params = array( 
						'Bbdtapag'  =>  $HOJE,
						'Cnpjrbtim'  =>  '27.531.200/0001-27'
						);
			$result = $clientSoap->execute( $params );
			
			$result = (array)$result->Recebimento;
			$itens = $result['Recebimento.RecebimentoItem'];

			foreach($itens as $item) {
				if($DADOS->codigo_barras == $item->BbCdgBar) {
					$PAGO = true;
					break;
				}
			}
			
			if($PAGO) {
				$atualiza = atualizar('estabelecimentos_boletos', "status='2', pagamento='$HOJE'", 'id="'.$ID.'"');
				
				$BOLETO = array("COD" => str_pad($DADOS->id, 12, 0, STR_PAD_LEFT),
								"DATA" => date("d/m/Y", strtotime($DADOS->criacao)),
								"VALOR" => number_format($DADOS->valor,2,",","."),
								"JUROS" => number_format($DADOS->juros,2,",","."),
								"MULTA" => number_format($DADOS->multa,2,",","."),
								"STATUS" => '<span class="badge badge-default badge-success badge-lg">PAGA</span>',
								"VENCIMENTO" => date("d/m/Y", strtotime($DADOS->vencimento)),
								"PAGAMENTO" => $HOJE,
								"ID" => $DADOS->id,
								);
				$Json = array("resposta" => 1, "BOLETO" => $BOLETO);
			} else {
				$Json = array("resposta" => 2, "titulo" => "NÃO PAGO!", "msg" => "O pagamento ainda não foi confirmado pela instituição financeira");
			}
		}
	} else 
	
	if ($_POST['acao'] == 'removerBoleto') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("estabelecimentos_boletos", "id='$cod'") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);