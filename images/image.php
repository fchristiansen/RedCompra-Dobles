<?php

// Begin the session
session_start();

// If the session is not present, set the variable to an error message
if(!isset($_SESSION['captcha_id']))
	$str = 'ERROR!';
// Else if it is present, set the variable to the session contents
else
	$str = $_SESSION['captcha_id'];

$path = getcwd();



// Create an image from button.png
$image = imagecreatefrompng('button.png');

// Set the font colour
$colour = imagecolorallocate($image, 255, 255, 255);

// Set the font
$font = $path.'/Anorexia.ttf';

// Set a random integer for the rotation between -15 and 15 degrees
$rotate = rand(-15, 15);

// Create an image using our original image and adding the detail
imagettftext($image, 14, $rotate, 18, 30, $colour, $font, $str);

// Set the content type
header('Content-Type: image/png');
header('Cache-Control: no-cache');
// Output the image as a png
imagepng($image);
