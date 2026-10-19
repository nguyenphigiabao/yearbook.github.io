<?php
	include 'core.inc.php';
	//only use if not on index.php
	if(!logged_in()){redirect('index.php');}

	//get user id from the url using GET, if not set, show user's own profile
	if(isset($_GET['id'])&&intval($_GET['id']>=1)){
		$user_id = $_GET['id'];
	}else{
		$user_id = $_SESSION['user_id'];
	}
	
	
	//get profile data
	$select_user_data = "SELECT  * FROM user WHERE id=".mysqli_real_escape_string($con,$user_id)." ";
	$run_user_data = mysqli_query($con,$select_user_data);
	$user = mysqli_fetch_assoc($run_user_data); //user data you can now access as for example $user['email'] 
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Yearbook [Scoolname]"/>
	<meta name=viewport content='width=520'>
	<link rel="shortcut icon" href="favicon.png" type="image/png"/>
	<title>Yearbook [schoolname]</title>
	<link rel="stylesheet" href="main.css" />
	<!--<script src="main.js"></script>-->
</head>
<body>
	<div class="page">
	
<?php
	include 'header.inc.php';
 
	if(!$user){
		echo '<div class="card"><p>Không tìm thấy người dùng này.</p></div>';
	}else{
		echo '<h1 class="profile-name">'.htmlspecialchars($user['user_name']).'</h1>';
		echo '<div class="card profile-card">
			<div class="profile-photo">'.user_image($user_id,2).'</div>
			<ul class="profile-info">
				<li><span>Giới tính</span>'.htmlspecialchars(ucfirst($user['gender'])).'</li>
				<li><span>Ngày sinh</span>'.htmlspecialchars($user['birth_date']).'</li>
				<li><span>E-mail</span>'.htmlspecialchars($user['email']).'</li>
			</ul>
		</div>';
		show_user_stories($con,$user_id);
	}
?>
		<!--
			the content
		-->
</div>
</body>
</html>