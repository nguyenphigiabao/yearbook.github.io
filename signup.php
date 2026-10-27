<?php
	include 'core.inc.php';
	//only use if not on index.php
	if(logged_in()){redirect('index.php');}
	$empty_error='';
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		foreach($_POST as $value) {
			if(is_string($value) && trim($value) === '') {
				$empty_error = 'Vui lòng điền đầy đủ thông tin các ô.';
				$_POST = array();
				break;
			}
		}
	}
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
		
		<?php
			include 'header.inc.php';
		
		?>
		<section class="signup-wrap">
			<?php sign_up($con); ?>
			<p class="form-note">Đã có tài khoản? <a href="index.php">Đăng nhập</a></p>
		</section>

		<footer>-cun-</footer>
	</div>

	<script>
	// 1. Bắt buộc điền mọi ô (trừ nút bấm và ô chọn file)
	document.querySelectorAll('.signup-wrap input, .signup-wrap select, .signup-wrap textarea').forEach(function (el) {
		var skip = ['submit', 'button', 'hidden', 'file', 'image', 'reset'];
		if (skip.indexOf(el.type) !== -1) return;
		el.required = true;
		el.addEventListener('invalid', function () {
			if (el.validity.valueMissing) { el.setCustomValidity('Vui lòng điền vào ô này.'); }
		});
		el.addEventListener('input', function () { el.setCustomValidity(''); });
	});
 
	// 2. Tô đỏ các thông báo lỗi do sign_up() in ra
	(function () {
		var KEY = /đã được sử dụng|không hợp lệ|không khớp|không đúng|vui lòng|bắt buộc/i;
		document.querySelectorAll('.signup-wrap *').forEach(function (el) {
			if (el.closest('label, h1, h2, h3, button, option, select, textarea')) return;
			if (el.classList.contains('error') || el.classList.contains('form-note')) return;
			var onlyLinks = Array.prototype.every.call(el.children, function (c) { return c.tagName === 'A'; });
			if (onlyLinks && KEY.test(el.textContent)) { el.classList.add('error'); }
		});
	})();
 
	// 3. Icon 👁 ở cuối ô mật khẩu
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