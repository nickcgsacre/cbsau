
function gravarForm(id, tipo) {
	
	//e.preventDefault(); 
	var dados = $( `#${id}` ).serialize();	
	var dados_Array = $( `#${id}` ).serializeArray();	
	var l = Ladda.create( document.querySelector( `#btn-${tipo}` ) );
	
	if(dados_Array[3]['value'] == '') {
		swal("ATENÇÃO", "Você precisa informar o nome do serviço", "info")
		return false;
	}
	
	l.start();
	
	//zerarChecagem();
	
	$.ajax({
		type: "POST",
		url: URL_SISTEMA+"/api/servicos",
		data: dados,
		success: function( data ){
			l.stop();
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
					
					//GRAVA O RESPONSÁVEL
					setTimeout(function(){ 
						gravarResponsavel()
					}, 1000);
					
					toastr.success(dados['msg'],dados['titulo'],{
						positionClass:"toast-bottom-full-width", 
						showMethod:"slideDown",
						hideMethod:"slideUp",
						closeButton:!0,
						timeOut:6000
					})

					if(tipo == 'novo') {
						window.location.replace(`${URL_SISTEMA}/servicos/novo`);
					} else if(tipo == 'concluir') {
						window.location.replace(`${URL_SISTEMA}/servicos/listar`);
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


$('#formCategoria').submit(function(e){
	e.preventDefault()
	let dados = $( this ).serialize()
	let J_dados = $( this ).serializeArray()
	
	var l = Ladda.create( document.querySelector( `#btn-addCat` ) );
	l.start();
	
	$.post(URL_SISTEMA+"/api/servicos", dados, function(result){
		
		let dados = JSON.parse(result);
		l.stop()
		
		switch(dados['resposta']) {
			case 0:
				swal(dados['titulo'], dados['msg'], "error")
				break
			case 1:
				document.getElementById("formCategoria"). reset();
				
				$(`<option value="${dados['ID']}" selected="">${dados['CAT']}</option>`).insertAfter("#addDCat");
				
				$('#novaCategoria').modal('hide');
												  
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
