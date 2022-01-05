<?php
define("PAGINA", "LISTAR SERVIÇOS");
define("CSS", '
<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/vendors/css/tables/datatable/datatables.min.css">');
define("JS", '
  <!-- BEGIN PAGE VENDOR JS-->
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/tables/datatables-extensions/datatables-sources.js"
  type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/servicos/listar.js"></script>
  <!-- END PAGE VENDOR JS-->
  ');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");

$CATEGORIAS = listar("servicos_categorias", "status=1", "categoria ASC");
foreach($CATEGORIAS as $CATEGORIA) {
	$B_CAT[$CATEGORIA->id_sc] = $CATEGORIA;
}
?>
  
  <!-- END VENDOR CSS-->


  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">LISTAR SERVIÇOS</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Serviços
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-500 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <button type="button" class="btn btn-icon btn-outline-danger" onclick="removerEmMassa()"><i class="la la-trash"></i> EXCLUÍR SELECIONADOS</button>
				  <a href="<?=URL_SISTEMA?>/servicos/novo" class="btn btn-icon btn-outline-primary"><i class="la la-plus"></i> NOVO SERVIÇO</a>
				</div>
			  
			  
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
	  
	  
        <section id="ajax">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Listar serviços</h4>
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
                          <th>COD</th>
                          <th>CATEGORIA</th>
                          <th>SERVIÇO</th>
                          <th>AÇÕES</th>
                        </tr>
                      </thead>
					  <tbody>	
						<?php						
						$LISTAR = listar("servicos", "", "servico ASC");
						foreach($LISTAR as $ITEM) {
						?>
                        <tr id="Iten-<?=$ITEM->id_servico?>">
                          <td><input type="checkbox" class="largerCheckbox" id="itens" name="itens[]" value="<?=$ITEM->id_servico?>" /></td>
                          <td><?=$ITEM->cod?></td>
                          <td><?=$B_CAT[$ITEM->id_cat]->categoria?></td>
                          <td><?=$ITEM->servico?></td>
                          <td>
							<button type="button" onclick="remover(<?=$ITEM->id_servico?>)" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="la la-trash"></i>
							</button>
							<a href="<?=URL_SISTEMA?>/servicos/editar&id=<?=$ITEM->id_servico?>&key=true" class="btn btn-outline-info mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="la la-edit"></i>
							</a>
						  </td>
                        </tr>
						<?php } ?>
					  </tbody>
                      <tfoot>
                        <tr>
                          <th><input type="checkbox" class="largerCheckbox MarcarTodos" /></th>
                          <th>COD</th>
                          <th>CATEGORIA</th>
                          <th>SERVIÇO</th>
                          <th>AÇÕES</th>
                        </tr>
                      </tfoot>
                    </table>
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
 
 
  
<?php include_once(__DIR__."/../footer.php"); ?>