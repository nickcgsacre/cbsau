<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$DADOS = buscar("guias as g LEFT JOIN associados as a ON a.id_associado=g.titular LEFT JOIN fornecedores as f on f.cod_fornecedor=g.fornecedor", "g.id_guia='".$_GET['guia']."'");

$SERVICOS = json_decode($DADOS->servicos);

foreach($SERVICOS as $SERVICO) {
	$SAVE[] = $SERVICO->id_servico;
}

$SAVE = implode(",", $SAVE);
$CATEGORIAS = listar("servicos as s RIGHT JOIN servicos_categorias as sc ON sc.id_sc=s.id_cat", "s.id_servico IN (".$SAVE.") GROUP BY sc.categoria");

foreach($CATEGORIAS as $CAT) {
	$CATEGORIA[] = $CAT->categoria;
}

$CATEGORIAS = implode(", ", $CATEGORIA);

?>
<title>GUIA DE ENCAMINHAMENTO #<?=str_pad($DADOS->id_guia, 6, 0, STR_PAD_LEFT)?></title>
<style>
body {
	font-family: Arial, Helvetica, sans-serif;
}
table {
	font-size: 12pt;
}
.logo {
	width: 20%!important;
	overflow: hidden;
}
.logo img {
	width: 100%;
	height: auto;
}
.t1 {
	width: 40%!important;
	overflow: hidden;
	text-align: center;
	font-size: 9pt;
	font-weight: bold;
}
.t2 {
	width: 20%!important;
	overflow:: hidden;
	font-size: 8pt;
	font-weight: bold;
    text-align: center;
}
.controle {
	width: 30%!important;
	overflow: hidden;
	text-align: center;
}
.controle .ct1 {
	font-size: 8pt;
	padding: 10px 0px 10px;
}
.controle .numero {
	font-weight: bold;
	font-size: 12pt;
	color: red;
	padding-bottom: 10px;
}
.controle .data {
	border-top: 2px solid;
    padding-top: 5px;
	font-weight: bold;
}
.controle .data span {
	font-size: 8pt;
	line-height: 15px;
	font-weight: inherit;
}
.label {
	font-size: 9pt;
    font-weight: bold;
}
.label span {
	margin: 0px 0px 0px -2px;
    padding: 0px 10px;
    border: 2px solid;
}
.value {
	padding: 5px 10px 3px;
    font-size: 10pt;
    font-weight: bold;
	min-height: 15px;
}
.assc {
	text-align: center;
}
.assc span {
	font-size: 8pt;
    display: block;
    border-bottom: 2px solid;
    padding-bottom: 2px;
}
.tab-servicos {
	font-size:9pt;
	margin-top: -2px;
}
.tab-servicos .topo {
	text-align: center;
	font-weight: bold;
}
.tab-servicos .topo td {
	padding: 3px;
}
.tab-servicos .itens td {
	padding: 3px;
	height: 16px;
}
.tab-servicos .total .texto {
	padding: 3px;
    font-size: 9pt;
    font-weight: bold;
    text-align: right;
	height:: 20px;
    color: #fff;
    background: #000;
}
.tab-assinatura {
    margin-top: -2px;
    font-size: 10px;
    text-align: center;
	font-weight: bold;
}
.obs {
	font-size: 8pt;
}
.text-red {
	color: red;
}
</style>
<script type="text/javascript">
	window.onload = function(){
		parent.imprimir()
	}
</script>
</head>

<body>
	<div style="width: 15cm; margin: 0 auto;">
   	
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td class="logo">
                	<img src="<?=URL_SISTEMA?>/arquivos/logomarca/logo.jpg" />
                </td>
                <td class="t1">
                	COOPERATIVA DE SAÚDE DOS<br/>
                    SERVIDORES PÚBLICOS DO CORPO<br/>
                    DE BOMBEIROS MILITAR DO ACRE<br/>
                    <br/>
                    CBSAÚDE
                </td>
                <td class="t2">GUIA DE ENCAMINHAMENTO</td>
                <td colspan="2" class="controle">
                	<div class="ct1">
                    	Nº DO CONTROLE
                    </div>
                    <div class="numero">
                    	<?=str_pad($DADOS->id_guia, 6, 0, STR_PAD_LEFT)?>
                    </div>
                    <div class="data">
                    	<span>DATA DA EMISSÃO</span>
                    	<?=date("d/m/Y", strtotime($DADOS->data_emissao))?>
                    </div>
                
                </td>
              </tr>
              <tr>
                <td colspan="4">
                	<div class="label"><span>NOME DO TITULAR</span></div>
                	<div class="value"><?=$DADOS->nome?></div>
                </td>
                <td class="assc">
                	<span>ASSOCIADO</span>
                    <?php if($DADOS->associado == 1) { echo 'NÃO'; } else { echo 'SIM'; } ?>
                </td>
              </tr>
              <tr>
                <td colspan="5">
                	<div class="label"><span>NOME DO DEPENDENTE</span></div>
                	<div class="value"><?php if($DADOS->associado == 1) { echo buscar("dependentes", "id_dependente='".$DADOS->dependente."'")->nome; } 
					else { echo '--------------------------'; } ?></div>
                </td>
              </tr>
              <tr>
                <td colspan="5">
                	<div class="label"><span>SERVIÇO PRESTADO POR</span></div>
                	<div class="value"><?=$DADOS->nome_fantasia?></div>
                </td>
              </tr>
              <tr>
                <td colspan="5">
                	<div class="label"><span>TIPO(S) DE SERVIÇO(S) PRESTADO(S)</span></div>
                	<div class="value"><?=$CATEGORIAS?></div>
                </td>
              </tr>
        </table>
        
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab-servicos">
              <tr class="topo">
                <td>COD</td>
                <td>DESCRIÇÃO DOS SERVIÇOS</td>
                <td>QUANT.</td>
                <td>VALOR UNIT.</td>
                <td>VALOR TOTAL</td>
              </tr>
              <?php //for($i=1; $i<=15; $i++) { 
			  $i = 1;
			  $Total = 0;
			  foreach($SERVICOS as $SERVICO) { $i++;
			  $D_SERVICO = buscar("servicos", "id_servico='".$SERVICO->id_servico."'");
			  $Total += intval($SERVICO->qtd)*$SERVICO->valor;
			  ?>
              <tr class="itens">
                <td align="center"><?=$D_SERVICO->cod?></td>
                <td><?=$D_SERVICO->servico?></td>
                <td align="center"></td>
                <td align="center"></td>
                <td align="center"></td>
              </tr>
              <?php } ?>
			  
			  <?php for($i=$i;$i<=15; $i++) { ?>
              <tr class="itens">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <?php } ?>
              <tr class="total">
                <td colspan="4" class="texto">VALOR TOTAL</td>
                <td align="center" class="text-red"><strong></strong></td>
              </tr>
        </table>
        
        <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tab-assinatura">
        	 <tr>
                <td>
                	<br/>CARIMBO E ASSINATURA DO EMISSOR<br/>
                    <br/><br/><br/><br/><br/><br/>
                    ________________________________<br/>
                    <br/>
                </td>
                <td>
                	<br/>ASSINATURA DO USUÁRIO<br/>
                    <br/><br/><br/><br/><br/><br/>
                    ________________________________<br/>
                    <br/>
                </td>
                <td>
                	<br/>CARIMBO E ASS. DO CONVÊNIADO<br/>
                    <br/><br/><br/><br/><br/><br/>
                    ________________________________<br/>
                    <br/>
                </td>
              </tr>
        </table>
        <div class="obs">Retorno válido por até 15 dias.</div>
    
    
    
    </div>



</body>
</html>
