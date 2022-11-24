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
            <a href="#">Paper</a>
          </li>
        </ul>
      </div>

      <div class="row">
        <div class="box col-md-12">
          <?php include('includes/success_error_message.php');?>
          <div class="box-inner">
            <div class="box-header well" data-original-title="">
              <h2><i class="glyphicon glyphicon-list"></i> Paper List</h2>
            </div>
            <div class="box-content">
              <?php
              if ( isset($_GET['del']) && isset($_GET['id']) ) {
                  $id = $_GET['id'];
                  if($con->query("UPDATE past_papers SET status = 2 WHERE id = $id")){
                    echo "<script>alert('Paper DELETED successfully...');</script>";
                  } else {
                    echo "<script>alert('Paper DELETED successfully...');</script>";
                  }

                  echo "<script>window.location.replace('view_paper.php');</script>";
              }

              if ( isset($_GET['paper']) && $_GET['paper'] != '' && isset($_GET['id']) ) {
                  $id = $_GET['id'];
                  if( $_GET['paper'] == 'dis' ){
                      $status = 0;
                  } else {
                      $status = 1;                    
                  }
                  if($con->query("UPDATE past_papers SET status = $status WHERE id = $id")){
                      echo "<script>alert('Paper Updated successfully...');</script>";
                  } else {
                      echo "<script>alert('Paper not Updated, please try again...');</script>";
                  }

                  echo "<script>window.location.replace('view_paper.php');</script>";
              }
              ?>
              <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <thead>
                  <tr>
                    <th>Tittle</th>
                    <th>Decription</th>
                    <th>Subject</th>
                    <th>Subcategory</th>
                    <th>Category</th>
                    <th>Added By</th>
                    <th>Status</th>
                    <th>Request</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT *, pp.`id` AS 'pp_id', pp.`tittle` AS 'pp_tittle', pp.`status` AS 'pp_status', ppc.`tittle` AS 'subcategory', pp.`description` AS 'pp_description', pps.`tittle` AS 'subject', mc.`tittle` AS 'category' FROM past_papers pp
                   INNER JOIN users ON pp.`added_by` = users.`user_id`
                   INNER JOIN past_paper_subjects pps ON pps.`id` = pp.`subject_id` 
                  INNER JOIN past_paper_categories ppc ON ppc.`id` = pps.`subcategory_id`
                  INNER JOIN material_categories mc ON mc.`id` = ppc.`category_id`";
                  $result = $con->query($sql);
                  if ($result) {
                    while ($rows = $result->fetch_assoc()) {?>
                     <tr>
                      <td><a href="../<?=$rows['paper_image'];?>" target="_BLANK"><?=$rows['pp_tittle'];?></a></td> 
                      <td><textarea class="form-control" rows="4"style="resize: none;" readonly=""><?=$rows['pp_description'];?> </textarea></td>
                      <td><?=$rows['subject'];?></td>
                      <td><?=$rows['subcategory'];?></td>
                      <td><?=$rows['category'];?></td>
                      <td><?=$rows['user_fname'].' '.$rows['user_lname'];?></td>
                      <?php
                        if ($rows['pp_status'] == 1) {?>
                          <td class="center">
                          <span class="label-success label label-default">Approved</span>
                        </td>
                      <?php  }
                      if ($rows['pp_status'] == 0) {?>
                        <td class="center">
                          <span class="label-danger label label-default">Not Approved</span>
                        </td>
                      <?php }?>
                        <?php
                        if ($rows['pp_status'] == 1) {?>
                          <td class="center">
                          <a href="view_paper.php?paper=dis&id=<?=$rows['pp_id']?>"><span class="label-danger label label-default">Disapprove</span></a>
                        </td>
                      <?php  }
                      if ($rows['pp_status'] == 0) {?>
                        <td class="center">
                          <a href="view_paper.php?paper=app&id=<?=$rows['pp_id'];?>"><span class="label-success label label-default">Approve</span></a>
                        </td>
                      <?php }?>
                      <td class="center">
                        <a class="btn btn-info edit-category" href="edit_paper.php?id=<?=$rows['pp_id']?>" data-toggle="modal">
                          <i class="glyphicon glyphicon-edit icon-white"></i>
                          Edit
                        </a>
                        <a class="btn btn-danger delete" href='view_paper.php?id=<?=$rows['pp_id']?>&del=yes'>
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
