<?php
require_once('required/session_maintanance.php');
include_once('includes/header.php');
include_once('includes/navbar.php');
require_once('../DB.php');
$sql = "SELECT * FROM past_paper_subjects WHERE id = ".$_GET['id'];
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
      <?php include 'includes/success_error_message.php'?>
      <a class="btn btn-sm btn-warning" href="view_subject.php"> Back</a><br><br>
      <form action="logic.php" method="POST">
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
                $sql = "SELECT * FROM past_paper_categories WHERE status = 1 AND category_id = ".$categories_row['category_id'];
                $result = $con->query($sql);
                $rows = $result->num_rows;
                if ($rows > 0 ) {
                 while ($row = $result->fetch_assoc()) {
                  $selected = '';
                  if( $row['id'] == $categories_row['id'] ){
                     $selected = 'selected';
                  }
                  echo "<option ".$selected." value=".$row['id'].">".$row['tittle']."</option>";
                }
              }
              ?>
            </select>
      </div>
      <br>
      <div class="row">
        <div class="col-12">
          <label for="material">Subject Tittle</label>  
          <textarea class="form-control" id="" required="" name="tittle" placeholder="Enter Subject Tittle Here"><?=$subjects_row['tittle']?></textarea>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12">
          <label for="selection">Subject Description</label>
          <textarea class="form-control" id="" required="" name="description" placeholder="Enter Subject Description Here"><?=$subjects_row['description']?></textarea>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12 center">
          <button type="submit" name="edit_subject" class="align-center btn btn-success">Edit</button>
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
        } 
      });
    });
  });
</script>


