
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
	
	let data = new Date(),
	dia  = data.getDate().toString(),
	diaF = (dia.length == 1) ? '0'+dia : dia,
	mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
	mesF = (mes.length == 1) ? '0'+mes : mes,
	anoF = data.getFullYear();
	
	if(status == 7) {
		swal({
			title: "DATA DA CONSULTA",
			text: "Por favor, informe a data da consulta",
			type: "input",
			inputType	: "date",
			inputValue: `${anoF}-${mesF}-${diaF}`,
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
		  
			$.post(URL_SISTEMA+"/api/guias", {'acao': 'editar', id, status, data}, function(result){
				console.log(result)
				var retorno = JSON.parse(result);
				if(retorno.resposta == 1) {
					var table = $('#listar').DataTable();			
					swal(retorno.titulo, retorno.msg, "success");
					$(`table #fatura-${id}`).children("td:nth-child(7)").html(`
						<span class="dropdown">
							<button id="btnSearchDrop${id}" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right">
								<i class="ft-settings"></i>
							</button>
							<span aria-labelledby="btnSearchDrop${id}" class="dropdown-menu mt-1 dropdown-menu-right">
								<a href="javascript:gerarGuia(${id})" class="dropdown-item">
									<i class="la la-print"></i> IMPRIMIR
								</a>
								<a href="javascript:statusGuia(${id}, 0)" class="dropdown-item">
									<i class="la la-ban"></i> CANCELAR
								</a>
								<a href="javascript:statusGuia(${id}, 8)" class="dropdown-item">
									<i class="fa fa-money"></i> FATURADO
								</a>
								<a class="dropdown-item">
									<i class="la la-close"></i> FECHAR
								</a>
							</span>
						</span>
					`)
					
				} else {
					swal("OOPS!", "Ocorrreu um erro inesperado, tente novamente em alguns minutos.", "error");
				}
			});
		});
	} else if(status == 9) {
		
		swal({
			title: "DATA DO PAGAMENTO",
			text: "Por favor, informe a data do pagamento",
			type: "input",
			inputType	: "date",
			inputValue: `${anoF}-${mesF}-${diaF}`,
			showCancelButton: true,
			closeOnConfirm: false,
			animation: "slide-from-top",
			confirmButtonColor: 'green',
			confirmButtonText: 'GRAVAR',
			cancelButtonText: 'CANCELAR'
		},function(data){
			swal({
				title: "VALOR PAGO",
				text: "Por favor, informe o valor do pagamento",
				type: "input",
				inputType	: "text",
				inputAttributes: {
					onkeyup: 'formatar.moeda(this)'
				},
				showCancelButton: true,
				closeOnConfirm: false,
				animation: "slide-from-top",
				confirmButtonColor: 'green',
				confirmButtonText: 'GRAVAR',
				cancelButtonText: 'CANCELAR'
			},function(valor){
				if (valor === false) return false;
			  
				if (valor === "") {
					swal.showInputError("Informe o valor pago!");
					return false
				}
				$.post(URL_SISTEMA+"/api/guias", {'acao': 'editar', data, valor, id, status}, function(result){
					var retorno = JSON.parse(result);
					if(retorno.resposta == 1) {
						var table = $('#listar').DataTable();			
						swal(retorno.titulo, retorno.msg, "success");
						
						$(`table #fatura-${id}`).children("td:nth-child(7)").html(`
							<span class="dropdown">
								<button id="btnSearchDrop${id}" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right">
									<i class="ft-settings"></i>
								</button>
								<span aria-labelledby="btnSearchDrop${id}" class="dropdown-menu mt-1 dropdown-menu-right">
									<a href="javascript:gerarGuia(${id})" class="dropdown-item">
										<i class="la la-print"></i> IMPRIMIR
									</a>
									<a href="javascript:statusGuia(${id}, 0)" class="dropdown-item">
										<i class="la la-ban"></i> CANCELAR
									</a>
									<a href="javascript:statusGuia(${id}, 9)" class="dropdown-item">
										<i class="fa fa-check-square"></i> PAGAR
									</a>
									<a class="dropdown-item">
										<i class="la la-close"></i> FECHAR
									</a>
								</span>
							</span>
						`)
					} else {
						swal("OOPS!", "Ocorrreu um erro inesperado, tente novamente em alguns minutos.", "error");
					}
				});
			});
		});
	} else {
		$.post(URL_SISTEMA+"/api/guias", {'acao': 'editar', id, status}, function(result){
			var retorno = JSON.parse(result);
			if(retorno.resposta == 1) {
				var table = $('#listar').DataTable();			
				swal(retorno.titulo, retorno.msg, "success");
				$(`table #fatura-${id}`).children("td:nth-child(7)").html(`
						<span class="dropdown">
							<button id="btnSearchDrop${id}" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right">
								<i class="ft-settings"></i>
							</button>
							<span aria-labelledby="btnSearchDrop${id}" class="dropdown-menu mt-1 dropdown-menu-right">
								<a href="javascript:gerarGuia(${id})" class="dropdown-item">
									<i class="la la-print"></i> IMPRIMIR
								</a>
								<a href="javascript:statusGuia(${id}, 0)" class="dropdown-item">
									<i class="la la-ban"></i> CANCELAR
								</a>
								<a class="dropdown-item">
									<i class="la la-close"></i> FECHAR
								</a>
							</span>
						</span>
					`)
			} else {
				swal("OOPS!", "Ocorrreu um erro inesperado, tente novamente em alguns minutos.", "error");
			}
		});
	}
}

function parcelarGuia(id) {
	swal({
		title: "PARECELAS",
		text: "Por favor, informe o número de parcelas",
		type: "input",
		inputType	: "number",
		showCancelButton: true,
		closeOnConfirm: false,
		animation: "slide-from-top",
		confirmButtonColor: 'green',
		confirmButtonText: 'GRAVAR',
		cancelButtonText: 'CANCELAR'
	},
	function(parcelas){
		if (parcelas === false) return false;
	  
		if (parcelas === "") {
			swal.showInputError("Informe a quantidade de parcelas!");
			return false
		}
	  
		$.post(URL_SISTEMA+"/api/guias", {'acao': 'parcelar', id, parcelas}, function(result){
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
}

function informacoesGuia(id) {
	$.post(URL_SISTEMA+"/api/guias", {'acao': 'informacoes', id}, function(result){
		let retorno = JSON.parse(result);
		swal({
			title: `INFORMAÇÕES`,
			text: retorno,
			html: true
		});
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


window.onload = function() {
	if(imprimirGuia) {
		gerarGuia(imprimirGuia)
	}
}