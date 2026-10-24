<?php
	include 'core.inc.php';
	//only use if not on index.php
	if(!logged_in()){redirect('index.php');}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="description" content="Yearbook [Schoolname]"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<title>Year Book - Thành viên lớp</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="main.css">
	<script src="main.js"></script>
</head>
<body>

	<div class="page">
	<?php 
		include 'header.inc.php';
		show_class_mates($con,1);
	?>
		<!--
			the content
		-->
		
		
	</div>
</div>
</body>
</html>