
function gravarForm(id, tipo) {
	
	//e.preventDefault(); 
	var dados = $( `#${id}` ).serialize();	
	var dados_Array = $( `#${id}` ).serializeArray();	
	var l = Ladda.create( document.querySelector( `#btn-${tipo}` ) );
	
	/*
	if(dados_Array[0]['value'] != '') {
		editarForm(id, tipo)
		return false;
	}*/
	
	l.start();
	
	//zerarChecagem();
	
	$.ajax({
		type: "POST",
		url: URL_SISTEMA+"/api/associados",
		data: dados,
		success: function( data ){
			l.stop();
			console.log(data)
			var dados = JSON.parse(data);
			
			switch(dados['resposta']) {
				case 0:
					toastr.error(dados['msg'],dados['titulo'],{
						positionClass:"toast-bottom-full-width", 
						showMethod:"slideDown",
						hideMethod:"slideUp",
						closeButton:!0,
						timeOut:6000
					})
					return 0
					break;
				case 1:
					document.getElementById('cod').value = dados['ID']
					document.getElementById('acao').value = 'editar'
					
					document.getElementById('dependente-associado').value = dados['ID']
					
					if(tipo == "salvarDependente") {
						setTimeout(function(){ 
							$("#formSaveDependente").submit();
						}, 300);
						
					} else if(tipo == "concluir") {
						setTimeout(function(){ 
							window.location.href = `${URL_SISTEMA}/associados/listar`;
						}, 300);
						
					} else if(tipo == "novo") {
						setTimeout(function(){ 
							window.location.href = `${URL_SISTEMA}/associados/novo`;
						}, 300);
						
					} else {
						toastr.success(dados['msg'],dados['titulo'],{
							positionClass:"toast-bottom-full-width", 
							showMethod:"slideDown",
							hideMethod:"slideUp",
							closeButton:!0,
							timeOut:6000
						})
					}

					return 1
					break;
				case 2:
					toastr.warning(dados['msg'],dados['titulo'],{
						positionClass:"toast-bottom-full-width", 
						showMethod:"slideDown",
						hideMethod:"slideUp",
						closeButton:!0,
						timeOut:6000
					})
					return 2
					break;
				default:
					return null
			}
		
		}
	})

	
}

function editarForm(id, tipo) {
	
	toastr.clear()
	toastr.success("Executado a ação de atualizar", "Atualizando...",{
		positionClass:"toast-bottom-full-width", 
		showMethod:"slideDown",
		hideMethod:"slideUp",
		closeButton:!0,
		timeOut:6000
	})
	
}

$('#formSaveDependente').submit(function(e){
	e.preventDefault()
	let dados = $( this ).serialize()
	let J_dados = $( this ).serializeArray()	
	
	
	if(J_dados[1]['value'] == '') {
		gravarForm("formNovo", "salvarDependente")
		return false;
	}	
	
	let l = Ladda.create( document.querySelector( '#btn-salvarDependente' ) )
	
	l.start();
	
	$.post(URL_SISTEMA+"/api/associados", dados, function(result){
		l.stop();
		
		let dados = JSON.parse(result);
		console.log(dados)
		
		switch(dados['resposta']) {
			case 0:
				swal(dados['titulo'], dados['msg'], "error")
				break
			case 1:
				document.getElementById("formSaveDependente"). reset();
				
				let verifica = $("#exibeDependentes h1").html()
				
				if(verifica == '<i class="ft-alert-triangle"></i>') {
					$("#exibeDependentes").html(`<ul class="list-group"></ul>`)
				}
				
				
				if(document.querySelector(`#dependente-${dados['item']['id']}`)) {
					$(`#dependente-${dados['item']['id']}`).html(`
														<button type="button" onclick="editarDependente(${dados['item']['id']})" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in" id="btn-editarDependente-${dados['item']['id']}">
															<i class="la la-edit"></i>
														</button>
														<button type="button" onclick="removerDependente(${dados['item']['id']})" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in" id="btn-removeDependente-${dados['item']['id']}">
															<i class="la la-trash"></i>
														</button>
														<h2 class="float-left">${dados['item']['nome']} - <small> ${dados['item']['parentesco']}<small></h2>`)
					
				} else {
					$(`#exibeDependentes ul`).append(`<li class="list-group-item" id="dependente-${dados['item']['id']}">
														<button type="button" onclick="editarDependente(${dados['item']['id']})" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in" id="btn-editarDependente-${dados['item']['id']}">
															<i class="la la-edit"></i>
														</button>
														<button type="button" onclick="removerDependente(${dados['item']['id']})" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in" id="btn-removeDependente-${dados['item']['id']}">
															<i class="la la-trash"></i>
														</button>
														<h2 class="float-left">${dados['item']['nome']} - <small> ${dados['item']['parentesco']}</small></h2>
													  </li>`)
				}
					
				$("#div-btn-salvarDependente").removeClass("col-md-10");
				$("#div-btn-salvarDependente").addClass("col-md-12");
				
				$("#div-btn-cancelarDependente").hide();
												  
				toastr.success(dados['msg'],dados['titulo'],{
					positionClass:"toast-bottom-full-width", 
					showMethod:"slideDown",
					hideMethod:"slideUp",
					closeButton:!0,
					timeOut:6000
				})
												  
				break
			case 2:
				swal(dados['titulo'], dados['msg'], "info")
				break
			default:
			
		}
		
	})
	
	
	
})

$('#buscarExtrato').submit(function(e){
	e.preventDefault()
	let dados = $( this ).serialize()
	let J_dados = $( this ).serializeArray()	
	
	let l = Ladda.create( document.querySelector( '#btn-buscarExtrato' ) )
	
	l.start();
	
	$.post(URL_SISTEMA+"/api/extrato", dados, function(result){
		l.stop();
		
		$('.exbirExtrato').html(result);
		
		
	})
	
	
	
})

function editarDependente(id) {
	
	let l = Ladda.create( document.querySelector( '#btn-editarDependente-'+id ) )
	
	l.start();
	
	$.post(URL_SISTEMA+"/api/associados", {acao: 'buscarDependente', id}, function(result){
		l.stop();
		
		let dados = JSON.parse(result);
		console.log(dados)
		try {
			document.getElementById('dependente-associado').value = dados.dados.id_associado
			document.getElementById('dependente-id').value = dados.dados.id_dependente
			document.getElementById('dependente-sexo').value = dados.dados.sexo
			document.getElementById('dependente-nome').value = dados.dados.nome
			document.getElementById('dependente-nascimento').value = dados.dados.nascimento
			document.getElementById('dependente-fator_rh').value = dados.dados.fator_rh
			document.getElementById('dependente-tipo_sanguineo').value = dados.dados.tipo_sanguineo
			document.getElementById('dependente-mae').value = dados.dados.mae
			document.getElementById('dependente-pai').value = dados.dados.pai
			document.getElementById('dependente-naturalidade').value = dados.dados.naturalidade
			document.getElementById('dependente-nacionalidade').value = dados.dados.nacionalidade
			document.getElementById('dependente-cpf').value = dados.dados.cpf
			document.getElementById('dependente-rg').value = dados.dados.rg
			document.getElementById('dependente-profissao').value = dados.dados.profissao
			document.getElementById('dependente-local_trabalho').value = dados.dados.local_trabalho
			document.getElementById('dependente-parentesco').value = dados.dados.parentesco
			document.getElementById('dependente-plano').value = dados.dados.plano
			document.getElementById('dependente-observacoes').value = dados.dados.observacoes
			
			$("#div-btn-salvarDependente").removeClass("col-md-12");
			$("#div-btn-salvarDependente").addClass("col-md-10");
			
			$("#div-btn-cancelarDependente").show();
			
		} catch(e){
		}
		
		
	})
	
}

$( "#btn-cancelarDependente" ).on("click", function() {
	document.getElementById("formSaveDependente").reset();
	
	$("#div-btn-salvarDependente").removeClass("col-md-10");
	$("#div-btn-salvarDependente").addClass("col-md-12");
	
	$("#div-btn-cancelarDependente").hide();
});

function verificaSeEstaGravado() {
	let dados_Array = $( `#formNovo` ).serializeArray();
	if(dados_Array[0]['value'] == '') {
		//PERGUNTA SE QUER GRAVAR
		swal({
		  title: "ATENÇÃO!",
		  text: "Você só pode inserir atividas após gravar o estabelecimento.\nDeseja Gravar o estabelecimento agora?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "green",
		  confirmButtonText: "GRAVAR AGORA",
		  cancelButtonColor: "red",
		  cancelButtonText: "NÃO GRAVAR",
		  closeOnConfirm: false
		},
		function(){
			swal({
				title: "Gravando..",
				text: "Aguarde enquanto gravamos o estabelecimento",
				showConfirmButton: false,
				imageUrl: URL_SISTEMA+"/app-assets/images/loader.gif"
			});
			
			$.when( gravarForm('formNovo', 'salvar1') ).done(function ( result ) {
				swal.close()
				return true;
			});
			
			
		});
		
		return false;
		
	}
	return true;
}


function parcelarGuias(associado) {

	swal({
		title: "PARCELAS",
		text: "Por favor, informe a quantidade de parcelas",
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
		$.post(URL_SISTEMA+"/api/associados", {'acao': 'parcelar', associado, parcelas}, function(result){
			console.log(result);
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


function informarPagamento(associado) {
	swal({
		title: "INFORMAR PAGAMENTO",
		text: "Por favor, informe o valor do pagamento",
		type: "input",
		inputType	: "text",
		showCancelButton: true,
		closeOnConfirm: false,
		animation: "slide-from-top",
		confirmButtonColor: 'green',
		confirmButtonText: 'GRAVAR',
		cancelButtonText: 'CANCELAR'
	},
	function(valor){
		if (valor === false) return false;
	  
		if (valor === "") {
			swal.showInputError("Informe o valor!");
			return false
		}
	  
		$.post(URL_SISTEMA+"/api/desconto", {'acao': 'pagamento', associado, valor}, function(result){
			console.log(result);
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

window.onload = function() {
	new dgCidadesEstados({
	  cidade: document.getElementById('cidade'),
	  estado: document.getElementById('uf')
	})
	
	try {
		let element = document.getElementById('buscarExtrato');
		let event = new Event('submit');
		element.dispatchEvent(event);
	} catch(e) {
	}
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
		  
			$.post(URL_SISTEMA+"/api/guias", {'acao': 'editar', id, status, data}, function(result){
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
		$.post(URL_SISTEMA+"/api/guias", {'acao': 'editar', id, status}, function(result){
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

function removerDependente(ID){
	swal({
	  title: "Aviso",
	  text: "Você tem certeza que deseja excluír esse dependente?",
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
						swal.showInputError("Por favor, digite sua senha");
						return false
					} else {
						
						$.post(URL_SISTEMA+"/api/associados", {'acao': 'removerDependente', 'cod':ID, 'senha': inputValue}, function(result){
							var retorno = JSON.parse(result);
							if(retorno.resposta == 1) {
								$(`#dependente-${ID}`).remove()
								
								swal("REMOVIDO", "Dependente removido com sucesso!", "success");
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

function formatoMoeda(campo) {	

	let campoValor = campo.value
	let campoLimpo = campoValor.replace(/[^0-9]/g,'')
	campoLimpo = parseInt(campoLimpo)
	campoLimpo = campoLimpo.toString()
	let tam = campoLimpo.length
	let novoValor
	
	if(campoLimpo == 'NaN') {
		novoValor = '0,00'
	} else if(tam == 1) {
		novoValor = '0,0'+campoLimpo
	} else if(tam == 2) {
		novoValor = '0,'+campoLimpo
	} else {
		novoValor = campoLimpo.substr( 0, tam - 2 ) +','+campoLimpo.substr( tam - 2, 2)
	}

	campo.value = novoValor
}
