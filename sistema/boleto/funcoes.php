<?php

if($B->codigo_barras == '') {
	$clientSoap = new SoapClient("http://sefaznet.ac.gov.br:8080/sefazonline/servlet/agerarcodigobarra?wsdl");
	$params = array( 
				'Dtavenc'  =>  $B->vencimento,
				'Cnpjrbtim'  =>  '27.531.200/0001-27',
				'Ccrbicodigo' => '5101',
				'Tipodoc' => $Tipodoc,
				'Documento' => $Documento,
				'Conrazsoc' => $E->razao_social,
				'Valor' => $B->valor,
				'Juros' => $B->juros,
				'Multa' => $B->multa);
	$result = $clientSoap->execute( $params );

	$cod_bar = $result->Strbar;
	
	//GRAVA O CODIGO DE BARRAS
	$grava = atualizar("estabelecimentos_boletos", "codigo_barras='$cod_bar'", "id='".$B->id."'");
	
	$B->codigo_barras = $cod_bar;
}


function fbarcode($valor){

	$fino = 1 ;
	$largo = 3 ;
	$altura = 50 ;

	  $barcodes[0] = "00110" ;
	  $barcodes[1] = "10001" ;
	  $barcodes[2] = "01001" ;
	  $barcodes[3] = "11000" ;
	  $barcodes[4] = "00101" ;
	  $barcodes[5] = "10100" ;
	  $barcodes[6] = "01100" ;
	  $barcodes[7] = "00011" ;
	  $barcodes[8] = "10010" ;
	  $barcodes[9] = "01010" ;
	  for($f1=9;$f1>=0;$f1--){
		for($f2=9;$f2>=0;$f2--){
		  $f = ($f1 * 10) + $f2 ;
		  $texto = "" ;
		  for($i=1;$i<6;$i++){
			$texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
		  }
		  $barcodes[$f] = $texto;
		}
	  }


	//Desenho da barra


	//Guarda inicial
	?><img src=<?=URL_SISTEMA?>/app-assets/images/boleto/p.gif width=<?=$fino?> height=<?=$altura?> border=0><img
	src=<?=URL_SISTEMA?>/app-assets/images/boleto/b.gif width=<?=$fino?> height=<?=$altura?> border=0><img
	src=<?=URL_SISTEMA?>/app-assets/images/boleto/p.gif width=<?=$fino?> height=<?=$altura?> border=0><img
	src=<?=URL_SISTEMA?>/app-assets/images/boleto/b.gif width=<?=$fino?> height=<?=$altura?> border=0><img
	<?php
	$texto = $valor ;
	if((strlen($texto) % 2) <> 0){
		$texto = "0" . $texto;
	}

	// Draw dos dados
	while (strlen($texto) > 0) {
	  $i = round(esquerda($texto,2));
	  $texto = direita($texto,strlen($texto)-2);
	  $f = $barcodes[$i];
	  for($i=1;$i<11;$i+=2){
		if (substr($f,($i-1),1) == "0") {
		  $f1 = $fino ;
		}else{
		  $f1 = $largo ;
		}
	?>
		src=<?=URL_SISTEMA?>/app-assets/images/boleto/p.gif width=<?=$f1?> height=<?=$altura?> border=0><img
	<?php
		if (substr($f,$i,1) == "0") {
		  $f2 = $fino ;
		}else{
		  $f2 = $largo ;
		}
	?>
		src=<?=URL_SISTEMA?>/app-assets/images/boleto/b.gif width=<?=$f2?> height=<?=$altura?> border=0><img
	<?php
	  }
	}

	// Draw guarda final
	?>
	src=<?=URL_SISTEMA?>/app-assets/images/boleto/p.gif width=<?=$largo?> height=<?=$altura?> border=0><img
	src=<?=URL_SISTEMA?>/app-assets/images/boleto/b.gif width=<?=$fino?> height=<?=$altura?> border=0><img
	src=<?=URL_SISTEMA?>/app-assets/images/boleto/p.gif width=<?=1?> height=<?=$altura?> border=0>
	  <?php
} //Fim da função

function esquerda($entra,$comp){
    return substr($entra,0,$comp);
}

function direita($entra,$comp){
    return substr($entra,strlen($entra)-$comp,$comp);
}

