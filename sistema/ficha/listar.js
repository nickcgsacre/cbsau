
function remover(ID){
	swal({
	  title: "Aviso",
	  text: "Você tem certeza que deseja excluír este fornecedor?",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: 'SIM',
	  cancelButtonClass: "btn-success",
	  cancelButtonText: 'NÃO',
	  //showLoaderOnConfirm: true,
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm) {
			if(isConfirm) {
				swal({
					title: "ATENÇÃO",
					text: "Por favor, digite sua senha de acesso para confirmar a exclusão",
					type: "input",
					inputType: 'password',
					showCancelButton: true,
					closeOnConfirm: false,
					confirmButtonColor: "green",
					cancelButtonColor: "red",
					confirmButtonText: "EXCLUÍR",
					cancelButtonText: "CANCELAR",		
					animation: "slide-from-top",
					showLoaderOnConfirm: true
				},
				function(inputValue){
					if (inputValue === false) return false;

					if (inputValue === "") {
						swal.showInputError("Por favor, informe sua senha");
						return false
					} else {
						
						$.post(URL_SISTEMA+"/api/fornecedores", {'acao': 'removerFornecedor', 'cod':ID, 'senha': inputValue}, function(result){
							var retorno = JSON.parse(result);
							if(retorno.resposta == 1) {
								var table = $('#listar').DataTable();
								table.row( "#Iten-"+ID ).remove().draw(true);
								
								swal("REMOVIDO", "Fornecedor removido com sucesso!", "success");
							} else if(retorno.resposta == 2) {
								swal.showInputError("Senha inválida");
							} else {
								swal("OOPS!", "Ocorrreu um erro inesperado, tente novamente em alguns minutos.", "error");
							}
						});

					}
				});
			} else {
				swal("CANCELADO", "Operação cancelada pelo usuário.", "error");
			}
		
	});
}

//REMOVER EM MASSA
function removerEmMassa(){
	swal({
	  title: "Aviso",
	  text: "Você tem certeza que deseja excluír estes fornecedores?",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-danger",
	  confirmButtonText: 'SIM',
	  cancelButtonClass: "btn-success",
	  cancelButtonText: 'NÃO',
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm) {
			if(isConfirm) {
				swal({
					title: "ATENÇÃO",
					text: "Por favor, digite sua senha de acesso para confirmar a exclusão",
					type: "input",
					inputType: 'password',
					showCancelButton: true,
					closeOnConfirm: false,
					confirmButtonColor: "green",
					cancelButtonColor: "red",
					confirmButtonText: "EXCLUÍR",
					cancelButtonText: "CANCELAR",		
					animation: "slide-from-top",
					showLoaderOnConfirm: true
				},
				function(inputValue){
					if (inputValue === false) return false;

					if (inputValue === "") {
						swal.showInputError("Por favor, sua senha");
						return false
					} else {

						let camposMarcados = new Array();
						$("input[type=checkbox][name='itens[]']:checked").each(function(){
							camposMarcados.push($(this).val());
						});
						
						$.post(URL_SISTEMA+"/api/fornecedores", {'acao': 'removerFornecedorEmMassa', 'ids':camposMarcados, 'senha': inputValue}, function(result){

							var retorno = JSON.parse(result);
							if(retorno.resposta == 1) {
								var table = $('#listar').DataTable();
						
								$.each(camposMarcados,function(i, ID){
									table.row( "#Iten-"+ID ).remove().draw(true);
								});
								
								swal("REMOVIDOS", "Fornecedor removido com sucesso!", "success");
							} else if(retorno.resposta == 2) {
								swal.showInputError("Senha inválida");
							} else {
								swal("OOPS!", "Ocorrreu um erro inesperado, tente novamente em alguns minutos.", "error");
							}
						});

					}
				});				
				
			} else {
				swal("CANCELADO", "Operação cancelada pelo usuário.", "error");
			}
		
	});
}

function statusGuia(id, status) {
	
	if(status == 7) {
		swal({
			title: "DATA DA CONSULTA",
			text: "Por favor, informe a data da consulta",
			type: "input",
			inputType	: "date",
			showCancelButton: true,
			closeOnConfirm: false,
			animation: "slide-from-top",
			confirmButtonColor: 'green',
			confirmButtonText: 'GRAVAR',
			cancelButtonText: 'CANCELAR'
		},
		function(data){
			if (data === false) return false;
		  
			if (data === "") {
				swal.showInputError("Informe uma data!");
				return false
			}
		  
			$.post(URL_SISTEMA+"/api/ordens", {'acao': 'editar', id, status, data}, function(result){
				console.log(result)
				var retorno = JSON.parse(result);
				if(retorno.resposta == 1) {
					var table = $('#listar').DataTable();			
					swal(retorno.titulo, retorno.msg, "success");
				} else {
					swal("OOPS!", "Ocorrreu um erro inesperado, tente novamente em alguns minutos.", "error");
				}
			});
		});
	} else {
		$.post(URL_SISTEMA+"/api/ordens", {'acao': 'editar', id, status}, function(result){
			var retorno = JSON.parse(result);
			if(retorno.resposta == 1) {
				var table = $('#listar').DataTable();			
				swal(retorno.titulo, retorno.msg, "success");
			} else {
				swal("OOPS!", "Ocorrreu um erro inesperado, tente novamente em alguns minutos.", "error");
			}
		});
	}
}

$(".MarcarTodos").click(function(){
	if ($(this).prop( "checked")){ 
		marcardesmarcar(true);
	}else{
		marcardesmarcar(false);
	}
});

function marcardesmarcar(bool){
 	$('input').each(
		function(){
		   $(this).prop("checked", bool);            
		 }
	);
}