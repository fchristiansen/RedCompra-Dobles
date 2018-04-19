<?php 
// Make the page validate
ini_set('session.use_trans_sid', '0');

// Include the random string file
require 'rand.php';

// Begin the session
session_start();

// Set the session contents
$_SESSION['captcha_id'] = $str;

require_once('ajax/MysqliDb.php');
require_once('ajax/config.php');
$db = new MysqliDb (DBHOST, DBUSER, DBPASS, DBNAME);
?>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Redcompra - Dobles</title>

	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="assets/css/fonts.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/custom.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div id="background"></div>


  	<section id="video">
  		<div class="heading">
  			<div class="logo center-block">
				<img class="img-responsive img-logo" src="assets/img/logo.png" alt="">
			</div>
	  		<div class="video-container">
				<div class="embed-container">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/uZFTK0sEMMs?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				</div>
	  		</div>
			<div class="text-center">
				<a class="btn btn-default btn-participa scroll-to" href="#dobleslink">participa aquí</a>
			</div>
  		</div>
  	</section> <!-- video -->
<div id="dobleslink"></div>
  	<section id="grid-dobles">
  		<div class="container">

  			<h1>¡vota por tu <span class="bold">favorito!</span></h1>

  			<div class="row">
  				<?php
				$db->orderBy("RAND ()");
				$results = $db->get('dobles');
				foreach ($results as $row) :
					$img = $row["imagen"];
				?>
				<div class="col-xs-6 col-sm-3 col-md-3">
					<div class="caja-doble">
						<a href="javascript:void(0);" class="btn-doble" data-id="<?php echo $row['idDoble'];?>" data-img="<?php echo $img;?>">
							<img class="img-responsive img-circle center-block img-doble" src="assets/img/<?php echo $img;?>">
						</a>
						<a href="javascript:void(0);" class="btn btn-default btn-vota" id="<?php echo $row['idDoble'];?>" data-img="<?php echo $img;?>">votar</a>
					</div>
				</div>
				<?php endforeach;?>
				
  			</div>
  		</div>
  	</section> <!-- grid dobles -->
	<footer>
		<div class="container position-relative">
			<div class="logo-footer center-block">
				<img class="img-responsive logo-footer" src="assets/img/logo-redcompra-footer.png" alt="">
			</div>
			<div class="rrss">
			<ul>
				<li><a href="#" target="_blank">Bases Legales</a></li>
				<li class="divisor"> | </li>
				<li><a class="icon-wrapper" href="https://www.facebook.com/RedcompraCL/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
				<li><a class="icon-wrapper" href="https://twitter.com/redcompracl?lang=es" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
			</ul>
		</div>
		</div>

	</footer>

    

	<!-- Modal -->
	<div class="modal fade" id="modal-voto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body">
		  	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  	   	 <div class="title" id="title-form">
			  	   	 	<h1>completa tus datos</h1>
			  	 		<h2>para participar</h2>
			  	   	 </div>
			  	   	 <div class="title" id="title-gracias" style="display: none;">
			  	   	 	<h2>gracias</h2>
			  	   	 	<h1>por votar por</h1>
			  	   	 </div>

				<form id="formDatos" class="center-block" method="post" action="ajax/guardar.php">
					<div class="form-group">
						<input type="hidden" name="doble" id="id-doble" value="">
						<input id="rut" name="rut" type="text" class="form-control rut" placeholder="RUT" data-trigger="focus" data-toggle="tooltip" data-container="body" data-placement="top" data-title="Recuerda ingresar un RUT válido." required="">
					</div>
					<div class="form-group">
						<input name="email" type="email" class="form-control" placeholder="EMAIL" data-trigger="focus" data-toggle="tooltip" data-container="body" data-placement="top" data-title="Recuerda ingresar  un email válido. Así podremos contactarte si eres ganador." required="">
					</div>
					<div class="form-group">
						<div id="captchaimage"><img src="images/image.php?<?php echo time(); ?>" width="132" height="46" alt="Captcha image">
						<a href="<?php echo htmlEntities($_SERVER['PHP_SELF'], ENT_QUOTES); ?>" id="refreshimg">Refrescar imagen</a></div>
						<label for="captcha">
						Ingrese los caracteres como se ve en la imagen de arriba (case insensitive):</label>
						<input type="text" maxlength="6" name="captcha" id="captcha" class="form-control">
					</div>
					<button type="submit" class="btn btn-default btn-enviar-voto center-block">votar</button>
				</form>
				<!-- gracias -->

				  	 <div class="caja-doble" style="display: none;" id="caja-gracias">
				  	 	<img class="img-responsive img-circle center-block img-doble" src="" id="img-artista">
				  	 		<p>Ya estás participando <br>
						por espectaculares premios </p>
						<a class="btn btn-default btn-enviar-voto center-block" data-dismiss="modal">cerrar</a>
				  	 </div>
		  </div>
		</div>
		</div>
	</div> <!-- modal registro -->

	<!-- Modal -->
	<div class="modal fade" id="modal-gracias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body">
		  	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  	 <div class="title">
			  	 	<h2>gracias</h2>
			  	 	<h1>por votar por</h1>
			  	 </div>
			  	 <div class="caja-doble">
			  	 	<img class="img-responsive img-circle center-block img-doble" src="https://api.fnkr.net/testimg/150x150/00CED1/FFF/?text=img+placeholder">
			  	 		<p>Ya estás participando <br>
				     	por espectaculares premios </p>
					<a class="btn btn-default btn-enviar-voto center-block" data-dismiss="modal">cerrar</a>
			  	 </div>
		  </div>
		</div>
		</div>
	</div> <!-- modal gracias -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="assets/vendor/jquery/jquery.form.min.js"></script>
    <script src="assets/vendor/jquery/jquery.Rut.min.js" type="text/javascript"></script>
	<script src="assets/vendor/jquery/jquery.validate.min.js"></script>
    <script src="assets/js/dobles.js"></script>
    <script src="assets/js/app.js"></script>
  </body>
</html>
