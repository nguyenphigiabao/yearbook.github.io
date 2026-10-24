<?php
	include 'core.inc.php';
	

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Yearbook [Scoolname]"/>
	<meta name=viewport content='width=device-width, initial-scale=1.0'>
	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<title>Yearbook - Đăng nhập</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="main.css" />
	<script src="main.js"></script>
</head>
<body>
	<div class="page">
		
		<?php
			include 'header.inc.php';
		?>
		<section class="signup-wrap">
			<?php if(!logged_in()){ ?>
				<div class="login-card">
					<h2>Đăng nhập</h2>
					<?php log_in($con); ?>
					<p class="form-note">Chưa có tài khoản? <a href="signup.php">Đăng ký</a></p>
				</div>
				<?php } else { ?>
					<div class="login-card">
						<h2>Đăng nhập thành công</h2>
						<p class="form-note">Chào mừng bạn đến với YearBook!</p>
						<p class="form-note">
							<a href="yearbookprojectbase.html">Vào trang chủ</a>
							<a href="logout.php>">Đăng xuất</a>
						</p>
					</div>
				<?php } ?>
		</section>
		</section>
	</div>
	<script>
	document.querySelectorAll('input[type="password"]').forEach(function (input) {
		var parent = input.parentNode;
		var label = input.previousElementSibling;

		var wrap = document.createElement('span');
		wrap.style.cssText = 'position:relative;display:block;flex:1 1 auto;width:100%;';
		parent.insertBefore(wrap, input);
		wrap.appendChild(input);
		input.style.setProperty('padding-right', '46px', 'important');

		if (label && label.tagName === 'LABEL') {
			parent.style.cssText += ';display:flex;align-items:center;gap:16px;';
			label.style.flex = '0 0 150px';
		}

		var eye = document.createElement('span');
		eye.textContent = '👁';
		eye.title = 'Hiện/ẩn mật khẩu';
		eye.style.cssText = 'position:absolute;right:16px;top:50%;transform:translateY(-50%);cursor:pointer;user-select:none;font-size:18px;opacity:.5;';
		wrap.appendChild(eye);
		eye.addEventListener('click', function () {
			var hidden = input.type === 'password';
			input.type = hidden ? 'text' : 'password';
			eye.style.opacity = hidden ? '1' : '.5';
		});
	});
	</script>
</body>
</html>