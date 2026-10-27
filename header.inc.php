

<header class="title">
	<h1>Yearbook <?php if(logged_in()){echo $_SESSION['class'];}?></h1>
</header>
	<?php if(logged_in()){
		echo '<nav class="navbar" >
				<a href="index.php">Trang chủ</a>
				<a href="class.php">Thành viên lớp</a>
				<a href="gallery.php">Thư viện ảnh</a>
				<a href="polls.php">Bình chọn</a>
				<a href="stories.php">Câu chuyện</a>
				<a href="user.php">Hồ sơ của tôi</a>
				';log_out();
			echo  '</nav>';
	};?>
</header>
