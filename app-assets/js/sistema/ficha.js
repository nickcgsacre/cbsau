var atestado = {
	procurar: function(form) {
		let dados = $( form ).serialize();	
		let J_dados = $( form ).serializeArray()
		
		let tipo = J_dados[0]['value']
		let opts = J_dados[2]['value']
		let motivo = J_dados[3]['value']
		let dias = J_dados[4]['value']
		let clinica = J_dados[5]['value']
		
		if(opts == '') {
			swal("Oops!", "Você deve selecionar uma opção!")
			return false;
		}
		if(motivo == '') {
			swal("Oops!", "Você deve informar o motivo!")
			return false;
		}
		if(dias == '') {
			swal("Oops!", "Você deve informar a quantidade de dias de afastamento")
			return false;
		}
		if(clinica == '') {
			swal("Oops!", "Você deve informar o nome da clínica")
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
			url: URL_SISTEMA+"/api/atestado",
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
					
					let form_id = form.id;
					
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
								<button type="button" onclick="atestado.gerar('${form_id}', ${id})" class="btn btn-outline-info mr-1">
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
					atestado.gerar(form.id, id)
				} else {
					swal("Oops!", `Nenhum ${tipo} foi encontrado`)
				}
			}
		})
		
	},
	gerar: function(form, usuario) {
		let J_dados = $( `#${form}` ).serializeArray()
		
		let tipo = J_dados[0]['value']
		let opts = J_dados[2]['value']
		let motivo = J_dados[3]['value']
		let dias = J_dados[4]['value']
		let clinica = J_dados[5]['value']
		
		$('html, body').animate({
					scrollTop: $('.imprime-resultado').offset().top
		}, 2000);
				
		let carregando = $('body');
		$(carregando).block({
			message: `<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Gerando o atestado médico</div>`,
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
			url: URL_SISTEMA+"/ficha/exibir-atestado",
			data: {usuario, tipo, opts, motivo, dias, clinica},
			success: function(data){
				$(carregando).unblock();
				$(`.imprime-resultado`).html(`
					<div class="card">
					  <div class="card-header">
						<h4 class="card-title">FICHA MÉDICA</h4>
						<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
						<div class="heading-elements">
						  <ul class="list-inline mb-0">
							<li><a href="javascript:window.print()"><i class="fa fa-print"></i></a></li>
						  </ul>
						</div>
					  </div>
					  <div class="card-content">
						<div class="card-body">
						  ${data}
						</div>
						<div class="card-footer">
							<div class="form-actions text-center">
								<button type="button" class="btn btn-info mr-1" onclick="window.print();">
									<i class="fa fa-print"></i> IMPRIMIR
								</button>
							</div>
						</div>
					  </div>
					</div>
				`)
			}
		})
	}
}