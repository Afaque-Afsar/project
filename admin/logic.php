<?php
require_once('required/session_maintanance.php');
include_once '../DB.php';
error_reporting(0);
//............Student User ...................

if (isset($_POST['update_user'])) {
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$user_id = $_POST['user_id'];
	
	
	$sql = "UPDATE users SET user_fname = '$fname', user_lname = '$lname', user_email = '$email', user_mobile = '$mobile' WHERE user_id = $user_id";

	$result = $con->query($sql);
	if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = "Record Updated!!!";
		header('location:users_list.php');
	}
	else{
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = "Record not Updated!!";
		header('location:users_list.php');
	}
}

if (isset($_POST['add_category'])) {
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	$tittle= $_POST['tittle'];
	$added_by = $_SESSION['user']['user_id'];

	$sql = "INSERT INTO material_categories (tittle, added_by) VALUES ('$tittle', $added_by)";
	$result = $con->query($sql);
	if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = "Category Added!!!";
		header('location:add_category.php');
	}
	else{
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = "Category not Added!!";
		header('location:add_category.php');
	}
}

if (isset($_POST['edit_category'])) {
	$tittle = $_POST['tittle'];
	$id = $_POST['id'];
	$sql = "UPDATE material_categories SET tittle='$tittle' WHERE id=".$id;
	$result = $con->query($sql);
	if ($result) {
        $_SESSION['success'] = true;
        $_SESSION['error'] = false;
        $_SESSION['message'] = "Category Updated!!!";
        header('location:view_category.php');
    }
    else{
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Category not Updated!!";
        header('location:view_category.php');
    }
}

if (isset($_GET['book'])) {
	$action = $_GET['book'];
	$id = $_GET['id'];
	if ($action == 'app') {
		$sql = "UPDATE books SET status = 1 WHERE id = $id";
		$result = $con->query($sql);
		if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = "Book Approved !!!";
		header('location:view_book.php');
		}
		else{
			$_SESSION['success'] = false;
			$_SESSION['error'] = true;
			$_SESSION['message'] = "Book not Approved!!";
			header('location:view_book.php');
		}
	}
	if ($action == 'dis') {
		$sql = "UPDATE books SET status = 0 WHERE id = $id";
		$result = $con->query($sql);
		if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = "Book disapproved !!!";
		header('location:view_book.php');
		}
		else{
			$_SESSION['success'] = false;
			$_SESSION['error'] = true;
			$_SESSION['message'] = "Book not Approved!!";
			header('location:view_book.php');
		}
	}
}

if (isset($_GET['material'])) {
	$action = $_GET['material'];
	$id = $_GET['id'];
	if ($action == 'app') {
		$sql = "UPDATE material SET status = 1 WHERE id = $id";
		$result = $con->query($sql);
		if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = "Material Approved !!!";
		header('location:view_material.php');
		}
		else{
			$_SESSION['success'] = false;
			$_SESSION['error'] = true;
			$_SESSION['message'] = "Material not Approved!!";
			header('location:view_material.php');
		}
	}
	if ($action == 'dis') {
		$sql = "UPDATE material SET status = 0 WHERE id = $id";
		$result = $con->query($sql);
		if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = "Material disapproved !!!";
		header('location:view_material.php');
		}
		else{
			$_SESSION['success'] = false;
			$_SESSION['error'] = true;
			$_SESSION['message'] = "Material not Dis-Approved!!";
			header('location:view_material.php');
		}
	}

	// if ($action == 'del') {
	// 	$sql = "UPDATE material SET status = 2 WHERE id = $id";
	// 	$result = $con->query($sql);
	// 	if ($result) {
	// 	$_SESSION['success'] = true;
	// 	$_SESSION['error'] = false;
	// 	$_SESSION['message'] = "Material Deleted !!!";
	// 	header('location:view_material.php');
	// 	}
	// 	else{
	// 		$_SESSION['success'] = false;
	// 		$_SESSION['error'] = true;
	// 		$_SESSION['message'] = "Material not Deleted!!";
	// 		header('location:view_material.php');
	// 	}
	// }
}

//............. Add Material .........................
if (isset($_POST['add_material'])) {
    $description = "";
    $is_insert = true;
    $format = $_POST['choose_format'];
    if ($format == 'text_format') {
        $description = $con->real_escape_string($_POST['description']);
    }
    if ($format == 'pdf_format') {
        if( isset($_FILES['material_pdf']) ) {
            $file = $_FILES['material_pdf'];
            if ( stripos( $file['type'], 'application/pdf' ) === false ) {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Please Provide Material Format in PDF Only!...";
                $is_insert = false;
                header("location: add_material.php");
            } else {
                $file_name_temp = time()."_material_".str_replace(" ", "",$file['name']);
                if (move_uploaded_file($file['tmp_name'], "../uploads/material/".$file_name_temp)){
                    $is_insert = true;
                    $description = "uploads/material/".$file_name_temp;
                } else {
                    $is_insert = false;
                }
            }
        }
    }
    if ($format == 'video_format') {
        if( isset($_FILES['material_video']) ) {
            $file = $_FILES['material_video'];
            if ( stripos( $file['type'], 'video/mp4' ) === false ) {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Please Provide Material Format in mp4 Only!...";
                $is_insert = false;
                header("location: add_material.php");
            } else {
                if (move_uploaded_file($file['tmp_name'], "../uploads/material/".$file['name'])){
                    $is_insert = true;
                    $description = "uploads/material/".$file['name'];
                } else {
                    $is_insert = false;
                }
            }
        }
    }
    if ($format == 'link_format') {
        $link = $_POST['material_link'];
        $description = str_replace('watch?v=', 'embed/', $link);
    }
     if ( $is_insert == true ) {
        $tittle = $_POST['tittle'];
        $category_id = $_POST['category'];
        $user_id = $_SESSION['user']['user_id'];
        $sql = "INSERT INTO material(tittle, description, material_format, category_id, added_by)
        VALUES('$tittle', '$description', '$format', '$category_id', $user_id)";
        $res = $con->query($sql);
        if( $res ){
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = "Material Added Successfully, Please Wait For Approval";
            header("location: add_material.php");

        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Material not Added, Please Try Again!...";
            header("location: add_material.php");
        }
    }
}

//.........ADD BOOKS ................
if (isset($_POST['add_book'])) {
	$cover_image = "";
	$book_pdf = "";
    $is_insert = true;
    if( isset($_FILES['image']) ) {
        $file = $_FILES['image'];
        if ( stripos( $file['type'], 'image' ) === false ) {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Please Provide Image Only!...";
            $is_insert = false;
            header("location: add_book.php");
        } else {
            $file_name_temp = time()."_cover_".str_replace(" ", "",$file['name']);
            if (move_uploaded_file($file['tmp_name'], "../uploads/books/cover_images/".$file_name_temp)){
                $is_insert = true;
                $cover_image = $con->real_escape_string("uploads/books/cover_images/".$file_name_temp);
            } else {
                $is_insert = false;
            }
        }
    }
    if( isset($_FILES['book_pdf']) ) {
        $file = $_FILES['book_pdf'];
        if ( stripos( $file['type'], 'application/pdf' ) === false ) {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Please Provide Book Format in PDF Only!...";
            $is_insert = false;
            header("location: add_book.php");
        } else {
            $file_name_temp = time()."_book_".str_replace(" ", "",$file['name']);
            if (move_uploaded_file($file['tmp_name'], "../uploads/books/".$file_name_temp)){
                $is_insert = true;
                $book_pdf = $con->real_escape_string("uploads/books/".$file_name_temp);
            } else {
                $is_insert = false;
            }
        }
    }
    if ( $is_insert == true ) {
        $category_id = $_POST['category'];
        $tittle = $con->real_escape_string($_POST['tittle']);
        $description = $con->real_escape_string($_POST['description']);
        $user_id = $_SESSION['user']['user_id'];
        $slug = "";
        if( isset($_POST['selected_category']) && !empty($_POST['selected_category']) ) {
            if ( in_array( $_POST['selected_category'], [ 'css', 'pms', 'pcs' ] ) ) {
                $slug = $_POST['type_select_values'];
            } else if ( in_array( $_POST['selected_category'], [ 'ielts', 'tofil' ] ) ) {
                $slug = $_POST['type'];
            }
        }
        
        $sql = "INSERT INTO books(`slug`, tittle, description, cover_image, book_pdf, added_by, category_id,status)
        VALUES('$slug', '$tittle', '$description', '$cover_image', '$book_pdf', $user_id, $category_id,1)";
        $res = $con->query($sql);
        if( $res ){
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = "Book Added Successfully";
            header("location: add_book.php");

        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Book not Added, Please Try Again!...".$sql;
            header("location: add_book.php");
        }
    }
}

//.........EDIT BOOKS ................
if (isset($_POST['edit_book'])) {
    // print_r($_FILES);die();
	$cover_image = "";
	$book_pdf = "";
    $is_insert = true;
    if( isset($_FILES['image']) && $_FILES['image']['size'] > 0 ) {
        $file = $_FILES['image'];
        if ( stripos( $file['type'], 'image' ) === false ) {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Please Provide Image Only!...";
            $is_insert = false;
            header("location: edit_book.php?id=".$id);
        } else {
            if (move_uploaded_file($file['tmp_name'], "../uploads/books/cover_images/".$file['name'])){
                $is_insert = true;
                $cover_image = $con->real_escape_string("uploads/books/cover_images/".$file['name']);
            } else {
                $is_insert = false;
            }
        }
    } else {
        $is_insert = true;
    }
    if( isset($_FILES['book_pdf']) && $_FILES['book_pdf']['size'] > 0 ) {
        $file = $_FILES['book_pdf'];
        if ( stripos( $file['type'], 'application/pdf' ) === false ) {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Please Provide Book Format in PDF Only!...";
            $is_insert = false;
            header("location: edit_book.php?id=".$id);
        } else {
            if (move_uploaded_file($file['tmp_name'], "../uploads/books/".$file['name'])){
                $is_insert = true;
                $book_pdf = $con->real_escape_string("uploads/books/".$file['name']);
            } else {
                $is_insert = false;
            }
        }
    } else {
        $is_insert = true;
    }
    if ( $is_insert == true ) {
        $category_id = $_POST['category'];
        $tittle = $con->real_escape_string($_POST['tittle']);
        $description = $con->real_escape_string($_POST['description']);
        $id = $_POST['book_id'];
        $slug = "";
        if( isset($_POST['selected_category']) && !empty($_POST['selected_category']) ) {
            if ( in_array( $_POST['selected_category'], [ 'css', 'pms', 'pcs' ] ) ) {
                $slug = $_POST['type_select_values'];
            } else if ( in_array( $_POST['selected_category'], [ 'ielts', 'tofil' ] ) ) {
                $slug = $_POST['type'];
            }
        }
        
        if( $cover_image != "" && $book_pdf != "" ){
            $sql = "UPDATE books SET `slug` = '$slug', tittle = '$tittle', description = '$description', cover_image = '$cover_image', book_pdf = '$book_pdf', 
            category_id = $category_id WHERE id = ".$id;
        } else if( $cover_image != "" && $book_pdf == "" ){
            $sql = "UPDATE books SET `slug` = '$slug', tittle = '$tittle', description = '$description', cover_image = '$cover_image', category_id = $category_id 
            WHERE id = ".$id;
        } else if( $cover_image == "" && $book_pdf != "" ){
            $sql = "UPDATE books SET `slug` = '$slug', tittle = '$tittle', description = '$description', book_pdf = '$book_pdf', category_id = $category_id 
            WHERE id = ".$id;
        } else {
            $sql = "UPDATE books SET `slug` = '$slug', tittle = '$tittle', description = '$description', category_id = $category_id WHERE id = ".$id;
        }
        
        $res = $con->query($sql);
        if( $res ){
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = "Book Updated Successfully";
            header("location: view_book.php");

        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Book not Updated, Please Try Again!...";
            header("location: edit_book.php?id=".$id);
        }
    }
}

//.......... Add Subcategory ...........
if (isset($_POST['add_subcategory'])) {
    $category_id = $_POST['category'];
    $tittle = $_POST['tittle'];
    $description = $_POST['description'];
    $added_by = $_SESSION['user']['user_id'];

    $sql = "INSERT INTO past_paper_categories (tittle, description, added_by, category_id, status) VALUES ('$tittle', '$description', $added_by, $category_id, 1)";
    $result = $con->query($sql);
    if ($result) {
        $_SESSION['success'] = true;
        $_SESSION['error'] = false;
        $_SESSION['message'] = " SubCategory Added Successfully";
        header("location: add_subcategory.php");

    } 
    else {
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = " SubCategory not Added";
        header("location: add_subcategory.php");
    }
}

//.......... Edit Subcategory ...........
if (isset($_POST['edit_subcategory'])) {
    $category_id = $_POST['category'];
    $tittle = $_POST['tittle'];
    $description = $_POST['description'];
    $id = $_POST['id'];

    $sql = "UPDATE past_paper_categories SET tittle = '$tittle', description = '$description', category_id = $category_id WHERE id = ".$id;
    $result = $con->query($sql);
    if ($result) {
        $_SESSION['success'] = true;
        $_SESSION['error'] = false;
        $_SESSION['message'] = " SubCategory Updated Successfully";
        header("location: view_subcategory.php");
    } 
    else {
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = " SubCategory not Updated";
        header("location: edit_subcategory.php?id=".$id);
    }
}

//............Add Subject....................
if (isset($_POST['add_subject'])) {
    $subcategory_id = $_POST['subcategory'];
    $tittle = $con->real_escape_string($_POST['tittle']);
    $description = $con->real_escape_string($_POST['description']);
    $added_by = $_SESSION['user']['user_id'];

    $sql = "INSERT INTO past_paper_subjects (tittle, description, subcategory_id, added_by, status) VALUES ('$tittle', '$description', $subcategory_id, $added_by, 1)";
    $result = $con->query($sql);

    if ($result) {
        $_SESSION['success'] = true;
        $_SESSION['error'] = false;
        $_SESSION['message'] = " Subject Added Successfully ";
        header("location: add_subject.php");

        } 
    else {
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = " Subject not Added";
        header("location: add_subject.php");
    }
}

//............Edit Subject....................
if (isset($_POST['edit_subject'])) {
    $subcategory_id = $_POST['subcategory'];
    $tittle = $con->real_escape_string($_POST['tittle']);
    $description = $con->real_escape_string($_POST['description']);
    $id = $_POST['id'];

    $sql = "UPDATE past_paper_subjects SET tittle = '$tittle', description = '$description', subcategory_id = $subcategory_id WHERE id = ".$id;
    $result = $con->query($sql);

    if ($result) {
        $_SESSION['success'] = true;
        $_SESSION['error'] = false;
        $_SESSION['message'] = " Subject Updated Successfully ";
        header("location: view_subject.php");

        } 
    else {
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = " Subject not Updated";
        header("location: edit_subject.php?id=".$id);
    }
}

//...........Add Past Paper ................
if (isset($_POST['add_paper'])) {
    $paper_image = '';
    if( isset($_FILES['image']) ) {
        $file = $_FILES['image'];
        if ( stripos( $file['type'], 'image' ) === false ) {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Please Provide Image Only!...";
            $is_insert = false;
            header("location: add_paper.php");
        } else {
            if (move_uploaded_file($file['tmp_name'], "../uploads/past_papers/".$file['name'])){
                $is_insert = true;
                $paper_image = "uploads/past_papers/".$file['name'];
            } else {
                $is_insert = false;
            }
        }
    }

    if ( $is_insert == true ) {
        $category_id = $_POST['category'];
        $subcategory_id = $_POST['subcategory'];
        $subject_id = $_POST['subject'];
        $tittle = $_POST['tittle'];
        $description = $_POST['description'];
        $added_by = $_SESSION['user']['user_id'];
        
        $sql = "INSERT INTO past_papers (tittle, description, paper_image, added_by, subject_id) VALUES ('$tittle', '$description', '$paper_image', $added_by, $subject_id)";
        $result = $con->query($sql);
        if( $result ){
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = " Paper added Successfully";
            header("location: add_paper.php");

        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Paper not Added, Please Try Again!...";
            header("location: add_paper.php");
        }
    }
}

//...........Edit Past Paper ................
if (isset($_POST['edit_paper'])) {
    $id = $_POST['id'];
    $paper_image = '';
    $is_insert = true;
    if( isset($_FILES['image']) && $_FILES['image']['error'] != 4 ) {
        $file = $_FILES['image'];
        if ( stripos( $file['type'], 'image' ) === false ) {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Please Provide Image Only!...";
            $is_insert = false;
            header("location: edit_paper.php?id=".$id);
        } else {
            if (move_uploaded_file($file['tmp_name'], "../uploads/past_papers/".time().$file['name'])){
                $is_insert = true;
                $paper_image = "uploads/past_papers/".time().$file['name'];
            } else {
                $is_insert = false;
            }
        }
    }

    if ( $is_insert == true ) {
        $category_id = $_POST['category'];
        $subcategory_id = $_POST['subcategory'];
        $subject_id = $_POST['subject'];
        $tittle = $_POST['tittle'];
        $description = $_POST['description'];
        
        $sql = "UPDATE past_papers SET tittle = '$tittle', description = '$description', ";
        if( $paper_image != '' ){
            $sql .= " paper_image = '$paper_image', ";
        }
        $sql .= " subject_id = $subject_id WHERE id = ".$id;
        $result = $con->query($sql);
        if( $result ){
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = " Paper Updated Successfully";
            header("location: view_paper.php");

        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Paper not Updated, Please Try Again!...";
            header("location: edit_paper.php?id=".$id);
        }
    }
}


//..............Add Quiz Question .....................
if (isset($_POST['add_question'])) {
    $quiz_part_id = $_POST['sub_quiz'];
    $question = $_POST['question'];
    $optionA = $_POST['optionA'];
    $optionB = $_POST['optionB'];
    $optionC = $_POST['optionC'];
    $optionD = $_POST['optionD'];
    $answer = $_POST['answer'];
    $description = $_POST['description'];
    $added_by = $_SESSION['user']['user_id'];

    $sql = "INSERT INTO questions (question, optionA, optionB, optionC, optionD, answer, description, quiz_part_id, added_by) VALUES('$question', '$optionA','$optionB', '$optionC', '$optionD', '$answer', '$description', $quiz_part_id, $added_by)";
    $result = $con->query($sql);
   
    if ($result) {
        $_SESSION['success'] = true;
        $_SESSION['error'] = false;
        $_SESSION['message'] = "Quiz Question Added Successfully";
        header("location: add_question.php");

        } 
    else {
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Quiz Question not Added";
        header("location: add_question.php");
    }

}


//..............Add Quiz .....................
if (isset($_POST['add_quiz'])) {
    $category_id = $_POST['category_id'];
    $title = $con->real_escape_string($_POST['title']);
    $added_by = $_SESSION['user']['user_id'];
    
    $sqlCheck = "SELECT id FROM quiz WHERE title = '$title' AND category_id = $category_id AND status != 2 ";
    $resCheck = $con->query($sqlCheck);
    if( $resCheck && $resCheck->num_rows > 0 ){
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Quiz Already Added Before.";
        header("location: add_quiz.php");
    } else {
        $sql = "INSERT INTO quiz (title, category_id, added_by) VALUES('$title', $category_id, $added_by)";
        $result = $con->query($sql);
       
        if ($result) {
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = "Quiz Added Successfully";
            header("location: add_quiz.php");
    
            } 
        else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Quiz not Added";
            header("location: add_quiz.php");
        }
    }
    
}//


//..............Edit Quiz .....................
if (isset($_POST['edit_quiz'])) {
    $category_id = $_POST['category_id'];
    $quiz_id = $_POST['quiz_id'];
    $title = $con->real_escape_string($_POST['title']);
    $added_by = $_SESSION['user']['user_id'];
    
    $sqlCheck = "SELECT id FROM quiz WHERE title = '$title' AND category_id = $category_id AND status != 2 AND id != $quiz_id ";
    $resCheck = $con->query($sqlCheck);
    if( $resCheck && $resCheck->num_rows > 0 ){
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Quiz Already Added Before.";
        header("location: add_quiz.php");
    } else {
        $sql = "UPDATE quiz SET  title = '$title', category_id = $category_id WHERE id = $quiz_id AND added_by = $added_by";
        $result = $con->query($sql);
       
        if ($result) {
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = "Quiz Updated Successfully";
            header("location: add_quiz.php");
    
            } 
        else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Quiz not Updated/Authentication not allowed!...";
            header("location: add_quiz.php");
        }
    }
    
}//

//..............Add Sub Quiz .....................
if (isset($_POST['add_sub_quiz'])) {
    $quiz_id = $_POST['quiz_id'];
    $title = $con->real_escape_string($_POST['quiz_part_title']);
    $added_by = $_SESSION['user']['user_id'];
    
    $sqlCheck = "SELECT id FROM quiz_parts WHERE title = '$title' AND quiz_id = $quiz_id AND status != 2 ";
    $resCheck = $con->query($sqlCheck);
    if( $resCheck && $resCheck->num_rows > 0 ){
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Quiz Part Already Added Before.";
        header("location: add_sub_quiz.php");
    } else {
        $sql = "INSERT INTO quiz_parts (title, quiz_id, added_by) VALUES('$title', $quiz_id, $added_by)";
        $result = $con->query($sql);
       
        if ($result) {
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = "Quiz Part Added Successfully";
            header("location: add_sub_quiz.php");
    
            } 
        else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Quiz Part not Added";
            header("location: add_sub_quiz.php");
        }
    }
    
}

//..............Edit Sub Quiz .....................
if (isset($_POST['edit_sub_quiz'])) {
    $quiz_id = $_POST['quiz_id'];
    $sub_quiz_id = $_POST['sub_quiz_id'];
    $title = $con->real_escape_string($_POST['quiz_part_title']);
    $added_by = $_SESSION['user']['user_id'];
    
    $sqlCheck = "SELECT id FROM quiz_parts WHERE title = '$title' AND quiz_id = $quiz_id AND status != 2 AND id != $sub_quiz_id ";
    $resCheck = $con->query($sqlCheck);
    if( $resCheck && $resCheck->num_rows > 0 ){
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Quiz Part Already Added Before.";
        header("location: add_sub_quiz.php");
    } else {
        $sql = "UPDATE quiz_parts SET title = '$title', quiz_id = $quiz_id WHERE id = $sub_quiz_id ";
        $result = $con->query($sql);
       
        if ($result) {
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = "Quiz Part Updated Successfully";
            header("location: add_sub_quiz.php");
    
            } 
        else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Quiz Part not Updated";
            header("location: add_sub_quiz.php");
        }
    }
    
}

if (isset($_POST['post_comment'])) {

    if ($_SESSION['user']['user_id'] == '') {
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = "Please Login Your Account";
        header('location:login.php');
    }
    
    $comment= $_POST['comment'];
    $discussion_id = $_POST['discussion_id'];
    $added_by = $_SESSION['user']['user_id'];

    $sql = "INSERT INTO comments (comment, added_by, discussion_id) VALUES ('$comment','$added_by','$discussion_id')";
    $result = $con->query($sql);
    if ($result) {
        $_SESSION['success'] = true;
        $_SESSION['error'] = false;
        $_SESSION['message'] = "Comment Added !!!";
        header('location:discussion_detail.php?id='.$discussion_id);
    }
    else{
        $_SESSION['success'] = false;
        $_SESSION['error'] = true;
        $_SESSION['message'] = " Comment not Added!!";
        header('location:discussion_detail.php?id='.$discussion_id);       
    }
}

?>