<?php
function show_polls($con){
	$user_drop = user_dropdown($con,1);
	$select_polls = "SELECT * FROM polls WHERE class='".$_SESSION['class']."' ";
	$run = mysqli_query($con,$select_polls);
	echo '<h1>Polls</h1>';
	if(mysqli_num_rows($run)<1){
		echo '<p>No polls to show yet</p>';
	}else{
		while($row = mysqli_fetch_assoc($run)){
			$id = $row['id'];
			$comment = $row['comment'];
			$type = $row['type'];
			echo '<div class="card">
					<h2>'.htmlspecialchars($comment ?? '').'</h2>';
			//check if user has answered 
			$check = "SELECT 1 FROM poll_answers WHERE poll_id=$id AND user_id='".$_SESSION['user_id']."'";
			$check_run = mysqli_query($con,$check);
			if(mysqli_num_rows($check_run)<1){
				if(isset($_POST['vote_'.$id])){
					$insert = "INSERT INTO poll_answers (user_id, poll_id, answer_1) VALUES(".$_SESSION['user_id'].",$id, ".$_POST['user_id_1'].")";
					if(mysqli_query($con,$insert)){
						redirect('polls.php');
					}else{
						echo $insert;
					}
				}
				//show form
				echo '<form action="" method="POST" onsubmit="keepScrollOnNextLoad()">
						'.user_dropdown($con,1).'
						<input type="submit" name="vote_'.$id.'" value="Vote">
					  </form>';
			}else{
				//show result
				$select_ans = "SELECT answer_1, COUNT(*) AS amounts
FROM poll_answers
WHERE poll_id = $id
GROUP BY answer_1
ORDER BY amounts DESC
LIMIT 1;";
				$run_ans = mysqli_query($con,$select_ans);
				$answer = mysqli_result($run_ans,0,'answer_1');
				$amount = mysqli_result($run_ans,0,'amounts');
				
				echo '<i>'.htmlspecialchars(getfield('user_name','user',$answer,$con) ?? '').' - '.$amount.' votes</i>';
			}
			echo '</div>';
		}
		
	}
}

function user_dropdown($con,$switch){
	$drop = '<select name="user_id_'.$switch.'">';
	$select = "SELECT id, user_name FROM user WHERE class='".$_SESSION['class']."'";
	$run = mysqli_query($con,$select);
	while($row = mysqli_fetch_assoc($run)){
		$drop .= '<option value="'.$row['id'].'">'.htmlspecialchars($row['user_name'] ?? '').'</option>';
	}
	$drop .= '</select>';
	return $drop;
}
  
?>