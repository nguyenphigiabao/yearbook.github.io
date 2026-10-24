

<header class="title">
	<h1>Yearbook <?php if(logged_in()){echo $_SESSION['class'];}?></h1>
</header>
	<?php if(logged_in()){
		echo '<nav class="navbar" >
				<a href="index.php">Home Page</a>
				<a href="class.php">Class Members</a>
				<a href="user.php">My profile</a>
				<a href="gallery.php">Photo Gallery</a>
				<a href="polls.php">Polls</a>
				<a href="stories.php">Stories</a>
				';log_out();
			echo  '</nav>';
	};?>
</header>
