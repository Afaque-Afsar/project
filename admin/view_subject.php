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
            <a href="#">Subject</a>
          </li>
        </ul>
      </div>

      <div class="row">
        <div class="box col-md-12">
          <?php include('includes/success_error_message.php');?>
          <div class="box-inner">
            <div class="box-header well" data-original-title="">
              <h2><i class="glyphicon glyphicon-list"></i> Subject List</h2>
            </div>
            <div class="box-content">
              <?php
              if ( isset($_GET['del']) && isset($_GET['id']) ) {
                  $id = $_GET['id'];
                  if($con->query("UPDATE past_paper_subjects SET status = 2 WHERE id = $id")){
                    echo "<script>alert('Paper Subject DELETED successfully...');</script>";
                  } else {
                    echo "<script>alert('Paper Subject DELETED successfully...');</script>";
                  }

                  echo "<script>window.location.replace('view_subject.php');</script>";
              }

              if ( isset($_GET['subject']) && $_GET['subject'] != '' && isset($_GET['id']) ) {
                  $id = $_GET['id'];
                  if( $_GET['subject'] == 'dis' ){
                      $status = 0;
                  } else {
                      $status = 1;                    
                  }
                  if($con->query("UPDATE past_paper_subjects SET status = $status WHERE id = $id")){
                      echo "<script>alert('Paper Subject Updated successfully...');</script>";
                  } else {
                      echo "<script>alert('Paper Subject not Updated, please try again...');</script>";
                  }

                  echo "<script>window.location.replace('view_subject.php');</script>";
              }
              ?>
              <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <thead>
                  <tr>
                    <th>Tittle</th>
                    <th>Description</th>
                    <th>Subcategory</th>
                    <th>Added By</th>
                    <th>Status</th>
                    <th>Request</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT *, pps.`id` AS 'pps_id', pps.`tittle` AS 'pps_tittle', pps.`status` AS 'ppsstatus', ppc.`tittle` AS 'subcategory', pps.`description` AS 'pps_description' FROM past_paper_subjects pps INNER JOIN users 
                  ON pps.`added_by` = users.`user_id`
                  INNER JOIN past_paper_categories ppc ON ppc.`id` = pps.`subcategory_id`
                  WHERE pps.`status` != 2 ";
                  $result = $con->query($sql);
                  if ($result) {
                    while ($rows = $result->fetch_assoc()) {?>
                     <tr>
                      <td><?=$rows['pps_tittle'];?></td>
                      <td><textarea class="form-control" rows="4"style="resize: none;" readonly=""><?=$rows['pps_description'];?> </textarea></td>
                      <td><?=$rows['subcategory'];?></td>
                      <td><?=$rows['user_fname'].' '.$rows['user_lname'];?></td>
                      <?php
                        if ($rows['ppsstatus'] == 1) {?>
                          <td class="center">
                          <span class="label-success label label-default">Approved</span>
                        </td>
                      <?php  }
                      if ($rows['ppsstatus'] == 0) {?>
                        <td class="center">
                          <span class="label-danger label label-default">Not Approved</span>
                        </td>
                      <?php }?>
                        <?php
                        if ($rows['ppsstatus'] == 1) {?>
                          <td class="center">
                          <a href="view_subject.php?subject=dis&id=<?=$rows['pps_id']?>"><span class="label-danger label label-default">Disapprove</span></a>
                        </td>
                      <?php  }
                      if ($rows['ppsstatus'] == 0) {?>
                        <td class="center">
                          <a href="view_subject.php?subject=app&id=<?=$rows['pps_id'];?>"><span class="label-success label label-default">Approve</span></a>
                        </td>
                      <?php }?>
                      <td class="center">
                        <a class="btn btn-info edit-category" href="edit_subject.php?id=<?=$rows['pps_id']?>" data-toggle="modal">
                          <i class="glyphicon glyphicon-edit icon-white"></i>
                          Edit
                        </a>
                        <a class="btn btn-danger delete" href='view_subject.php?id=<?=$rows['pps_id']?>&del=yes'>
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
