<?php
require_once('required/session_maintanance.php');
include_once('includes/header.php');
include_once('includes/navbar.php');
require_once('../DB.php');
?>
<div class="ch-container">
  <div class="row">
    <!-- left menu starts -->
    <div class="col-sm-2 col-lg-2">
      <?php include_once('includes/sidebar.php'); ?>
    </div>
    <div id="content" class="col-lg-10 col-sm-10">
      <?php include 'includes/success_error_message.php'?>
      <form action="logic.php" method="POST" enctype="multipart/form-data">
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
         <label>Sub Category</label>
            <select class="form-control" name="subcategory" id="subcategory">
              <option>Select Sub Category</option>
            </select>
      </div>
      <br>
      <div class="row">
         <label>Subject</label>
            <select class="form-control" name="subject" id="subject">
              <option>Select Subject</option>
            </select>
      </div>
      <br>
      <div class="row">
        <div class="col-12">
          <label for="material">Tittle</label>  
          <textarea class="form-control" id="" required="" name="tittle" placeholder="Enter Past Paper Tittle Here"></textarea>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12">
          <label for="selection">Description</label>
          <textarea class="form-control" id="" name="description" placeholder="Enter Past Paper Description Here"></textarea>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12">
          <label for="image">Image</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-12 center">
          <button type="submit" name="add_paper" class="align-center btn btn-success">Add</button>
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


