
function gravarForm(id, tipo) {
	
	//e.preventDefault(); 
	var dados = $( `#${id}` ).serialize();	
	var dados_Array = $( `#${id}` ).serializeArray();	
	var l = Ladda.create( document.querySelector( `#btn-${tipo}` ) );
	
	if(dados_Array[2]['value'] == '') {
		swal("ATENÇÃO", "Você precisa informar o nome do plano", "info")
		return false;
	}
	
	l.start();
	
	//zerarChecagem();
	
	$.ajax({
		type: "POST",
		url: URL_SISTEMA+"/api/planos",
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
						window.location.replace(`${URL_SISTEMA}/planos/novo`);
					} else if(tipo == 'concluir') {
						window.location.replace(`${URL_SISTEMA}/planos/listar`);
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