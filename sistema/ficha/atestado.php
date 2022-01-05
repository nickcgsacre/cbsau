<?php
define("PAGINA", "ATESTADO MÉDICO");
define("CSS", '');
define("JS", '');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");

?>

  
  <!-- END VENDOR CSS-->


  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">ATESTADO MÉDICO</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Atestado Médico
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
							<h4 class="card-title"><i class="fa fa-search"></i> PROCURAR O PACIENTE</h4>
						  </div>
						  <div class="card-content">
							<div class="card-body p1">
							  <ul class="nav nav-tabs nav-underline no-hover-bg">
								<li class="nav-item">
								  <a class="nav-link active" id="base-associado" data-toggle="tab" aria-controls="associado" href="#associado" aria-expanded="true">ASSOCIADO</a>
								</li>
								<li class="nav-item">
								  <a class="nav-link" id="base-dependente" data-toggle="tab" aria-controls="dependente" href="#dependente" aria-expanded="false">DEPENDENTE</a>
								</li>
							  </ul>
							  <div class="tab-content px-1 pt-1">
								<div role="tabpanel" class="tab-pane active" id="associado" aria-expanded="true" aria-labelledby="base-associado">
								  <div class="row">
									<div class="col-12 border-right-blue-grey border-right-lighten-4 pr-2 p-0">
									  
									  <form class="form form-horizontal" id="b1" onsubmit="atestado.procurar(this); return false;">
										  <input type="hidden" name="acao" value="associado" />
									  
										  <div class="row">
											<div class="col-8">
											  <fieldset class="form-group position-relative">
												<input type="text" class="form-control form-control-xl input-xl" name="termo" placeholder="Digite o nome, CPF ou o código do associado">
												<div class="form-control-position">
												  <i class="ft-mic font-medium-4"></i>
												</div>
											  </fieldset>
											</div>
											<div class="col-4">
											  <fieldset class="form-group position-relative">
												<select class="form-control form-control-xl input-xl" name="opts">
													<option value="">Selecione uma opção</option>
													<option value="1">Atendido(a)</option>
													<option value="2">Medicado(a)</option>
													<option value="0">Atendido(a) & Medicado(a)</option>
											    </select>
											  </fieldset>
											</div>
											<div class="col-8">
											  <fieldset class="form-group position-relative">
												<input type="text" class="form-control form-control-xl input-xl" name="motivo" placeholder="Motivo do afastamento">
											  </fieldset>
											</div>
											<div class="col-4">
											  <fieldset class="form-group">
												<input type="number" class="form-control form-control-xl input-xl" name="dias" placeholder="Dias de afastamento">
											  </fieldset>
											</div>
											<div class="col-12">
											  <fieldset class="form-group">
												<input type="text" class="form-control form-control-xl input-xl" name="clinica" placeholder="Nome da clínica">
											  </fieldset>
											</div>
										  </div>
										  <div class="row">
											<div class="col-12 text-center">
											  <button type="submit" class="btn btn-primary btn-block btn-md">
												<i class="fa fa-stethoscope"></i>  GERAR ATESTADO MÉDICO
											  </button>
											</div>
										  </div>
									  
									  </form>
									</div>
									
								  </div>
								
								</div>
								
								
								<div class="tab-pane" id="dependente" aria-labelledby="base-dependente">
								  <div class="row">
									<div class="col-12 border-right-blue-grey border-right-lighten-4 pr-2 p-0">
									  
									  <form class="form form-horizontal" id="b2" onsubmit="atestado.procurar(); return false;">
										  <input type="hidden" name="acao" value="dependente" />
										  <div class="row">
											<div class="col-8">
											  <fieldset class="form-group position-relative">
												<input type="text" class="form-control form-control-xl input-xl" name="termo" placeholder="Digite o nome ou CPF do dependente">
												<div class="form-control-position">
												  <i class="ft-mic font-medium-4"></i>
												</div>
											  </fieldset>
											</div>
											<div class="col-4">
											  <fieldset class="form-group position-relative">
												<select class="form-control form-control-xl input-xl" name="opts">
													<option value="">Selecione uma opção</option>
													<option value="1">Atendido(a)</option>
													<option value="2">Medicado(a)</option>
													<option value="0">Atendido(a) & Medicado(a)</option>
											    </select>
											  </fieldset>
											</div>
											<div class="col-8">
											  <fieldset class="form-group position-relative">
												<input type="text" class="form-control form-control-xl input-xl" name="motivo" placeholder="Motivo do afastamento">
											  </fieldset>
											</div>
											<div class="col-4">
											  <fieldset class="form-group">
												<input type="number" class="form-control form-control-xl input-xl" name="dias" placeholder="Dias de afastamento">
											  </fieldset>
											</div>
											<div class="col-12">
											  <fieldset class="form-group">
												<input type="text" class="form-control form-control-xl input-xl" name="clinica" placeholder="Nome da clínica">
											  </fieldset>
											</div>
										  </div>
										  <div class="row">
											<div class="col-12 text-center">
											  <button type="submit" class="btn btn-primary btn-block btn-md">
												<i class="fa fa-stethoscope"></i>  GERAR ATESTADO MÉDICO
											  </button>
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