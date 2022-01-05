
function gravarForm(id, tipo) {
	
	//e.preventDefault(); 
	var dados = $( `#${id}` ).serialize();	
	var dados_Array = $( `#${id}` ).serializeArray();	
	var l = Ladda.create( document.querySelector( `#btn-${tipo}` ) );
	
	if(dados_Array[2]['value'] == '') {
		swal("ATENÇÃO", "Você precisa informar o Nome do usuário", "info")
		return false;
	} else if(dados_Array[3]['value'] == '') {
		swal("ATENÇÃO", "Você precisa informar o cargo do usuário", "info")
		return false;
	} else if(dados_Array[7]['value'] == '') {
		swal("ATENÇÃO", "Você precisa informar o Login de acesso do usuário", "info")
		return false;
	} else if(dados_Array[8]['value'] == '' && dados_Array[1]['value'] == 'novo') {
		swal("ATENÇÃO", "Você precisa informar a senha de acesso do usuário", "info")
		return false;
	} else if(dados_Array[9]['value'] == '' && dados_Array[1]['value'] == 'novo') {
		swal("ATENÇÃO", "Você precisa confirmar a senha de acesso do usuário", "info")
		return false;
	} else if(dados_Array[8]['value'] != dados_Array[9]['value']) {
		swal("ATENÇÃO", "A senha e a confirmação da senha não são iguais", "info")
		return false;
	}
	
	l.start();
	
	//zerarChecagem();
	
	$.ajax({
		type: "POST",
		url: URL_SISTEMA+"/api/usuarios",
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
					
					toastr.success(dados['msg'],dados['titulo'],{
						positionClass:"toast-bottom-full-width", 
						showMethod:"slideDown",
						hideMethod:"slideUp",
						closeButton:!0,
						timeOut:6000
					})

					if(tipo == 'novo') {
						window.location.replace(`${URL_SISTEMA}/usuarios/novo&tipo=${GET_TIPO}&key=true`);
					} else if(tipo == 'concluir') {
						window.location.replace(`${URL_SISTEMA}/usuarios/listar&tipo=${GET_TIPO}&key=true`);
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