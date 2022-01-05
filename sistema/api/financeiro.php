<?php 

if(URL_SISTEMA AND $_SESSION['user']) {
	//ADICIONA FORNECEDOR
	if($_POST['acao'] == 'categoriaDespesas') {
		$categoria = strip_tags($_POST['categoria']);
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if(contarQueryes("despesas_categorias", "categoria='$categoria'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "Categoria já cadastrado", "msg" => "Esse categoria já está cadastrada no sistema." );
		} else if(!$categoria) {
			$Json = array("resposta" => 2, "titulo" => "Inválido", "msg" => "Digite o nome da categoria." );
		} else {
		
			$grava = gravar("despesas_categorias", "'', '$categoria', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Categoria cadastrada com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" =>$grava );
			}
		}
	}
	else if($_POST['acao'] == "categoriaDespesasEditar") {
		$id_cat = strip_tags($_POST['id']);
		$categoria = strip_tags($_POST['categoria']);
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if(contarQueryes("despesas_categorias", "categoria='$categoria' AND id_cat!='$id_cat'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "Categoria já cadastrado", "msg" => "Esse categoria já está cadastrada no sistema.");
		} else if(!$categoria) {
			$Json = array("resposta" => 2, "titulo" => "Inválido", "msg" => "Digite o nome da categoria.");
		} else {
		
			$grava = atualizar("despesas_categorias", "categoria='$categoria'", "id_cat='$id_cat'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "ATUALIZADO", "msg" => "Categoria atualizada com sucesso!.", "ID" => $grava);
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!", "obs" => $grava);
			}
		}
		
	}
	else if($_POST['acao'] == 'removerCategoria') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( excluir("despesas_categorias", "id_cat='$cod'") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	else if($_POST['acao'] == 'novaDespesa') {
		$cod = $_POST['cod'];
		$tipo = $_POST['tipo'];
		$caixa = strip_tags($_POST['caixa']);
		$fornecedor = strip_tags($_POST['fornecedor']);
		$documento = strip_tags($_POST['documento']);
		$valor = number_format(implode(".", explode(",", implode("", explode(".",$_POST['valor'])))));
		$emissao = implode("-", array_reverse(explode("/", $_POST['emissao'])));
		$vencimento = implode("-", array_reverse(explode("/", $_POST['vencimento'])));
		$categoria = strip_tags($_POST['categoria']);
		$descriminacao = strip_tags($_POST['descriminacao']);
		$status = 2;
		$usuario = dados_sessao($_SESSION['user'])->usuario;

	
		if(!$fornecedor and $tipo == 0) {
			$Json = array("resposta" => 2, "titulo"  => "Oops!", "msg" => "Informe o forncedor");
		} else if(!$documento and $tipo == 0){
			$Json = array("resposta" => 2, "titulo"  => "Oops!", "msg" => "Informe o nº do documento");
		} else if(!$valor){
			$Json = array("resposta" => 2, "titulo"  => "Oops!", "msg" => "Informe o valor");
		} else if(!$emissao){
			$Json = array("resposta" => 2, "titulo"  => "Oops!", "msg" => "Informe a data de emissão");
		} else if(!$vencimento){
			$Json = array("resposta" => 2, "titulo"  => "Oops!", "msg" => "Informe a data de vencimento");
		} else {
			
			//VERIFICA SE O BOLETO FOI ANEXADO
			if($_FILES['boleto']['name']) {
				$EXTENSAO = end(explode(".",$_FILES['boleto']['name']));
				$ARQUIVO = 'despesa-'.uniqid().'.'.$EXTENSAO;
				$TAMANHO = filesize($_FILES['boleto']['tmp_name']);
				$TAMANHO_MB = ($TAMANHO / 1000000);
				
				if($TAMANHO_MB > intval(ini_get('post_max_size'))) {
					$Json = array("resposta" => 2, "titulo" => "Oops", "msg" => "Não foi possível enviar o boleto. O tamanho maximo permitido é de ".intval(ini_get('post_max_size'))."MB");
				} else {					
					// CAMINHO DO UPLOAD
					$uploaddir="./arquivos/despesas/";
					
					copy($_FILES['boleto']['tmp_name'], $uploaddir . $ARQUIVO);
					$boleto = $ARQUIVO;
				}
			}
			
			if(!$Json) {
				
				$grava = gravar("despesas", "'', '$tipo', '$categoria', '$fornecedor', '$caixa', '$documento', '$emissao', '$vencimento', NULL, '$descriminacao', '$valor', '0', '$boleto', '', '$status'");
			
				if($grava) {
					$Json = array("resposta" => 1);
				} else {
					$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
				}
			}
		}
	}
	else if($_POST['acao'] == 'cancelarDespesa') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$usuario = dados_sessao($_SESSION['user'])->usuario;

	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( atualizar("despesas", "status='0'", "id='$cod'") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	else if($_POST['acao'] == 'liquidarDespesa') {
		$cod = $_POST['cod'];
		$senha = md5($_POST['senha']);
		$pagamento = date('Y-m-d');
		$usuario = dados_sessao($_SESSION['user'])->usuario;

	
		if( contarQueryes("usuarios", "id='$usuario' AND senha='$senha'") != 1) {
			$Json = array("resposta" => 2);
		} else if( atualizar("despesas", "pagamento='$pagamento', status='1'", "id='$cod'") ){
			$Json = array("resposta" => 1);
		} else {
			$Json = array("resposta" => 0, "titulo" => "Erro interno", "msg" => "Ocorre um erro interno. Atualize a pagina e tente novamente.");
		}
	}
	else if($_POST['acao'] == 'novaConta') {
		$id_banco = strip_tags($_POST['banco']);
		$tipo = strip_tags($_POST['tipo']);
		$agencia = strip_tags($_POST['agencia']);
		$conta = strip_tags($_POST['conta']);
		$variacao = strip_tags($_POST['variacao']);
		$status = 1;
		
		//VERIFICA SE O CNPJ está cadastrado
		if(contarQueryes("contas_bancarias", "id_banco='$id_banco' AND conta='$conta' AND agencia='$agencia' AND tipo='$tipo'") >= 1) {
			$Json = array("resposta" => 2, "titulo" => "Conta já cadastrado", "msg" => "Esse conta já está cadastrada no sistema." );
		} else if(!$id_banco) {
			$Json = array("resposta" => 2, "titulo" => "Inválido", "msg" => "Selecione o banco." );
		} else if(!$agencia) {
			$Json = array("resposta" => 2, "titulo" => "Inválido", "msg" => "Digite o número da agencia." );
		} else if(!$conta) {
			$Json = array("resposta" => 2, "titulo" => "Inválido", "msg" => "Digite o número da conta." );
		} else {
		
			$grava = gravar("contas_bancarias", "'', '$id_banco', '$tipo', '$agencia', '$conta', '$variacao', '$status'");
			
			if($grava) {
				$Json = array("resposta" => 1, "titulo" => "CADASTRADO", "msg" => "Conta bancaria cadastrada com sucesso!.");
			} else {
				$Json = array("resposta" => 0, "titulo" => "Oops!", "msg" => "Ocorreu um problema interno. Tente novamente!");
			}
		}
	} 
} else {
	$Json = array("resposta" => 0, "titulo" => "Acesso Negado", "msg" => "Você não tem permissão para acessar o sistema" );
}
echo json_encode($Json);