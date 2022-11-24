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
                <form action="logic.php" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <label>Category</label>
                            <select class="form-control" name="category">
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
                        <div class="col-12">
                            <label for="material">Subcategory Tittle</label>  
                            <textarea class="form-control" id="" required="" name="tittle" placeholder="Enter Sub Category Tittle Here"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label for="selection">Subcategory Description</label>
                            <textarea class="form-control" id="" required="" name="description" placeholder="Enter Sub Category Description Here"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12 center">
                            <button type="submit" name="add_subcategory" class="align-center btn btn-success">Add</button>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
    </div>
    <?php

    include_once('includes/footer.php');
?>


