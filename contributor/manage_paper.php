<?php
    require_once('required/session_maintainance.php');
$page_name = ' | Past Papers';
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
      <div class="row" style="margin: 18px;" >
        <div class="col-12">
          <label>Category</label>
          <select class="form-control" id="category" name="category">
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
      <div class="row" style="margin: 18px;">
         <label>Sub Category</label>
            <select class="form-control" name="subcategory" id="subcategory">
              <option>Select Sub Category</option>
            </select>
      </div>
      <div class="row" style="margin: 18px;">
         <label>Subject</label>
            <select class="form-control" name="subject" id="subject">
              <option>Select Subject</option>
            </select>
      </div>
      <hr>
      <div id="content_record">
        
      </div>
  </div>
      </div>
</div>
<?php

include_once('includes/footer.php');

// function is_active_page( $page_no ){
//   global $page;
//   if ( $page == $page_no ) {
//     return 'class="disabled"';
//   }
// }
?>
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click', '.delete',function(e){
      e.preventDefault();
      if( confirm('Do you want to delete this book') ){
        $(this).prop('disabled', true);
        var paper_id = $(this).data('id');
           $.ajax({
            url: "ajaxservices/ajax.php",
            type: "POST",
            data: { 'type':"delete_paper", paper_id:paper_id, user_id:"<?= $_SESSION['user']['user_id']; ?>" },
            success: function( response ){
                if(response.includes('true')){
                    alert("Paper Deleted Successfully, ");
                    location.reload();
                } else {
                    alert("Paper Not Deleted, Please Try Again...");
                }
                $(this).prop('disabled', false);
            },
            error: function(){
                alert("Internal Error!...");
            },
            complete: function(){

            }
           });
      } 
    });

     var category_id = " ";
     var subcategory_id = " ";
     var subject_id = " ";
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
      });
    });

    $('#subject').on('change',function(){
      subject_id = $(this).val();
      $.ajax({
        type: 'POST', 
        url: 'paper_ajax.php',
        data: {'category_id': category_id, 'subcategory_id': subcategory_id, 'subject_id': subject_id},
        cache: false,
        success: function(result){
          $('#content_record').html(result);
        }
      });
    });


   
  });
</script>