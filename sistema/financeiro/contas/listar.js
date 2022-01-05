
var financeiro = {
	despesas: function(form) {
		let dados = $( form ).serialize();	
		let J_dados = $( form ).serializeArray()
		
		let carregando = $('body');
		$(carregando).block({
			message: `<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Gerando dados</div>`,
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
			url: URL_SISTEMA+"/financeiro/despesas/extrato",
			data: dados,
			success: function( data ){
				$(carregando).unblock();
				
				$('html, body').animate({
					scrollTop: $('.imprime-resultado').offset().top
				}, 2000);
				
				$('.imprime-resultado').html(`${data}`)
				setTimeout(function(){
					$('#listar').DataTable();
				}, 1000);
					
			}
		})
	},
	cancelar: function(ID){ 
		swal({
		  title: "Aviso",
		  text: "Você tem certeza que deseja cancelar essa despesa?",
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
							
							$.post(URL_SISTEMA+"/api/financeiro", {'acao': 'cancelarDespesa', 'cod':ID, 'senha': inputValue}, function(result){
								var retorno = JSON.parse(result);
								if(retorno.resposta == 1) {
									var table = $('#listar').DataTable();
									table.row( "#Iten-"+ID ).remove().draw(true);
									
									swal("CANCELADO", "Despesa cancelada com sucesso!", "success");
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
	},
	liquidar: function(ID){ 
		swal({
		  title: "Aviso",
		  text: "Você tem certeza que deseja liquidar essa despesa?",
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
						text: "Por favor, digite sua senha de acesso para confirmar",
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
							
							$.post(URL_SISTEMA+"/api/financeiro", {'acao': 'liquidarDespesa', 'cod':ID, 'senha': inputValue}, function(result){
								var retorno = JSON.parse(result);
								if(retorno.resposta == 1) {
									var table = $('#listar').DataTable();
									table.row( "#Iten-"+ID ).remove().draw(true);
									
									swal("LIQUIDADO", "Despesa liquidada com sucesso!", "success");
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
}
