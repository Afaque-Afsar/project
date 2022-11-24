<?php
    session_start();
    if( !isset( $_SESSION['user']['user_id'] ) ){
        die('Not logged in');
    }
	require_once('../../DB.php');
	if ( isset($_POST['type']) && $_POST['type'] == 'delete_discussion' ) {
		$discussion_id = $_POST['discussion_id'];
		$user_id = $_POST['user_id'];
		$sql = "UPDATE discussion SET status = 2 WHERE id = $discussion_id ";
        if ($con->query($sql)) {
        	$return = "true";
        } else {
			$return = "false";
        }
        echo $return;
	} else if ( isset($_POST['type']) && $_POST['type'] == 'delete_book' ) {
		$book_id = $_POST['book_id'];
		$user_id = $_POST['user_id'];
		$sql = "UPDATE books SET status = 2 WHERE id = $book_id ";
        if ($con->query($sql)) {
        	$return = "true";
        } else {
			$return = "false";
        }
        echo $return;
	} else if ( isset($_POST['type']) && $_POST['type'] == 'delete_material' ) {
        $material_id = $_POST['material_id'];
        $user_id = $_POST['user_id'];
        $sql = "UPDATE material SET status = 2 WHERE  id = $material_id ";
        if ($con->query($sql)) {
            $return = "true";
        } else {
            $return = "false";
        }
        echo $return;
    } else if ( isset($_POST['type']) && $_POST['type'] == 'delete_paper' ) {
        $paper_id = $_POST['paper_id'];
        $user_id = $_POST['user_id'];
        $sql = "UPDATE past_papers SET status = 2 WHERE  id = $paper_id ";
        if ($con->query($sql)) {
            $return = "true";
        } else {
            $return = "false";
        }
        echo $return;
    } else if ( isset($_GET['type']) && $_GET['type'] == 'delete_user' ) {
		$user_id = $_GET['user_id'];
		if($con->query("UPDATE users SET user_status = 2 WHERE user_id = $user_id")){
            echo 'deleted';
        } else {
            echo 'not';
        }        
	} else if ( isset($_GET['type']) && $_GET['type'] == 'edit_user' ) {
		$user_id = $_GET['user_id'];
		$f_name = $con->real_escape_string($_GET['f_name']);
		$last_name = $con->real_escape_string($_GET['last_name']);
		$email = $con->real_escape_string($_GET['email']);
		$mobile = $con->real_escape_string($_GET['mobile']);
		$status = $_GET['status'];
		$role = $_GET['role'];
		$sql = "UPDATE users SET user_fname = '$f_name', user_lname = '$last_name', user_email = '$email', user_mobile = '$mobile', role_id = $role, user_status = $status WHERE user_id = $user_id";
		if($con->query($sql)){
            echo 'edited';
        } else {
            echo 'not'.$sql;
        }        
	} else if ( isset($_GET['type']) && $_GET['type'] == 'get_quiz' ) {
		$category_id = $_GET['category_id'];
// 		$sql = "SELECT * FROM quiz WHERE category_id = $category_id AND status = 1 AND added_by = ".$_SESSION['user']['user_id']." ";
        $sql = "SELECT * FROM quiz WHERE category_id = $category_id AND status = 1 ";
		$res = $con->query($sql);
		$response = ['status' => 'false', 'quiz' => []];
		$response['sql'] = $sql;
		if( $res && $res->num_rows > 0 ){
		    $response['status'] = 'true';
            while( $row = $res->fetch_assoc() ){
                $response['quiz'][] = $row;
            }
        }
        echo json_encode($response);
	} else if ( isset($_GET['type']) && $_GET['type'] == 'get_sub_quiz' ) {
		$quiz_id = $_GET['quiz_id'];
		$sql = "SELECT * FROM quiz_parts WHERE quiz_id = $quiz_id AND status = 1 ";
		$res = $con->query($sql);
		$response = ['status' => 'false', 'quiz_parts' => []];
		if( $res && $res->num_rows > 0 ){
		    $response['status'] = 'true';
            while( $row = $res->fetch_assoc() ){
                $response['quiz_parts'][] = $row;
            }
        }
        echo json_encode($response);
	} else if ( isset($_GET['type']) && $_GET['type'] == 'get_sub_quiz_complete' ) {
		$quiz_id = $_GET['quiz_id'];
		$sql = "SELECT q.*, c.tittle, quiz.title as 'quiz_title', quiz.category_id, u.user_id, u.user_fname, u.user_lname 
		        FROM quiz_parts q 
		        INNER JOIN quiz ON quiz.id = q.quiz_id 
		        INNER JOIN material_categories c ON c.id = quiz.category_id 
		        INNER JOIN users u ON u.user_id = q.added_by 
		        WHERE quiz_id = $quiz_id AND q.status = 1 ";
		$res = $con->query($sql);
		$response = ['status' => 'false', 'quiz_parts' => []];
		if( $res && $res->num_rows > 0 ){
		    $response['status'] = 'true';
            while( $row = $res->fetch_assoc() ){
                $response['quiz_parts'][] = $row;
            }
        }
        echo json_encode($response);
	} else if ( isset($_GET['type']) && $_GET['type'] == 'get_all_quiz' ) {
		$sub_quiz_id = $_GET['sub_quiz_id'];
		$sql = "SELECT * FROM questions WHERE quiz_part_id = $sub_quiz_id  AND status = 1  ";
		$res = $con->query($sql);
		$response = ['status' => 'false', 'questions' => []];
		if( $res && $res->num_rows > 0 ){
		    $response['status'] = 'true';
            while( $row = $res->fetch_assoc() ){
                $response['questions'][] = $row;
            }
        }
        echo json_encode($response);
	}  else if ( isset($_POST['type']) && $_POST['type'] == 'delete_question' ) {
		$question_id = $_POST['question_id'];
		$user_id = $_POST['user_id'];
		$sql = "UPDATE questions SET status = 2 WHERE id = $question_id ";
        if ($con->query($sql)) {
        	$return = "true";
        } else {
			$return = "false";
        }
        echo $return;
	}  else if ( isset($_POST['type']) && $_POST['type'] == 'question_details' ) {
		$question_id = $_POST['question_id'];
		$user_id = $_POST['user_id'];
		$quiz_id = $_POST['quiz'];
		$sub_quiz_id = $_POST['sub_quiz'];
		$category_id = $_POST['category'];
		
		$sql = "SELECT * FROM questions WHERE id = $question_id ";
        $res = $con->query($sql);
        if ( $res && $res->num_rows > 0 ) {
        	$row = $res->fetch_assoc();
        	$found = "true";
        } else {
			$found = "false";
        }
        
        $sub_quiz_array = [];
        if ( $found == "true" ) {
        	$sql2 = "SELECT * FROM quiz_parts WHERE quiz_id = ".$quiz_id;
        	$res2 = $con->query($sql2);
            if ( $res2 && $res2->num_rows > 0 ) {
            	while( $row2 = $res2->fetch_assoc() ){
            	    $sub_quiz_array[] = $row2;
            	}
            	$found2 = "true";
            } else {
    			$found2 = "false";
            }
        } 
        $quiz_array = [];
        if ( $found2 == "true" ) {
        	$sql3 = "SELECT * FROM quiz WHERE category_id = ".$category_id;
        	$res3 = $con->query($sql3);
            if ( $res3 && $res3->num_rows > 0 ) {
            	while( $row3 = $res3->fetch_assoc() ){
            	    $quiz_array[] = $row3;
            	}
            	$found3 = "true";
            } else {
    			$found3 = "false";
            }
        } 
        
        if(  $found == "true" &&  $found2 == "true"  &&  $found3 == "true"  ){
        ?>
            <input type="hidden" id="question_id_edit" value="<?= $question_id; ?>">
            <tr>
                <td>Category</td>
                <td>
                    <select class="form-control" id="edit_category" name="edit_category">
                      <option>Select Category</option>
                      <?php
                       $sql = "SELECT * FROM material_categories  WHERE status = 1";
                       $result = $con->query($sql);
                       $rows = $result->num_rows;
                       if ($rows > 0 ) {
                            while ($record = $result->fetch_assoc()) {
                            ?>
                                <option value="<?= $record['id']; ?>" <?= ($record['id'] == $category_id)?'selected':'' ?> > 
                                    <?= $record['tittle']; ?>
                                </option>
                            <?php
                              //echo "<option value=".$record['id']." ".($record['id'] == $quiz_array[0]['id'])?'selected':''." >".$record['tittle']."</option>";
                            }
                       }
                      ?>  
                  </select>
                </td>
            </tr>
            <tr>
                <td>Quiz</td>
                <td>
                    <select class="form-control" id="edit_quiz_select" name="edit_quiz_select">
                        <option>Select Quiz/Subejct</option>
                        <?php
                            foreach ( $quiz_array as $value ) {
                            ?>
                                <option value="<?= $value['id']; ?>" <?= ($value['id'] == $quiz_id)?'selected':'' ?> > 
                                    <?= $value['title']; ?>
                                </option>
                            <?php
                                //echo "<option value=".$value['id'].">".$value['title']."</option>";
                            }
                        ?>  
                    </select>
                </td>
            </tr>
            <tr>
                <td>Subject Part/Quiz Part</td>
                <td>
                    <select class="form-control" id="edit_sub_quiz_select" name="edit_sub_quiz_select">
                        <option>Select Subject Part/Quiz Part</option>
                        <?php
                            foreach ( $sub_quiz_array as $value ) {
                            ?>
                                <option value="<?= $value['id']; ?>" <?= ($value['id'] == $sub_quiz_id)?'selected':'' ?> > 
                                    <?= $value['title']; ?>
                                </option>
                            <?php
                                //echo "<option value=".$value['id'].">".$value['tittle']."</option>";
                            }
                        ?>  
                    </select>
                </td>
            </tr>
            <tr>
                <td>Question</td>
                <td>
                    <textarea id="edit_question_description" class='form-control'><?= $row['question']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Option A</td>
                <td>
                    <input class='form-control' type="text" name="optionA" value="<?= $row['optionA']; ?>" id="edit_optionA" >
                </td>
            </tr>
            <tr>
                <td>Option B</td>
                <td>
                    <input class='form-control' type="text" name="optionB" value="<?= $row['optionB']; ?>" id="edit_optionB" >
                </td>
            </tr>
            <tr>
                <td>Option C</td>
                <td>
                    <input class='form-control' type="text" name="optionC" value="<?= $row['optionC']; ?>" id="edit_optionC" >
                </td>
            </tr>
            <tr>
                <td>Option D</td>
                <td>
                    <input class='form-control' type="text" name="optionD" value="<?= $row['optionD']; ?>" id="edit_optionD" >
                </td>
            </tr>
            <tr>
                <td>Correct Option</td>
                <td>
                    <select class='form-control' id="correct_option">
                        <option value="A" <?= ('A' == $row['answer'])?'selected':'' ?> >A</option>
                        <option value="B" <?= ('B' == $row['answer'])?'selected':'' ?> >B</option>
                        <option value="C" <?= ('C' == $row['answer'])?'selected':'' ?> >C</option>
                        <option value="D" <?= ('D' == $row['answer'])?'selected':'' ?> >D</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Answer Description</td>
                <td>
                    <input class='form-control' type="text" name="edit_description" value="<?= $row['description']; ?>" id="edit_description" >
                </td>
            </tr>
        <?php
        } else {
            echo "No record found, Please try again...";
        }
        
	}  else if ( isset($_POST['type']) && $_POST['type'] == 'edit_question' ) {
	    $quiz_part_id = $_POST['quiz_part_id']; 
        $question = $con->real_escape_string($_POST['question']);
        $optionA = $con->real_escape_string($_POST['optionA']);
        $optionB = $con->real_escape_string($_POST['optionB']);
        $optionC = $con->real_escape_string($_POST['optionC']); 
        $optionD = $con->real_escape_string($_POST['optionD']);
        $description = $con->real_escape_string($_POST['description']);
        $answer = $_POST['correct_option'];
        $question_id = $_POST['question_id'];
        $user_id = $_SESSION['user']['user_id'];
        
        $sql = "UPDATE questions SET quiz_part_id = $quiz_part_id, question = '$question', optionA = '$optionA', optionB = '$optionB', optionC = '$optionC', optionD = '$optionD',
                answer = '$answer', description = '$description'
                WHERE id = $question_id ";
        if ($con->query($sql)) {
        	$return = "edited";
        } else {
			$return = "Not Edited, Please Try Again...";
        }
        echo $return;
	} else if ( isset($_POST['type']) && $_POST['type'] == 'delete_sub_quiz' ) {
	    $user_id = $_SESSION['user']['user_id'];
        $sql = "UPDATE quiz_parts SET status = 2 WHERE id = ".$_POST['sub_quiz_id'];
        if( $con->query( $sql ) ){
            $message = "Quiz Part Deleted Successfully!...";
        } else {
            $message = "Quiz Part Not Deleted, Please Try Again!...";
        }
        echo $message;
	}

	