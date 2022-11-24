<?php
    require_once('required/session_maintainance.php');
    $page_name = ' | Edit Book';
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    require_once('../DB.php');
    
    if ( isset($_POST['edit_book']) ) {
        // print_r($_POST);die();
        $category_id = $_POST['category'];
        $tittle = $con->real_escape_string($_POST['tittle']);
        $description = $con->real_escape_string($_POST['description']);
        $user_id = $_SESSION['user']['user_id'];
        $id = $_POST['id'];
        $cover_image = "";
    	$book_pdf = "";
    	$slug = "";
        if( isset($_POST['selected_category']) && !empty($_POST['selected_category']) ) {
            if ( in_array( $_POST['selected_category'], [ 'css', 'pms', 'pcs' ] ) ) {
                $slug = $_POST['type_select_values'];
            } else if ( in_array( $_POST['selected_category'], [ 'ielts', 'tofil' ] ) ) {
                $slug = $_POST['type'];
            }
        }
    	$sql = "UPDATE books SET slug = '$slug', tittle = '$tittle', description = '$description', category_id = $category_id ";
        $is_insert = true;
        if( isset($_FILES['image']) && $_FILES['image']['error'] != 4  ) {
            $file = $_FILES['image'];
            if ( isset($_FILES['image']) && stripos( $file['type'], 'image' ) === false ) {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Please Provide Image Only!...";
                $is_insert = false;
                echo "<script>window.location.replace('edit_book.php?id=".$id."');</script>";
            } else if ( isset($_FILES['image'])) {
                $file_name_temp = time()."_cover_".str_replace(" ", "",$file['name']);
                if (move_uploaded_file($file['tmp_name'], "../uploads/books/cover_images/".$file_name_temp)){
                    $is_insert = true;
                    $cover_image = "uploads/books/cover_images/".$file_name_temp;
                    $sql .= ", cover_image = '".$cover_image."'";
                } else {
                    $is_insert = false;
                }
            }
        }
        if( isset($_FILES['book_pdf']) && $_FILES['book_pdf']['error'] != 4    ) {
            $file = $_FILES['book_pdf'];
            // print_r($file);die();
            if ( stripos( $file['type'], 'application/pdf' ) === false ) {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Please Provide Book Format in PDF Only!...";
                $is_insert = false;
                echo "<script>window.location.replace('edit_book.php?id=".$id."');</script>";
            } else {
                $file_name_temp = time()."_book_".str_replace(" ", "",$file['name']);
                if (move_uploaded_file($file['tmp_name'], "../uploads/books/".$file_name_temp)){
                    $is_insert = true;
                    $book_pdf = "uploads/books/".$file_name_temp;
                    $sql .= ", book_pdf = '".$book_pdf."'";
                } else {
                    $is_insert = false;
                }
            }
        }
        if ( $is_insert == true ) {
            $sql .= " WHERE id = $id AND added_by = $user_id ";
            $res = $con->query($sql);
            if( $res ){
                $_SESSION['success'] = true;
                $_SESSION['error'] = false;
                $_SESSION['message'] = "Book Updated Successfully";
                echo "<script>window.location.replace('manage_book.php');</script>";
    
            } else {
                $_SESSION['success'] = false;
                $_SESSION['error'] = true;
                $_SESSION['message'] = "Book Not Updated Please Try Again Later".$sql;
                echo "<script>window.location.replace('edit_book.php?id=".$id."');</script>";
            }
        }
    }

    if ( isset($_GET['id']) ) {
        $id = $_GET['id'];
        
        $user_id = $_SESSION['user']['user_id'];
        $sql = "SELECT * FROM books WHERE id = $id AND added_by = $user_id ";
        $res = $con->query($sql);
        if( $res && $res->num_rows > 0 ){
            $row = $res->fetch_assoc();
            /*echo "<pre>";
            print_r($row);
            die();*/
        } else {
            $_SESSION['success'] = false;
            $_SESSION['error'] = true;
            $_SESSION['message'] = "This book is not related to you!...";
            echo "<script>window.history.back();</script>";
        }
    } else {
        echo "<script>window.history.back();</script>";
    }
    
    
    $compulsoryBooksCss = [
            'english-precis-composition-books' => 'English Precis & Composition Books',
            'essay-books' =>'Essay Books',
            'pakistan-affairs-books' =>'Pakistan Affairs Books',
            'general-science-and-ability-books' =>'General Science & Ability Books',
            'islamic-studies-books' =>'Islamic Studies Books',
            'current-affairs-books' =>'Current Affairs Books'
        ];
    
        
    $optionalBooksCss = [
            'optional-accountancy-auditing' => 'GROUP I - Accountancy & Auditing',
            'optional-economics' => 'GROUP I - Economics',
            'optional-computer-science' => 'GROUP I - Computer Science',
            'optional-political-science' => 'GROUP I - Political Science',
            'optional-international-relations' => 'GROUP I - International Relations',
            'optional-physics' => 'GROUP II - Physics',
            'optional-chemistry' => 'GROUP II - Chemistry',
            'optional-applied-mathematics' => 'GROUP II - Applied Mathematics',
            'optional-pure-mathematics' => 'GROUP II - Pure Mathematics',
            'optional-statistics' => 'GROUP II - Statistics',
            'optional-geology' => 'GROUP II - Geology',
            'optional-business-administration' => 'GROUP III - Business Administration',
            'optional-public-administration' => 'GROUP III - Public Administration',
            'optional-governance-public-policies' => 'GROUP III - Governance & Public Policies',
            'optional-town-planning-urban-management' => 'GROUP III - Town Planning & Urban-Management',
            'optional-history-of-pakistan-india' => 'GROUP IV - History of Pakistan & India',
            'optional-islamic-history-culture' => 'GROUP IV - Islamic History & Culture',
            'optional-british-history' => 'GROUP IV - British History',
            'optional-european-history' => 'GROUP IV - European History',
            'optional-history-of-usa' => 'GROUP IV - History of USA',
            'optional-gender-studies' => 'GROUP V - Gender Studies',
            'optional-environmental-sciences' => 'GROUP V - Environmental Sciences',
            'optional-agriculture-forestry' => 'GROUP V - Agriculture & Forestry',
            'optional-botany' => 'GROUP V - Botany',
            'optional-zoology' => 'GROUP V - Zoology',
            'optional-english-literature' => 'GROUP V - English Literature',
            'optional-urdu-literature' => 'GROUP V - Urdu Literature',
            'optional-law' => 'GROUP VI - Law',
            'optional-constitutional-law' => 'GROUP VI - Constitutional Law',
            'optional-international-law' => 'GROUP VI - International Law',
            'optional-muslim-law-jurisprudence' => 'GROUP VI - Muslim Law & Jurisprudence',
            'optional-mercantile-law' => 'GROUP VI - Mercantile Law',
            'optional-criminology' => 'GROUP VI - Criminology',
            'optional-philosophy' => 'GROUP VI - Philosophy',
            'optional-journalism-mass-communication' => 'GROUP VII - Journalism & Mass Communication',
            'optional-psychology' => 'GROUP VII - Psychology',
            'optional-geography' => 'GROUP VII - Geography',
            'optional-sociology' => 'GROUP VII - Sociology',
            'optional-anthropology' => 'GROUP VII - Anthropology',
            'optional-punjabi' => 'GROUP VII - Punjabi',
            'optional-sindhi' => 'GROUP VII - Sindhi',
            'optional-pushto' => 'GROUP VII - Pushto',
            'optional-balochi' => 'GROUP VII - Balochi',
            'optional-persian' => 'GROUP VII - Persian',
            'optional-arabic' => 'GROUP VII - Arabic'
        ];

    ?>
    <style type="text/css">
        .tox-statusbar__text-container{
            display: none !important;
        }
    </style>
    <script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
          tinymce.init({
            selector: '#mytextarea'
          });
    </script>
    <div class="ch-container">
        <div class="row">
            <!-- left menu starts -->
            <div class="col-sm-2 col-lg-2">
                <?php include_once('includes/sidebar.php'); ?>
            </div>
            <div id="content" class="col-lg-10 col-sm-10">
                <?php include '../include/success_error_message.php'?>
                <a class="btn btn-sm btn-warning" href="manage_book.php" > Back</a><br><br>
                <form action="" method="POST" id="book_form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $_GET['id']; ?>" >
                    <div class="row">
                        <div class="col-12">
                            <label>Category</label>
                            <select class="form-control js-example-basic-single" name="category" id="category_select">
                                <option>Select Category</option>
                                <?php
                                 $sql = "SELECT * FROM material_categories WHERE status = 1";
                                 $result = $con->query($sql);
                                 $rows = $result->num_rows;
                                 $selected_cat = '';
                                 if ($rows > 0 ) {
                                     while ($category = $result->fetch_assoc()) {
                                         $selected = '';
                                         if( $category['id'] == $row['category_id'] ){
                                             $selected = 'selected';
                                             $selected_cat = strtolower($category['tittle']);
                                         }
                                         ?>
                                         <option value="<?= $category['id']; ?>"  data-id='<?=strtolower($category['tittle']);?>' <?= ($category['id'] == $row['category_id'])?'selected':'';?>><?= $category['tittle']?></option>
                                         <?php
                                     }
                                 }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <?php
                        if( $selected_cat != '' && ($selected_cat == 'css' || $selected_cat == 'pms' || $selected_cat == 'pcs') ){
                            $display = '';
                        } else {
                            $display = 'none';
                        }
                    ?>
                    <div class="row" id="compulsory_optional"  style="display: <?= $display; ?>;">
                        <div class="col-md-6" style="padding-left: 40px; padding-right: 40px;">
                            <label for="subject">Type</label>
                            <select class="form-control" name="type" id="type_select">
                                <option value="compulsory">Compulsory</option>
                                <option value="optional" <?= ( isset( $optionalBooksCss[str_replace($selected_cat."-","",$row['slug'])] ) )?'selected':''; ?> >Optional</option>
                            </select>
                        </div>
                        <div class="col-md-6" style="padding-left: 40px; padding-right: 40px;">
                            <label for="subject">Subject</label>
                            <select class="form-control" name="type_select_values" id="type_select_values">
                            <?php
                                $slug = $row['slug'];
                                $slug_th = substr($slug, 4);
                                if( isset( $compulsoryBooksCss[$slug_th] ) ){
                                    foreach( $compulsoryBooksCss as $key => $value ){
                                        $slected = '';
                                        if( $key == $slug_th ){
                                            $slected = 'selected';
                                        }
                                    ?>
                                        <option value='<?= $selected_cat.'-'.$key; ?>' <?=$slected;?> ><?= $value; ?></option>
                                    <?php
                                    }
                                } else if( isset( $optionalBooksCss[$slug_th] ) ){
                                    foreach( $optionalBooksCss as $key => $value ){
                                        $slected = '';
                                        if( $key == $slug_th ){
                                            $slected = 'selected';
                                        }
                                    ?>
                                        <option value='<?= $selected_cat.'-'.$key; ?>' <?=$slected;?> ><?= $value; ?></option>
                                    <?php
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <?php
                        if( $selected_cat != '' && ( $selected_cat == 'ielts' || $selected_cat == 'tofil' ) ){
                            $display = '';
                            $slug = $row['slug'];
                            $slug_th = substr($slug, 6);
                        } else {
                            $display = 'none';
                        }
                    ?>
                    <div class="row" id="listening_reading_section" style="display: <?= $display; ?>;">
                        <div class="col-md-12" style="padding-left: 40px; padding-right: 40px;">
                            <label for="subject">Type</label>
                            <select class="form-control" name="type" id="type_select_bottom">
                                <option value="<?= $selected_cat; ?>-listening" <?= ($slug_th == 'listening')?'selected':''; ?> >Listening</option>
                                <option value="<?= $selected_cat; ?>-reading" <?= ($slug_th == 'reading')?'selected':''; ?> >Reading</option>
                                <option value="<?= $selected_cat; ?>-writing" <?= ($slug_th == 'writing')?'selected':''; ?> >Writing</option>
                                <option value="<?= $selected_cat; ?>-speaking" <?= ($slug_th == 'speaking')?'selected':''; ?> >Speaking</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="subject">Book Title</label>
                            <textarea class="form-control" id="book" required="" name="tittle" placeholder="Enter Book Title Here"><?= $row['tittle']; ?></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="mytextarea">Book Description</label>
                            <textarea id="mytextarea" class="form-control" name="description" placeholder="Enter Book Description Here"><?= $row['description']; ?></textarea>
                        </div>
                    </div> 
                    <br>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <?php
                                if( isset($row['cover_image']) && !empty($row['cover_image']) && $row['cover_image'] != '' ){
                                    echo '<img src="../'.$row['cover_image'].'" style="width: 200px; height: 200px;">';
                                }
                            ?>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <label for="image">Upload NewBook Cover Image</label>
                            <input type="file" id="image"  name="image" accept="image/*">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <?php
                                if( isset($row['book_pdf']) && !empty($row['book_pdf']) && $row['book_pdf'] != '' ){
                                    echo '<a href="../'.$row['book_pdf'].'" target="_blank">'.substr(str_replace('uploads/books/', '', $row['book_pdf']), strpos($row['book_pdf'], "_")+1).'</a>';
                                }
                            ?>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <label for="image">Upload NewBook PDF</label>
                            <input type="file" id="book_pdf" class="form-control" name="book_pdf" accept="application/pdf">
                        </div>
                    </div>
                    <br>
                    <input type="hidden" name="selected_category" id="selected_category" value="<?= $selected_cat; ?>">
                    <div class="row">
                        <div class="col-12 center">
                            <button type="submit" name="edit_book" class="align-center btn btn-success">Edit</button>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
        <div class="row"></div>
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

