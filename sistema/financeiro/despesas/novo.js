//CADASTRAR
$('#cadastrar').submit(function(e){
	e.preventDefault();	
	let l = Ladda.create( document.querySelector( '#gravar' ) );
	l.start();
	
	let formulario = document.getElementById('cadastrar');
	let formData = new FormData(formulario);
	
	$.ajax({
		url: URL_SISTEMA+"/api/financeiro",
		type: 'POST',
		data: formData,
		success: function (data) {
			if(data) {
				console.log(data)
				let retorno = JSON.parse(data);
				l.stop();
				
				if(retorno['resposta'] == 1) {
					swal({
						title: "INSERIDO!",
						text: "Despesa cadastrada com sucesso!",
						type: "success",
						timer: 2000,
						showConfirmButton: false
					},
					function(){
						window.location.href=`${URL_SISTEMA}/financeiro/despesas/listar`;
					});
					
				} else if(retorno['resposta'] == 2) {
					swal(retorno.titulo, retorno.msg, 'error')
				} else {
					swal('Oops!', 'Não foi possível cadastrar essa despesa. Atualize a pagina e tente novamente.', 'error')
				}
			} else {
				swal('Oops!', 'Ocorreu um erro inesperado, tente novamente!', 'warning')
			}
		},
		cache: false,
		contentType: false,
		processData: false,
		xhr: function(){
			var xhr = new window.XMLHttpRequest();
			//Upload progress, request sending to server
			xhr.upload.addEventListener("progress", function(evt){
				/*let percentComplete = parseInt( (evt.loaded / evt.total * 100), 10);
				$(`#barra-de-progesso`).html(`${percentComplete}%`);
				$(`#barra-de-progesso`).width(`${percentComplete}%`);*/
				
			}, false);
			return xhr;
		},
	});
});
