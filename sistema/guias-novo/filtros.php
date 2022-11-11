<?php
    $associados = listar("associados");
    $fornecedores = listar("fornecedores");
?>

<div class="col-12 mb-2">
    <form action="<?=URL_SISTEMA.'/guias-novo/index'?>" method="POST" id="filtros-guias-form">
        <div class="row">
            <div class="col-1">
                <div class="form-group">
                    <label for="numero">Nº GUIA</label>
                    <input type="number" name="numero" class="form-control" value="<?=$_POST['numero']?>">
                </div>
            </div>
            <div class="col-2 mr-2">
                <div class="form-group">
                    <label for="titular">Titutar</label>
                    <select id="titular" name="titular" class="form-control select2 mr-2">
                    <option value="">Selecione</option>
                        <?php foreach($associados as $associado) { ?>
                            <option value="<?=$associado->id_associado?>" <?php if($_POST['titular'] == $associado->id_associado) {?> selected <?php } ?> >
                                <?=$associado->nome?> - <?=$associado->matricula?>
                            </option>
                        <?php } ?>
					</select>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label for="plano">Plano</label>
                    <select class="form-control" name="plano">
                        <option value="">Selecione</option>
                        <?php foreach($planos as $plano) { ?>
                            <option value="<?=$plano->id_plano?>" <?php if($_POST['plano'] == $plano->id_plano) {?> selected <?php } ?> >
                                <?=$plano->nome?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-2 mr-2">
                <div class="form-group">
                    <label for="associado">Associado</label>
                    <select id="associado" name="associado" class="form-control select2">
                        <option value="">Selecione</option>
                        <?php foreach($associados as $associado) { ?>
                            <option value="<?=$associado->id_associado?>" <?php if($_POST['associado'] == $associado->id_associado) {?> selected <?php } ?> >
                                <?=$associado->nome?> - <?=$associado->matricula?>
                            </option>
                        <?php } ?>
					</select>
                </div>
            </div>
            <div class="col-2 mr-2">
                <div class="form-group">
                    <label for="fornecedor">Fornecedor</label>
                    <select id="fornecedor" name="fornecedor" class="form-control select2">
                        <option value="">Selecione</option>
                        <?php foreach($fornecedores as $fornecedor) { ?>
                            <option value="<?=$fornecedor->id_fornecedor?>" <?php if($_POST['fornecedor'] == $fornecedor->id_associado) {?> selected <?php } ?> >
                                <?=$fornecedor->nome_fantasia?>
                            </option>
                        <?php } ?>
					</select>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label for="data_emissao">Emissão inicial</label>
                    <input type="date" name="data_emissao" class="form-control daterange" value="<?=$_POST['data_emissao']?>">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label for="data_emissao_final">Emissão final</label>
                    <input type="date" name="data_emissao_final" class="form-control daterange" value="<?=$_POST['data_emissao_final']?>">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="col-12 mb-5">
    <button class="btn btn-primary float-right ml-1" type="submit" form="filtros-guias-form">Filtrar</button>
    <a href="<?=URL_SISTEMA."/guias-novo/index"?>" class="btn btn-secondary float-right" type="button">Limpar filtros</a>
</div>