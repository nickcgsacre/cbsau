<?php 
include_once("../../config/db.php");
include_once("../../modulos/modulos.php");

if($_POST['acao'] == 'consultar'){
$associado = strip_tags($_POST['associado']);
$DADOS = listar("associados", "nome like'%".$associado."%' or cpf like '%".$associado."%' or matricula like '%".$associado."%'");
$Json = array("resposta" => $DADOS);
echo json_encode($Json);
} 