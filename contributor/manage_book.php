<?php
    require_once('required/session_maintainance.php');
$page_name = ' | Book';
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
      <?php include '../include/success_error_message.php'?>
      <div class="row" style="margin: 18px;" >
        <div class="col-12">
          <label>Category</label>
          <select class="form-control js-example-basic-single" id="select_category" name="category">
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
    $(document).on('click', '.delete', function(e){
      e.preventDefault();
        if( confirm('Do you want to delete this discussion') ){
            $(this).prop('disabled', true);
           var book_id = $(this).data('id');
           $.ajax({
            url: "ajaxservices/ajax.php",
            type: "POST",
            data: { 'type':"delete_book", book_id:book_id, user_id:"<?= $_SESSION['user']['user_id']; ?>" },
            success: function( response ){
                if(response.includes('true')){
                    alert("Book Deleted Successfully, ");
                    location.reload();
                } else {
                    alert("Book Not Deleted, Please Try Again...");
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
    $('#select_category').on('change',function(){
      var category_id = $(this).val();
      $.ajax({
        url: "book_ajax.php",
        data: {'category_id' : category_id},
        type: "POST",
        cache: false,
        success: function(result){
          $('#content_record').html(result);
        } 
      });
    });
  });
</script>