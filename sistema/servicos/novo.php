<?php
define("PAGINA", "NOVO SERVIÇO");
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
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/servicos/novo.js"></script>
  <!-- END PAGE LEVEL JS-->
  ');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");


$CATEGORIAS = listar("servicos_categorias", "status='1'");
?>
  
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">NOVO SERVIÇOS</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/servicos/listar">Serviços</a>
                </li>
                <li class="breadcrumb-item active"> Novo Serviço
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-550 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/servicos/listar" class="btn btn-icon btn-outline-danger"><i class="la la-close"></i> CANCELAR</a>
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
							<div class="row">
							
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="cod">Cod.</label>
								  <input type="text" id="cod" class="form-control" required name="cod" autocomplete="off">
								</div>
							  </div>
							  
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="categoria">
									Categoria
									<a href="#" data-toggle="modal" data-target="#novaCategoria" class="badge badge-success text-right">Add Categoria</a>
								  </label>
								  <select id="categoria" name="categoria" class="form-control select2">
									<option value="" id="addDCat" selected="" disabled="">Selecione uma categoria</option>
									<?php
									foreach($CATEGORIAS as $CATEGORIA) {
										echo '<option value="'.$CATEGORIA->id_sc.'" >'.$CATEGORIA->categoria.'</option>';
									}
									?>
								  </select>
								</div>
							  </div>
							  
							  <div class="col-md-7">
								<div class="form-group">
								  <label for="servico">Serviço</label>
								  <input type="text" id="servico" class="form-control" required name="servico" autocomplete="off">
								</div>
							  </div>
							  
							  <div class="col-md-12">
								<div class="form-group">
								  <label for="descricao">Descrição</label>
								  <input type="text" id="descricao" class="form-control" required name="descricao" autocomplete="off">
								</div>
							  </div>
							  
							  
							</div>
						  </div>
						  <div class="form-actions">
							<button type="button" class="btn btn-success ladda-button" data-style="zoom-in" onclick="gravarForm('formNovo', 'salvar1')" id="btn-salvar1">
							  <i class="la la-save"></i> SALVAR
							</button>
						  </div>
						
						</form>
                      </div>
					  
                      
					</div>
					
					
                  </div>
                </div>
              </div>
            </div>
            
		  </div>
        </section>
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  
  
	<!-- NOVA CATEGORIA -->
	<div class="modal fade text-left" id="novaCategoria" tabindex="-1" role="dialog" aria-labelledby="novaCategoria"
	  aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header bg-success white">
			  <h4 class="modal-title white"><i class="fa fa-plus-square"></i> Nova Categoria</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<form action="#" id="formCategoria">
			  <input type="hidden" name="acao" value="novaCategoria"/>
			  <input type="hidden" name="id" value=""/>
			  <div class="modal-body">
				<label>Categoria</label>
				<div class="form-group">
				  <input type="text" id="cat-categoria" name="categoria" class="form-control">
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="submit" id="btn-addCat" class="btn btn-outline-success ladda-button" data-style="zoom-in">
					<i class="fa fa-save"></i> ADD CATEGORIA
				</button>
			  </div>
			</form>
		  </div>
		</div>
	</div>


  
  
<?php include_once(__DIR__."/../footer.php"); ?>
