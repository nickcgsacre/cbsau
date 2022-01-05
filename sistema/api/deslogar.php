<?php 

if( session_destroy() ) {
	$Json = array("resposta" => 1);
} else {
	$Json = array("resposta" => 0);
}

echo json_encode($Json);