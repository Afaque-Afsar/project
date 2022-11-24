<?php
require_once('required/session_maintanance.php');
    $page_name = ' | Add Question';
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    require_once('../DB.php');
?>
    
    <style type="text/css">
        .tox-statusbar__text-container{
            display: none !important;
        }
    </style>
    <!-- <script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
          tinymce.init({
            selector: '#mytextarea'
          });
    </script> -->
    <div class="ch-container">
        <div class="row">
            <!-- left menu starts -->
            <div class="col-sm-2 col-lg-2">
                <?php include_once('includes/sidebar.php'); ?>
            </div>
            <div id="content" class="col-lg-10 col-sm-10">
                <?php include '../include/success_error_message.php'?>
                <form action="logic.php" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <label>Category</label>
                            <select class="form-control" name="category_id" required id="category_id">
                                <option value="">Select Category</option>
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
                         <label for="quiz">Quiz/Subject</label>
                            <select class="form-control" name="quiz_id" required id="quiz">
                              <option value="">Select Quiz</option>
                            </select>
                      </div>
                      <br>
                      <div class="row">
                         <label>Sub Quiz/Quiz Part</label>
                            <select class="form-control" name="sub_quiz" required id="sub_quiz">
                              <option value="">Select Subject Part/Sub Quiz</option>
                            </select>
                      </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="subject">Question</label>
                            <textarea class="form-control" id="book" required="" name="question" placeholder="Enter Question Here"></textarea>
                        </div>
                    </div>
                    <br>
                     <div class="row">
                        <div class="col-6">
                            <label>OptionA</label>
                            <input type="text" class="form-control" required name="optionA">
                        </div> <br>
                        <div class="col-6">
                            <label>OptionB</label>
                            <input type="text" class="form-control" required name="optionB">
                        </div>
                     </div>
                    <br>
                     <div class="row">
                        <div class="col-6">
                            <label>OptionC</label>
                            <input type="text" class="form-control" required name="optionC">
                        </div> <br>
                        <div class="col-6">
                            <label>OptionD</label>
                            <input type="text" class="form-control" required name="optionD">
                        </div>
                     </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Answer</label>
                            <select class="form-control" name="answer" required id="answer">
                              <option value="">Select Correct Choice</option>
                              <option value="A">A</option>
                              <option value="B">B</option>
                              <option value="C">C</option>
                              <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label>Answer Description</label>
                            <textarea class="form-control" required name="description" placeholder="Enter Correct Answer Description Here"></textarea>
                        </div>
                    </div>
                    <br>
                    
                    <div class="row">
                        <div class="col-12 center">
                            <button type="submit" name="add_question" class="align-center btn btn-success">Add</button>
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
        $('#category_id').change(function(){
            var category_id = $(this).val();
            $.ajax({
                url: 'ajaxservices/ajax.php',
                type:'GET',
                data: { 'category_id': category_id, 'type' : 'get_quiz' },
                success: function(response){
                    if ( response.includes('true') ){
                        var resp = JSON.parse(response);
                        var html = '<option value="">Select Quiz</option>';
                        $.each(resp.quiz, function(index, value){
                            html += '<option value="'+value['id']+'">'+value['title']+'</option>';
                        });
                        $("#quiz").html(html);
                    } else if( response.includes('false') ) {
                        var html = '<option value="">Select Quiz</option>';
                        $("#quiz").html(html);
                    } else {
                        alert("Internal error, please try again...");
                    }
                },
                error: function(){
                    alert('Internal Error, Please try again...');
                }
            });
        });
        
        $('#quiz').change(function(){
          var quiz_id = $(this).val();
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
                    $("#sub_quiz").html(html);
                } else if( response.includes('false') ) {
                    var html = '<option value="">Select Subject/Sub Quiz</option>';
                    $("#sub_quiz").html(html);
                } else {
                    alert("Internal error, please try again...");
                }
            },
            error: function(){
                alert('Internal Error, Please try again...');
            }
          })
        });
        
    });
</script> 

