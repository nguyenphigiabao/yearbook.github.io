<?php
	include 'core.inc.php';
    include 'home.inc.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8"/>
	<meta name="description" content="Yearbook [Schoolname]"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<title>Year Book - <?php echo logged_in() ? 'Trang chủ' : 'Đăng nhập'; ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="main.css">
	<script src="main.js"></script>
</head>
<body>
	<div class="page">
        <?php 
            include 'header.inc.php';
        ?>
		<?php if(!logged_in()){ ?>
			<section class="signup-wrap">
				<div class="login-card">
					<h2>Đăng Nhập</h2>
						<?php log_in($con); ?>
						<p class="form-note">Chưa có tài khoản? <a href="signup.php">Đăng ký</a></p>
				</div>
			</section>
		<?php } else { show_home($con); } ?>

	</div>
</body>
</html>