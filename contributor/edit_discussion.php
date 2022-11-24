<?php
    require_once('required/session_maintainance.php');
    $page_name = ' | Edit Discussions';
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    require_once('../DB.php');
    
    if ( isset($_POST['submit']) ) {
        $image_path = "";
        $discussion_id = $_POST['discussion_id'];
        $subject = $con->real_escape_string($_POST['subject']);
        $description = $con->real_escape_string($_POST['description']);
        $user_id = $_SESSION['user']['user_id'];
        $is_insert = true;
        // print_r($_FILES);
        if( isset($_FILES['image']) && $_FILES['image']['error'] == 0 && !empty($_FILES['image']['name']) ) {
            $file = $_FILES['image'];
            if ( stripos( $file['type'], 'image' ) === false ) {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Please Provide Image Only!...";
                $is_insert = false;
            } else {
                $file_name = time().'_'.$file['name'];
                if (move_uploaded_file($file['tmp_name'], "../uploads/discussion_images/".$file_name)){
                    $image_path = "/uploads/discussion_images/".$file_name;
                    $sql = "UPDATE discussion SET subject = '$subject', discussion = '$description', image_path = '$image_path' WHERE id = $discussion_id AND added_by = $user_id ";
                } else {
                    $sql = "UPDATE discussion SET subject = '$subject', discussion = '$description' WHERE id = $discussion_id AND added_by = $user_id ";
                    $is_insert = false;
                }
            }
        } else {
            $sql = "UPDATE discussion SET subject = '$subject', discussion = '$description' WHERE id = $discussion_id AND added_by = $user_id ";
        }
        if( $is_insert == true ){
            $res = $con->query($sql);
            if( $res ){
                $_SESSION['success'] = true;
                $_SESSION['error'] = false;
                $_SESSION['message'] = "Discussion Edited Successfully";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Discussion not Edited, Please Try Again!...".$sql;
            }
        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Internal Error, Please Try Again!...".$sql;
        }
        
        
        
        // image_path

    }

    if ( isset($_GET['id']) ) {
        $id = $_GET['id'];
        
        $user_id = $_SESSION['user']['user_id'];
        $sql = "SELECT * FROM discussion WHERE id = $id AND added_by = $user_id ";
        $res = $con->query($sql);
        if( $res && $res->num_rows > 0 ){
            $row = $res->fetch_assoc();
        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "This discussion is not related to you!...";
            echo "<script>window.history.back();</script>";
        }
    } else {
        echo "<script>window.history.back();</script>";
    }

    ?>
    <style type="text/css">
        .tox-statusbar__text-container{
            display: none !important;
        }
    </style>
    <script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
          tinymce.init({
            selector: '#mytextarea'
          });
    </script>
    <div class="ch-container">
        <div class="row">
            <!-- left menu starts -->
            <div class="col-sm-2 col-lg-2">
                <?php include_once('includes/sidebar.php'); ?>
            </div>
            <div id="content" class="col-lg-10 col-sm-10">
                <?php include '../include/success_error_message.php'?>
                <a class="btn btn-sm btn-warning" href="manage_discussion.php" > Back</a><br><br>
                <form action="" method="POST" id="discussion_form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <label for="subject">Discussion Subject</label>
                            <textarea class="form-control" id="subject" required="" name="subject" placeholder="Enter Discussion Subject Here"><?= $row['subject']; ?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="discussion_id" value="<?= $id ?>">
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="mytextarea">Discussion Description</label>
                            <textarea id="mytextarea" name="description" placeholder="Enter Discussion Description Here"><?= $row['discussion']; ?></textarea>
                        </div>
                    </div> 
                    <br>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <?php
                                if( isset($row['image_path']) && !empty($row['image_path']) && $row['image_path'] != '' ){
                                    echo '<img src="../'.$row['image_path'].'" style="width: 200px; height: 200px;">';
                                }
                            ?>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <label for="image">Add Image</label>
                            <input type="file" id="image"  name="image" accept="image/*">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 center">
                            <button type="submit" name="submit" class="align-center btn btn-success">Save Changes</button>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
        <div class="row"></div>
    </div>
    <?php

    include_once('includes/footer.php');

