<?php 
if($_POST['acao'] == 'logar') {
	$ip = ip_cliente();
	$chave = codigoAleatorio();
	$login = addslashes($_POST['usuario']);
	$senha = md5($_POST['senha']);
	$validade = strtotime("+".SESSAO." minute",time("d/m/Y H:i:s"));
	$navegador = getenv('HTTPS_USER_AGENT');
	$ipreal = $_SERVER['HTTPS_X_FORWARDED_FOR'];
	
	if(!$_SESSION['firewall']){
		$_SESSION['firewall'] = 0;
	}
	
	$_SESSION['firewall'] = 0;
	if($_SESSION['firewall'] >= TENTATIVAS) { 
		$data = date('Y-m-d H:i:s');
		gravar("firewall", "'','$ip', '$ipreal', '$navegador', '$data', 'Forçar acesso ao sistema', '1'");
		$Json = array("resposta" => 5); //IP BLOQUEADO		
	} else {
		if(contarQueryes("usuarios", "login='$login' and login!=''") != 1) {
			$_SESSION['firewall'] += 1;
			$Json = array("resposta" => 2);//USUÁRIO INVÁLIDO
		} else if(contarQueryes("usuarios", "(login='$login' and login!='') and status=1") != 1) {
			$_SESSION['firewall'] += 1;
			$Json = array("resposta" => 3);//USUÁRIO BLOQUEADO
		} else if(contarQueryes("usuarios", "(login='$login' and login!='') and senha='$senha' and status=1") != 1) {
			$_SESSION['firewall'] += 1;
			$Json = array("resposta" => 4);//SENHA INVÁLIDO
		} else {
			$usuario = buscar("usuarios", "(login='$login' and login!='') and senha='$senha' and status=1");
			
			excluir("sessoes", "usuario='".$usuario->id."'");
			if(gravar("sessoes", "'','".$usuario->id."', '$chave', '$validade', '1'")){
				$_SESSION['user'] = $chave;
				$Json = array("resposta" => 1);
			}			
			
		}
		
	}
	
}

echo json_encode($Json);