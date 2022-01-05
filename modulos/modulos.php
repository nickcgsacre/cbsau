<?php

	//GERA UM NUMERO ALEATORIA
	function codigoAleatorio($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false, $minusculas = true) {
		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		$retorno = '';
		$caracteres = '';
		if ($minusculas) $caracteres .= $lmin;
		if ($maiusculas) $caracteres .= $lmai;
		if ($numeros) $caracteres .= $num;
		if ($simbolos) $caracteres .= $simb;
		$len = strlen($caracteres);
		for ($n = 1; $n <= $tamanho; $n++) {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand-1];
		}
		return $retorno;
	}
	
	//PEGA OS DADOS DA SESSÃO
	function dados_sessao($sessao) {
		global $conexao;		
		$stmt = $conexao->prepare("SELECT * FROM sessoes as s LEFT JOIN usuarios as u ON s.usuario=u.id WHERE s.chave='".$sessao."'");
		$stmt->execute();
		$resultado = $stmt->fetchAll(PDO::FETCH_OBJ)[0];
		
		return $resultado;
	}
	
	//LISTAR TABELA
	function listar($tabela, $query=null, $ordem='') {
		global $conexao;	
		
		if($ordem) {
			$ordem = " ORDER BY ".$ordem." ";
		}
		
		if($query) {
			$stmt = $conexao->prepare("SELECT * FROM ".$tabela." WHERE ".$query.$ordem." ");
			$stmt->execute();
		
		} else {
			$stmt = $conexao->prepare("SELECT * FROM ".$tabela.$ordem." ");
			$stmt->execute();
		}
		
		while($dados = $stmt->fetch(PDO::FETCH_OBJ)) {
			$itens[] = $dados;
		}
		
		return $itens;
	}
	
	//BUSCAR TABELA
	function buscar($tabela, $query=null) {
		global $conexao;
		
		if($query) {
			$stmt = $conexao->prepare("SELECT * FROM ".$tabela." WHERE ".$query." ");
			$stmt->execute();
		} else {
			$stmt = $conexao->prepare("SELECT * FROM ".$tabela." ");
			$stmt->execute();
		}
		
		$resultado = $stmt->fetchAll(PDO::FETCH_OBJ)[0];
		
		return $resultado;
	}
	
	//INSERIR DADOS
	function gravar($tabela, $dados) {
		global $conexao;
		
		$stmt = $conexao->prepare("INSERT INTO $tabela VALUES ($dados)");
		$stmt->execute();
		
		if($stmt) {
			return $conexao->lastInsertId();
		} else {
			return false;
		}
	}
	
	//ATUALIZAR DADOS
	function atualizar($tabela, $set, $where) {
		global $conexao;
		
		$stmt = $conexao->query("UPDATE $tabela SET $set WHERE $where");
		//$stmt->execute();
		
		if($stmt) {
			return true;
		} else {
			return false;
		}
	}
	
	//EXCLUÍR DADOS
	function excluir($tabela, $where) {
		global $conexao;
		
		$stmt = $conexao->prepare("DELETE FROM $tabela WHERE $where");
		$stmt->execute();
		
		if($stmt) {
			return true;
		} else {
			return false;
		}
	}
	
	//CONTAR QUERYES
	function contarQueryes($tabela, $query = null) {
		global $conexao;
		
		if($query) {
			$query = " WHERE $query";
		} else {
			$query = "";
		}
		
		try {
			$res = $conexao->query("SELECT COUNT(*) FROM $tabela $query");
			$total = $res->fetchColumn();
		} catch( PDOException $e ) {
			//print_r($e);
		}
		
		return $total;
	}
	
	function somar($somar, $tabela, $query = null) {
		global $conexao;
		if($query) {
			$query = " WHERE $query";
		} else {
			$query = "";
		}
		
		try {
			$res = $conexao->query("SELECT SUM($somar) FROM $tabela $query");
			$total = $res->fetchColumn();
		} catch( PDOException $e ) {
			$total = 0;
		}
		
		return $total;
	}
	
	function proximaFatura($associado) {		
		$guias = listar("guias", "titular='$associado' AND status='8'");
		$total = 0;
		foreach($guias as $dados) {
			if($dados->parcelas > 1) {
				
				$parcela = $dados->pagar / $dados->parcelas;
				$total += $parcela;
			
			} else {
				$total += $dados->pagar;
			}
		}
		
		return $total;
	}
	
	function saldoDevedor($associado) {		
		$guias = listar("guias", "titular='$associado' AND status='8'");
		$total = 0.0;
		foreach($guias as $dados) {
			$total += $dados->saldo;
		}
		
		return $total;
	}
	
	function enviarSms($numero, $mensagem) {
		$SMS_EMAIL = 'atendimento@acresites.com.br';
		$SMS_SENHA = 'a20121988';
		
		$clientSoap = new SoapClient("http://portal.gtisms.com:2000/gti/API/SMSService.asmx?wsdl");
		$params = array( 
					'email'  =>  $SMS_EMAIL,
					'senha'  =>  $SMS_SENHA,
					'mensagem' => $mensagem,
					'numeros' => $numero,
					'id'	  => '' );
		$result = $clientSoap->envioMessagem( $params );
		$infor = $result->envioMessagemResult;
		$estado_do_envio = print_r($infor, true);
		
		return $estado_do_envio;
		
	}
	
	//PEGAR O IP
	function ip_cliente() {
		$SEUIP = NULL;
		if (getenv('HTTP_CLIENT_IP'))
		 $SEUIP = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
		 $SEUIP = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
		 $SEUIP = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
		 $SEUIP = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		$SEUIP = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
		 $SEUIP = getenv('REMOTE_ADDR');
		else
		 $SEUIP = 'UNKNOWN';
		
		return $SEUIP; 
	}
	
	function saudacao() {
		$AGORA = date('H:i:s'); 
		if($AGORA > '00:00:00' AND $AGORA < '12:00:00') {
			return "Bom dia";
		} else if($AGORA > '12:00:00' AND $AGORA < '18:00:00') {
			return "Boa tarde";
		} else {
			return "Boa noite";
		}
	}
	
	
	$DADOS_USUARIO = dados_sessao($_SESSION['user']); //DADOS DO USUÁRIO