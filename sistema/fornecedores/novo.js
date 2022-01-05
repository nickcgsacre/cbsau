
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
		url: URL_SISTEMA+"/api/fornecedores",
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
					
					document.getElementById('servico-fornecedor').value = dados['ID']
					
					if(tipo == "salvarServico") {
						setTimeout(function(){ 
							$("#formSaveServico").submit();
						}, 300);
						
					} else if(tipo == "concluir") {
						setTimeout(function(){ 
							window.location.href = `${URL_SISTEMA}/fornecedores/listar`;
						}, 300);
						
					} else if(tipo == "novo") {
						setTimeout(function(){ 
							window.location.href = `${URL_SISTEMA}/fornecedores/novo`;
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

$('#formSaveServico').submit(function(e){
	e.preventDefault()
	let dados = $( this ).serialize()
	let J_dados = $( this ).serializeArray()	
	
	
	if(J_dados[1]['value'] == '') {
		gravarForm("formNovo", "salvarServico")
		return false;
	}	
	
	let l = Ladda.create( document.querySelector( '#btn-salvarServico' ) )
	
	l.start();
	
	$.post(URL_SISTEMA+"/api/fornecedores", dados, function(result){
		l.stop();
		
		let dados = JSON.parse(result);
		
		switch(dados['resposta']) {
			case 0:
				swal(dados['titulo'], dados['msg'], "error")
				break
			case 1:
				document.getElementById("formSaveServico").reset();
				
				let verifica = $("#exibeServicos h1").html()
				
				if(verifica == '<i class="ft-alert-triangle"></i>') {
					$("#exibeServicos").html(`<ul class="list-group"></ul>`)
				}
				
				
				if(document.querySelector(`#servico-${dados['item']['id']}`)) {
					$(`#servico-${dados['item']['id']}`).html(`
														<button type="button" onclick="editarServico(${dados['item']['id']})" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in" id="btn-editarServico-${dados['item']['id']}">
															<i class="la la-edit"></i>
														</button>
														<button type="button" onclick="removeServico(${dados['item']['id']})" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in" id="btn-removeServico-${dados['item']['id']}">
															<i class="la la-trash"></i>
														</button>
														<h2 class="float-left">${dados['item']['servico']} - <small> R$ ${dados['item']['valor']}<small></h2>`)
					
				} else {
					$(`#exibeServicos ul`).append(`<li class="list-group-item" id="servico-${dados['item']['id']}">
														<button type="button" onclick="editarServico(${dados['item']['id']})" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in" id="btn-editarServico-${dados['item']['id']}">
															<i class="la la-edit"></i>
														</button>
														<button type="button" onclick="removeServico(${dados['item']['id']})" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in" id="btn-removeServico-${dados['item']['id']}">
															<i class="la la-trash"></i>
														</button>
														<h2 class="float-left">${dados['item']['servico']} - <small> R$ ${dados['item']['valor']}<small></h2>
													  </li>`)
				}
					
				$("#div-btn-salvarServico").removeClass("col-md-10");
				$("#div-btn-salvarServico").addClass("col-md-12");
				
				$("#div-btn-cancelarServico").hide();
												  
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

function editarServico(id) {
	
	let l = Ladda.create( document.querySelector( '#btn-editarServico-'+id ) )
	
	l.start();
	
	$.post(URL_SISTEMA+"/api/fornecedores", {acao: 'buscarServico', id}, function(result){
		l.stop();
		
		let dados = JSON.parse(result);
		
		try {
			document.getElementById('servico-fornecedor').value = dados.dados.id_fornecedor
			document.getElementById('servico-id').value = dados.dados.id_fs
			document.getElementById('servico-cod_servico').value = dados.dados.codigo_servico
			document.getElementById('servico-valor').value = dados.dados.valor
			document.getElementById('servico-observacoes').value = dados.dados.obs
			
			
			$("#div-btn-salvarServico").removeClass("col-md-12");
			$("#div-btn-salvarServico").addClass("col-md-10");
			
			$("#div-btn-cancelarServico").show();
			
			console.log(dados.dados.codigo_servico)
			
			//$( ".ac-combobox" ).on( "autocompleteselect", function( event, ui ) {} );
			$( ".ac-combobox" ).autocomplete({
			   focus: function( event, ui ) {
				   $( ".ac-combobox" ).val(  dados.dados.codigo_servico );
				   console.log('ALTEROU')
			   }
			});
		} catch(e){
		}
		
		
	})
	
}


$( "#btn-cancelarServico" ).on("click", function() {
	document.getElementById("formSaveServico").reset();
	
	$("#div-btn-salvarServico").removeClass("col-md-10");
	$("#div-btn-salvarServico").addClass("col-md-12");
	
	$("#div-btn-cancelarServico").hide();
});

function removeServico(ID){
	swal({
	  title: "Aviso",
	  text: "Você tem certeza que deseja excluír esse serviço?",
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
						
						$.post(URL_SISTEMA+"/api/fornecedores", {'acao': 'removerServico', 'cod':ID, 'senha': inputValue}, function(result){
							var retorno = JSON.parse(result);
							if(retorno.resposta == 1) {
								$(`#servico-${ID}`).remove()
								
								swal("REMOVIDO", "Serviço removido com sucesso!", "success");
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

window.onload = function() {
	new dgCidadesEstados({
	  cidade: document.getElementById('cidade'),
	  estado: document.getElementById('uf')
	})
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

function selecionaTipo(valor) {
	let v = valor.value
	
	if(v == 1) {
		$("#label_nome_fantasia").html(`Nome Fantasia*`);
		$("#div_razao_social").show();
		$("#label_cpf").html(`CNPJ*`);
		$("#cpf").inputmask("99.999.999/9999-99");
		$("#label_rg").html(`Insc. Estadual*`);
		$("#label_expedidor").html(`Insc. Municipal`);
	} else {
		$("#label_nome_fantasia").html(`Nome*`);
		$("#div_razao_social").hide();
		$("#label_cpf").html(`CPF`);
		$("#cpf").inputmask("999.999.999-99");
		$("#label_rg").html(`RG`);
		$("#label_expedidor").html(`Orgão Expedidor`);
	}
}
