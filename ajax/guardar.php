<?php
session_start();
date_default_timezone_set('America/Santiago');
require_once ('MysqliDb.php');
require_once('config.php');
$db = new MysqliDb (DBHOST, DBUSER, DBPASS, DBNAME);

//validar que post de ajax
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

$mssg = "";

if(!$ajax){
	echo "error";
   	return false;
}

// Chequear campos vacíos
if(empty($_POST['rut']) || empty($_POST['captcha']) || empty($_POST['doble']) ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "error";
   return false;
}

//chequear Captcha
if(strtoupper($_POST['captcha']) == $_SESSION['captcha_id']){
	$captcha = true;
}else{
	$captcha = false;
}

function valida_rut($rut)
{
    $rut = preg_replace('/[^k0-9]/i', '', $rut);
    $dv  = substr($rut, -1);
    $numero = substr($rut, 0, strlen($rut)-1);
    $i = 2;
    $suma = 0;
    foreach(array_reverse(str_split($numero)) as $v)
    {
        if($i==8)
            $i = 2;
        $suma += $v * $i;
        ++$i;
    }
    $dvr = 11 - ($suma % 11);
    
    if($dvr == 11)
        $dvr = 0;
    if($dvr == 10)
        $dvr = 'K';
    if($dvr == strtoupper($dv))
        return true;
    else
        return false;
}

$rut = strip_tags(htmlspecialchars($_POST['rut']));
$idDoble = strip_tags(htmlspecialchars($_POST['doble']));
$mail = strip_tags(htmlspecialchars($_POST['email']));

$rut = str_replace(".", "", $rut);
$mail = strtolower($mail);

//validar rut con funcion php
$rutValido = valida_rut($rut);

if($captcha && $rutValido) {

$id = 0;
//buscar si ya existe
$result = $db->rawQuery('SELECT * from participantes where rut = ?', Array ($rut));

	if($db->count == 0){
		$data = Array (
				'rut' => $rut, 
				'email' => $mail, 
				'fechaRegistro' => date('Y-m-d H:i:s')
				);
		$id = $db->insert ('participantes', $data);
		if(!$id){
			$mssg = "error";
		}

	}else{
		//echo "existe";
		foreach ($result as $row) {
			$id = $row["idUsuario"];
		}
	}
	if($id >= 1){
		$_SESSION['usrRedCompra'] = $id;
		//guardar voto
		$data = array('idUsuario' => $id,
						'idDoble' => $idDoble,
						'fechaVoto' => date('Y-m-d H:i:s')
					);
		$id2 = $db->insert ('votos', $data);
		if($id2){
			$mssg = "ok";
		}else{
			$mssg = "error";
		}
	}
}else{
	$mssg = "error";
}

echo $mssg;
?>