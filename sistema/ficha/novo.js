
function gravarForm() {	
	let servicos = {}
	$("table > tbody  > tr").each(function(tr, item){
		let itens = {}
		$.each(this.cells, function(th, item){
			let op
			if(th == 0) { op = 'data'}
			if(th == 1) { op = 'descricao'}
			if(th == 2) { op = 'valor'}
			if(th == 3) { op = 'assinatura'}
			
			itens[op] = $(this).text()
		});
		servicos[tr] = itens
	});
	
	let id = $( "input[name='id']" ).val()
	let acao = $( "input[name='acao']" ).val()
	let titular = $( "select[name='titular']" ).val()
	let tipo = $( "select[name='tipo']" ).val()
	let dependente = $( "select[name='dependente']" ).val()
	let fornecedor = $( "select[name='fornecedor']" ).val()
	
	
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
		
	$.ajax({
		type: "POST",
		url: URL_SISTEMA+"/api/ordens",
		data: {acao, id, titular, tipo, dependente, fornecedor, servicos},
		success: function( data ){
			$(block_ele).unblock();
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
					$( "input[name='id']" ).val(dados['ID'])
					toastr.success(dados['msg'],dados['titulo'],{
						positionClass:"toast-bottom-full-width", 
						showMethod:"slideDown",
						hideMethod:"slideUp",
						closeButton:!0,
						timeOut:6000
					})
					window.print();
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
	if(get_Acao == 'editar') {
		let element = document.getElementById('titular');
		let event = new Event('change');
		element.dispatchEvent(event);
		
		element = document.getElementById('tipo');
		event = new Event('change');
		element.dispatchEvent(event);
		
		element = document.getElementById('fornecedor');
		event = new Event('change');
		element.dispatchEvent(event);
		
		setTimeout(function(){
			element = document.getElementById('dependente');
			event = new Event('change');
			element.dispatchEvent(event);
		}, 3000);
		gerar.liberar()
	}
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
		
		if(selecionaDependente) {
			$('#dependente').val(selecionaDependente);
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

/*$("#fornecedor").change(function(){
	
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
	
});*/

var gerar = {
	titular: function(id) {
		$.post(URL_SISTEMA+"/api/ordens", {acao: 'buscarTitular', id}, function(result){
			if(result) {
				let dados = JSON.parse(result);				
				$('#orden-nome').html(dados.dados.nome);
				$('#orden-plano').html(dados.plano.nome);
				$('#orden-endereco').html(dados.dados.endereco);
				$('#orden-bairro').html(dados.dados.bairro);
				$('#orden-telefone').html(dados.dados.telefone);
				$('#orden-nascimento').html(dados.dados.nascimento);
				$('#orden-naturalidade').html(dados.dados.naturalidade);
				$('#orden-estado-civil').html(dados.dados.estado_civil);
				$('#orden-titular').html(dados.dados.nome);
				
				gerar.liberar();
			}
		});
	},
	dependente: function(id) {
		$.post(URL_SISTEMA+"/api/ordens", {acao: 'buscarDependente', id}, function(result){
			if(result) {
				let dados = JSON.parse(result);
				$('#orden-nome').html(dados.dados.nome);
				$('#orden-endereco').html(dados.dados.endereco);
				$('#orden-bairro').html(dados.dados.bairro);
				$('#orden-telefone').html(dados.dados.telefone);
				$('#orden-nascimento').html(dados.dados.nascimento);
				$('#orden-naturalidade').html(dados.dados.naturalidade);
				$('#orden-estado-civil').html(dados.dados.estado_civil);
				
				gerar.liberar();
			}
		});		
	},
	fornecedor: function(id) {
		$.post(URL_SISTEMA+"/api/ordens", {acao: 'buscarFornecedor', id}, function(result){
			if(result) {
				let dados = JSON.parse(result);
				$('#orden-fornecedor').html(dados.dados.nome_fantasia);
				
				gerar.liberar();
			}
		});	
	},
	inserir: function() {
		let descricao = $('#servicos').val()
		$('#servicos').val('')
		
		let ttt = $( "tbody tr" ).length;
		let achou = true;
		
		while(achou) {
			if (typeof($(`tr #dt-${ttt}`)) !== "undefined") { 
				achou = false; 
			}
			ttt++;
		}
		
		$('tbody').append(`	<tr>
								<th scope="row" id="dt-${ttt}" ondblclick="gerar.editar.campo(this, 'data')"></th>
								<th scope="row" id="desc-${ttt}" ondblclick="gerar.editar.campo(this, 'descricao')">${descricao}</th>
								<th scope="row" id="vlr-${ttt}" ondblclick="gerar.editar.campo(this, 'valor')"></th>
								<th scope="row"></th>
							</tr>`)
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
			
			$(campo).html(`
				<div _ngcontent-gie-c178="" class="card-block">
					<fieldset _ngcontent-gie-c178="">
						<div _ngcontent-gie-c178="" class="input-group">
							<input _ngcontent-gie-c178="" type="text" value="${valor}" ${comando} data-tipo="${tipo}" aria-describedby="button-addon6" class="form-control">
							<div _ngcontent-gie-c178="" class="input-group-append">
								<button _ngcontent-gie-c178="" onclick="gerar.editar.salvar(this)" type="button" class="btn btn-primary bg-info border-info"><i _ngcontent-gie-c178="" class="fa fa-save"></i></button>
							</div>
						</div>
					</fieldset>
				</div>
			`)
		},
		salvar: function(campo) {
			campo = $(campo).parent().parent().parent().parent().parent()[0]
			let tipo = $(`#${campo.id} input`).attr("data-tipo")
			let valor = $(`#${campo.id} input`).val()
			if(tipo == 'valor' && valor != '') { valor = `R$ ${valor}`; }
			$(campo).attr("ondblclick",`gerar.editar.campo(this, '${tipo}')`);
			$(campo).html(valor)
		}
	},
	liberar: function() {
		let titular = $( "select[name='titular']" ).val()
		let tipo = $( "select[name='tipo']" ).val()
		let dependente = $( "select[name='dependente']" ).val()
		let fornecedor = $( "select[name='fornecedor']" ).val()
		
		if(titular && fornecedor) {
			if(tipo == 1 && dependente == '') {
				$('#painel').hide()
			} else {
				$('#painel').show()
			}
		} else {
			$('#painel').hide()
		}
		
	}
}
