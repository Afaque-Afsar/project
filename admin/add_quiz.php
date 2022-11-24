<?php
require_once('required/session_maintanance.php');
    require_once('../DB.php');
    if( isset( $_GET['id'] ) && isset( $_GET['del'] ) && $_GET['del'] === 'yes' && $_GET['id'] != '' ){
        $user_id = $_SESSION['user']['user_id'];
        $sql = "UPDATE quiz SET status = 2 WHERE id = ".$_GET['id'];
        if( $con->query( $sql ) ){
            $_SESSION['success'] = true;
            $_SESSION['error'] = false;
            $_SESSION['message'] = "Quiz Deleted Successfully!...";
        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "Quiz Not Deleted, Please Try Again!...";
        }
        header("location: add_quiz.php");
    }
    $page_name = ' | Add Quiz';
    
    
    include_once('includes/header.php');
    include_once('includes/navbar.php');
?>
    
    <style type="text/css">
        .tox-statusbar__text-container{
            display: none !important;
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
                <?php include('includes/success_error_message.php');?>
                <form action="logic.php" method="POST">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <label for="category_id">Category</label>
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
                            <label for="title">Quiz Name/ Subject Name</label>
                            <textarea class="form-control" id="title" required="" name="title" placeholder="Enter Quiz Name/ Subject Name Here"></textarea>
                        </div>
                        <input type="hidden" name="quiz_id" id="quiz_id" value="">
                        <div class="col-sm-12 col-md-2 ">
                            <button type="submit" name="add_quiz" id="process_quiz" class="btn btn-sm align-center btn btn-success center">Add</button>
                            <button type="button" id="cancel_edit" class="btn btn-sm align-center btn btn-danger hidden" >Cancel</button>
                        </div>
                    </div>    
                </form>
                <br>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-hover table-stripped bootstrap-datatable datatable responsive dataTable" id='quiz_table'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Quiz</th>
                                    <th>Category</th>
                                    <th>Added By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql = "SELECT quiz.*, c.tittle, u.user_id, u.user_fname, u.user_lname  FROM quiz
                                        INNER JOIN material_categories c ON c.id = quiz.category_id
                                        INNER JOIN users u ON u.user_id = quiz.added_by 
                                        WHERE quiz.status = 1";
                                $result = $con->query($sql);
                                $count = 1;
                                if ($result &&  $result->num_rows > 0 ) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$count."</td>";
                                        echo "<td class='quiz_title' data-id='".$row['id']."'>".$row['title']."</td>";
                                        echo "<td class='quiz_category' data-id='".$row['id']."' data-categoryid='".$row['category_id']."'>".$row['tittle']."</td>";
                                        echo "<td>".$row['user_fname']." ".$row['user_lname']."<br><small>".$row['created_at']."</small></td>";
                                        echo '<td><i class="glyphicon glyphicon-edit quiz_edit" data-id="'.$row['id'].'"></i> &nbsp;&nbsp;&nbsp; <i class="glyphicon glyphicon-trash icon-danger quiz_delete" style="color: red;" data-id="'.$row['id'].'"></i> </td>';
                                        
                                        echo "</tr>";
                                        $count++;
                                    }
                                }
                                
                            ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    include_once('includes/footer.php');
?>
<script>
    $(document).ready(function(){
        $('#category_id').change(function(){
            // $("#category_idoption:selected" ).text();
            // $("#quiz_table_filter input").val($("#category_id option:selected" ).text());
        });
        
        $('.quiz_delete').click(function(){
            if( confirm( 'Are you sure you want to delete this record?' ) ){
                let id = $(this).data('id');
                window.location.replace(window.location.href+'?id='+id+'&del=yes');
            }
        });
        $('.quiz_edit').click(function(e){
            let quiz_title = $('.quiz_title[data-id="'+$(this).data('id')+'"]').html();
            let category = $('.quiz_category[data-id="'+$(this).data('id')+'"]').data('categoryid');
            $('#quiz_id').val($(this).data('id'));
            $('#title').val(quiz_title);
            $('#category_id').val(category).trigger('change');
            // $('#category_id').trigger('change');
            $("#process_quiz").attr('name', "edit_quiz").html("Edit");
            $("#cancel_edit").removeClass('hidden');
        });
        $("#cancel_edit").click(function(){
            $('#title').val('');
            $('#category_id').val('').trigger('change');
            // $('#category_id').trigger('change');
            $("#process_quiz").attr('name', "add_quiz").html("Add");
            $("#cancel_edit").addClass('hidden');
        });
    });
</script>
