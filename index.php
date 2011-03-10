<?php
/* Error Reporting */
	ini_set("display_errors", 1);
	error_reporting(E_ALL);
	
/* Init System */
	require_once('system.php');
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>ReCSS</title>
 		<link rel="stylesheet" href="css/boilerplate.css" />
 		<link rel="stylesheet" href="css/styles.css" />
 		<link rel="stylesheet" href="css/SyntaxHighlighterModified.css" />
	</head>
	<body>
		<div id="panel">
			<fieldset class="clearfix">
				<h1>ReCSS<span class="pink">beta</span></h1>
				<p>ReCSS takes raw CSS and prettifies it to your specifications. Currently a work in progress...</p>
				<form id="form" action="#" method="post">
					<hr />
					<h2>Preferences:</h2>
					<label for="comments">Strip Comments</label>
					<input type="checkbox" name="comments" id="comments" />
					<label for="minify">Minify</label>
					<input type="checkbox" name="minify" id="minify" />
					<hr />
					<h2>Add Your CSS:</h2>
					<label for="css-text">Paste Your Code Here: </label><textarea name="text" id="css-text"></textarea>
					<label for="sumbit" id="doit">Do it!</label>
					<input type="submit" name="submit" value="submit" id="submit"/>
				</form>
			</fieldset>
		</div>
		<div id="result">
			<div id="status">
				<?php echo $status; ?>
			</div>
			<div id="codearea">
				<pre name="code" class="javascript" id="code"><?php echo $response; ?></pre>
			</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
		<script>window.jQuery || document.write('<script src="js/libs/jquery-1.5.1.min.js">\x3C/script>')</script>
		<script src="js/scrollto.jquery.js"></script>
		<script src="js/tabby.jquery.js"></script>
		<script src="js/shCoreStaticMaker.js"></script>
		<script src="js/shBrushCss.js"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>