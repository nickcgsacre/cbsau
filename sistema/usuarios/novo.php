<?php
if($_GET['tipo'] == 'internos') {
	$OPTS = array(
		"singular" => "interno",
		"plural" => "internos",
		"tipo" => 1,
	);
} else {
	$OPTS = array(
		"singular" => "externo",
		"plural" => "externos",
		"tipo" => 0,
	);
}

define("PAGINA", "NOVO FUNCIONÁRIO");
define("CSS", '
	<!-- BEGIN Page Level CSS-->
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/core/colors/palette-gradient.min.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/plugins/ui/jqueryui.css">
	<!-- END Page Level CSS-->');
define("JS", '
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="'.URL_SISTEMA.'/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js"
  type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/forms/extended/form-inputmask.min.js" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/navs/navs.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/jquery-ui/autocomplete.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/usuarios/novo.js"></script>
  <!-- END PAGE LEVEL JS-->
  ');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");
?>
  
  <script>
		const GET_TIPO = '<? $_GET['tipo'] ?>';
  </script>
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">NOVO FUNCIONÁRIO <?=strtoupper($OPTS['singular'])?></h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/usuarios/listar&tipo=<?=$_GET['tipo']?>&key=true">Funcionários</a>
                </li>
                <li class="breadcrumb-item active"> Novo Funcionário <?=ucfirst($OPTS['singular'])?>
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-550 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/usuarios/listar&tipo=<?=$_GET['tipo']?>&key=true" class="btn btn-icon btn-outline-danger"><i class="la la-close"></i> CANCELAR</a>
				  <a href="javascript:gravarForm('formNovo', 'salvar')" class="btn btn-icon btn-outline-primary ladda-button" data-style="zoom-in" id="btn-salvar">
					<i class="la la-save"></i> SALVAR
				  </a>
				  <a href="javascript:gravarForm('formNovo', 'novo')" class="btn btn-icon btn-outline-info ladda-button" data-style="zoom-in" id="btn-novo">
					<i class="la la-plus-circle"></i> SALVAR E NOVO
				  </a>
				  <a href="javascript:gravarForm('formNovo', 'concluir')" class="btn btn-icon btn-outline-success ladda-button"data-style="zoom-in" id="btn-concluir">
					<i class="la la-check-circle"></i> CONCLUÍR
				  </a>
				</div>
				
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
	


        <!-- Tabs with Icons start -->
        <section id="justified-tabs-with-icons">
		
          <div class="row match-height">
			<div class="col-xl-12 col-lg-12">
              <div class="card">
                <div class="card-content">
                  <div class="card-body">
				  
                    <div class="tab-content px-1 pt-1">
					
                      <div role="tabpanel" class="tab-pane active" id="empresa" aria-labelledby="empresa-tab1"
                      aria-expanded="true">
						<form id="formNovo" class="form" autocomplete="off">
						<input type="hidden" id="cod" name="id" value="" />
						<input type="hidden" id="acao" name="acao" value="novo" />
                        
						  <div class="form-body">
							<h4 class="form-section"><i class="ft-user"></i> Dados Pessoais</h4>
							<div class="row">
							  <div class="col-md-8">
								<div class="form-group">
								  <label for="nome">Nome*</label>
								  <input type="text" id="nome" class="form-control" required name="nome" autocomplete="off">
								</div>
							  </div>
							  <?php if($OPTS['tipo'] == 1) { ?>
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="cargo">Cargo*</label>
								  <select id="cargo" name="cargo" class="form-control">
									<option value="" selected="" disabled="">Selecione o cargo</option>
									<?php
									$CARGOS = listar("cargos", "status=1", "cargo ASC");
									foreach($CARGOS as $CARGO) {
										echo '<option value="'.$CARGO->id.'">'.$CARGO->cargo.'</option>';
									}
									?>
								  </select>
								</div>
							  </div>
							  <?php } else { ?>
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="cargo">Fornecedor*</label>
								  <select id="cargo" name="cargo" class="form-control">
									<option value="" selected="" disabled="">Selecione o fornecedor</option>
									<?php
									$CARGOS = listar("fornecedores", "status=1", "nome_fantasia ASC");
									foreach($CARGOS as $CARGO) {
										echo '<option value="'.$CARGO->cod_fornecedor.'">'.$CARGO->nome_fantasia.'</option>';
									}
									?>
								  </select>
								</div>
							  </div>
							  <?php } ?>
							</div>
							<div class="row">
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="email">E-mail</label>
								  <input type="text" id="email" class="form-control" name="email">
								</div>
							  </div>
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="telefone">Telefone</label>
								  <input type="text" id="telefone" class="form-control phone-inputmask" name="telefone">
								</div>
							  </div>
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="celular">Celular</label>
								  <input type="text" id="celular" class="form-control xphone-inputmask" name="celular">
								</div>
							  </div>
							</div>
							
							<h4 class="form-section"><i class="la la-key"></i> Dados de acesso</h4>
							<div class="row">
							
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="login">Login*</label>
								  <input type="text" id="login" class="form-control" name="login">
								</div>
							  </div>
							
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="senha">Senha*</label>
								  <input type="password" id="senha" class="form-control" name="senha">
								</div>
							  </div>
							
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="r_senha">Confirme a Senha*</label>
								  <input type="password" id="r_senha" class="form-control" name="r_senha">
								</div>
							  </div>
							  
							</div>
							
						  </div>
						  <div class="form-actions">
							<button type="button" class="btn btn-success ladda-button" data-style="zoom-in" onclick="gravarForm('formNovo', 'salvar1')" id="btn-salvar1">
							  <i class="la la-save"></i> SALVAR
							</button>
						  </div>
							
						<input type="hidden" id="tipo" name="tipo" value="<?=$OPTS['tipo']?>" />
						</form>
                      </div>
					  
                      
					</div>
					
					
                  </div>
                </div>
              </div>
            </div>
            
		  </div>
        </section>
        <!-- Tabs with Icons end -->
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  
<?php include_once(__DIR__."/../footer.php"); ?>
