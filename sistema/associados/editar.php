<?php
define("PAGINA", "EDITAR ASSOCIADO");
define("CSS", '
	<!-- BEGIN Page Level CSS-->
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/core/colors/palette-gradient.min.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/css/plugins/ui/jqueryui.css">
	<link rel="stylesheet" type="text/css" href="'.URL_SISTEMA.'/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
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
  <script src="'.URL_SISTEMA.'/app-assets/js/sistema/cidade.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/navs/navs.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/jquery-ui/autocomplete.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script type="text/javascript" src="'.URL_SISTEMA.'/sistema/associados/novo.js"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js"
  type="text/javascript"></script>
  <script src="'.URL_SISTEMA.'/app-assets/js/scripts/pages/invoices-list.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
  ');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");

$DADOS = buscar("associados", "id_associado='".$_GET['id']."'");
$PARENTESCOS = listar("parentesco", "status=1", "parentesco ASC");
$PLANOS = listar("planos", "status=1", "mensalidade ASC");
$L_DEPENDENTES = listar("dependentes", "id_associado='".$DADOS->id_associado."' AND status=1", "nome ASC");
$GUIAS = listar("guias as g LEFT JOIN associados as a ON a.id_associado=g.titular LEFT JOIN fornecedores as f on f.cod_fornecedor=g.fornecedor LEFT JOIN guias as gu ON gu.id_guia=g.id_guia", "g.titular='".$DADOS->id_associado."' AND g.fornecedor!='-1'", "g.data_emissao DESC");
$HOJE = date('Y-m-d');

foreach($PARENTESCOS as $PARENTESCO) {
	$B_PARENTESCO[$PARENTESCO->id_parentesco] = $PARENTESCO;
}

foreach($L_DEPENDENTES as $DEPENDENTE) {
	$DEPENDENTES[$DEPENDENTE->id_dependente] = $DEPENDENTE;
}

foreach($PLANOS as $PLANO) {
	$B_PLANO[$PLANO->id_plano] = $PLANO;
}
?>
  
  

  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">EDITAR ASSOCIADO</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>/associados/listar">Associados</a>
                </li>
                <li class="breadcrumb-item active"> Editar Associado
                </li>
              </ol>
            </div>
          </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-550 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <a href="<?=URL_SISTEMA?>/associados/listar" class="btn btn-icon btn-outline-danger"><i class="la la-close"></i> CANCELAR</a>
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
                    <ul class="nav nav-tabs nav-linetriangle nav-justified">
                      <li class="nav-item">
                        <a class="nav-link active" id="pessoal-tab1" data-toggle="tab" href="#pessoal"
                        aria-controls="pessoal" aria-expanded="true"><i class="fa fa-user"></i> Dados Pessoais</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="dependentes-tab1" data-toggle="tab" href="#dependentes" aria-controls="dependentes"
                        aria-expanded="false"><i class="fa fa-users"></i> Dependentes</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="documentos-tab1" data-toggle="tab" href="#ordens" aria-controls="documentos"
                        aria-expanded="false"><i class="fa fa-file-text"></i> Ordem de Serviços</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="guias-tab1" data-toggle="tab" href="#guias" aria-controls="guias"
                        aria-expanded="false"><i class="fa fa-file"></i> Guias</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="extrato-tab1" data-toggle="tab" href="#extrato" aria-controls="extrato"
                        aria-expanded="false"><i class="fa fa-ticket"></i> Extrato Financeiro</a>
                      </li>
                    </ul>
					
                    <div class="tab-content px-1 pt-1">
					
                      <div role="tabpanel" class="tab-pane active" id="pessoal" aria-labelledby="pessoal-tab1"
                      aria-expanded="true">
						<form id="formNovo" class="form" autocomplete="off">
						<input type="hidden" id="cod" name="id" value="<?=$DADOS->id_associado?>" />
						<input type="hidden" id="acao" name="acao" value="editar" />
                        
						  <div class="form-body">
							<div class="row">
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="matricula">Nº Matrícula*</label>
								  <input type="text" id="matricula" class="form-control" value="<?=$DADOS->matricula?>" required name="matricula" autocomplete="off">
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="sexo">Sexo</label>
								  <select id="sexo" name="sexo" class="form-control">
									<option value="" selected="" disabled="">Selecione o sexo</option>
									<option <?php if($DADOS->sexo == 'Masculino') { echo "selected"; } ?>>Masculino</option>
									<option <?php if($DADOS->sexo == 'Feminino') { echo "selected"; } ?>>Feminino</option>
								  </select>
								</div>
							  </div>
							  <div class="col-md-8">
								<div class="form-group">
								  <label for="nome">Nome*</label>
								  <input type="text" id="nome" class="form-control" required name="nome" value="<?=$DADOS->nome?>" autocomplete="off">
								</div>
							  </div>
							</div>
							
							<div class="row">
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="nascimento">Data Nascimento</label>
								  <input type="text" class="form-control date-inputmask" id="nascimento" name="nascimento"  value="<?=strftime("%d/%m/%Y", strtotime( $DADOS->nascimento ));?>">
								</div>
							  </div>
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="naturalidade">Naturalidade</label>
								  <input type="text" id="naturalidade" class="form-control" name="naturalidade" value="<?=$DADOS->naturalidade?>">
								</div>
							  </div>
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="nacionalidade">Nacionalidade</label>
								  <input type="text" id="nacionalidade" class="form-control" name="nacionalidade" value="<?=$DADOS->nacionalidade?>">
								</div>
							  </div>
							  <?php /*<div class="col-md-2">
								<div class="form-group">
								  <label for="tipo_sanguineo">Tipo Sanguíneo</label>
								  <input type="text" id="tipo_sanguineo" class="form-control" name="tipo_sanguineo" value="<?=$DADOS->tipo_sanguineo?>">
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="fator_rh">Fator RH</label>
								  <input type="text" id="fator_rh" class="form-control" name="fator_rh" value="<?=$DADOS->fator_rh?>">
								</div>
							  </div> */ ?> 
							    <div class="col-md-4">
								    <div class="form-group">
									  <label for="situacao">Situação Funcional</label>
									  <select id="situacao" name="situacao" class="form-control">
										<option value="" selected="" disabled="">Selecione uma opção</option>
										<option <?php if($DADOS->situacao == 'Ativo(a)') { echo 'selected'; } ?>>Ativo(a)</option>
										<option <?php if($DADOS->situacao == 'Inativo(a)') { echo 'selected'; } ?>>Inativo(a)</option>
										<option <?php if($DADOS->situacao == 'Civil') { echo 'selected'; } ?>>Civil</option>
										<option <?php if($DADOS->situacao == 'Pensionista') { echo 'selected'; } ?>>Pensionista</option>
									  </select>
									</div>
							    </div>
							</div>
							
						
							<div class="row">
							<div class="col-md-4">
								    <div class="form-group">
									  <label for="situacao">Matrícula do Soldado</label>
									  <input type="text" id="matricula_sold" class="form-control" name="matricula_sold" value="<?=$DADOS->matricula_sold?>">
									</div>
							    </div>

								<div class="col-md-4">
								    <div class="form-group">
									  <label for="situacao">Posto/Graduação</label>
									  <input type="text" id="graduacao" class="form-control" name="graduacao" value="<?=$DADOS->graduacao?>">
									</div>
							    </div>

								<div class="col-md-4">
								    <div class="form-group">
									  <label for="situacao">Unidade</label>
									  <input type="text" id="unidade" class="form-control" name="unidade" value="<?=$DADOS->unidade?>">
									</div>
							    </div>
							</div>

							<div class="row">
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="estado_civil">Estado Civil</label>
								  <select id="estado_civil" name="estado_civil" class="form-control">
									<option value="" selected="" disabled="">Selecione o estado civil</option>
									<option <?php if($DADOS->estado_civil == 'Casado(a)') { echo 'selected'; } ?>>Casado(a)</option>
									<option <?php if($DADOS->estado_civil == 'Solteiro(a)') { echo 'selected'; } ?>>Solteiro(a)</option>
									<option <?php if($DADOS->estado_civil == 'Divorciado(a)') { echo 'selected'; } ?>>Divorciado(a)</option>
									<option <?php if($DADOS->estado_civil == 'Viúvo(a)') { echo 'selected'; } ?>>Viúvo(a)</option>
								  </select>
								</div>
							  </div>
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="cpf">CPF</label>
								  <input type="text" id="cpf" class="form-control cpf-inputmask" name="cpf" value="<?=$DADOS->cpf?>">
								</div>
							  </div>
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="rg">RG</label>
								  <input type="text" id="rg" class="form-control" name="rg" value="<?=explode("/", $DADOS->rg)[0]?>">
								</div>
							  </div>
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="expedidor">Expedidor</label>
								  <input type="text" id="expedidor" class="form-control" name="expedidor" value="<?=explode("/", $DADOS->rg)[1]?>">
								</div>
							  </div>
							</div>
							
							<div class="row">
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="admissao">Data Admissão*</label>
								  <input type="text" class="form-control date-inputmask" id="admissao" name="admissao" value="<?=strftime("%d/%m/%Y", strtotime( $DADOS->admissao ));?>">
								</div>
							  </div>
								<div class="col-md-9">
									<div class="form-group">
									  <label for="plano">Plano</label>
									  <select id="plano" name="plano" class="form-control">
										<option value="" selected="" disabled="">Selecione o plano</option>
										<?php
										foreach($PLANOS as $P) {
											echo "<option value='".$P->id_plano."'"; if($DADOS->plano == $P->id_plano) { echo 'selected'; } echo ">".$P->nome." (R$ ".number_format($P->mensalidade, 2, ',', '.')." MENSAL - DESCONTO DE ".$P->cobrado."%)</option>";
										}
										?>
									  </select>
									</div>
								</div>
							</div>
							
							<div class="row">
							  <div class="col-md-12">
								<div class="form-group">
								  <label for="observacoes">Observações</label>
								  <textarea class="form-control" id="observacoes" name="observacoes"><?=$DADOS->observacoes?></textarea>
								</div>
							  </div>
							</div>
							
							<h4 class="form-section"><i class="la la-phone"></i> Contato</h4>
							<div class="row">
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="telefone1">Telefone</label>
								  <input type="text" id="telefone1" class="form-control phone-inputmask" name="telefone1" value="<?=$DADOS->telefone1?>">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="celular1">Celular</label>
								  <input type="text" id="celular1" class="form-control xphone-inputmask" name="celular1" value="<?=$DADOS->celular1?>">
								</div>
							  </div>
							
							  <div class="col-md-6">
								<div class="form-group">
								  <label for="email">E-mail</label>
								  <input type="text" id="email" class="form-control" name="email" value="<?=$DADOS->email?>">
								</div>
							  </div>
							  
							</div>
							
							<h4 class="form-section"><i class="la la-map-marker"></i> Endereço</h4>
							<div class="row">
							  
							  <div class="col-md-10">
								<div class="form-group">
								  <label for="endereco">Endereço</label>
								  <input type="text" id="endereco" class="form-control" name="endereco" value="<?=$DADOS->endereco?>">
								</div>
							  </div>
							
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="numero">Número</label>
								  <input type="text" id="numero" class="form-control" name="numero" value="<?=$DADOS->numero?>">
								</div>
							  </div>
							
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="bairro">Bairro</label>
								  <input type="text" id="bairro" class="form-control" name="bairro" value="<?=$DADOS->bairro?>">
								</div>
							  </div>
							
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="cep">CEP</label>
								  <input type="text" id="cep" class="form-control cep-inputmask" name="cep" value="<?=$DADOS->cep?>">
								</div>
							  </div>
							  
							  <div class="col-md-2">
								<div class="form-group">
								  <label for="uf">Estado</label>
								  <select id="uf" name="uf" class="form-control" value="<?=$DADOS->estado?>">
									<option value="" selected="" disabled="">Selecione o estado</option>
									
								  </select>
								</div>
							  </div>
							  <div class="col-md-3">
								<div class="form-group">
								  <label for="cidade">Cidade</label>
								  <select id="cidade" name="cidade"value="<?=$DADOS->cidade?>" class="form-control">
									<option value="0" selected="" disabled="">Selecione o estado</option>
								  </select>
								</div>
							  </div>
							</div>
							
						  </div>
						  <div class="form-actions">
							<button type="button" class="btn btn-warning mr-1">
							  <i class="ft-x"></i> LIMPAR
							</button>
							<button type="button" class="btn btn-success ladda-button" data-style="zoom-in" onclick="gravarForm('formNovo', 'salvar1')" id="btn-salvar1">
							  <i class="la la-save"></i> SALVAR
							</button>
						  </div>
						
						</form>
                      </div>
                      
                      <div class="tab-pane" id="dependentes" role="tabpanel" aria-labelledby="dependentes-tab1"
                      aria-expanded="false">
                        <div class="form-body">
							<form id="formSaveDependente" name="formDependente" class="form" autocomplete="off">
							<input type="hidden" id="dependente-acao" name="acao" value="addDependente" />
							<input type="hidden" id="dependente-associado" name="associado" value="<?=$DADOS->id_associado?>" />
							<input type="hidden" id="dependente-id" name="id" value="" />
							<div class="row">
							  <div class="col-md-2">
								<div class="form-group">
								  <select id="dependente-sexo" name="sexo" class="form-control">
									<option value="" selected="" disabled="">Sexo</option>
									<option>Masculino</option>
									<option>Feminino</option>
								  </select>
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <select id="dependente-parentesco" name="parentesco" class="form-control">
									<option value="" selected="" disabled="">Parentesco</option>
									<?php
									foreach($PARENTESCOS as $P) {
										echo "<option value='".$P->id_parentesco."'>".$P->parentesco."</option>";
									}
									?>
									
								  </select>
								</div>
							  </div>
							  <div class="col-md-6">
								<div class="form-group">
								  <input type="text" id="dependente-nome" class="form-control" name="nome" placeholder="Nome do dependente">
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <input type="text" id="dependente-nascimento" class="form-control date-inputmask" placeholder="Data de Nascimento" name="nascimento">
								</div>
							  </div>
							  <?php /*
							  <div class="col-md-2">
								<div class="form-group">
								  <input type="text" id="dependente-tipo_sanguineo" class="form-control" name="tipo_sanguineo" placeholder="Tipo Sanguíneo">
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <input type="text"  id="dependente-fator_rh" class="form-control" name="fator_rh" placeholder="Fator RH">
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <input type="text" id="dependente-naturalidade" class="form-control" name="naturalidade" placeholder="Naturalidade">
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <input type="text" class="form-control" id="dependente-nacionalidade" name="nacionalidade" placeholder="Nacionalidade">
								</div>
							  </div>*/ ?>
							  <div class="col-md-4">
								<div class="form-group">
								  <input type="text" class="form-control cpf-inputmask" id="dependente-cpf" name="cpf" placeholder="CPF">
								</div>
							  </div>
							  <div class="col-md-4">
								<div class="form-group">
								  <input type="text" class="form-control" id="dependente-rg" name="rg" placeholder="RG">
								</div>
							  </div>
							  <?php /*<div class="col-md-2">
								<div class="form-group">
								  <input type="text" class="form-control" id="dependente-profissao" name="profissao" placeholder="Profissão">
								</div>
							  </div>
							  <div class="col-md-2">
								<div class="form-group">
								  <input type="text" class="form-control" id="dependente-local_trabalho" name="local_trabalho" placeholder="Local de trabalho">
								</div>
							  </div>
							  <div class="col-md-4">
								<div class="form-group">
								  <input type="text" class="form-control" id="dependente-mae" name="mae" placeholder="Nome da mãe">
								</div>
							  </div>
							  <div class="col-md-4">
								<div class="form-group">
								  <input type="text" class="form-control" id="dependente-pai" name="pai" placeholder="Nome do pai">
								</div>
							  </div>*/?>
							  <div class="col-md-4">
								<div class="form-group">
								  <select id="dependente-plano" name="plano" class="form-control">
									<option value="" selected="" disabled="">Plano</option>
									<?php
									foreach($PLANOS as $P) {
										echo "<option value='".$P->id_plano."'>".$P->nome." (R$ ".number_format($P->mensalidade, 2, ',', '.')." MENSAL - DESCONTO DE ".$P->cobrado."%)</option>";
									}
									?>
								  </select>
								</div>
							  </div>
							  <div class="col-md-12">
								<div class="form-group">
								  <input type="text" id="dependente-observacoes" class="form-control" name="observacoes" placeholder="Observações">
								</div>
							  </div>
							  <div class="col-md-12" id="div-btn-salvarDependente">
								<div class="form-group" id="btnSubmit">
								  <button type="submit" class="btn btn-success btn-min-width mr-1 mb-1 btn-block ladda-button" data-style="zoom-in" id="btn-salvarDependente"><i class="fa fa-save"></i> SALVAR DEPENDENTE</button>
								</div>
							  </div>
							  <div class="col-md-2" id="div-btn-cancelarDependente" style="display: none;">
								<div class="form-group">
								  <button type="button" class="btn btn-danger btn-min-width mr-1 mb-1 btn-block ladda-button" data-style="zoom-in" id="btn-cancelarDependente"><i class="fa fa-close"></i> CANCELAR</button>
								</div>
							  </div>
							</div>
							</form>
							
							<h4 class="form-section"><i class="la la-archive"></i> Lista de dependentes</h4>
							
							<div class="row text-center">
								<div class="col-md-12" id="exibeDependentes">
									<?php if(count($L_DEPENDENTES) >= 1) { ?>
									<ul class="list-group">
										<?php foreach($L_DEPENDENTES as $DEPENDENTE) { ?>
										<li class="list-group-item" id="dependente-<?=$DEPENDENTE->id_dependente?>">
											<button type="button" onclick="editarDependente(<?=$DEPENDENTE->id_dependente?>)" class="btn btn-outline-success mr-1 float-right ladda-button" data-style="zoom-in" id="btn-editarDependente-<?=$DEPENDENTE->id_dependente?>">
												<i class="la la-edit"></i>
											</button>
											<button type="button" onclick="removerDependente(<?=$DEPENDENTE->id_dependente?>)" class="btn btn-outline-danger mr-1 float-right ladda-button" data-style="zoom-in" id="btn-removeDependente-<?=$DEPENDENTE->id_dependente?>">
												<i class="la la-trash"></i>
											</button>
											<h2 class="float-left">
											<?=$DEPENDENTE->nome?> - <small> <?=$B_PARENTESCO[$DEPENDENTE->parentesco]->parentesco?></small><br/>
											<small><?=strftime('%d/%m/%Y', strtotime($DEPENDENTE->nascimento))?> | <strong><?=($B_PLANO[$DEPENDENTE->plano]->nome) ? $B_PLANO[$DEPENDENTE->plano]->nome : 'NENHUM PLANO'?></strong></small>
											</h2>
										</li>
										<?php } ?>
									</ul>
									<?php } else { ?>
									<h1 class="display-1" align="center"><i class="ft-alert-triangle"></i></h1>
									<h3 align="center">NENHUM DEPENDENTE NO MOMENTO!!</h3>
									<?php } ?>
								</div>
							</div>
						</div>
                      </div>
					  
					  <div class="tab-pane" id="ordens" role="tabpanel" aria-labelledby="ordens-tab1"
                      aria-expanded="false">
						
                        <div class="form-body">
							
							<div class="row text-center">
								<div class="col-md-12" id="exibeDocumentos">
									<h1 class="display-1" align="center"><i class="ft-alert-triangle"></i></h1>
									<h3 align="center">NENHUMA ORDEM DE SERVIÇO NO MOMENTO!!</h3>
								</div>
							</div>
							
						</div>
					  </div>
					  
                      <div class="tab-pane" id="guias" role="tabpanel" aria-labelledby="guias-tab1"
                      aria-expanded="false">
						
                        <div class="form-body">
							
							<div class="row">
								<div class="col-md-12" id="exibeGuias">
									<?php if( count($GUIAS) >= 1 ) {  ?>
									
									<div class="table-responsive">
										<table id="invoices-list" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
										  <thead>
											<tr>
											  <th>Nº GUIA</th>
											  <th>TITULAR/BENEFICIÁRIO</th>
											  <th>FORNECEDOR</th>
											  <th>VALOR</th>
											  <th>DATA EMISSÃO</th>
											  <th>STATUS</th>
											  <th>DATA PAGAMENTO</th>
											  <th>IMPRIMIR</th>
											</tr>
										  </thead>
										  <tbody>
											<!-- PAID -->
											<?php 
											foreach($GUIAS as $GUIA) {
											?>
											<tr id="fatura-<?=$GUIA->id_guia?>">
											  <td><?=str_pad($GUIA->id_guia, 6, 0, STR_PAD_LEFT)?></td>
											  <td>
												<?=$GUIA->nome?><br/>
												<small><?=($GUIA->associado == 1) ? $DEPENDENTES[$GUIA->dependente]->nome : $GUIA->nome?></small>
											  </td>
											  <td><?=($GUIA->nome_fantasia) ? $GUIA->nome_fantasia : $GUIA->razao_social?></td>
											  <td>
												<small class="text-tachado text-danger">R$ <?=number_format($GUIA->valor,2,",",".")?></small><br/>
												<strong class="text-success">R$ <?=number_format($GUIA->pagar,2,",",".")?></strong>
											  </td>							  
											  <td><?=date("d/m/Y", strtotime($GUIA->data_emissao))?></td>
											  <td>
												
												<?php
												if($GUIA->status == 1) {
													echo '<span class="badge badge-default badge-success badge-lg">NOVA</span>';
												} else if($GUIA->status == 7) {
													echo '<span class="badge badge-default badge-danger badge-lg">ATENDIDO</span>';
												} else if($GUIA->status == 8) {
													echo '<span class="badge badge-default badge-warning badge-lg">FATURADO</span>';
												} else if($GUIA->status == 9) {
													echo '<span class="badge badge-default badge-success badge-lg">PAGO</span>';
												} else if($GUIA->status == 10) {
													echo '<span class="badge badge-default badge-success badge-lg">PARCELADO</span>';
												} else {
													echo '<span class="badge badge-default badge-success badge-lg">CANCELADA</span>';
												}
												?>												
												</span>
											  </td>
											  <td><?php if($GUIA->status == 9) { echo date("d/m/Y", strtotime($GUIA->data_pagamento)); } else { echo '---'; }?></td>
											  <td>
												<span class="dropdown">
												  <button id="btnSearchDrop<?=$GUIA->id_guia?>" type="button" data-toggle="dropdown" aria-haspopup="true"
												  aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right"><i class="ft-settings"></i></button>
												  <span aria-labelledby="btnSearchDrop<?=$GUIA->id_guia?>" class="dropdown-menu mt-1 dropdown-menu-right">
													<a href="javascript:gerarGuia(<?=$GUIA->id_guia?>)" class="dropdown-item"><i class="la la-print"></i> IMPRIMIR</a>
													TESTE
													<?php if($GUIA->status == 1) { ?>
													<a href="javascript:statusGuia(<?=$GUIA->id_guia?>, 0)" class="dropdown-item"><i class="la la-ban"></i> CANCELAR</a>
													<a href="javascript:statusGuia(<?=$GUIA->id_guia?>, 7)" class="dropdown-item"><i class="la la-check"></i> ATENDIDO</a>
													<?php } ?>
													<?php if($GUIA->status == 7) { ?>
													<a href="javascript:statusGuia(<?=$GUIA->id_guia?>, 0)" class="dropdown-item"><i class="la la-ban"></i> CANCELAR</a>
													<a href="javascript:statusGuia(<?=$GUIA->id_guia?>, 8)" class="dropdown-item"><i class="fa fa-cash"></i> COBRADO</a>
													<?php } ?>
													<a class="dropdown-item"><i class="la la-close"></i> FECHAR</a>
												  </span>
												</span>
											  </td>
											</tr>
											<?php } ?>
										  </tbody>
										  <tfoot>
											<tr>
											  <th>Nº GUIA</th>
											  <th>TITULAR</th>
											  <th>FORNECEDOR</th>
											  <th>VALOR</th>
											  <th>DATA EMISSÃO</th>
											  <th>STATUS</th>
											  <th>DATA PAGAMENTO</th>
											  <th>IMPRIMIR</th>
											</tr>
										  </tfoot>
										</table>
									  </div>
								  
									
									<?php } else { ?>
									<h1 class="display-1" align="center"><i class="ft-alert-triangle"></i></h1>
									<h3 align="center">NENHUMA GUIA NO MOMENTO!!</h3>
									<?php } ?>
								</div>
							</div>
							
						</div>
					  </div>
					  
					  
					  <div class="tab-pane" id="extrato" role="tabpanel" aria-labelledby="extrato-tab1"
                      aria-expanded="false">
						
                        <div class="form-body">
							
							<div class="col-12">
								<div class="card bg-gradient-x-info">
									<div class="card-content">
										<div class="row">
											<div class="col-lg-4 col-md-6 col-sm-12 border-right-info border-right-lighten-3">
												<div class="card-body text-center">
												<span class="text-white">TOTAL DE ATENDIMENTOS</span>
													<h1 class="display-4 text-white">
														<i class="feather ft-activity font-large-2"></i> <?=contarQueryes("guias", "titular='".$DADOS->id_associado."' AND fornecedor>='1'") + contarQueryes("ordens", "titular='".$DADOS->id_associado."'")?></h1>
													
												</div>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12 border-right-info border-right-lighten-3">
												<div class="card-body text-center">
												<span class="text-white">PROXIMA FATURA</span>
													<h1 class="display-4 text-white">
														<i class="feather ft-clipboard font-large-2"></i> <small>R$</small> <?=number_format(somar("pagar", "ordens", "titular='".$DADOS->id_associado."' AND status='8'") + proximaFatura($DADOS->id_associado), 2, ",", ".")?>
													</h1>
												
												</div>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="card-body text-center">
												<span class="text-white">SALDO DEVEDOR</span>
														<h1 class="display-4 text-white">
														<i class="icon-wallet font-large-2"></i> <small>R$</small> <?=number_format(somar("pagar", "ordens", "titular='".$DADOS->id_associado."' AND (status='7' OR status='8')") + saldoDevedor($DADOS->id_associado), 2, ",", ".")?>
													</h1>
													<a href="javascript:informarPagamento(<?=$DADOS->id_associado?>)" class="badge badge-pill bg-blue-grey">DESCONTAR PAGAMENTO</a>
													<a href="javascript:parcelarGuias(<?=$DADOS->id_associado?>)" class="badge badge-pill bg-blue-grey">PARCELAR SALDO</a> &nbsp;
													<!--<a href="javascript:informarPagamento(<?=$DADOS->id_associado?>)" class="badge badge-pill bg-blue-grey">INFORMAR PAGAMENTO</a>-->
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
																	
							
							<div class="content-body">
								<section class="card">
									<div class="card-body" id="invoice-template">
										<div class="pt-2" id="invoice-items-details">
											<form class="form-body" id="buscarExtrato">
												<input type="hidden" name="acao" value="extrato" />
												<input type="hidden" name="id_associado" value="<?=$DADOS->id_associado?>" />
												<div class="row">
																									  
												  <div class="col-md-2">
													<div class="form-group">
													  <label for="extrato-inicio">Ano</label>
														<select class="form-control form-control" id="selecionaAno" name="ano">
															<option value="">Selecione o ano</option>
															<?php for($i= date('Y'); $i >= date('Y') - 5;$i--) { ?>
															<option value="<?=$i?>"><?=$i?></option>
															<?php } ?>
														</select>
													</div>
												  </div>									  
												  <div class="col-md-2">
													<div class="form-group">
														<label for="extrato-final">Mês</label>
														<select class="form-control form-control" id="selecionaMes" name="mes">
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
													</div>
												  </div>
												  
												  <div class="col-md-2">
													<div class="form-group">
													  <label for="extrato-tipo">Tipo</label>
													  <select id="extrato-tipo" name="tipo" class="form-control">
														<option value="x" selected="">Todos</option>
														<option value="1">Guias</option>
														<option value="2">Mensalidades</option>
														
													  </select>
													</div>
												  </div>
												  
												  <div class="col-md-2">
													<div class="form-group">
													  <label for="extrato-status">Status</label>
													  <select id="extrato-status" name="status" class="form-control">
														<option value="x" selected="" >Todos</option>
														<option value="1">Novo</option>
														<option value="7">Atendido</option>
														<option value="8">Faturado</option>
														<option value="9">Pago</option>
														<option value="0">Cancelado</option>
													  </select>
													</div>
												  </div>
												  
												  <div class="col-md-2">
													<div class="form-group">
													  <label for="extrato-atendimento">Beneficiário</label>
													  <select id="extrato-atendimento" name="atendimento" class="form-control">
														<option value="x" selected="" selected="">Todos</option>
														<option value="0">Titular</option>
														<option value="1">Dependentes</option>
														
													  </select>
													</div>
												  </div>
												  
												  <div class="col-md-2">
													<div class="form-group">
														<label class="text-white"> ....... </label>
														<button type="submit" class="btn btn-success btn-block ladda-button" data-style="zoom-in" id="btn-buscarExtrato">
														<i class="fa fa-filter"></i> FILTRAR
														</button>
													</div>
												  </div>
												  
												</div>
												
											</form>
											
											<div class="exbirExtrato printable">
											</div>
											
										</div>
										<div id="invoice-footer">
											<div class="row">
												<div class="col-md-7 col-sm-12">
												</div>
												<div class="col-md-5 col-sm-12 text-center">
													<button class="btn btn-info btn-lg my-1" onclick="window.print()" type="button"><i class="la la-print"></i> IMPRIMIR</button>
												</div>
											</div>
										</div>
									</div>
								</section>
							</div>
							
							
							
						</div>
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


	<!-- Modal -->
	<div class="modal fade text-left" id="verPdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title" id="myModalLabel1">Visualizar PDF</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			  <?php /*<iframe src="off.pdf" class="visualizar" id="iframeVerArquivo" width="100%" height="500px"></iframe>*/ ?>
			</div>
		  </div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade text-left" id="verImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title" id="myModalLabel1">Visualizar Imagem</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body" id="exibeImg">
			</div>
		  </div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade text-left" id="addBoleto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h4 class="modal-title" id="myModalLabel1">Nova Fatura</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				<form id="addFatura" class="form-body" >
					<input type="hidden" name="acao" value="gerarboleto"/>
					<div class="row">
					  <div class="col-md-3">
						<div class="form-group">
						  <label for="vencimento">VENCIMENTO</label>
						  <input type="text" id="vencimento" class="form-control date-inputmask" name="vencimento">
						</div>
					  </div>
					  <div class="col-md-3">
						<div class="form-group">
						  <label for="valor">VALOR</label>
						  <input type="text" id="valor" class="form-control" onkeyup="formatoMoeda(this)" name="valor">
						</div>
					  </div>
					  <div class="col-md-3">
						<div class="form-group">
						  <label for="juros">JUROS</label>
						  <input type="text" id="juros" class="form-control" onkeyup="formatoMoeda(this)" name="juros">
						</div>
					  </div>
					  <div class="col-md-3">
						<div class="form-group">
						  <label for="multa">MULTA</label>
						  <input type="text" id="multa" class="form-control" onkeyup="formatoMoeda(this)" name="multa">
						</div>
					  </div>
					  <div class="col-md-12">
						<div class="form-group">
						  <label for="inst1">INSTRUÇÕES DE PAGAMENTO (Linha 1)</label>
						  <input type="text" id="inst1" class="form-control" name="inst1">
						</div>
					  </div>
					  <div class="col-md-12">
						<div class="form-group">
						  <label for="inst2">INSTRUÇÕES DE PAGAMENTO (Linha 2)</label>
						  <input type="text" id="inst2" class="form-control" name="inst2">
						</div>
					  </div>
					  <div class="col-md-12">
						<div class="form-group">
						  <label for="inst3">INSTRUÇÕES DE PAGAMENTO (Linha 3)</label>
						  <input type="text" id="inst3" class="form-control" name="inst3">
						</div>
					  </div>
					  <div class="col-md-12">
						<div class="form-group">
						  <button type="submit" class="btn btn-success btn-min-width mr-1 mb-1"><i class="la la-check"></i> Inserir</button>
						</div>
					  </div>
					</div>
				</form>
			</div>
		  </div>
		</div>
	</div>
	
	<?php /*<iframe src="off.pdf" id="imprimirPDF" width="0px" height="0px"></iframe>*/ ?>
  

<?php include_once(__DIR__."/../footer.php"); ?>
  <script>
  $("#selecionaAno").change(function(){
	valor = this.value
	let data = new Date(),
		dia  = data.getDate().toString(),
		diaF = (dia.length == 1) ? '0'+dia : dia,
        mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesF = (mes.length == 1) ? '0'+mes : mes,
        anoF = data.getFullYear();
	
	let meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
	$('#selecionaMes').html(`<option value="">Selecione um mês</option>`)
	if(valor == anoF) {
		for(let i = 0; i<mes;i++) {
			$('#selecionaMes').append(`<option value="${i + 1}">${meses[i]}</option>`)
		}
	} else {
		for(let i = 0; i<12;i++) {
			$('#selecionaMes').append(`<option value="${i + 1}">${meses[i]}</option>`)
		}
	}		
});
  </script>
