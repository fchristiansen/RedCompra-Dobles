<?php
session_start();
date_default_timezone_set('America/Santiago');
require_once ('MysqliDb.php');
require_once('config.php');
$db = new MysqliDb (DBHOST, DBUSER, DBPASS, DBNAME);

//validar que post de ajax
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

if(!$ajax){
	echo "error";
   	return false;
}

$voto = "";
$mssg = "";

if(isset($_SESSION['usrRedCompra']) && !empty($_POST['voto'])) {
	$idUsuario = $_SESSION['usrRedCompra'];
	$idDoble = $_POST["voto"];

	//guardar voto
	$data = array('idUsuario' => $idUsuario,
					'idDoble' => $idDoble,
					'fechaVoto' => date('Y-m-d H:i:s')
				);
	$id2 = $db->insert ('votos', $data);
	if($id2){
		$mssg = "ok";
	}else{
		$mssg = "error";
	}

	
}else{
	$mssg = "error";
}

echo $mssg;