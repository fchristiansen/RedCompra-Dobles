<?php
session_start();
if(!isset($_SESSION['usrRedCompra'])) {
    // session isn't started
    echo "1";
}else{
	echo "2";
}
?>