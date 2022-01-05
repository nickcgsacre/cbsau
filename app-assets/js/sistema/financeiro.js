$("#selecionaAno").change(function(){
	valor = this.value
	let data = new Date(),
		dia  = data.getDate().toString(),
		diaF = (dia.length == 1) ? '0'+dia : dia,
        mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0'+mes : mes,
        anoF = data.getFullYear();
	
	let meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
	$('#selecionaMes').html(`<option value="">Selecione um mês</option>`)
	if(valor == anoF) {
		for(let i = 0; i<mes;i++) {
			$('#selecionaMes').append(`<option value="${i + 1}">${meses[i]}</option>`)
		}
	} else {
		for(let i = 0; i<12;i++) {
			$('#selecionaMes').append(`<option value="${i + 1}">${meses[i]}</option>`)
		}
	}		
});

var extrato = {
	servicos: function(form) {
		let dados = $( form ).serialize();	
		let J_dados = $( form ).serializeArray()
		
		let ano = J_dados[1]['value']
		let mes = J_dados[2]['value']
		
		if(ano == '') {
			swal("Oops!", "Você deve selecionar um ano!")
			return false;
		}
		
		if(mes == '') {
			swal("Oops!", "Você deve selecionar um mês!")
			return false;
		}
		
		let carregando = $('body');
		$(carregando).block({
			message: `<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Gerando extrato</div>`,
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
			url: URL_SISTEMA+"/financeiro/extrato-servicos",
			data: dados,
			success: function( data ){
				$(carregando).unblock();
				
				$('html, body').animate({
					scrollTop: $('.imprime-resultado').offset().top
				}, 2000);
				
				$('.imprime-resultado').html(`
				<div class="card">
				  <div class="card-header">
					<h4 class="card-title">EXTRATO FINANCEIRO</h4>
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
				  </div>
				</div>
				`)
					
					
			}
		})
	},
	mensalidades: function(form) {
		let dados = $( form ).serialize();	
		let J_dados = $( form ).serializeArray()
		
		let ano = J_dados[1]['value']
		let mes = J_dados[2]['value']
		
		if(ano == '') {
			swal("Oops!", "Você deve selecionar um ano!")
			return false;
		}
		
		if(mes == '') {
			swal("Oops!", "Você deve selecionar um mês!")
			return false;
		}
		
		let carregando = $('body');
		$(carregando).block({
			message: `<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Gerando extrato</div>`,
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
			url: URL_SISTEMA+"/financeiro/extrato-mensalidades",
			data: dados,
			success: function( data ){
				$(carregando).unblock();
				
				$('html, body').animate({
					scrollTop: $('.imprime-resultado').offset().top
				}, 2000);
				
				$('.imprime-resultado').html(`
				<div class="card">
				  <div class="card-header">
					<h4 class="card-title">EXTRATO FINANCEIRO</h4>
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
				  </div>
				</div>
				`)
					
					
			}
		})
	}
}