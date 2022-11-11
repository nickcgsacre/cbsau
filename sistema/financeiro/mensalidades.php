<?php
define("PAGINA", "EXTRATO FINANCEIRO | MENSALIDADES");
define("CSS", '');
define("JS", '');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");

$associados = listar('associados', "status='1' order by nome");

?>
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">EXTRATO FINANCEIRO</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Extrato Financeiro
                </li>
                <li class="breadcrumb-item active">Mensalidades
                </li>
              </ol>
            </div>
          </div>
        </div>
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
							<h4 class="card-title"><i class="fa fa-search"></i> GERAR EXTRATO</h4>
						  </div>
						  <div class="card-content">
							<div class="card-body">
							 
							 
								<div class="row">
									<div class="col-12">
									  
									  <form class="form form-horizontal" id="b1" onsubmit="extrato.mensalidades(this, event)">
										  <input type="hidden" name="acao" value="mensalidades" />
									  
										  <div class="row">
											<div class="col-4 mr-2">
												<fieldset class="form-group">
													<label for="">Associado</label>
													<select class="form-control form-control-xl select2 input-xl" id="selecionaAssociado" name="associado">
														<option value="">Selecione um associado</option>
														<?php foreach($associados as $associado) { ?> 
															<option value="<?=$associado->id_associado?>"><?=$associado->nome?></option>
														<?php } ?>
													</select>
												</fieldset>
											</div>
											<div class="col-2 mr-2">
											  <fieldset class="form-group">
												<label for="">Ano</label>
												<select class="form-control form-control-xl select2 input-xl" multiple id="selecionaAno" name="ano[]">
													<option value="">Selecione o ano</option>
													<?php for($i= date('Y'); $i >= date('Y') - 5;$i--) { ?>
													<option value="<?=$i?>"><?=$i?></option>
													<?php } ?>
											    </select>
											  </fieldset>
											</div>
											<div class="col-2 mr-2">
											  <fieldset class="form-group">
												<label for="">Mês</label>
												<select class="form-control form-control-xl select2 input-xl" placeholder="Mês" multiple id="selecionaMes" name="mes[]">
													<option value="">Selecione um mês</option>
													<option value="1">Janeiro</option>
													<option value="2">Fevereiro</option>
													<option value="3">Março</option>
													<option value="4">Abril</option>
													<option value="5">Maio</option>
													<option value="6">Junho</option>
													<option value="7">Julho</option>
													<option value="8">Agosto</option>
													<option value="9">Setembro</option>
													<option value="10">Outubro</option>
													<option value="11">Novembro</option>
													<option value="12">Dezembro</option>
											    </select>
											  </fieldset>
											</div>
											<div class="col-1 text-center">
											  <button type="submit" class="btn btn-primary mt-2">
												<i class="fa fa-magic"></i>  GERAR EXTRATO
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
 
 
<!-- <script>
	$(document).ready(function() {
		alert('funciona');
	});
</script> -->
  
<?php include_once(__DIR__."/../footer.php"); ?>