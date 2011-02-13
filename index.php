<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>reCSS</title>
		<meta description="Convert XML and HTML to CSS" />
		<meta keywords="reCSS, xml, html, css, converter, convert, conversion" />
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script src="scripts.js"></script>
	</head>
	<body>
		<fieldset>
			<legend>reCSS<span>beta</span></legend>
			<p>XML to CSS converter</p>
			<p>
				reCSS takes an XML document and breaks it into a
				well formatted CSS document with classes, ids and
				tabbed inheritance. Hit submit, you'll see what I'm
				talkin' about.
			</p>
			<p id="status"></p>
			<hr />
			<form id="form" action="#" method="get">
				<label for="url">Enter your URL here:</label>
				<input type="text" name="url" id="url" />
				<label id="loading" for="submit">&nbsp;</label>
				<input type="submit" name="submit" id="submit" />
			</form>
		</fieldset>
	</body>
</html>