<?php

//basic set up for php project, start session so you can use $_SESSION variables, and include the connections
session_start();
include 'connect.inc.php';
include 'images.inc.php';

//redirect to another page
function redirect($url){
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
        }
    else
        {  
        echo '<script type="text/javascript">
				window.location.href="'.$url.'";
			  </script>
              <noscript>
					<meta http-equiv="refresh" content="0;url='.$url.'" />
			  </noscript>'; 
			  exit;
    }
}

//check if user is logged in, checks if user if is set, and if system is Yearbook, we'll set these at log in
function logged_in(){
	 if(isset($_SESSION['user_id'])&&intval($_SESSION['user_id'])>=1&&isset($_SESSION['class'])&&$_SESSION['loggedin']==1){
		return true;	
	 }else{
		return false;
		}
	}


//unsets the loggin setting and returns to main page
function log_out(){
	echo '<form action="" method="POST">
		<input type="submit" class="submit-btn-small" name="logout" value="Log out"></form>';
	if(isset($_POST['logout'])){
		session_destroy();
		redirect('index.php');
	}
}

function log_in($con){
	echo '<form action="" method="POST">
			E-mail: <input type="email" name="email" required> <br>
			Password <input type="password" name="password">  <br>
			<input type="submit" name="loggin" value="Log-in">
		 </form>';
		 
	if(isset($_POST['loggin'])){
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password_hash = hash("sha256", $password);
		//see if there is a user with this email and password combination
		$select_user = "SELECT * FROM user WHERE email='".mysqli_real_escape_string($con,$email)."' AND password='".mysqli_real_escape_string($con,$password_hash)."'";
		$run = mysqli_query($con, $select_user);
		if(mysqli_num_rows($run)!=1){
			echo '<p style="color: red;">Sai mật khẩu hoặc E-mail</p>';
		}else{
			$user = mysqli_fetch_assoc($run);
			//create a session 
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['class'] = $user['class'];
			$_SESSION['loggedin'] = 1;
			redirect('index.php');
		}
	}
}



function user_image($user_id,$switch){
	if($switch==1){
		$class = 'small_thumbnail';
	}else{
		$class = 'thumbnail';
	}
	$url = 'user.php?id='.$user_id;
	 if(file_exists('uploads/profile_'.$user_id.'.png')){
			$img =  '<div class="'.$class.'"><img src="uploads/profile_'.$user_id.'.png" ></div>';
			if($switch==2){$img .= delete_image($url, $user_id,'png','profile');}
		}else if(file_exists('uploads/profile_'.$user_id.'.jpg')){
			$img =  '<div class="'.$class.'"><img  src="uploads/profile_'.$user_id.'.jpg" ></div>';
			if($switch==2){$img .= delete_image($url, $user_id,'jpg','profile');}
		}else if(file_exists('uploads/profile_'.$user_id.'.jpeg')){
			$img =  '<div class="'.$class.'"><img  src="uploads/profile_'.$user_id.'.jpeg"></div>';
			if($switch==2){$img .= delete_image($url, $user_id,'jpeg','profile');}
		}else if(file_exists('uploads/profile_'.$user_id.'.gif')){
			$img =  '<div class="'.$class.'"><img  src="uploads/profile_'.$user_id.'.gif" ></div>';
			if($switch==2){$img .= delete_image($url, $user_id,'gif','profile');}
		}else{
			$img = '<div class="'.$class.'"><img  src="img/portrait.png" ></div>';
			if($switch==2){
				if($user_id==$_SESSION['user_id']){
			$img .=  '<form enctype="multipart/form-data" action="upload_profile_image.php?user_id='.$user_id.'" method="POST" style="display:inline-block;font-size:12px;">
					Thêm ảnh đại diện (.png, .jpg hoặc .jpeg): <br/><input name="uploaded" type="file" /><br />
					<input type="submit" value="Upload" class="small_button" />
				</form><br/>'; 
															 
			if(isset($_GET['file_error'])){
					 $img .=  '<p>Xin lỗi, chỉ chấp nhận các tệp có định dạng .jpg, .jpeg và .png.</p>';
			}
			if(isset($_GET['size_error'])){
				 $img .=  '<p>Rất tiếc, tệp được tải lên quá lớn. Dung lượng tối đa là 3MB.</p>';
			}
			if(isset($_GET['type_error'])){
				$img .=  '<p>Tệp được tải lên không phải là hình ảnh.</p>';
			}
		}
			}
		}
		
		return $img;
}

function delete_image($url, $id, $extension,$name){
	$delete = '';
	if(($_SESSION['user_id']==$id)){
		$delete .= '<p><a  href="'.$url.'&delete_image='.$id.'"  style="font-size:12px;">Xóa hình ảnh</a></p>';
	}
	
	if(isset($_GET['delete_image'])&&$_GET['delete_image']==$id&&$_SESSION['user_id']==$id&&$name=='profile'){
		$file_to_delete = 'uploads/'.$name.'_'.$id.'.'.$extension;
		if(unlink($file_to_delete)){
			redirect($url);	
		}else{
			$delete .= 'Verwijderen mislukt.';
		}
	}
	return $delete;
}



function sign_up($con){    
	$form = '<h1>FORM ĐĂNG KÝ</h1>
            <form action="" method="POST">
			<table>
			<tr>
				<td><label for="fname">Họ & Tên:</label></td>
				<td><input type="text" id="fname" name="fname"></td>
			</tr>
            <tr>
				<td><label for="email">Email:</label></td>
				<td><input type="email" id="email" name="email"></td>
			</tr>
            <tr>
				<td><label for="password">Password:</label></td>
				<td><input type="password" id="password" name="password"></td>
			</tr>
            <tr>
				<td><lable for="ngày sinh">Ngày Sinh:</lable></td>
				<td><input type="date" name="birth_date"></td>
			</tr>
            <tr>
				<td><lable for="giới tính">Giới Tính:</lable></td>
				<td><input type="radio" name="gender" value="nam" checked>Nam 
            <input type="radio" name="gender" value="nữ">Nữ 
            <input type="radio" name="gender" value="khác">Khác </td>
			</tr>
            <tr>
				<td><label for="lớp">Lớp:</label></td>
				<td><select id="Lớp" name="class">
                <option value="12 Anh 1">12 Anh 1</option>
                <option value="12 Anh 2">12 Anh 2</option>
                <option value="12 Toán 1">12 Toán 1</option>
                <option value="12 Toán 2">12 Toán 2</option>
                <option value="12 Lý">12 Lý</option>
                <option value="12 Hoá">12 Hoá</option>
                <option value="12 Sinh">12 Sinh</option>
                <option value="12 Tin">12 Tin</option>
                <option value="12 Văn">12 Văn</option>
                <option value="12 Sử">12 Sử</option>
                <option value="12 Địa">12 Địa</option>
                <option value="12 Pháp">12 Pháp</option>
                <option value="12 Trung">12 Trung</option>
            </select>
            </td></tr>
			</table>
			<br>
			<h2><lable for="ảnh đại diện">Ảnh Đại Diện:</lable></h2>
           
		   <div class="form-container">
                <div class="form-group">
                    <lable>Lời tự nhủ trong kỉ yếu:</lable><br>
                    <input type="text" name="question_1">
                </div>
            
			
                <div class="form-group">
                    <label>Giới thiệu bản thân:</label><br>
                    <textarea name="question_2"></textarea>
                </div>
			
			
                <div class="form-group">
                    <label>Công việc mơ ước trong tương lai:</label><br>
                    <input type="text" name="question_3">
                </div>
			
			
                <div class="form-group">
                    <lable>Lời nhắn đến bản thân trong tương lai:</lable><br>
                    <textarea name="question_4"></textarea>
                </div>
			
                <div class="form-group">
                    <label>Kỉ niệm đáng nhớ thời cấp ba:</label><br>
                    <textarea name="question_5"></textarea>
                </div>
			
			
                <div class="form-group"> 
                    <label>Môn học yêu thích:</label> <br>
                    <input type="text" name="question_6"> 
                </div>
			
			
			
                <div class="form-group">
                    <label>Góc confession ẩn danh:</label><br>
                    <textarea name="question_7" placeholder="Sẽ không ai biết bạn viết ra những điều này"></textarea>
                </div>
            </div>
            <br>
            <br>
            <input type="submit" name="save" class="submit-btn" value="Submit">
        </form>';
		echo '<div class="card">';
		if(isset($_POST['loggin'])){
			echo '<h1>ĐĂNG KÝ THÀNH CÔNG</h1>';
				log_in($con);
		}else 
        if(isset($_POST['save'])) {
			
            $fname=$_POST['fname'];
            $femail=$_POST['email'];
            $fpassword=$_POST['password'];
            $fpassword_hash = hash("sha256", $fpassword);
            $fbirth_date=$_POST['birth_date'];
            $fgender=$_POST['gender'];
            $fclass=$_POST['class'];
            $fquestion_1=$_POST['question_1'];
            $fquestion_2=$_POST['question_2'];
            $fquestion_3=$_POST['question_3'];
            $fquestion_4=$_POST['question_4'];
            $fquestion_5=$_POST['question_5'];
            $fquestion_6=$_POST['question_6'];
            $fquestion_7=$_POST['question_7'];
            
			  $select = "SELECT id FROM user WHERE email='".mysqli_real_escape_string($con,$femail)."' ORDER BY id DESC LIMIT 1";
               $run = mysqli_query($con,$select);
			   if(mysqli_num_rows($run)>=1){
				   echo '<p>Email này đã được sử dụng, <a href="index.php">Đăng nhập?</a></p>';
				   echo $form;
			   }else{
			
            $insert = "INSERT INTO user (
		    user_name,
		    class,
		    birth_date,
            gender,
		    email,
		    password
	        ) VALUES (
		    '".mysqli_real_escape_string($con,$fname)."',
		    '".mysqli_real_escape_string($con,$fclass)."',
		    '".mysqli_real_escape_string($con,$fbirth_date)."',
            '".mysqli_real_escape_string($con,$fgender)."',
		    '".mysqli_real_escape_string($con,$femail)."',
		    '".mysqli_real_escape_string($con,$fpassword_hash)."'
	        )";
            
            if(mysqli_query($con,$insert)){
                $select = "SELECT id FROM user WHERE email='".mysqli_real_escape_string($con,$femail)."' ORDER BY id DESC LIMIT 1";
                $run = mysqli_query($con,$select);
                $row = mysqli_fetch_assoc($run); //get data from the query
                $user_id = $row['id']; 

            if(!empty($fquestion_1)){
	            $insert = "INSERT INTO questions (user_id, question, answer) VALUES (
		        $user_id,
		        '".mysqli_real_escape_string($con,"Lời tự nhủ trong kỉ yếu:")."',
		        '".mysqli_real_escape_string($con,$fquestion_1)."'	
		        ) ";
	        mysqli_query($con,$insert);
            }

            if(!empty($fquestion_2)){
	            $insert = "INSERT INTO questions (user_id, question, answer) VALUES (
		        $user_id,
		        '".mysqli_real_escape_string($con,"Giới thiệu bản thân:")."',
		        '".mysqli_real_escape_string($con,$fquestion_2)."'	
		        ) ";
	        mysqli_query($con,$insert);
            }

            if(!empty($fquestion_3)){
	            $insert = "INSERT INTO questions (user_id, question, answer) VALUES (
		        $user_id,
		        '".mysqli_real_escape_string($con,"Công việc mơ ước trong tương lai:")."',
		        '".mysqli_real_escape_string($con,$fquestion_3)."'	
		        ) ";
	        mysqli_query($con,$insert);
            }

            if(!empty($fquestion_4)){
	            $insert = "INSERT INTO questions (user_id, question, answer) VALUES (
		        $user_id,
		        '".mysqli_real_escape_string($con,"Lời nhắn đến bản thân trong tương lai:")."',
		        '".mysqli_real_escape_string($con,$fquestion_4)."'	
		        ) ";
	        mysqli_query($con,$insert);
            }

            if(!empty($fquestion_5)){
	            $insert = "INSERT INTO questions (user_id, question, answer) VALUES (
		        $user_id,
		        '".mysqli_real_escape_string($con,"Kỉ niệm đáng nhớ thời cấp ba:")."',
		        '".mysqli_real_escape_string($con,$fquestion_5)."'	
		        ) ";
	        mysqli_query($con,$insert);
            }

            if(!empty($fquestion_6)){
	            $insert = "INSERT INTO questions (user_id, question, answer) VALUES (
		        $user_id,
		        '".mysqli_real_escape_string($con,"Môn học yêu thích:")."',
		        '".mysqli_real_escape_string($con,$fquestion_6)."'	
		        ) ";
	        mysqli_query($con,$insert);
            }

            if(!empty($fquestion_7)){
	            $insert = "INSERT INTO questions (user_id, question, answer) VALUES (
		        0,
		        '".mysqli_real_escape_string($con,"Góc confession ẩn danh:")."',
		        '".mysqli_real_escape_string($con,$fquestion_7)."'	
		        ) ";
	        mysqli_query($con,$insert);
            }

	            echo '<h1>ĐĂNG KÝ THÀNH CÔNG</h1>';
				log_in($con);
            }else{
	            echo '<h2 class="error">ĐĂNG KÝ KHÔNG THÀNH CÔNG</h2>';
				 echo $form;
            }

			   } 
        } else {
			
			echo $form;
			
        }
		echo '</div>';
		}


function show_class_mates($con){
	$select = "SELECT * FROM user WHERE class='".mysqli_real_escape_string($con,$_SESSION['class'])."'";
	$run = mysqli_query($con,$select);
	if(mysqli_num_rows($run)<1){
		echo '<p>No classmates to show yet.</p>';
	}else{
		echo '
				<h1>Class Members</h1>
				<div class="container">';
		//loop through users 
		while($row = mysqli_fetch_assoc($run)){
			$user_id = $row['id'];
			$name = $row['user_name'];
			echo '<a href="user.php?id='.$user_id.'"><div class="card profile_card">
					'.user_image($user_id,1).'
					<p>'.htmlspecialchars($name ?? '').'</p>
				</div></a>';
		}
		
		echo '</div>';
	}
}



function show_user_stories($con,$user_id){
	$select = "SELECT * FROM questions WHERE user_id='".mysqli_real_escape_string($con,$user_id)."' ";
	$run = mysqli_query($con,$select);
	if($user_id<1){
		echo '<h2>Annonymous stories</h2>';
	}else{
		echo '<h2>Q&A</h2>';
	}
	if(mysqli_num_rows($run)<1){
		echo '<p>Nothing to show yet.</p>';
	}else{
		while($row = mysqli_fetch_assoc($run)){
			$question = $row['question'];
			$answer = $row['answer'];
			if($user_id<1){
				echo '<div class="bubble">
						<p><i>'.htmlspecialchars($answer ?? '').'</i></p>
					  </div>';
			}else{
				echo '<div class="card story">
						<h3>'.htmlspecialchars($question ?? '').'</h3>
						<p><i>'.htmlspecialchars($answer ?? '').'</i></p>
					  </div>';
			}
		}
	}
}

?>