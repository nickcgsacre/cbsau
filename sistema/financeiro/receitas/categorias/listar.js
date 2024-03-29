var nova =  {
	categoria: function() {
		swal({
			title: "NOVA CATEGORIA",
			text: "Informe o nome da categoria",
			type: "input",
			inputType: 'text',
			showCancelButton: true,
			closeOnConfirm: false,
			confirmButtonColor: "green",
			cancelButtonColor: "red",
			confirmButtonText: "ADICIONAR",
			cancelButtonText: "CANCELAR",		
			animation: "slide-from-top",
			showLoaderOnConfirm: true
		},
		function(inputValue){
			if (inputValue === false) return false;

			if (inputValue === "") {
				swal.showInputError("Por favor, informe a categoria");
				return false
			} else {
				
				$.post(URL_SISTEMA+"/api/financeiro", {'acao': 'categoriaDespesas', 'categoria': inputValue}, function(retorno){
					if(retorno.resposta == 1) {
						//var table = $('#listar').DataTable();
						//table.row( "#Iten-"+ID ).remove().draw(true);
						
						
						swal({
							title: "INSERIDO!",
							text: "Categoria cadastrada com sucesso!",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						},
						function(){
							location.reload();
						});
					} else if(retorno.resposta == 2) {
						swal(retorno.titulo, retorno.msg, "error");
					} else {
						swal("OOPS!", "Ocorrreu um erro inesperado, tente novamente em alguns minutos.", "error");
					}
				},'json');

			}
		});
	},
	editar: function(id, categoria) {
		swal({
			title: "EDITAR CATEGORIA",
			text: "Informe o nome da categoria",
			type: "input",
			inputType: 'text',
			inputValue: categoria,
			showCancelButton: true,
			closeOnConfirm: false,
			confirmButtonColor: "green",
			cancelButtonColor: "red",
			confirmButtonText: "ATUALIZAR",
			cancelButtonText: "CANCELAR",		
			animation: "slide-from-top",
			showLoaderOnConfirm: true
		},
		function(inputValue){
			if (inputValue === false) return false;

			if (inputValue === "") {
				swal.showInputError("Por favor, informe a categoria");
				return false
			} else {
				
				$.post(URL_SISTEMA+"/api/financeiro", {'acao': 'categoriaDespesasEditar', 'categoria': inputValue, id}, function(retorno){
					if(retorno.resposta == 1) {
						//var table = $('#listar').DataTable();
						//table.row( "#Iten-"+ID ).remove().draw(true);
						
						swal({
							title: "ATUALIZADO!",
							text: "Categoria atualizada com sucesso!",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						},
						function(){
							location.reload();
						});
						
					} else if(retorno.resposta == 2) {
						swal(retorno.titulo, retorno.msg, "error");
					} else {
						swal("OOPS!", "Ocorrreu um erro inesperado, tente novamente em alguns minutos.", "error");
					}
				},'json');

			}
		});
	}
}

function remover(ID){
	swal({
	  title: "Aviso",
	  text: "Você tem certeza que deseja excluír essa categoria?",
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
						
						$.post(URL_SISTEMA+"/api/financeiro", {'acao': 'removerCategoria', 'cod':ID, 'senha': inputValue}, function(result){
							var retorno = JSON.parse(result);
							if(retorno.resposta == 1) {
								swal({
									title: "REMOVIDO!",
									text: "Categoria removida com sucesso!",
									type: "success",
									timer: 2000,
									showConfirmButton: false
								},
								function(){
									location.reload();
								});
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
	  text: "Você tem certeza que deseja excluír estes associados?",
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
						
						$.post(URL_SISTEMA+"/api/associados", {'acao': 'removerAssociadosEmMassa', 'ids':camposMarcados, 'senha': inputValue}, function(result){

							var retorno = JSON.parse(result);
							if(retorno.resposta == 1) {
								var table = $('#listar').DataTable();
						
								$.each(camposMarcados,function(i, ID){
									table.row( "#Iten-"+ID ).remove().draw(true);
								});
								
								swal("REMOVIDOS", "Associados removido com sucesso!", "success");
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