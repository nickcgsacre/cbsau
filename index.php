<?php
include_once("config/db.php");
include_once("modulos/modulos.php");
$_ROTA = implode("/", $ROTA);


if($_SESSION['firewall'] >= 5 or contarQueryes("firewall", "ip='".ip_cliente()."' or ip_real='".ip_cliente()."' ") >= 1) {
	session_destroy();
	include_once("sistema/403.php");

} 
elseif($_SESSION['user'] and contarQueryes("sessoes", "chave='".$_SESSION['user']."' AND validade>='".time("d/m/Y G:i:s")."'") == 1) {
	
	if($ROTA[1] != 'checar') {
		atualizar("sessoes", "validade='".strtotime("+".SESSAO." minute",time("d/m/Y H:i:s"))."'", "chave='".$_SESSION['user']."'");	
	}
	
	if($ROTA[0] == 'api') {
		if(file_exists("sistema/api/".$ROTA[1].".php")) {
			include_once("sistema/api/".$ROTA[1].".php");

		} else {
			include_once("sistema/404.php");
		}
	} else if($ROTA[0]) {
		if(file_exists("sistema/".$_ROTA.".php")) {
			include_once("sistema/".$_ROTA.".php");	
		} else {
			include_once("sistema/404.php");
		}
	} else {
		include_once("sistema/home-1.php");
	}
	
} else {
	if($ROTA[0] == 'api') {
		include_once("sistema/api/".$ROTA[1].".php");
	} else if($ROTA[0] == 'redefinir-senha') {
		include_once("sistema/redefinir-senha.php");
	} else if($ROTA[0] == 'consulta') {
		if(isset($ROTA[1]) AND $ROTA[1] = 'listar'){
			include_once("sistema/consulta/listar.php");
		}else{
			include_once("sistema/consulta.php");
		}

	} else {
		include_once("sistema/login.php");
	}
}