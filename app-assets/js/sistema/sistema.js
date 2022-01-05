var carregandoImpressao
checagem()

//FUNÇÃO PARA DESLOGAR
function deslogar() {
	$.ajax({
		type: "POST",
		url: URL_SISTEMA+"/api/deslogar",
		success: function( data ){
			let dados = JSON.parse(data);
			
			switch(dados['resposta']) {
				case 1:
					toastr.success("Você será redirecionado para a tela de login.","ATÉ LOGO!",{
						positionClass:"toast-top-full-width", 
						showMethod:"slideDown",
						hideMethod:"slideUp",
						closeButton:!0,
						timeOut:6e6
					})
					setTimeout(function(){
						window.location.replace("")
					}, 5000);
					break
				default:
					swal("Oops!", "Houve um erro insperado, tente novamente. Caso o error persista, entre em contato com o suporte")
			}
			
		}, error: function() {
			swal("Oops!", "Houve um erro insperado, tente novamente. Caso o error persista, entre em contato com o suporte")
		}
	})
	
}

function checagem() {
	$.ajax({
		type: "POST",
		url: URL_SISTEMA+"/api/checar",
		dataType: "json",
		success: function( data ){
			if(data.resposta == 1) {
				if(data.limite >= 5.15 && data.limite <= 4.45) {
					swal("SESSÃO EXPIRANDO", "Sua sessão irá expirar em menos de 5 minutos")
				}
				if(data.limite >= 2.15 && data.limite <= 1.45) {
					swal("SESSÃO EXPIRANDO", "Sua sessão irá expirar em menos de 1 minuto")
				}
			} else {
				window.location.replace("")
			}
			
			setTimeout(function(){ checagem() }, 30000);
		}
	})
		
}

function gerarGuia(ID) {
	carregandoImpressao = $('.card-body').closest('.card');
	$(carregandoImpressao).block({
		message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Gerando a guia</div>',
		fadeIn: 1000,
		fadeOut: 1000,
		//timeout: 2000, //unblock after 2 seconds
		overlayCSS: {
			backgroundColor: '#fff',
			opacity: 0.8,
			cursor: 'wait'
		},
		css: {
			border: 0,
			padding: '10px 15px',
			color: '#fff',
			width: 'auto',
			backgroundColor: '#333'
		}
	});
	
	
	document.getElementById('iImpressao').src = `${URL_SISTEMA}/api/guia&guia=${ID}&key=true`;
		
	
	
	/*$.post(URL_SISTEMA+"/api/guia", {acao: 'gerarGuia', id}, function(result){
		console.log(id)
		console.log(result)
		let dados = JSON.parse(result);
		$(block_ele).unblock();
		
		$("#dependente").html(`<option value="" selected="" disabled="">Selecione o dependente</option>`);
		
		if(dados.dados != '') {
			
			for(let i in dados.dados) {
				$("#dependente").append(`<option value="${dados.dados[i]['id_dependente']}">${dados.dados[i]['nome']}</option>`);
			}
			
		}
		
	});*/
}

function imprimir(){
	$(carregandoImpressao).unblock();
	document.getElementById('iImpressao').focus(); 
	document.getElementById('iImpressao').contentWindow.print();
}﻿

var formatar = {
	data: function(campo){
		var v = campo.value;
		$(campo).attr('maxlength', 10);
		v=v.replace(/\D/g,"");
		v=v.replace(/^(\d{2})(\d)/g,"$1/$2");
		v=v.replace(/(\d)(\d{4})$/,"$1/$2");
		
		campo.value = v;
	},
	moeda: function(campo) {	
		let v = campo.value
		$(campo).attr('maxlength', 18);
		v = v.replace(/\D/g, '');
		v = v.replace(/[0-9]{15}/, 'Inválido');
		v = v.replace(/(\d{1})(\d{11})$/, '$1.$2');
		v = v.replace(/(\d{1})(\d{8})$/, '$1.$2');
		v = v.replace(/(\d{1})(\d{5})$/, '$1.$2');
		v = v.replace(/(\d{1})(\d{1,2})$/, '$1,$2');
		campo.value = v
	}

	
}

var ficha = {
	procurar: function(form) {
		let dados = $( form ).serialize();	
		let J_dados = $( form ).serializeArray()
		
		let tipo = J_dados[0]['value']
		let area = J_dados[2]['value']
		
		if(area == '') {
			swal("Oops!", "Você deve selecionar a area de especialidade!")
			return false;
		}
		
		let carregando = $('.card-body.p1').closest('.card');
		$(carregando).block({
			message: `<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Procurando ${tipo}</div>`,
			fadeIn: 1000,
			fadeOut: 1000,
			//timeout: 2000, //unblock after 2 seconds
			overlayCSS: {
				backgroundColor: '#fff',
				opacity: 0.8,
				cursor: 'wait'
			},
			css: {
				border: 0,
				padding: '10px 15px',
				color: '#fff',
				width: 'auto',
				backgroundColor: '#333'
			}
		});
		
		
		$.ajax({
			type: "POST",
			url: URL_SISTEMA+"/api/ficha",
			data: dados,
			dataType: "json",
			success: function( data ){
				$(carregando).unblock();
				dados = data.dados
				
				$('html, body').animate({
					scrollTop: $('.imprime-resultado').offset().top
				}, 2000);
				
				if(dados.length > 1) {
					$('.imprime-resultado').html(`
					<div class="card">
					  <div class="card-header">
						<h4 class="card-title">ASSOCIADOS ENCONTRADOS</h4>
						<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
						<div class="heading-elements">
						  <ul class="list-inline mb-0">
							<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
						  </ul>
						</div>
					  </div>
					  <div class="card-content">
						<div class="card-body">
						  <div class="table-responsive">
							<table id="new-orders-table" class="table table-hover table-xl mb-0">
							  <thead>
								<tr>
								  <th class="border-top-0">NOME</th>
								  <th class="border-top-0">CPF</th>
								  <th class="border-top-0"></th>
								</tr>
							  </thead>
							  <tbody>								
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
					</div>
					`)
					
					for(let i in dados) {
						let id
						if(tipo == 'associado') {
							id = dados[i]['id_associado']
						} else {
							id = dados[i]['id_dependente']
						}
						
						$(`.imprime-resultado tbody`).append(`
							<tr>
							  <td class="text-truncate p-1">${dados[i]['nome']}</td>
							  <td class="text-truncate">${dados[i]['cpf']}</td>
							  <td class="text-truncate text-right">
								<button type="button" onclick="ficha.exibir(${id}, '${area}', '${tipo}')" class="btn btn-outline-info mr-1">
									<i class="fa fa-arrow-circle-right"></i>
								</button>
							  </td>
							</tr>
						`)
					}
				} else if(dados.length == 1) {
					let id
					if(tipo == 'associado') {
						id = dados[0]['id_associado']
					} else {
						id = dados[0]['id_dependente']
					}
					ficha.exibir(id, `${area}`, `${tipo}`)
				} else {
					swal("Oops!", `Nenhum ${tipo} foi encontrado`)
				}
			}
		})
	},
	exibir: function(id, area, tipo) {
		$("input[name=add-area]").val(area)
		$("input[name=add-tipo]").val(tipo)
		$("input[name=add-id]").val(id)
		
		$('html, body').animate({
					scrollTop: $('.imprime-resultado').offset().top
		}, 2000);
				
		let carregando = $('body');
		$(carregando).block({
			message: `<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Procurando ${tipo}</div>`,
			fadeIn: 1000,
			fadeOut: 1000,
			//timeout: 2000, //unblock after 2 seconds
			overlayCSS: {
				backgroundColor: '#fff',
				opacity: 0.8,
				cursor: 'wait'
			},
			css: {
				border: 0,
				padding: '10px 15px',
				color: '#fff',
				width: 'auto',
				backgroundColor: '#333'
			}
		});
		
		$.ajax({
			type: "POST",
			url: URL_SISTEMA+"/ficha/exibir",
			data: {id, area, tipo},
			success: function( data ){
				$(carregando).unblock();
				$(`.imprime-resultado`).html(`
					<div class="card">
					  <div class="card-header">
						<h4 class="card-title">FICHA MÉDICA</h4>
						<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
						<div class="heading-elements">
						  <ul class="list-inline mb-0">
							<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
						  </ul>
						</div>
					  </div>
					  <div class="card-content">
						<div class="card-body">
						  ${data}
						</div>
					  </div>
					</div>
				`)
			}
		})
	},
	guia: {
		add: function() { 
			/*let ttt = $( "tbody tr" ).length;
			let achou = true;
			
			while(achou) {
				if (typeof($(`tr #dt-${ttt}`)) !== "undefined") { 
					achou = false; 
				}
				ttt++;
			}*/
			let area = $("input[name=add-area]").val()
			let tipo = $("input[name=add-tipo]").val()
			let id = $("input[name=add-id]").val()
			
			let carregando = $('body');
			$(carregando).block({
				message: `<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Aguarde...</div>`,
				fadeIn: 1000,
				fadeOut: 1000,
				//timeout: 2000, //unblock after 2 seconds
				overlayCSS: {
					backgroundColor: '#fff',
					opacity: 0.8,
					cursor: 'wait'
				},
				css: {
					border: 0,
					padding: '10px 15px',
					color: '#fff',
					width: 'auto',
					backgroundColor: '#333'
				}
			});
			
			$.ajax({
				type: "POST",
				url: URL_SISTEMA+"/api/ficha",
				data: {acao: 'add', area, tipo, id},
				dataType: "json",
				success: function( data ){
					$(carregando).unblock();
					if(data.resposta == 1) {
						$(`.table.table-bordered.table-striped tbody`).append(`
									<tr>
										<th scope="row" id="dt-${data.id}" ondblclick="ficha.guia.editar.campo(this, 'data')">${data.data}</th>
										<th scope="row" id="desc-${data.id}" ondblclick="ficha.guia.editar.campo(this, 'descricao')">Duplo clique para editar</th>
										<th scope="row" id="vlr-${data.id}" ondblclick="ficha.guia.editar.campo(this, 'medico')"></th>
									</tr>`)
					} else {
						swal("Oops!", "Ocorreu um erro inesperado. Por favor, atualize a pagina e tenta novamente!");
					}
				}
			})
		},
		editar: {
			campo: function(campo, tipo) {
				let valor = $(campo).html()
				$(campo).attr("ondblclick","");
				let comando = ''

				if(tipo == 'data') {
					comando = `onkeyup="formatar.data(this)"`
				} else if(tipo == 'valor') {
					comando = `onkeyup="formatar.moeda(this)"`
					if(valor) { valor = valor.split('R$ ')[1]; }
				}
				
				if(valor == 'Duplo clique para editar') {
					valor = ''
				}
				
				$(campo).html(`
					<div _ngcontent-gie-c178="" class="card-block">
						<fieldset _ngcontent-gie-c178="">
							<div _ngcontent-gie-c178="" class="input-group">
								<textarea _ngcontent-gie-c178="" value="${valor}" ${comando} data-tipo="${tipo}" aria-describedby="button-addon6"  cols="60" rows="5" onkeypress="if (this.value.length > 352) { return false; }" class="form-control">${valor}</textarea>
								<div _ngcontent-gie-c178="" class="input-group-append">
									<button _ngcontent-gie-c178="" onclick="ficha.guia.editar.salvar(this)" type="button" class="btn btn-primary bg-info border-info"><i _ngcontent-gie-c178="" class="fa fa-save"></i></button>
								</div>
							</div>
						</fieldset>
					</div>
				`)
			},
			salvar: function(campo) {
				campo = $(campo).parent().parent().parent().parent().parent()[0]
				let tipo = $(`#${campo.id} textarea`).attr("data-tipo")
				let valor = $(`#${campo.id} textarea`).val()
				let id = campo.id;
				if(tipo == 'valor' && valor != '') { valor = `R$ ${valor}`; }
				let carregando = $('body');
				console.log(tipo);
				$(carregando).block({
					message: `<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Gravando...</div>`,
					fadeIn: 1000,
					fadeOut: 1000,
					//timeout: 2000, //unblock after 2 seconds
					overlayCSS: {
						backgroundColor: '#fff',
						opacity: 0.8,
						cursor: 'wait',
						position: 'fixed'
					},
					css: {
						border: 0,
						padding: '10px 15px',
						color: '#fff',
						width: 'auto',
						backgroundColor: '#333',
						position: 'fixed'
					}
				});
			
				$.ajax({
					type: "POST",
					url: URL_SISTEMA+"/api/ficha",
					data: {acao: 'editar', tipo, valor, id},
					dataType: "json",
					success: function( data ){
						$(carregando).unblock();
						console.log(data)
						$(campo).attr("ondblclick",`ficha.guia.editar.campo(this, '${tipo}')`);
						$(campo).html(valor)
					}, error: function(e) {
						console.log('error')
						console.log(e)
					}
					
				})
			}
		}
	}
}