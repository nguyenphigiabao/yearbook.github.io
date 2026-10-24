<?php
	include 'core.inc.php';
	//only use if not on index.php
	if(!logged_in()){redirect('index.php');}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8"/>
	<meta name="description" content="Yearbook [Schoolname]"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<title>Year Book - Photo Gallery</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="main.css">
	<script src="main.js"></script>
</head>
<body>
	<div class="page">
        <?php 
            include 'header.inc.php'; 
            echo '<h2 class="page-heading">Photo Gallery</h2>';
            get_pictures($con);
        ?>
</body>
</html>