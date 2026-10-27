<?php
	include 'core.inc.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8"/>
	<meta name="description" content="Yearbook [Schoolname]"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<title>Year Book - Đăng nhập</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="main.css">
	<script src="main.js"></script>
</head>
<body>
	<div class="page">
		<?php include 'header.inc.php'; ?>

		<section class="signup-wrap">
			<?php if(!logged_in()){ ?>
				<div class="login-card">
					<h2>Đăng nhập</h2>
					<?php log_in($con); ?>
					<p class="form-note">Chưa có tài khoản? <a href="signup.php">Đăng ký</a></p>
				</div>
			<?php } else { ?>
				<div class="login-card">
					<h2>Đăng nhập thành công 🎉</h2>
					<p class="form-note">Chào mừng bạn đến với Year Book!</p>
					<p class="form-note">
						<a href="home.php">Vào trang chủ</a>
					</p>
				</div>
			<?php } ?>
		</section>

	</div>
</body>
</html>