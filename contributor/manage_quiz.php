<?php
    require_once('required/session_maintainance.php');
$page_name = ' | Quiz';
include_once('includes/header.php');
include_once('includes/navbar.php');
require_once('../DB.php');

?>
<style>
    .question_row {
        cursor: pointer;
    } 
</style>
<div class="ch-container">
  <div class="row">
    <!-- left menu starts -->
    <div class="col-sm-2 col-lg-2">
      <?php include_once('includes/sidebar.php'); ?>
    </div>
    <div id="content" class="col-lg-10 col-sm-10">
      <div class="row" style="margin: 18px;" >
        <div class="col-sm-12 col-lg-4">
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
          <div class="col-sm-12 col-lg-4" >
             <label>Quiz</label>
                <select class="form-control" name="quiz" id="quiz">
                  <option>Quiz/Subject</option>
                </select>
          </div>
          <div class="col-sm-12 col-lg-4" >
             <label>Subject Part/Quiz Part</label>
                <select class="form-control" name="sub_quiz" id="sub_quiz">
                  <option>Select Subject/Quiz Part</option>
                </select>
          </div>
      </div>
      <hr>
      <div id="content_record">
            <table id='response_table' class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Option A</th>
                        <th>Option B</th>
                        <th>Option C</th>
                        <th>Option D</th>
                        <th>Correct Option</th>
                        <th>Answer Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id='table_body'></tbody>
            </table>
      </div>
  </div>
      </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Edit Question</h3>
                </div>
                <div class="modal-body">
                    <input class='form-control' type="hidden" value="" id="user_id">
                    <table id="modal_table">
                        
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" id="edit_question">Save changes</a>
                </div>
            </div>
        </div>
    </div>
<?php

include_once('includes/footer.php');

?>
<script type="text/javascript">
  $(document).ready(function(){
     var category_id = " ";
     var subcategory_id = " ";
     var subject_id = " ";
    $('#category').change(function(){
        var category_id = $(this).val();
        get_quiz( category_id, 'quiz', 'sub_quiz' );
    });
    
    $(document).on('change', '#edit_category', function(){
        var category_id = $(this).val();
        get_quiz( category_id, 'edit_quiz_select', 'edit_sub_quiz_select' );
    });

    $('#quiz').change(function(){
      var quiz_id = $(this).val();
      get_sub_quiz( quiz_id, 'sub_quiz' );
    });
    
    $(document).on('change', '#edit_quiz_select', function(){
        var quiz_id = $(this).val();
        get_sub_quiz( quiz_id, 'edit_sub_quiz_select' );
    });

    $('#sub_quiz').on('change',function(){
      var sub_quiz_id = $(this).val();
      get_questions(sub_quiz_id);
    });
    
    
    $(document).on('click', '#edit_question', function(){
        var quiz_part_id = $('#edit_sub_quiz_select').val();
        var question = $('#edit_question_description').val();
        var optionA = $('#edit_optionA').val();
        var optionB = $('#edit_optionB').val();
        var optionC = $('#edit_optionC').val();
        var optionD = $('#edit_optionD').val();
        var correct_option = $('#correct_option').val();
        var question_id = $('#question_id_edit').val();
        var description = $('#edit_description').val();
        
        if( quiz_part_id == '' || question == '' || optionA == '' || optionB == '' || optionC == '' || optionD == '' || correct_option == '' || question_id == '' ){
            alert('Some fields are empty');
        } else {
            $.ajax({
                url:'ajaxservices/ajax.php',
                type:'post',
                data: {
                        type:'edit_question', 
                        quiz_part_id:quiz_part_id, 
                        question:question,
                        optionA:optionA,
                        optionB:optionB,
                        optionC: optionC,
                        optionD:optionD,
                        correct_option:correct_option,
                        question_id: question_id,
                        description: description
                    },
                success: function(response){
                    if ( response == 'edited' ) {
                        $("#myModal").modal('hide');
                        alert('Question edited successfully');
                        get_questions($('#sub_quiz').val());
                    } else {
                        alert(response);
                    }
                },
                error: function(){
                    alert('internal error, please try again...');
                }
            });
        }
    });
    
    $(document).on('click', '.question_row_delete', function(){
        var q_id = $(this).data('id');
        $.ajax({
            url: "ajaxservices/ajax.php",
            type: "POST",
            data: { 'type':"delete_question", 'question_id':q_id, user_id:"<?= $_SESSION['user']['user_id']; ?>" },
            success: function( response ){
                if(response.includes('true')){
                    alert("Question Deleted Successfully, ");
                    get_questions($('#sub_quiz').val());
                } else {
                    alert("Question Not Deleted, Please Try Again...");
                }
                // $(this).prop('disabled', false);
            },
            error: function(){
                alert("Internal Error!...");
            },
            complete: function(){

            }
        });
    });
    
    $(document).on('click', '.question_row_edit', function(){
        var q_id = $(this).data('id');
        var sub_quiz = $('#sub_quiz').val();
        var quiz = $('#quiz').val();
        var category = $('#category').val();
         
        $.ajax({
            url: "ajaxservices/ajax.php",
            type: "POST",
            data: { 'type':"question_details", 'question_id':q_id, user_id:"<?= $_SESSION['user']['user_id']; ?>", 'quiz' : quiz, 'sub_quiz' : sub_quiz, 'category':category },
            success: function( response ){
                $("#modal_table").html(response);
                $("#myModal").modal('show');
                
            },
            error: function(){
                alert("Internal Error, please try again!...");
            }
        });
    });


   
  });
  
  function get_sub_quiz( quiz_id, select_id ){
      $.ajax({
        type: 'GET', 
        url: 'ajaxservices/ajax.php',
        data: {'quiz_id': quiz_id, 'type' : 'get_sub_quiz'},
        success: function(response){
            if ( response.includes('true') ){
                var resp = JSON.parse(response);
                var html = '<option value="">Select Subject/Sub Quiz</option>';
                $.each(resp.quiz_parts, function(index, value){
                    html += '<option value="'+value['id']+'">'+value['title']+'</option>';
                });
                $("#"+select_id).html(html);
            } else if( response.includes('false') ) {
                var html = '<option value="">Select Subject/Sub Quiz</option>';
                $("#"+select_id).html(html);
            } else {
                alert("Internal error, please try again...");
            }
        },
        error: function(){
            alert('Internal Error, Please try again...');
        }
      });
  }
  
    function get_quiz( category_id, select_id, sub_quiz_select_id ){
        $.ajax({
            url: 'ajaxservices/ajax.php',
            type:'GET',
            data: { 'category_id': category_id, 'type' : 'get_quiz' },
            success: function(response){
                var html1 = '<option value="">Select Subject/Sub Quiz</option>';
                $("#"+sub_quiz_select_id).html(html1);
                if ( response.includes('true') ){
                    var resp = JSON.parse(response);
                    var html = '<option value="">Select Quiz</option>';
                    $.each(resp.quiz, function(index, value){
                        html += '<option value="'+value['id']+'">'+value['title']+'</option>';
                    });
                    $("#"+select_id).html(html);
                } else if( response.includes('false') ) {
                    var html = '<option value="">Select Quiz</option>';
                    $("#"+select_id).html(html);
                } else {
                    alert("Internal error, please try again...");
                }
            },
            error: function(){
                alert('Internal Error, Please try again...');
            }
        });
    }
  
  function get_questions(sub_quiz_id = ''){
      if( sub_quiz_id != '' ){
            $.ajax({
                type: 'GET', 
                url: 'ajaxservices/ajax.php',
                data: {'sub_quiz_id': sub_quiz_id, 'type': 'get_all_quiz'},
                cache: false,
                success: function(response){
                    if ( response.includes('true') ){
                        var resp = JSON.parse(response);
                        var html = '';
                        $.each(resp.questions, function(index, value){
                            html += "<tr class='question_row' data-id='"+value['id']+"'>";
                            html += '<td>'+value['question']+'</td>';
                            html += '<td>'+value['optionA']+'</td>';
                            html += '<td>'+value['optionB']+'</td>';
                            html += '<td>'+value['optionC']+'</td>';
                            html += '<td>'+value['optionD']+'</td>';
                            html += '<td>'+value['answer']+'</td>';
                            html += '<td>'+value['description']+'</td>';
                            if( value['added_by'] == "<?= $_SESSION['user']['user_id']; ?>" ){
                                html += '<td><i class="glyphicon glyphicon-edit question_row_edit" data-id="'+value['id']+'"></i>'; 
                                html += ' &nbsp;&nbsp;&nbsp; <i class="glyphicon glyphicon-trash icon-danger question_row_delete" style="color: red;" data-id="'+value['id']+'"></i> </td>';
                            } else {
                                html += '<td>Not Allowed</td>';
                            }
                            html += "</tr>";
                        });
                        $("#table_body").html(html);
                    } else if( response.includes('false') ) {
                        var html = '';
                        $("#table_body").html(html);
                    } else {
                        alert("Internal error, please try again...");
                    }
                   
                },
                error: function(){
                    alert("Internal error, please try again...");
                },
                complete: function(){
                    $("#response_table").DataTable();
                }
            });
          
      } else {
          $("#table_body").html('');
      }
  }
</script>