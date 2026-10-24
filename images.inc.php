<?php

// 4.mysql_result replacement
function mysqli_result($query, $row, $field = 0) {
    // Adjust the result pointer to that specific row
    $query->data_seek($row);
    // Fetch result array
    $data = $query->fetch_array();
	if(!empty($data)){
		return $data[$field];
	}else{
		return $data = NULL;
	}
}

//display the time hours/ minutes
function display_time($date){
	return date_format(date_create($date),"H:i");
}

function getfield($field,$table, $id, $con){
	
	$query = "SELECT $field FROM $table WHERE id='$id'";
	if($query_run = mysqli_query($con, $query)){
		if($query_result = mysqli_result($query_run,0, $field)){
			return $query_result;
		}else{
			return '';
		}
	}
}


function display_date($date, $switch){
	if($date=='0000-00-00'){
		$display_date = 'N.v.t.';
	}else{
	$day = date_format(date_create($date),' j');
	$month = date_format(date_create($date),' n');
	$year = date_format(date_create($date),' Y');
	
	switch($month){
		case 1:
			$display_month = 'januari';
			break;
		case 2:
			$display_month = 'februari';
			break;
		case 3:
			$display_month = 'maart';
			break;
		case 4:
			$display_month = 'april';
			break;
		case 5: 
			$display_month = 'mei';
			break;
		case 6:
			$display_month = 'juni';
			break;
		case 7:
			$display_month = 'juli';
			break;
		case 8:
			$display_month = 'augustus';
			break;
		case 9: 
			$display_month = 'september';
			break;
		case 10: 
			$display_month = 'oktober';
			break;
		case 11: 
			$display_month = 'november';
			break;
		case 12:
			$display_month = 'december';
			break;
	}
	
	if($switch==1){
		return $display_date = $day.' '.$display_month.' '.$year;
	} else if($switch ==3){
		return $display_date = date_format(date_create($date),"d-m-y");
	}else if($switch ==4){
		return $display_date = date_format(date_create($date),"d-m-Y");
	}else{
		return $display_date = $day.' '.substr($display_month, 0, 3).' '.$year;
	}
	}
}

function show_picture($con){
	if(isset($_GET['upload'])&&$_GET['upload']>=1){
		$photo_id = $_GET['upload'];
		$date_time = getfield('date','photos',$photo_id,$con);
		$name = getfield('name','photos',$photo_id,$con);
		$user_id = getfield('user_id','photos',$photo_id,$con);
		$comment = getfield('comment','photos',$photo_id,$con);
		$user_name = getfield('user_name','user',$user_id,$con);
		
		echo '<div id="floater">
				<p><img src="'.$name.'" width="500px;"></p>
				<p>'.htmlspecialchars($user_name ?? '').' '.htmlspecialchars($comment ?? '').'</p>';
				if($user_id==$_SESSION['user_id']){
					if(isset($_POST['delete_image_'.$photo_id])){
						if(unlink($name)){
							$delete = "DELETE FROM photos WHERE id=$photo_id";
							mysqli_query($con,$delete);
							redirect('gallery.php?order_id='.$order_id.'&#photos');
						}
					}
					if($_SESSION['user_id']==$user_id){
						echo '<form action="" method="POST" style="display:inline-block;">
							<input type="submit" class="small_button" name="delete_image_'.$photo_id.'" value="Delete photo"/> 
						</form> ';
					}
				}
		echo '<input type="button" class="small_button button_link" value="Close" onclick="window.location.href=\'gallery.php?\'" />
			  </div>';
	}
}

function upload_picture($con){
	$ok = 0;
	echo '<form class="upload-form" enctype="multipart/form-data" action="" method="POST">
		<input name="upload_picture" type="file" accept="image/png, image/jpeg" />
		<textarea name="comment" placeholder="Comment (optional)"></textarea>
		<button type="submit" name="upload_picture" value="1" class="upload-btn">Tải ảnh lên</button>
	</form>';
	// echo '<form enctype="multipart/form-data" action="" method="POST">';
			
	// 			echo '
	// 					<input name="upload_picture" type="file" /><br/>
	// 					<textarea name="comment" style="width:500px" placeholder="Comment (optional)"></textarea><br/>
	// 					<input type="submit" value="Tải ảnh lên" name="upload_picture" class="small_button"/>
	// 				 <br/></form>'; 
																 
				 if(isset($_GET['file_error'])){
					 echo '<p>Xin lỗi, chỉ chấp nhận các tệp có định dạng .jpg, .jpeg và .png.</p>';
				}
				 if(isset($_GET['size_error'])){
					 echo '<p>Rất tiếc, tệp được tải lên quá lớn. Dung lượng tối đa là 3MB.</p>';
				}
				 if(isset($_GET['type_error'])){
					 echo '<p>Tệp được tải lên không phải là hình ảnh.</p>';
				 }
			
		
			if(isset($_POST['upload_picture'])){

				if(isset($_FILES['upload_picture'])&&file_exists($_FILES['upload_picture']['tmp_name'] ?? '')  ){

				$comment = $_POST['comment'];
				  $insert = "INSERT INTO photos VALUES(NULL,
															'".$_SESSION['class']."',
															'".$_SESSION['user_id']."',
															'temp_name',
															'".mysqli_real_escape_string($con,$comment)."',
															'".mysqli_real_escape_string($con,date('Y-m-d H:i:s'))."'
															)";
				if(!mysqli_query($con, $insert)){
					echo '<p>Failed to create datebase row</p>';
				}else{
					$select = "SELECT id FROM photos WHERE class='".$_SESSION['class']."' AND user_id =".$_SESSION['user_id']." ORDER BY id DESC LIMIT 1";
					$run = mysqli_query($con, $select);
					$photo_id = mysqli_result($run,0,'id');
					if(isset($_FILES['upload_picture'])&&file_exists($_FILES['upload_picture']['tmp_name'] ?? '')  ){
						$ext = findexts($_FILES['upload_picture']['name']); 
						$new_name = 'photo_upload_'.$order_id.'_'.$photo_id.'.';
						$target = "uploads/";
						$target_file = $target .$new_name.strtolower($ext);
						$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

						// Check if file already exists
						if (file_exists($target_file)) {
						  echo "Sorry, file already exists.";
						  $uploadOk = 0;
						}

						
						// Allow certain file formats
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
						 ) {
						  echo "Sorry, only JPG, JPEG, PNG & PDF files are allowed.";
						  $uploadOk = 0;
						}

						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
						  echo "Sorry, your file was not uploaded.";
						// if everything is ok, try to upload file
						} else {
							//if size to big, compress
							if($_FILES["upload_picture"]["size"] > 2097152){
								$imageTemp = $_FILES["upload_picture"]["tmp_name"]; 
								$imageSize = convert_filesize($_FILES["upload"]["size"]); 
								 
								// Compress size and upload image 
								$compressedImage = compressImage($imageTemp, $target_file, 90); 
								 
								if($compressedImage){ 
									$compressedImageSize = filesize($compressedImage); 
									$compressedImageSize = convert_filesize($compressedImageSize); 
									 
									$status = 'success'; 
									$statusMsg = "Image compressed successfully."; 
									$ok =1;
								}else{ 
									$statusMsg = "Image compress failed!"; 
									$ok =0;
								}
						
							}else{
								if (move_uploaded_file($_FILES["upload_picture"]["tmp_name"], $target_file)) {
									
									$ok = 1;
								  } else {
									echo "Sorry, there was an error uploading your file.";
									$ok =0;
								  }
							}
							
							if($ok==1){
								
								echo $update = "UPDATE photos SET name='".mysqli_real_escape_string($con, $target_file)."' WHERE id=$photo_id";
								mysqli_query($con, $update);
								$upload_id = 1;	
								redirect('gallery.php');
							}else{
								$delete = "DELETE FROM photos WHERE id=$photo_id";
								mysqli_query($con, $delete);
							}
							
						}
					}
				}
			}
			}
}



function compressImage($source, $destination, $quality) { 
    // Get image info 
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Create a new image from file 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
     
    // Save image 
    imagejpeg($image, $destination, $quality); 
     
    // Return compressed image 
    return $destination; 
}

function convert_filesize($bytes, $decimals = 2) { 
    $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB'); 
    $factor = floor((strlen($bytes) - 1) / 3); 
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor]; 
}

 function findexts ($filename) { 
	 $filename = strtolower($filename) ; 
	 $exts = explode(".", $filename) ; 
	 $n = count($exts)-1; 
	 $exts = $exts[$n]; 
	 return $exts; 
 }


function get_pictures($con){
	
	
	$select = "SELECT * FROM photos WHERE class='".$_SESSION['class']."' ORDER BY id ASC";
	$run = mysqli_query($con, $select);
	$num = mysqli_num_rows($run);
		echo '<br/><br/><h3 id="photos">Photos</h3>';
		
			upload_picture($con);
		
		show_picture($con);
		if(mysqli_num_rows($run)<1){
			echo '<p>Chưa có ảnh hiển thị</p>';
		}else{
			echo '<div class="photo-gallery" id="photo-gallery">';
			while($row = mysqli_fetch_assoc($run)){
				$id = $row['id'];
				$name = $row['name'];
				$date_time = $row['date'];
				$comment = $row['comment'];
				
				echo '<a href="gallery.php?upload='.$id.'" title="'.htmlspecialchars($comment ?? '').'"><div class="photo-item placeholder">
					<div class="thumbnail"><img src="'.$name.'" ></div>
					
				</div><p>'.htmlspecialchars($comment ?? '').'</p></a>';
				
			}
			echo '</div>';
		}
	
}


?>

