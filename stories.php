<?php
	include 'core.inc.php';
	//only use if not on index.php
	if(!logged_in()){redirect('index.php');}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Yearbook [Scoolname]"/>
	<meta name=viewport content='width=520'>
	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<title>Yearbook [schoolname]</title>
	<link rel="stylesheet" href="main.css" />
	<script src="main.js"></script>
</head>
<body>

	<div class="page">
	<?php include 'header.inc.php'; 
	 show_user_stories($con,0);?>
		<!--
			the content
		-->
		
	</div>
</div>
</body>
</html>