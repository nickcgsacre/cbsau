<table class="table table-hover shadow mt-2">
    <thead class="bg-dark text-white">
        <tr>
            <th>Nº GUIA</th>
            <th>Titular</th>
            <th>Plano</th>
            <th>Associado</th>
            <th>Fornecedor</th>
            <th class="text-center">Data da emissão</th>
            <th class="text-center">Status</th>
            <th class="text-center">Valor</th>
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($guias) > 0) { ?>
            <?php $totalValores = 0; ?>
            <?php foreach ($guias as $guia) { ?>
                <?php
                $titularId = $guia->titular;
                $planoId = $guia->plano;
                $associadoId = $guia->associado;
                $fornecedorId = $guia->fornecedorId;
                $dataEmissao = date_create($guia->data_emissao);
                $totalValores += $guia->valor;

                $titular = buscar("associados", "id_associado='$titularId'");
                $plano = buscar("planos", "id_plano='$planoId'");
                $associado = buscar("associados", "id_associado='$associadoId'");
                $fornecedor = buscar("fornecedores", "cod_fornecedor='$fornecedorId'");
                ?>
                <tr>
                    <td><?= $guia->id_guia ?></td>
                    <td><?= $titular->nome ?></td>
                    <td><?= $plano ? $plano->nome : 'Não informado' ?></td>
                    <td><?= $associado ? $associado->nome : 'Não informado' ?></td>
                    <td><?= $fornecedor->nome_fantasia ? $fornecedor->nome_fantasia : 'Não informado' ?></td>
                    <td class="text-center"><?= date_format($dataEmissao, 'd/m/Y') ?></td>
                    <td class="text-center">
                        <?php
                            if ($guia->status) {
                                if ($guia->status == 1) {
                                    echo '<span class="badge badge-default badge-success badge-lg">NOVA</span>';
                                } else if ($guia->status == 7) {
                                    echo '<span class="badge badge-default badge-danger badge-lg">ATENDIDO</span>';
                                } else if ($guia->status == 8) {
                                    echo '<span class="badge badge-default badge-warning badge-lg">AGUARDANDO PAGAMENTO</span>';
                                } else if ($guia->status == 9) {
                                    echo '<span class="badge badge-default badge-success badge-lg">PAGO</span>';
                                } else if ($guia->status == 10) {
                                    echo '<span class="badge badge-default badge-success badge-lg">PARCELADO</span>';
                                } else {
                                    echo '<span class="badge badge-default badge-default badge-lg">CANCELADA</span>';
                                }
                            } else {
                                echo '-';
                            }
                        ?>
                        </span>
                    </td>
                    <td class="text-center"> 
                        R$ <?=$guia->valor?>
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cogs"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="javascript:gerarGuia(<?= $guia->id_guia ?>)">Imprimir</a>
                                <a class="dropdown-item" href="javascript:statusGuia(<?= $guia->id_guia ?>, 0)">Cancelar</a>
                                <a class="dropdown-item" href="#">Atendido</a>
                                <a class="dropdown-item" href="#">Pago</a>
                                <a class="dropdown-item" href="#">Pagar parcela</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            <tr class="bg-secondary">
                <td colspan="7"></td>
                <td class="text-center">
                    <h4 class="text-white">
                        <strong>Total:</strog> R$ <?=$totalValores?>
                    </h4>
                </td>
                <td></td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="7" class="text-center">Nenhuma guia encontrada</td>
            </tr>
        <?php } ?>
    </tbody>
</table>