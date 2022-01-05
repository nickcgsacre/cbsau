<?php
$L_CATEGORIAS = listar("despesas_categorias");
$CATEGORIA = [];

foreach($L_CATEGORIAS as $DADOS) {
	$CATEGORIA[$DADOS->id_cat] = $DADOS;
}

?>


					<table class="table table-striped table-bordered sourced-data" id="listar">
                      <thead>
                        <tr>
                          <th>Documento</th>
                          <th>Categoria</th>
                          <th>Fornecedor</th>
                          <th>Valor</th>
                          <th>Vencimento</th>
                          <th>Status</th>
                          <th>Ações</th>
                        </tr>
                      </thead>
					  <tbody>	
						<?php
						$hoje = date('Y-m-d');
						if($_POST['acao'] == 'busca') {
							$query = [];
							$query[] = "tipo='0'";
							
							if(($_POST['inicio'] or $_POST['final']) and $_POST['parametro']) {
								
								$_POST['inicio'] = date(implode("-", array_reverse(explode("/", $_POST['inicio']))));
								$_POST['final'] = date(implode("-", array_reverse(explode("/", $_POST['final']))));
								
								if($_POST['inicio'] > $_POST['final']) {
									$INVETER = $_POST['final'];
									$_POST['final'] = $_POST['inicio'];
									$_POST['inicio'] = $INVETER;
								}
								
								if($_POST['final']) {
									$query[] = $_POST['parametro'].">='".$_POST['inicio']."' AND ".$_POST['parametro']."<='".$_POST['final']."'";
								}
							}
							
							if($_POST['status']) {
								if($_POST['status'] != 'all') {
									$query[] = "status='".$_POST['status']."'";
								}
							}
							
							if($_POST['categoria']) {
								if($_POST['categoria'] != 'all') {
									$query[] = "categoria='".$_POST['categoria']."'";
								}
							}
							
							if($query) {
								$query = implode(" AND ", $query);
							} else {
								$query = "";
							}
							
							if($_POST['parametro']) {
								$order = $_POST['parametro']." ASC";
							} else {
								$order = "vencimento ASC";
							}
							
							$LISTAR = listar("despesas", $query, $order);
						} else {
							$LISTAR = listar("despesas", "tipo='0' AND status='2'", "vencimento ASC");
						}
						
						foreach($LISTAR as $ITEM) {
							$FORNECEDOR = buscar("fornecedores", "cod_fornecedor='".$ITEM->fornecedor."'");
						?>
                        <tr id="Iten-<?=$ITEM->id?>">
                          <td><?=($ITEM->documento) ? $ITEM->documento : "NÃO INFORMADO";?></td>
                          <td><?=($ITEM->categoria) ? $CATEGORIA[$ITEM->categoria]->categoria : "NÃO CATEGORIZADO";?></td>
                          <td><?=($ITEM->fornecedor) ? $FORNECEDOR->nome_fantasia : "NÃO INFORMADO";?></td>
                          <td><?=($ITEM->valor) ? "R$ ".number_format($ITEM->valor,2,",",".") : "N/A";?></td>
                          <td><?=($ITEM->vencimento) ? strftime("%d/%m/%Y", strtotime( $ITEM->vencimento )) : "N/A";?></td>
                          <td><?php if($ITEM->status == 1) {
							  echo '<span class="notification-tag badge badge-default badge-success float-right m-0">LIQUIDADA</span>';
						  } else if ($ITEM->status == 2){ 
							if($ITEM->vencimento == $hoje) {
								echo '<span class="notification-tag badge badge-default badge-warging float-right m-0">VENCENDO</span>';
							} else if($ITEM->vencimento < $hoje) {
								echo '<span class="notification-tag badge badge-default badge-danger float-right m-0">EM ATRASO</span>';
							} else {
								echo '<span class="notification-tag badge badge-default badge-info float-right m-0">NÃO PAGO</span>';
							}
						  } else {
							  echo '<span class="notification-tag badge badge-default badge-danger float-right m-0">CANCELADA</span>';
						  }?></td>
                          <td>
							<?php if($ITEM->status == 2) { ?>
							<button type="button" onclick="financeiro.cancelar(<?=$ITEM->id?>)" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-times-rectangle-o"></i>
							</button>
							<a href="javascript:financeiro.liquidar(<?=$ITEM->id?>)" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-check-square-o"></i>
							</a>
							<?php } ?>
							<?php if($ITEM->comprovante) { ?>
							<a href="javascript:financeiro.comprovante(<?=$ITEM->id?>)" class="btn btn-outline-info mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-ticket"></i>
							</a>
							<?php } ?>
							<?php if($ITEM->boleto) { ?>
							<a href="<?=URL_SISTEMA?>/arquivos/despesas/<?=$ITEM->boleto?>" target="_new" class="btn btn-outline-info mr-1 float-right ladda-button" data-style="zoom-in">
								<i class="fa fa-barcode"></i>
							</a>
							<?php } ?>
						  </td>
                        </tr>
						<?php } ?>
					  </tbody>
                      <tfoot>
                        <tr>
                          <th>Documento</th>
                          <th>Fornecedor</th>
                          <th>Valor</th>
                          <th>Vencimento</th>
                          <th>Status</th>
                          <th>Ações</th>
                        </tr>
                      </tfoot>
                    </table>
                  