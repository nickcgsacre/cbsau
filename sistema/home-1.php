<?php
define("PAGINA", "DASHBOARD");
define("CSS", "");
define("JS", '');

include_once(__DIR__."/header.php");
include_once(__DIR__."/menu.php");
if($DADOS_USUARIO->tipo == 1) {
	$GUIAS = listar("guias", NULL, "data_emissao DESC LIMIT 5");
} else {
	$GUIAS = listar("guias", "fornecedor='".$DADOS_USUARIO->cargo."' AND status='1'", "data_emissao DESC");
}
?>
  
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
	  
        <div class="row">
		
			<div class="col-xl-5 col-lg-12">
				<div class="card" style="height: 560px; zoom: 1;">
				  <div class="card-header">
					<h4 class="card-title">Últimas guias</h4>
					<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
					<div class="heading-elements">
					  <ul class="list-inline mb-0">
						<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
					  </ul>
					</div>
				  </div>
				  <div class="card-content">
					<div class="card-body">
						<div id="new-orders" class="vertical-scroll scroll-example height-500 ps ps--active-y">
							  <div class="table-responsive">
								<table id="new-orders-table" class="table table-hover table-xl mb-0">
								  <thead>
									<tr>
									  <th class="border-top-0">Nº Guia</th>
									  <th class="border-top-0">Associado</th>
									  <th class="border-top-0"></th>
									</tr>
								  </thead>
								  <tbody>
									
									<?php foreach($GUIAS as $GUIA) { ?>
									<tr>
									  <td class="text-truncate"><?=str_pad($GUIA->id_guia, 6, 0, STR_PAD_LEFT)?></td>
									  <td class="text-truncate p-1"><?=($GUIA->associado == 0)? buscar("associados", "id_associado='".$GUIA->titular."'")->nome : buscar("dependentes", "id_dependente='".$GUIA->dependente."'")->nome ?></td>
									  <td class="text-truncate"><a href="javascript:gerarGuia(<?=$GUIA->id_guia?>)">
										<button type="button" class="btn btn-outline-info mr-1"><i class="la la-print"></i></button>
									  </td>
									</tr>
									<?php } ?>
									
								  </tbody>
								</table>
							  </div>
						</div>
					</div>
				  </div>
				</div>
			  </div>
		
		
			<div class="col-12 col-xl-7">
				<div class="row">
					<div class="col-12">
					
						<div class="card">
						  <div class="card-header">
							<h4 class="card-title"><i class="fa fa-search"></i> BUSCAR</h4>
						  </div>
						  <div class="card-content">
							<div class="card-body">
							  <ul class="nav nav-tabs nav-underline no-hover-bg">
								<li class="nav-item">
								  <a class="nav-link active" id="base-associado" data-toggle="tab" aria-controls="associado" href="#associado" aria-expanded="true">ASSOCIADO</a>
								</li>
								<li class="nav-item">
								  <a class="nav-link" id="base-dependente" data-toggle="tab" aria-controls="dependente" href="#dependente" aria-expanded="false">DEPENDENTE</a>
								</li>
								<?php if($DADOS_USUARIO->tipo == 1) { ?>
								<li class="nav-item">
								  <a class="nav-link" id="base-fornecedor" data-toggle="tab" aria-controls="fornecedor" href="#fornecedor" aria-expanded="false">FORNECEDOR</a>
								</li>
								<?php } ?>
								<li class="nav-item">
								  <a class="nav-link" id="base-guia" data-toggle="tab" aria-controls="guia" href="#guia" aria-expanded="false">GUIA DE ENCAMINHAMENTO</a>
								</li>
							  </ul>
							  <div class="tab-content px-1 pt-1">
								<div role="tabpanel" class="tab-pane active" id="associado" aria-expanded="true" aria-labelledby="base-associado">
								  <div class="row">
									<div class="col-12 border-right-blue-grey border-right-lighten-4 pr-2 p-0">
									  
										  <fieldset class="form-group position-relative">
											<input type="text" class="form-control form-control-xl input-xl" id="iconLeft1" placeholder="Digite o nome ou o código do associado">
											<div class="form-control-position">
											  <i class="ft-mic font-medium-4"></i>
											</div>
										  </fieldset>
										  <div class="row py-2">
											<div class="col-12 text-center">
											  <button onclick="busca_associado();" class="btn btn-primary btn-md"><i class="ft-search"></i>  PROCURAR ASSOCIADO</button>
											</div>
										  </div>
									  </div>

									<div id="retorno_search"></div>
									
										<script>
										function busca_associado(){
											var associado = document.getElementById('iconLeft1').value;
											if(associado!=''){
											  //document.getElementById('retorno_search').innerHTML = associado;
											  $.ajax({
          									  method: "POST",
           									  url: URL_SISTEMA+"/sistema/api/ficha",
            								  data: {associado:associado, acao:'consultar'}, 
											  success: function(data){
												  console.log(data.resposta);
												let dados = JSON.parse(data);
												document.getElementById('retorno_search').innerHTML = dados['resposta'];
   											  }
        										});
											}
										}
										</script>
								  </div>
								
								</div>
								
								
								<div class="tab-pane" id="dependente" aria-labelledby="base-dependente">
								  <div class="row">
									<div class="col-12 border-right-blue-grey border-right-lighten-4 pr-2 p-0">
									  
									  <form class="form form-horizontal">
									  
										  <fieldset class="form-group position-relative">
											<input type="text" class="form-control form-control-xl input-xl" id="iconLeft1" placeholder="Digite o nome ou o CPF do dependente">
											<div class="form-control-position">
											  <i class="ft-mic font-medium-4"></i>
											</div>
										  </fieldset>
										  <div class="row py-2">
											<div class="col-12 text-center">
											  <a href="search-website.html" class="btn btn-primary btn-md"><i class="ft-search"></i>  PROCURAR DEPENDENTE</a>
											</div>
										  </div>
									  
									  </form>
									</div>
									
								  </div>
								
								</div>
								
								<div class="tab-pane" id="fornecedor" aria-labelledby="base-fornecedor">
								  <div class="row">
									<div class="col-12 border-right-blue-grey border-right-lighten-4 pr-2 p-0">
									  
									  <form class="form form-horizontal">
									  
										  <fieldset class="form-group position-relative">
											<input type="text" class="form-control form-control-xl input-xl" id="iconLeft1" placeholder="Digite o nome ou o CPF/CNPJ do fornecedor">
											<div class="form-control-position">
											  <i class="ft-mic font-medium-4"></i>
											</div>
										  </fieldset>
										  <div class="row py-2">
											<div class="col-12 text-center">
											  <a href="search-website.html" class="btn btn-primary btn-md"><i class="ft-search"></i>  PROCURAR FORNECEDOR</a>
											</div>
										  </div>
									  
									  </form>
									</div>
									
								  </div>
								
								</div>
								
								<div class="tab-pane" id="guia" aria-labelledby="base-guia">
								  <div class="row">
									<div class="col-12 border-right-blue-grey border-right-lighten-4 pr-2 p-0">
									  
									  <form class="form form-horizontal">
									  
										  <fieldset class="form-group position-relative">
											<input type="text" class="form-control form-control-xl input-xl" id="iconLeft1" placeholder="Digite o nome do titular ou o nº da guia">
											<div class="form-control-position">
											  <i class="ft-mic font-medium-4"></i>
											</div>
										  </fieldset>
										  <div class="row py-2">
											<div class="col-12 text-center">
											  <a href="search-website.html" class="btn btn-primary btn-md"><i class="ft-search"></i>  PROCURAR GUIA DE ENCAMINHAMENTO</a>
											</div>
										  </div>
									  
									  </form>
									</div>
									
								  </div>
								
								</div>
							  
							  </div>
							</div>
						  </div>
						</div>
					
					</div>
				</div>
				
				<div class="row">
					<?php if($DADOS_USUARIO->tipo == 1) { ?>
				  <div class="col-lg-4 col-12">
					<div class="card pull-up">
					  <div class="card-content">
						<div class="card-body">
						  <div class="media d-flex">
							<div class="media-body text-left">
							  <h6 class="text-muted">Associados </h6>
							  <h3><?=intval(contarQueryes("associados", "status=1"))?></h3>
							</div>
							<div class="align-self-center">
							  <i class="fa fa-users success font-large-2 float-right"></i>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
					<?php } ?>
					<?php if($DADOS_USUARIO->tipo == 1) { ?>
				  <div class="col-lg-4 col-12">
					<div class="card pull-up">
					  <div class="card-content">
						<div class="card-body">
						  <div class="media d-flex">
							<div class="media-body text-left">
							  <h6 class="text-muted">Dependentes </h6>
							  <h3><?=intval(contarQueryes("dependentes", "status=1"))?></h3>
							</div>
							<div class="align-self-center">
							  <i class="icon-users info font-large-2 float-right"></i>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
					<?php } ?>
					<?php if($DADOS_USUARIO->tipo == 1) { ?>
				  <div class="col-lg-4 col-12">
					<div class="card pull-up">
					  <div class="card-content">
						<div class="card-body">
						  <div class="media d-flex">
							<div class="media-body text-left">
							  <h6 class="text-muted">Guias</h6>
							  <h3><?=intval(contarQueryes("guias"))?></h3>
							</div>
							<div class="align-self-center">
							  <i class="icon-docs warning font-large-2 float-right"></i>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
					<?php } ?>
				  <div class="col-lg-4 col-12">
					<a href="<?=URL_SISTEMA?>/ficha/listar" class="card pull-up">
					  <div class="card-content">
						<div class="card-body">
						  <div class="media d-flex">
							<div class="media-body text-left">
							  <h6 class="text-muted">Fichas Médicas</h6>
							  <h3>--</h3>
							</div>
							<div class="align-self-center">
							  <i class="icon-docs info font-large-2 float-right"></i>
							</div>
						  </div>
						</div>
					  </div>
					</a>
				  </div>
				  <div class="col-lg-4 col-12">
					<a href="<?=URL_SISTEMA?>/ficha/atestado" class="card pull-up">
					  <div class="card-content">
						<div class="card-body">
						  <div class="media d-flex">
							<div class="media-body text-left">
							  <h6 class="text-muted">Atestado Médico</h6>
							  <h3>--</h3>
							</div>
							<div class="align-self-center">
							  <i class="icon-docs info font-large-2 float-right"></i>
							</div>
						  </div>
						</div>
					  </div>
					</a>
				  </div>
				  <div class="col-lg-4 col-12">
					<a href="<?=URL_SISTEMA?>/ficha/receituario" class="card pull-up">
					  <div class="card-content">
						<div class="card-body">
						  <div class="media d-flex">
							<div class="media-body text-left">
							  <h6 class="text-muted">Recetuário Médico</h6>
							  <h3>--</h3>
							</div>
							<div class="align-self-center">
							  <i class="icon-docs info font-large-2 float-right"></i>
							</div>
						  </div>
						</div>
					  </div>
					</a>
				  </div>
				</div>
				
			</div>
		
		</div>
		
      </div>
    </div>
  </div>
<?php include_once(__DIR__."/footer.php"); ?>