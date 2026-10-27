<header class="title">
    <h1>Year Book</h1>
</header>


<nav class="navbar">
	<a href="index.php">Home Page</a>
	<a href="class.php">Class Members</a>
	<?php if(logged_in()){ ?>
		<a href="user.php">My profile</a>
	<?php } ?>
	<a href="gallery.php">Photo Gallery</a>
	<a href="polls.php">Polls</a>
	<a href="stories.php">Stories</a>
	<?php if(logged_in()){ ?>
		<a href="logout.php" class="logout-btn">Log out</a>
	<?php } ?>
</nav>
