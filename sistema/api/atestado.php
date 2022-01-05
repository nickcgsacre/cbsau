<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	if($_POST['acao'] == 'dependente') {
		$termo = addslashes($_POST['termo']);
		
		$DADOS = listar("dependentes", "nome like'%".$termo."%' or cpf like '%".$termo."%'");
		
		$Json = array("dados" => $DADOS);
	}
	else if($_POST['acao'] == 'associado') {
		$termo = addslashes($_POST['termo']);
		
		$DADOS = listar("associados", "nome like'%".$termo."%' or cpf like '%".$termo."%' or matricula like '%".$termo."%'");
		
		$Json = array("dados" => $DADOS);
	}
	else if($_POST['acao'] == 'add') {
		$ID = $_POST['id'];
		$AREA = $_POST['area'];
		$TIPO = ($_POST['tipo'] == 'associado') ? 0 : 1;
		$DATA = date('Y-m-d');
		
		$gravar =  gravar("ficha_medica", "'', '$AREA', '$TIPO', '$ID', '', '', '$DATA', '0'");
		
		if($gravar) {
			$Json = array("resposta" => 1, "id" => $gravar, "data" => date('d/m/Y'));
		} else {
			$Json = array("resposta" => 0);
		}
		
	}
	else if($_POST['acao'] == 'editar') {
		$ID = preg_replace("/[^0-9]/", "", $_POST['id']);
		$tipo = $_POST['tipo'];
		$valor = $_POST['valor'];
		
		if($tipo == 'data') { $valor = implode("-", array_reverse(explode("/", $valor))); }

		$gravar = atualizar("ficha_medica", "$tipo='$valor', status='1'", "id_ficha='$ID'");
		
		if($gravar) {
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0);
		}
	}
	//REMOVE O ASSOCIADO EM MASSA
	else if($_POST['acao'] == 'removerAssociadosEmMassa') {
		$ids = $_POST['ids'];
		$tids = implode(",", $ids);
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("associados", "id_associado IN ($tids)") ){
			excluir("dependentes", "id_associado IN ($tids)");
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);