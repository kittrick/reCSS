<?php
/* Require Classes */
require_once('classes.php');

/* Init Classes */
$Parse = new Parse;

/* Parse Based on Submission Type */
if(!empty($_POST)){
	
	/* Create Local Vars */
	$input = $_POST;
	
	/* Parse Based on Type */
	$Parse->parseText($input['text']);
	
	/* Strip Commments */
	if(isset($input['comments'])) $Parse->stripComments();
	
	/* Minify */
	if(isset($input['minify'])) $Parse->minify();
	
}

/* Under Construction Warning (Heloo 1995) */
$Parse->addStatus('warning','ReCSS is a work in Progress, not ready yet!');

/* Create Local Vars */
$status = $Parse->status;
$response = $Parse->response;