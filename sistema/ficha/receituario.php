<?php
define("PAGINA", "RECEITUÁRIO MÉDICO");
define("CSS", '');
define("JS", '');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");

?>
<style>
.contenteditable[placeholder]:empty:before {
    content: attr(placeholder);
    color: #555; 
}
</style>
  
  <!-- END VENDOR CSS-->


  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">RECEITUÁRIO MÉDICO</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Receituário Médico
                </li>
              </ol>
            </div>
          </div>
        </div>
		<!--
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-500 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <button type="button" class="btn btn-icon btn-outline-danger" onclick="removerEmMassa()"><i class="la la-trash"></i> EXCLUÍR SELECIONADOS</button>
				  <a href="<?=URL_SISTEMA?>/ordens/novo" class="btn btn-icon btn-outline-primary"><i class="la la-plus"></i> NOVA FICHA</a>
				</div>
			  
			  
            </div>
          </div>
        </div> 
		-->
      </div>
      <div class="content-body">
	  
        <!-- Ajax sourced data -->
        <section id="ajax">
          <div class="row">
            
			<div class="col-12 col-xl-12">
				<div class="row">
					<div class="col-12">
					
						<div class="card">
						  <div class="card-header">
							<h4 class="card-title"><i class="fa fa-search"></i> RECEITUÁRIO MÉDICO</h4>
						  </div>
						  <div class="card-content">
							<div class="card-body printable">
									<h3 class="text-center">
										<img src="<?=URL_SISTEMA?>/app-assets/images/logo.png" style="width: 120px!important"/>
									</h3>
									<h1 class="text-center" style="font-size:24px !important;"><strong>CBSAÚDE</strong></h1>
									<h6 class="text-center"  style="font-size:10px !important;">COOPERATIVA DE SAÚDE DOS SERVIDORES PÚBLICOS DO CORPO DE BOMBEIROS</h6>
									<h3 class="text-center" style="text-decoration: underline; font-size:18px !important;">RECEITUÁRIO</h3>
									<h3 id="nomePaciente" style="font-size: 20px !important;" class="text-center"></h3>
									<hr/>
									<h3 class="contenteditable" contenteditable="true" placeholder="Clique para preencher o receituário" ></h3>
								
							</div>
						  </div>
						  <div id="card-footer">
							  <div class="row">
								<div class="col-sm-12 col-12 text-center">
									<button onclick="window.print()" type="button" class="btn btn-info btn-print btn-lg my-1">
										<i class="la la-print mr-50"></i>
										IMPRIMIR
									</button>
								</div>
							  </div>
							</div>
						</div>
					
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-12 imprime-resultado">
					
					</div>
				</div>
			
          </div>
        </section>
        <!--/ Ajax sourced data -->
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  
  
  
<?php include_once(__DIR__."/../footer.php"); ?>
 <style>

.sweet-alert {
width: 601px !important;
}
	</style>
 <script>
	$( document ).ready(function() {
		setTimeout(function(){
			swal({
				title: "PACIENTE",
				text: "Informe o CPF ou nome do paciente",
				type: "input",
				showCancelButton: false,
				closeOnConfirm: false,
				confirmButtonText: "PROCURAR",
				animation: "slide-from-top",
				inputPlaceholder: "Nome ou CPF do paciente",
				showLoaderOnConfirm: true,
			},
			function(inputValue){

				if (inputValue === "") {
					swal.showInputError("Você precisa informar o nome ou CPF do paciente");
					return false
				} else {
					$.post(URL_SISTEMA+"/api/ficha", {'acao': 'buscarAssociadoDependente', 'termo':inputValue}, function(retorno){
						let dados = retorno.dados
						if(dados.length == 1) {
							$('#nomePaciente').html(`<strong>${dados[0]['nome']}</strong>`)
							swal.close();
						} else if(dados.length > 1) {
							let pacientes = ''
							for(let i in dados) {
								pacientes += `<tr onclick="selecionarPaciente('${dados[i]['id_associado']}')">
												  <td class="text-truncate text-left"><a>${dados[i]['nome']}</a></td>
												  <td class="text-truncate p-1 text-left"><a>${dados[i]['cpf']}</a></td>
												</tr>`
							}
							swal({
							  title: "SELECIONE O PACIENTE",
							  showCancelButton: false,
							  showConfirmButton: false,
							  text: `
								<center>Clique no nome do paciente</center>
								<table class="table table-striped table-bordered table-responsive dataex-select-initialization">
								  <thead>
									<tr>
									  <th class="border-top-0">PACIENTE</th>
									  <th class="border-top-0">CPF</th>
									</tr>
								  </thead>
								  <tbody>
										${pacientes}						
								  </tbody>
								</table>`,
							  html: true
							});
						} else {
							swal.showInputError("Nenhum paciente foi encontrado!");
							return false
						}
					}, 'json');
				}

				
			});
		}, 1000);
	});
	
	function loadPaciente(inputValue){
		var nome = inputValue;
		$('#nomePaciente').html(`<strong>${nome}</strong>`)
				swal.close();
	}

	function selecionarPaciente(inputValue) {
		$.post(URL_SISTEMA+"/api/ficha", {'acao': 'buscarAssociadoDependenteID', 'termo':inputValue}, function(retorno){
			let dados = retorno.dados
			if(dados.length == 1) {
				$('#nomePaciente').html(`<strong>${dados[0]['nome']}</strong>`)
				swal.close();
			} else if(dados.length > 1) {
				let pacientes = ''
				for(let i in dados) {
					pacientes += `<tr onclick="loadPaciente('${dados[i]['nome']}')">
									  <td class="text-truncate text-left"><a>${dados[i]['nome']}</a></td>
									  <td class="text-truncate p-1 text-left"><a>${dados[i]['cpf']}</a></td>
									</tr>`
									}
				swal({
				  title: "SELECIONE O PACIENTE",
				  showCancelButton: false,
				  showConfirmButton: false,
				  text: `
					<center>Clique no nome do paciente</center>
					<table class="table table-striped table-bordered table-responsive dataex-select-initialization" style="width:100%;">
					  <thead>
						<tr>
						  <th class="border-top-0" style="width: 100% !important;">PACIENTE</th>
						  <th class="border-top-0">CPF</th>
						</tr>
					  </thead>
					  <tbody>
							${pacientes}						
					  </tbody>
					</table>`,
				  html: true
				});
			} else {
				swal.showInputError("Nenhum paciente foi encontrado!");
				return false
			}
		}, 'json');
	}
 </script>