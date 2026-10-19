<?php
	include 'core.inc.php';
	//only use if not on index.php
	if(logged_in()){redirect('index.php');}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8"/>
	<meta name="description" content="Yearbook [Schoolname]"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<title>Year Book - Đăng ký</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="main.css">
	<script src="main.js"></script>
</head>
<body>
	<div class="page">
		<header class="title">
			<h1>Year Book</h1>
		</header>

		<nav class="navbar">
			<a href="index.php">Home Page</a>
			<a href="class.php">Class Members</a>
			<a href="user.php">My profile</a>
			<a href="gallery.php">Photo Gallery</a>
			<a href="polls.php">Polls</a>
			<a href="stories.php">Stories</a>
		</nav>

		<?php
		
		
		?>
		<section class="signup-wrap">
			<?php sign_up($con); ?>
			<p class="form-note">Đã có tài khoản? <a href="index.php">Đăng nhập</a></p>
		</section>

		<footer>-made with love by npgb-</footer>
	</div>

	
</body>
</html>