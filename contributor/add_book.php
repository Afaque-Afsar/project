<?php
    require_once('required/session_maintainance.php');
    $page_name = ' | Add Books';
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    require_once('../DB.php');
    if ( isset($_POST['submit']) ) {
        
        $image_path = "";
        $is_insert = true;
        if( isset($_FILES['image']) ) {
            $file = $_FILES['image'];
            if ( stripos( $file['type'], 'image' ) === false ) {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Please Provide Image Only!...";
                $is_insert = false;
            } else {
                if (move_uploaded_file($file['tmp_name'], "../uploads/discussion_images/".$file['name'])){
                    $is_insert = true;
                    $image_path = "/uploads/discussion_images/".$file['name'];
                } else {
                    $is_insert = false;
                }
            }
        }
        if ( $is_insert == true ) {
            $subject = $con->real_escape_string($_POST['subject']);
            $description = $con->real_escape_string($_POST['description']);
            $user_id = $_SESSION['user']['user_id'];
            $sql = "INSERT INTO discussion(subject, discussion, image_path, added_by)
                    VALUES('$subject', '$description', '$image_path', $user_id)";
            $res = $con->query($sql);
            if( $res ){
                $_SESSION['success'] = true;
                $_SESSION['error'] = false;
                $_SESSION['message'] = "Discussion Added Successfully, Please Wait For Approval";
            } else {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Discussion not Added, Please Try Again!...";
            }
        }
        
        // image_path

    }

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
                <form action="logic.php" method="POST" id="book_form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <label>Category</label>
                            <select class="form-control js-example-basic-single" name="category" id="category_select">
                                <option>Select Category</option>
                                <?php
                                 $sql = "SELECT * FROM material_categories WHERE status = 1";
                                 $result = $con->query($sql);
                                 $rows = $result->num_rows;
                                 if ($rows > 0 ) {
                                     while ($row = $result->fetch_assoc()) {
                                        echo "<option value=".$row['id']." data-id='".strtolower($row['tittle'])."'>".$row['tittle']."</option>";
                                         # code...
                                     }
                                 }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="compulsory_optional"  style="display: none;">
                        <div class="col-md-6" style="padding-left: 40px; padding-right: 40px;">
                            <label for="subject">Type</label>
                            <select class="form-control" name="type" id="type_select">
                                <option value="compulsory">Compulsory</option>
                                <option value="optional">Optional</option>
                            </select>
                        </div>
                        <div class="col-md-6" style="padding-left: 40px; padding-right: 40px;">
                            <label for="subject">Subject</label>
                            <select class="form-control" name="type_select_values" id="type_select_values">
                                <option>English Precis & Composition Books</option>
                                <option>Essay Books</option>
                                <option>Pakistan Affairs Books</option>
                                <option>General Science & Ability Books</option>
                                <option>Islamic Studies Books</option>
                                <option>Current Affairs Books</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="listening_reading_section" style="display: none;">
                        <div class="col-md-12" style="padding-left: 40px; padding-right: 40px;">
                            <label for="subject">Type</label>
                            <select class="form-control" name="type" id="type_select_bottom">
                                <option value="listening">Listening</option>
                                <option value="reading">Reading</option>
                                <option value="writing">Writing</option>
                                <option value="speaking">Speaking</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="subject">Book Title</label>
                            <textarea class="form-control" id="book" required="" name="tittle" placeholder="Enter Book Title Here"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="mytextarea">Book Description</label>
                            <textarea id="mytextarea" class="form-control" name="description" placeholder="Enter Book Description Here"></textarea>
                        </div>
                    </div> 
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="image">Book Cover Image</label>
                            <input type="file" id="image" required="" class="form-control" name="image" accept="image/*">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="image">Book PDF</label>
                            <input type="file" id="book_pdf" required="" class="form-control" name="book_pdf" accept="application/pdf">
                        </div>
                    </div>
                    <br>
                    <input type="hidden" name="selected_category" id="selected_category">
                    <div class="row">
                        <div class="col-12 center">
                            <button type="submit" name="add_book" class="align-center btn btn-success">Add</button>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
    </div>
    <?php

    include_once('includes/footer.php');
?>
<script>
    
    var compulsoryBooksCss = [
            'English Precis & Composition Books',
            'Essay Books',
            'Pakistan Affairs Books',
            'General Science & Ability Books',
            'Islamic Studies Books',
            'Current Affairs Books'
        ];
        
    var compulsoryBooksCssSlug = [
            'english-precis-composition-books',
            'essay-books',
            'pakistan-affairs-books',
            'general-science-and-ability-books',
            'islamic-studies-books',
            'current-affairs-books'
        ];
        
    var optionalBooksCss = [
            'GROUP I - Accountancy & Auditing',
            'GROUP I - Economics',
            'GROUP I - Computer Science',
            'GROUP I - Political Science',
            'GROUP I - International Relations',
            'GROUP II - Physics',
            'GROUP II - Chemistry',
            'GROUP II - Applied Mathematics',
            'GROUP II - Pure Mathematics',
            'GROUP II - Statistics',
            'GROUP II - Geology',
            'GROUP III - Business Administration',
            'GROUP III - Public Administration',
            'GROUP III - Governance & Public Policies',
            'GROUP III - Town Planning & Urban-Management',
            'GROUP IV - History of Pakistan & India',
            'GROUP IV - Islamic History & Culture',
            'GROUP IV - British History',
            'GROUP IV - European History',
            'GROUP IV - History of USA',
            'GROUP V - Gender Studies',
            'GROUP V - Environmental Sciences',
            'GROUP V - Agriculture & Forestry',
            'GROUP V - Botany',
            'GROUP V - Zoology',
            'GROUP V - English Literature',
            'GROUP V - Urdu Literature',
            'GROUP VI - Law',
            'GROUP VI - Constitutional Law',
            'GROUP VI - International Law',
            'GROUP VI - Muslim Law & Jurisprudence',
            'GROUP VI - Mercantile Law',
            'GROUP VI - Criminology',
            'GROUP VI - Philosophy',
            'GROUP VII - Journalism & Mass Communication',
            'GROUP VII - Psychology',
            'GROUP VII - Geography',
            'GROUP VII - Sociology',
            'GROUP VII - Anthropology',
            'GROUP VII - Punjabi',
            'GROUP VII - Sindhi',
            'GROUP VII - Pushto',
            'GROUP VII - Balochi',
            'GROUP VII - Persian',
            'GROUP VII - Arabic'
        ];
        
    var optionalBooksCssSlug = [
            'optional-accountancy-auditing',
            'optional-economics',
            'optional-computer-science',
            'optional-political-science',
            'optional-international-relations',
            'optional-physics',
            'optional-chemistry',
            'optional-applied-mathematics',
            'optional-pure-mathematics',
            'optional-statistics',
            'optional-geology',
            'optional-business-administration',
            'optional-public-administration',
            'optional-governance-public-policies',
            'optional-town-planning-urban-management',
            'optional-history-of-pakistan-india',
            'optional-islamic-history-culture',
            'optional-british-history',
            'optional-european-history',
            'optional-history-of-usa',
            'optional-gender-studies',
            'optional-environmental-sciences',
            'optional-agriculture-forestry',
            'optional-botany',
            'optional-zoology',
            'optional-english-literature',
            'optional-urdu-literature',
            'optional-law',
            'optional-constitutional-law',
            'optional-international-law',
            'optional-muslim-law-jurisprudence',
            'optional-mercantile-law',
            'optional-criminology',
            'optional-philosophy',
            'optional-journalism-mass-communication',
            'optional-psychology',
            'optional-geography',
            'optional-sociology',
            'optional-anthropology',
            'optional-punjabi',
            'optional-sindhi',
            'optional-pushto',
            'optional-balochi',
            'optional-persian',
            'optional-arabic'
        ];
        
    function create_dropdown( type_val, values_array, slug_array ){
        var html = '';
        for( var i = 0; i < values_array.length; i++ ){
            html += '<option value="'+type_val+'-'+slug_array[i]+'">'+values_array[i]+'</option>';
        }
        $("#type_select_values").html(html);
    }
    
    function create_dropdown_ielts_tofil( type_val ){
        var html = '';
        html += '<option value="'+type_val+'-listening">Listening</option>';
        html += '<option value="'+type_val+'-reading">Reading</option>';
        html += '<option value="'+type_val+'-writing">Writing</option>';
        html += '<option value="'+type_val+'-speaking">Speaking</option>';
        $("#type_select_bottom").html(html);
    }
    
    $(document).ready(function(){
        $("#category_select").change(function(){
            var selected_cat = $(this).find(":selected").data('id');
            
            $('#compulsory_optional, #listening_reading_section').hide();
            if( selected_cat == 'css' || selected_cat == 'pms' || selected_cat == 'pcs' ){
                $("#selected_category").val(selected_cat);
                $('#compulsory_optional').show();
                $('#type_select').val('compulsory');
                create_dropdown( selected_cat, compulsoryBooksCss, compulsoryBooksCssSlug );
            } else if( selected_cat == 'ielts' || selected_cat == 'tofil' ){
                $("#selected_category").val(selected_cat);
                $('#listening_reading_section').show();
                create_dropdown_ielts_tofil( selected_cat );
            } else {
                $("#selected_category").val('');
                
            }
        });
        
        $("#type_select").change(function(){
            var cat = $("#category_select").find(":selected").data('id');
            // console.log(cat);
            var selected_cat = $(this).val();
            if( selected_cat == 'optional' ){
                create_dropdown( cat, optionalBooksCss, optionalBooksCssSlug );
            } else if( selected_cat == 'compulsory' ){
                create_dropdown( cat, compulsoryBooksCss, compulsoryBooksCssSlug );
            }
        });
    });
</script>

