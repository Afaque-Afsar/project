<?php
require_once('required/session_maintanance.php');
include_once('includes/header.php');
include_once('includes/navbar.php');
include('../DB.php');
?>
<div class="ch-container">
  <div class="row">
    <div class="col-sm-2 col-lg-2">
      <?php include_once('includes/sidebar.php'); ?>
    </div>    
    <div id="content" class="col-lg-10 col-sm-10">
      <!-- content starts -->
      <div>
        <ul class="breadcrumb">
          <li>
            <a href="dashboard.php">Home</a>
          </li>
          <li>
            <a href="#">Sub-Category</a>
          </li>
        </ul>
      </div>

      <div class="row">
        <div class="box col-md-12">
          <?php include('includes/success_error_message.php');?>
          <div class="box-inner">
            <div class="box-header well" data-original-title="">
              <h2><i class="glyphicon glyphicon-list"></i> Sub-Category List</h2>
            </div>
            <div class="box-content">
              <?php
              if ( isset($_GET['del']) && isset($_GET['id']) ) {
                  $id = $_GET['id'];
                  if($con->query("UPDATE past_paper_categories SET status = 2 WHERE id = $id")){
                    echo "<script>alert('Paper Sub Category DELETED successfully...');</script>";
                  } else {
                    echo "<script>alert('Paper Sub Category DELETED successfully...');</script>";
                  }

                  echo "<script>window.location.replace('view_subcategory.php');</script>";
              }

              if ( isset($_GET['subcat']) && $_GET['subcat'] != '' && isset($_GET['id']) ) {
                  $id = $_GET['id'];
                  if( $_GET['subcat'] == 'dis' ){
                      $status = 0;
                  } else {
                      $status = 1;                    
                  }
                  if($con->query("UPDATE past_paper_categories SET status = $status WHERE id = $id")){
                      echo "<script>alert('Paper Sub Category Updated successfully...');</script>";
                  } else {
                      echo "<script>alert('Paper Sub Category not Updated, please try again...');</script>";
                  }

                  echo "<script>window.location.replace('view_subcategory.php');</script>";
              }

              
              ?>
              <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <thead>
                  <tr>
                    <th>Tittle</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Added By</th>
                    <th>Status</th>
                    <th>Request</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT *, ppc.`id` AS 'ppc_id', ppc.`tittle` AS 'ppc_tittle', ppc.`status` AS 'ppcstatus', mc.`tittle` AS 'category' FROM past_paper_categories ppc INNER JOIN users 
                  ON ppc.`added_by` = users.`user_id`
                  INNER JOIN material_categories mc ON mc.`id` = ppc.`category_id`
                  WHERE ppc.`status` != 2";
                  $result = $con->query($sql);
                  if ($result) {
                    while ($rows = $result->fetch_assoc()) {?>
                     <tr>
                      <td><?=$rows['ppc_tittle'];?></td>
                      <td><textarea class="form-control" rows="4"style="resize: none;" readonly=""><?=$rows['description'];?> </textarea></td>
                      <td><?=$rows['category'];?></td>
                      <td><?=$rows['user_fname'].' '.$rows['user_lname'];?></td>
                      <?php
                        if ($rows['ppcstatus'] == 1) {?>
                          <td class="center">
                          <span class="label-success label label-default">Approved</span>
                        </td>
                      <?php  }
                      if ($rows['ppcstatus'] == 0) {?>
                        <td class="center">
                          <span class="label-danger label label-default">Not Approved</span>
                        </td>
                      <?php }?>
                        <?php
                        if ($rows['ppcstatus'] == 1) {?>
                          <td class="center">
                          <a href="view_subcategory.php?subcat=dis&id=<?=$rows['ppc_id']?>"><span class="label-danger label label-default">Disapprove</span></a>
                        </td>
                      <?php  }
                      if ($rows['ppcstatus'] == 0) {?>
                        <td class="center">
                          <a href="view_subcategory.php?subcat=app&id=<?=$rows['ppc_id'];?>"><span class="label-success label label-default">Approve</span></a>
                        </td>
                      <?php }?>
                      <td class="center">
                        <a class="btn btn-info edit-category" href="edit_subcategory.php?id=<?=$rows['ppc_id']?>" data-toggle="modal"  data-id='<?= $rows["ppc_id"]; ?>' data-tittle="<?=$rows['tittle'];?>">
                          <i class="glyphicon glyphicon-edit icon-white"></i>
                          Edit
                        </a>
                        <a class="btn btn-danger delete" href='view_subcategory.php?id=<?=$rows['ppc_id']?>&del=yes'>
                          <i class="glyphicon glyphicon-trash icon-white"></i>
                          Delete
                        </a>
                      </td>  
                    </tr>
                  <?php }
                }
                ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!--/span-->

    </div><!--/row-->

    <!-- content ends -->
  </div><!--/#content.col-md-0-->
</div><!--/fluid-row-->
 
<?php
include_once 'includes/footer.php';
?>
</body>
</html>
