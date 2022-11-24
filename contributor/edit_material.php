<?php
    require_once('required/session_maintainance.php');
$page_name = ' | Edit Material';
include_once('includes/header.php');
include_once('includes/navbar.php');
require_once('../DB.php');

$sql = "SELECT * FROM material WHERE id = ".$_GET['id'];
$result = $con->query($sql);
if ($result && $result->num_rows > 0 ) {
    $material_row = $result->fetch_assoc();
} else {
    echo "<script>window.history.back();</script>";
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
            <div class="row">
                <div class="col-sm-12">
                    <?php include('../include/success_error_message.php');?>
                </div>
            </div>
            <a class="btn btn-sm btn-warning" href="manage_material.php" > Back</a><br><br>
            <form action="logic.php" method="POST" id="discussion_form" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?=$_GET['id'];?>">
                <div class="row">
                    <div class="col-12">
                        <label>Category</label>
                        <select class="form-control js-example-basic-single" name="category">
                            <option>Select Category</option>
                            <?php
                            $sql = "SELECT * FROM material_categories WHERE status = 1";
                            $result = $con->query($sql);
                            $rows = $result->num_rows;
                            if ($rows > 0 ) {
                               while ($row = $result->fetch_assoc()) {
                                $selected = '';
                                if( $row['id'] == $material_row['category_id'] ){
                                    $selected = 'selected';
                                }
                                echo "<option ".$selected." value=".$row['id'].">".$row['tittle']."</option>";
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
                    <textarea class="form-control" id="material" required="" name="tittle" placeholder="Enter Material Tittle Here"><?=$material_row['tittle'];?></textarea>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <label for="selection">Material Description</label>
                    <select class="form-control select-format" name="choose_format">
                        <option hidden>Choose Description Format</option>
                        <option value="text_format" <?=($material_row['material_format'] == 'text_format')?'selected':'';?> >In Text format</option>
                        <option value="pdf_format" <?=($material_row['material_format'] == 'pdf_format')?'selected':'';?> >In PDF file format</option>
                        <option value="video_format" <?=($material_row['material_format'] == 'video_format')?'selected':'';?> >In Video format</option>
                        <option value="link_format" <?=($material_row['material_format'] == 'link_format')?'selected':'';?> >In Link format</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row text-format">
                <div class="col-12">
                    <label for="mytextarea">Material Description</label>
                    <textarea id="mytextarea" name="description" placeholder="Enter Material Description Here"><?=$material_row['description'];?></textarea>
                </div>
            </div> 
            <br>
            <?php
                if( $material_row['material_format'] == 'pdf_format' ){
                ?>
                    <div class="row ">
                        <div class="col-12">
                            <a href="../<?=$material_row['description'];?>" target="_blank">View PDF</a>
                        </div>
                    </div> 
                    <br>
                <?php  
                }
            ?>
            <div class="row pdf-format">
                <div class="col-12">
                    <label for="pdf">Material PDF</label>
                    <input type="file" id="pdf" class="form-control" name="material_pdf" accept="application/pdf">
                </div>
            </div>
            <?php
                if( $material_row['material_format'] == 'video_format' ){
                ?>
                    <div class="row ">
                        <div class="col-12">
                            <a href="../<?=$material_row['description'];?>" target="_blank">View Video</a>
                        </div>
                    </div> 
                    <br>
                <?php  
                }
            ?>
            <br>
            <div class="row video-format">
                <div class="col-12" style="margin-top: -30px;">
                    <label>Material Video</label>
                    <input type="file" class="form-control" name="material_video" accept="video/mp4">
                </div>
            </div>
            <?php
                if( $material_row['material_format'] == 'link_format' ){
                ?>
                    <div class="row ">
                        <div class="col-12">
                            <div class="embed-responsive embed-responsive-16by9" style="width: 90%; height: 50%;">
                              <iframe src="<?=$material_row['description'];?>" class="embed-responsive-item" controls>
                              </iframe>
                            </div>
                        </div>
                    </div> 
                    <br><br><br>
                <?php  
                }
            ?>
            <br>
            <div class="row link-format">
                <div class="col-12" style="margin-top: -45px;">
                    <label>Material Link</label>
                   <input type="text" class="form-control" value="<?=$material_row['description'];?>" name="material_link">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12 center">
                    <button type="submit" name="edit_material" class="align-center btn btn-success">Edit</button>
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
        $(".select-format").change();
    });
</script>

