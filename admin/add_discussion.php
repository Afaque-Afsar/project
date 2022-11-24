<?php
    require_once('required/session_maintanance.php');
    $page_name = ' | Add Discussions';
    include_once('includes/header.php');
    include_once('includes/navbar.php');

    if ( isset($_POST['submit']) ) {
        require_once('../DB.php');
        $image_path = "";
        $is_insert = true;
        if( isset($_FILES['image']) && $_FILES['image']['error'] != 4 ) {
            $file = $_FILES['image'];
            if ( stripos( $file['type'], 'image' ) === false ) {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Please Provide Image Only!...";
                $is_insert = false;
            } else {
                if (move_uploaded_file($file['tmp_name'], "../uploads/discussion_images/".$file['name'])){
                    $is_insert = true;
                    $image_path = "/uploads/discussion_images/".$file['name'];
                } else {
                    $is_insert = false;
                }
            }
        }
        if ( $is_insert == true ) {
            $subject = $con->real_escape_string($_POST['subject']);
            $description = $con->real_escape_string($_POST['description']);
            $user_id = $_SESSION['user']['user_id'];
            $sql = "INSERT INTO discussion(subject, discussion, image_path, added_by)
                    VALUES('$subject', '$description', '$image_path', $user_id)";
            $res = $con->query($sql);
            if( $res ){
                $_SESSION['success'] = true;
                $_SESSION['error'] = false;
                $_SESSION['message'] = "Discussion Added Successfully, Please Wait For Approval";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Discussion not Added, Please Try Again!...";
            }
        }
        
        // image_path

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
                <form action="" method="POST" id="discussion_form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <label for="subject">Discussion Subject</label>
                            <textarea class="form-control" id="subject" required="" name="subject" placeholder="Enter Discussion Subject Here"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="mytextarea">Discussion Description</label>
                            <textarea id="mytextarea" name="description" placeholder="Enter Discussion Description Here"></textarea>
                        </div>
                    </div> 
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 center">
                            <button type="submit" name="submit" class="align-center btn btn-success">Add</button>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
    </div>
    <?php

    include_once('includes/footer.php');
?>
<!-- <script type="text/javascript">
    $(document).ready(function(){
        $('#discussion_form').submit(function(e){
            e.preventDefault();
            alert('working');
        });
    });
</script> -->

