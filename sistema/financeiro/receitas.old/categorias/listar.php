<?php
define("PAGINA", "EXTRATO FINANCEIRO | CATEGORIA DE DESPESAS");
define("CSS", '
<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/vendors/css/tables/datatable/datatables.min.css">');
define("JS", '
  <!-- BEGIN PAGE VENDOR JS-->
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js?v=1.0.1"
  type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/financeiro/despesas/categorias/listar.js"></script>
  <!-- END PAGE VENDOR JS-->');
include_once(__DIR__."/../../../header.php");
include_once(__DIR__."/../../../menu.php");

?>

  
  <!-- END VENDOR CSS-->


  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">CATEGORIAS DE DEPESAS</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Extrato Financeiro
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/financeiro/despesas/listar">Despesas</a>
                <li class="breadcrumb-item active">Categorias
                </li>
              </ol>
            </div>
          </div>
        </div>
		
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-500 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/financeiro/despesas/listar" class="btn btn-icon btn-outline-info"><i class="la la-list"></i> DESPESAS</a>
				  <a href="<?=URL_SISTEMA?>/financeiro/despesas/novo" class="btn btn-icon btn-outline-success"><i class="la la-plus"></i> NOVA DESPESAS</a>
				  <a href="javascript:nova.categoria()" class="btn btn-icon btn-outline-primary"><i class="la la-plus"></i> NOVA CATEGORIA</a>
				</div>
			  
			  
            </div>
          </div>
        </div> 
		
      </div>
      <div class="content-body">
	  
        <!-- Ajax sourced data -->
        <section id="ajax">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Listar categorias</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collpase show">
                  <div class="card-body card-dashboard">
					<table class="table table-striped table-bordered sourced-data" id="listar">
                      <thead>
                        <tr>
                          <th><input type="checkbox" class="largerCheckbox MarcarTodos" /></th>
                          <th>ID</th>
                          <th>Categoria</th>
                          <th>Ações</th>
                        </tr>
                      </thead>
					  <tbody>	
                        <tr id="Iten-0">
                          <td><input type="checkbox" class="largerCheckbox" id="itens" name="itens[]" value="0" /></td>
                          <td>0</td>
                          <td>Não categorizada</td>
                          <td>
						  </td>
                        </tr>
						<?php						
						$LISTAR = listar("despesas_categorias", "status='1'", "categoria ASC");
						foreach($LISTAR as $ITEM) {
						?>
                        <tr id="Iten-<?=$ITEM->id_cat?>">
                          <td><input type="checkbox" class="largerCheckbox" id="itens" name="itens[]" value="<?=$ITEM->id_cat?>" /></td>
                          <td><?=$ITEM->id_cat?></td>
                          <td><?=($ITEM->categoria) ? $ITEM->categoria : "Não Informada";?></td>
                          <td>
							<button type="button" onclick="remover(<?=$ITEM->id_cat?>)" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="la la-trash"></i>
							</button>
							<a href="javascript:nova.editar(<?=$ITEM->id_cat?>, '<?=$ITEM->categoria?>')" class="btn btn-outline-info mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="la la-edit"></i>
							</a>
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
        </section>
        <!--/ Ajax sourced data -->
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
 
  
<?php include_once(__DIR__."/../../../footer.php"); ?>