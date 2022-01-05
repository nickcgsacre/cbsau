$(document).ready(function(){"use strict";void 0!=$("form.form-horizontal").attr("novalidate")&&$("input,select,textarea").not("[type=submit]").jqBootstrapValidation(),$(".chk-remember").length&&$(".chk-remember").iCheck({checkboxClass:"icheckbox_square-blue",radioClass:"iradio_square-blue"})});

//LOGIN
$('#logar').submit(function(e){
	e.preventDefault();
	let dados = $( this ).serialize();	
	let J_dados = $( this ).serializeArray()

	let l = Ladda.create( document.querySelector( '#btn-logar' ) );
	l.start();
	
	toastr.clear()
	
	if(J_dados[1]['value'] == '') {
		toastr.warning("Por favor, forneça um nome de usuário válido","USUÁRIO INVÁLIDO",{
			positionClass:"toast-top-full-width", 
			showMethod:"slideDown",
			hideMethod:"slideUp",
			closeButton:!0,
			timeOut:6e6
		})
		l.stop();
	} else if(J_dados[2]['value'] == '') {
		toastr.warning("Por favor, forneça um senha válida","SENHA INVÁLIDA",{
			positionClass:"toast-top-full-width", 
			showMethod:"slideDown",
			hideMethod:"slideUp",
			closeButton:!0,
			timeOut:6e6
		})
		l.stop();
	} else {
		
		$.ajax({
			type: "POST",
			url: URL_SISTEMA+"/api/logar",
			data: dados,
			success: function( data ){
				
				let dados = JSON.parse(data);
				
				switch(dados['resposta']) {
					case 1:
						toastr.success("Aguarde... Você está sendo redirecionado.","LOGADO COM SUCESSO!",{
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
					case 2:
						toastr.error('Não encontramos esse usuário. Verifique se você digitou corretamente.',"ACESSO NEGADO",{
							positionClass:"toast-top-full-width", 
							showMethod:"slideDown",
							hideMethod:"slideUp",
							closeButton:!0,
							timeOut:6e6
						})
						l.stop();
						break
					case 3:
						toastr.error('Seu acesso foi bloqueado pelo administrador.',"ACESSO NEGADO",{
							positionClass:"toast-top-full-width", 
							showMethod:"slideDown",
							hideMethod:"slideUp",
							closeButton:!0,
							timeOut:6e6
						})
						l.stop();
						break
					case 4:
						toastr.error('A senha digitada é inválida. Verifique se você digitou corretamente.',"ACESSO NEGADO",{
							positionClass:"toast-top-full-width", 
							showMethod:"slideDown",
							hideMethod:"slideUp",
							closeButton:!0,
							timeOut:6e6
						})
						l.stop();
						break
					case 5:
						toastr.error('Seu acesso ao sistema foi bloqueado. Entre em contato com o seu superior.',"ACESSO BLOQUEADO!",{
							positionClass:"toast-top-full-width", 
							showMethod:"slideDown",
							hideMethod:"slideUp",
							closeButton:!0,
							timeOut:6e6
						})
						l.stop();
						break
					default:
						toastr.error("Não foi possível conectar ao servidor. Tente novamente!","SEM COMUNICAÇÃO",{
							positionClass:"toast-top-full-width", 
							showMethod:"slideDown",
							hideMethod:"slideUp",
							closeButton:!0,
							timeOut:6e6
						})
						l.stop();
				}
				
				
			}, error: function() {
			}
		})
	}

})