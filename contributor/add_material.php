<?php
    require_once('required/session_maintainance.php');
$page_name = ' | Add Material';
include_once('includes/header.php');
include_once('includes/navbar.php');
require_once('../DB.php');

if ( isset($_POST['submit']) ) {
    $image_path = "";
    $is_insert = true;
    if( isset($_FILES['image']) ) {
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
    .text-format{
        display: none;
    }
    .pdf-format{
        display: none;
    }
    .video-format{
        display: none;
    }
    .link-format{
        display: none;
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
            <form action="logic.php" method="POST" id="discussion_form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        <label>Category</label>
                        <select class="form-control js-example-basic-single" name="category">
                            <option>Select Category</option>
                            <?php
                            $sql = "SELECT * FROM material_categories WHERE status = 1";
                            echo $sql;
                            $result = $con->query($sql);
                            $rows = $result->num_rows;
                            if ($rows > 0 ) {
                               while ($row = $result->fetch_assoc()) {
                                echo "<option value=".$row['id'].">".$row['tittle']."</option>";
                                         # code...
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <label for="material">Material Tittle</label>  
                    <textarea class="form-control" id="material" required="" name="tittle" placeholder="Enter Material Tittle Here"></textarea>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <label for="selection">Material Description</label>
                    <select class="form-control select-format" name="choose_format">
                        <option hidden>Choose Description Format</option>
                        <option value="text_format">In Text format</option>
                        <option value="pdf_format">In PDF file format</option>
                        <option value="video_format">In Video format</option>
                        <option value="link_format">In Link format</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row text-format">
                <div class="col-12">
                    <label for="mytextarea">Material Description</label>
                    <textarea id="mytextarea" name="description" placeholder="Enter Material Description Here"></textarea>
                </div>
            </div> 
            <br>
            <div class="row pdf-format">
                <div class="col-12">
                    <label for="pdf">Material PDF</label>
                    <input type="file" id="pdf" class="form-control" name="material_pdf" accept="application/pdf">
                </div>
            </div>
            <br>
            <div class="row video-format">
                <div class="col-12" style="margin-top: -30px;">
                    <label>Material Video</label>
                    <input type="file" class="form-control" name="material_video" accept="video/mp4">
                </div>
            </div>
            <br>
            <div class="row link-format">
                <div class="col-12" style="margin-top: -45px;">
                    <label>Material Link</label>
                   <input type="text" class="form-control" name="material_link">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12 center">
                    <button type="submit" name="add_material" class="align-center btn btn-success">Add</button>
                </div>
            </div>    
        </form>
    </div>
</div>
</div>
<?php

include_once('includes/footer.php');
?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".select-format").on('change', function(){
            if (this.value == 'text_format') {
                $('.text-format').show();
                $('.pdf-format').hide();
                $('.video-format').hide();
                $('.link-format').hide();
            }
            if (this.value == 'pdf_format') {
                $('.pdf-format').show();
                $('.text-format').hide();
                $('.video-format').hide();
                $('.link-format').hide();
            }
            if (this.value == 'video_format') {
                $('.video-format').show();
                $('.pdf-format').hide();
                $('.text-format').hide();
                $('.link-format').hide();
            }
            if (this.value == 'link_format') {
                $('.link-format').show();
                $('.video-format').hide();
                $('.pdf-format').hide();
                $('.text-format').hide();
            }
        });
    });
</script>

