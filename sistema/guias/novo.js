
function gravarForm(id, tipo) {
	
	//e.preventDefault(); 
	var dados = $( `#${id}` ).serialize();	
	var dados_Array = $( `#${id}` ).serializeArray();	
	var l = Ladda.create( document.querySelector( `#btn-${tipo}` ) );
	
	
	let block_ele = $('.card-body').closest('.card');
	$(block_ele).block({
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
	
	/*
	if(dados_Array[0]['value'] != '') {
		editarForm(id, tipo)
		return false;
	}*/
	
	l.start();
	
	//zerarChecagem();
	
	$.ajax({
		type: "POST",
		url: URL_SISTEMA+"/api/guias",
		data: dados,
		success: function( data ){
			console.log(data)
			l.stop();
			$(block_ele).unblock();
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
					setTimeout(function(){ 
						window.location.href = `${URL_SISTEMA}/guias/listar&acao=exibir&guia=${dados.ID}&key=true`;
					}, 300);

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

window.onload = function() {
	$("#div-dependente").hide();
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

function buscarDependentes(valor) {
	let id = valor;
	let block_ele = $('.card-body').closest('.card');
	$(block_ele).block({
		message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Buscando dependentes...</div>',
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
	
	$.post(URL_SISTEMA+"/api/guias", {acao: 'buscarDependentes', id}, function(result){
		let dados = JSON.parse(result);
		$(block_ele).unblock();
		
		$("#dependente").html(`<option value="" selected="" disabled="">Selecione o dependente</option>`);
		
		if(dados.dados != '') {
			
			for(let i in dados.dados) {
				$("#dependente").append(`<option value="${dados.dados[i]['id_dependente']}">${dados.dados[i]['nome']}</option>`);
			}
			
		}
		
	});
};

function selecionaTipo(valor) {
	let v = valor.value
	let t = $('#titular').val()
	
	if(v == 1) {
		buscarDependentes(t);
		$("#div-dependente").show();
	} else {
		$("#div-dependente").hide();
	}
}


$("#fornecedor").change(function(){
	
	let id = this.value;
	let block_ele = $('.card-body').closest('.card');
	$(block_ele).block({
		message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Buscando serviços...</div>',
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
	
	$.post(URL_SISTEMA+"/api/guias", {acao: 'buscarServicos', id}, function(result){
		let dados = JSON.parse(result);
		$(block_ele).unblock();
		
		$("#servicos").html(``);
		
		if(dados.dados != '') {
			
			for(let i in dados.dados) {
				$("#servicos").append(`<option value="${dados.dados[i]['codigo_servico']}-${dados.dados[i]['valor']}">${dados.dados[i]['servico']} - R$ ${dados.dados[i]['valor']}</option>`);
			}
			
		}
		
	});
	
});
