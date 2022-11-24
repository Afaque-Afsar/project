<?php
    require_once('required/session_maintainance.php');
    require_once('../DB.php');
    if( isset( $_GET['id'] ) && isset( $_GET['del'] ) && $_GET['del'] === 'yes' && $_GET['id'] != '' ){
        $user_id = $_SESSION['user']['user_id'];
        $sql = "UPDATE quiz_parts SET status = 2 WHERE id = ".$_GET['id']." AND added_by = $user_id ";
        if( $con->query( $sql ) ){
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = "Quiz Part Deleted Successfully!...";
        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Quiz Part Not Deleted, Please Try Again!...";
        }
        header("location: add_sub_quiz.php");
    }
    $page_name = ' | Add Sub Quiz';
    include_once('includes/header.php');
    include_once('includes/navbar.php');
?>
    
    <style type="text/css">
        .tox-statusbar__text-container{
            display: none !important;
        }
        .dataTables_filter {
            float: right;
            margin-top: -30px;
        }
        .quiz_edit, .quiz_delete {
            cursor: pointer;
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
                    <input type="hidden" name="sub_quiz_id" id="sub_quiz_id">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label>Category</label>
                            <select class="form-control js-example-basic-single" name="category_id" id="category_id" required>
                                <option value=''>Select Category</option>
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
                        <div class="col-sm-12 col-md-6">
                            <label>Quiz</label>
                            <select class="form-control js-example-basic-single" name="quiz_id" id="quiz" required>
                                <option value=''>Select Quiz</option>
                                
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-10">
                            <label for="quiz_part_title">Sub Quiz/Quiz Part</label>
                            <textarea class="form-control" id="quiz_part_title" required="" name="quiz_part_title" placeholder="Enter Sub Quiz/Quiz Part"></textarea>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <button type="submit" name="add_sub_quiz" id="process_sub_quiz" class="btn-sm align-center btn btn-success">Add</button>
                            <button type="button" id="cancel_edit" class="btn btn-sm align-center btn btn-danger hidden" >Cancel</button>
                        </div>
                    </div>   
                </form>
                <br>
                <hr>
                <div class="row">
                    <div class="col-sm-12" id="response_div">
                        
                    </div>
                </div>
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
                    alert("Internal error, please try again...");
                }
            });
        });
        
        $('#quiz').change(function(){
            var quiz_id = $(this).val();
            get_quiz_parts( quiz_id );
        });
        
        $(document).on('click', '.quiz_delete', function(){
            if( confirm( 'Are you sure you want to delete this record?' ) ){
                let id = $(this).data('id');
                $.ajax({
                    url: 'ajaxservices/ajax.php',
                    type:'POST',
                    data: { 'sub_quiz_id': id, 'type' : 'delete_sub_quiz' },
                    success: function(response){
                        if ( response.includes('Deleted Successfully') ){
                            alert("Quiz part deleted successfully...");
                            get_quiz_parts( $('#quiz').val() );
                        } else if( response.includes('Not Deleted') ) {
                            alert('Quiz Sub part not deleted or deletion not allowed, please try again');
                        } else {
                            alert("Internal error, please try again...");
                        }
                    },
                    error: function(){
                        alert("Internal error, please try again...");
                    }
                });
            }
        });
        
        $("#cancel_edit").click(function(){
            $('#quiz_part_title').val('');
            $('#category_id').val('').trigger('change');
            // $('#quiz').val('').trigger('change');
            $("#process_sub_quiz").attr('name', "add_sub_quiz").html("Add");
            $("#cancel_edit").addClass('hidden');
        });
        
        $(document).on('click', '.quiz_edit', function(e){
            let sub_quiz_title = $('.sub_quiz_title[data-id="'+$(this).data('id')+'"]').html();
            let category = $('.quiz_category[data-id="'+$(this).data('id')+'"]').data('categoryid');
            // $('#category_id').val(category).trigger('change');
            $('#quiz_part_title').val(sub_quiz_title);
            // $('#quiz').val(sub_quiz_title);
            // $('#category_id').trigger('change');
            $("#process_sub_quiz").attr('name', "edit_sub_quiz").html("Edit");
            $("#cancel_edit").removeClass('hidden');
            $('#sub_quiz_id').val($(this).data('id'));
        });
        
    });
    
    function get_quiz_parts( quiz_id ){
        $.ajax({
            url: 'ajaxservices/ajax.php',
            type:'GET',
            data: { 'quiz_id': quiz_id, 'type' : 'get_sub_quiz_complete' },
            success: function(response){
                if ( response.includes('true') ){
                    var resp = JSON.parse(response);
                    var html = '<table class="table table-hover table-stripped bootstrap-datatable datatable responsive dataTable">';
                    html += '<thead>';
                    html += '<tr>';
                    html += '<th>#</th>';
                    html += '<th>Sub Quiz</th>';
                    html += '<th>Quiz</th>';
                    html += '<th>Category</th>';
                    html += '<th>Added By</th>';
                    html += '<th>Actions</th>';
                    html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';
                        
                    var count = 1;
                    $.each(resp.quiz_parts, function(index, value){
                        html += "<tr>";
                        html += "<td>"+count+"</td>";
                        html += "<td class='sub_quiz_title' data-id='"+value['id']+"'>"+value['title']+"</td>";
                        html += "<td class='quiz_title' data-id='"+value['quiz_id']+"'>"+value['quiz_title']+"</td>";
                        html += "<td class='quiz_category' data-id='"+value['id']+"' data-categoryid='"+value['category_id']+"'>"+value['tittle']+"</td>";
                        html += "<td>"+value['user_fname']+" "+value['user_lname']+"<br><small>"+value['created_at']+"</small></td>";
                        if( value['user_id'] == "<?= $_SESSION['user']['user_id']; ?>" ){
                            html += '<td><i class="glyphicon glyphicon-edit quiz_edit" data-id="'+value['id']+'"></i> &nbsp;&nbsp;&nbsp; <i class="glyphicon glyphicon-trash icon-danger quiz_delete" style="color: red;" data-id="'+value['id']+'"></i> </td>';
                        } else {
                            html += '<td>Not Allowed</td>';
                        }
                        html += "</tr>";
                        count++;
                    });
                    html += '</tbody>';
                    html += '</table>';
                    $("#response_div").html(html);
                } else if( response.includes('false') ) {
                    var html = '';
                    $("#response_div").html(html);
                } else {
                    alert("Internal error, please try again...");
                }
            },
            error: function(){
                alert('');
            },
            complete: function(){
                $(".dataTable").dataTable();
            }
        });
    }
    
</script>
