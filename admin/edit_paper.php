<?php
require_once('required/session_maintanance.php');
$page_name = ' | Edit Paper';
include_once('includes/header.php');
include_once('includes/navbar.php');
require_once('../DB.php');
$sql = "SELECT * FROM past_papers WHERE id = ".$_GET['id'];
$result = $con->query($sql);
if ($result && $result->num_rows > 0 ) {
    $paper_row = $result->fetch_assoc();
} else {
    echo "<script>window.history.back();</script>";
}

$sql = "SELECT * FROM past_paper_subjects WHERE id = ".$paper_row['subject_id'];
$result = $con->query($sql);
if ($result && $result->num_rows > 0 ) {
    $subjects_row = $result->fetch_assoc();
} else {
    echo "<script>window.history.back();</script>";
}


$sql = "SELECT * FROM past_paper_categories WHERE id = ".$subjects_row['subcategory_id'];
$result = $con->query($sql);
if ($result && $result->num_rows > 0 ) {
    $categories_row = $result->fetch_assoc();
} else {
    echo "<script>window.history.back();</script>";
}

?>
<div class="ch-container">
  <div class="row">
    <!-- left menu starts -->
    <div class="col-sm-2 col-lg-2">
      <?php include_once('includes/sidebar.php'); ?>
    </div>
    <div id="content" class="col-lg-10 col-sm-10">
      <?php include '../include/success_error_message.php'?>
      <a class="btn btn-sm btn-warning" href="view_paper.php"> Back</a><br><br>
      <form action="logic.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
        <div class="row">
          <div class="col-12">
            <label>Category</label>
            <select class="form-control" name="category" id="category">
              <option>Select Category</option>
              <?php
              $sql = "SELECT * FROM material_categories WHERE status = 1";
              $result = $con->query($sql);
              $rows = $result->num_rows;
              if ($rows > 0 ) {
               while ($row = $result->fetch_assoc()) {
                $selected = '';
                if( $row['id'] == $categories_row['category_id'] ){
                    $selected = 'selected';
                }
                echo "<option ".$selected." value=".$row['id'].">".$row['tittle']."</option>";
              }
            }
            ?>
          </select>
        </div>
      </div>
      <br>
      <div class="row">
         <label>Sub Category</label>
            <select class="form-control" name="subcategory" id="subcategory">
              <option>Select Sub Category</option>
              <?php
              $sql1 = "SELECT * FROM past_paper_categories WHERE status = 1 AND category_id = ".$categories_row['category_id'];
              $result1 = $con->query($sql1);
              $rows1 = $result1->num_rows;
              if ($rows1 > 0 ) {
               while ($row1 = $result1->fetch_assoc()) {
                $selected = '';
                if( $row1['id'] == $categories_row['id'] ){
                    $selected = 'selected';
                }
                echo "<option ".$selected." value=".$row1['id'].">".$row1['tittle']."</option>";
              }
            }
            ?>
            </select>
      </div>
      <br>
      <div class="row">
         <label>Subject</label>
            <select class="form-control" name="subject" id="subject">
              <option>Select Subject</option>
              <?php
              $sql2 = "SELECT * FROM past_paper_subjects WHERE status = 1 AND subcategory_id = ".$subjects_row['subcategory_id'];
              $result2 = $con->query($sql2);
              $rows2 = $result2->num_rows;
              if ($rows2 > 0 ) {
               while ($row2 = $result2->fetch_assoc()) {
                $selected = '';
                if( $row2['id'] == $subjects_row['subcategory_id'] ){
                    $selected = 'selected';
                }
                echo "<option ".$selected." value=".$row2['id'].">".$row2['tittle']."</option>";
              }
            }
            ?>
            </select>
      </div>
      <br>
      <div class="row">
        <div class="col-12">
          <label for="material">Tittle</label>  
          <textarea class="form-control" id="" required="" name="tittle" placeholder="Enter Past Paper Tittle Here"><?=$paper_row['tittle'];?></textarea>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12">
          <label for="selection">Description</label>
          <textarea class="form-control" id="" name="description" placeholder="Enter Past Paper Description Here"><?=$paper_row['description'];?></textarea>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-6">
          <label for="image">Image</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="col-sm-6">
          <img src="../<?= $paper_row['paper_image']; ?>" height="400px">
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12 center">
          <button type="submit" name="edit_paper" class="align-center btn btn-success">Update</button>
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
  $(document).ready(function() {
    var category_id = " ";
    $('#category').change(function(){
      category_id = $(this).val();
      $.ajax({
        type: 'POST',
        url: 'subcategory_ajax.php',
        data: {'category_id': category_id},
        cache: false,
        success: function(result){
          $('#subcategory').html(result);
          $('#subject').html('<option value=""> Select Sub-Category First</option>');

        } 
      });
    });

    $('#subcategory').change(function(){
      subcategory_id = $(this).val();
      $.ajax({
        type: 'POST', 
        url: 'subject_ajax.php',
        data: {'subcategory_id': subcategory_id},
        cache: false,
        success: function(result){
          $('#subject').html(result);
        }
      })
    });
  });
</script>


