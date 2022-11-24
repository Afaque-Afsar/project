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
            <a href="#">Material</a>
          </li>
        </ul>
      </div>

      <div class="row">
        <div class="box col-md-12">
          <?php include('includes/success_error_message.php');?>
          <div class="box-inner">
            <div class="box-header well" data-original-title="">
              <h2><i class="glyphicon glyphicon-list"></i> Material List</h2>
            </div>
            <div class="box-content">
              <?php
              if ( isset($_GET['del']) && isset($_GET['id']) ) {
                  $id = $_GET['id'];
                  if($con->query("UPDATE material SET status = 2 WHERE id = $id")){
                      $_SESSION['msg'] = "Material DELETED successfully...";
                  } else {
                      $_SESSION['msg'] = "Material not DELETED, please try again...";
                  }

                  echo "<script>window.location.replace('view_material.php');</script>";
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
                  $sql = "SELECT *, material.`id` AS 'm_id', material.`tittle` AS 'notes', material.`status` AS 'mstatus', mc.`tittle` AS 'category' FROM material INNER JOIN users 
                  ON material.`added_by` = users.`user_id`
                  INNER JOIN material_categories mc ON mc.`id` = material.`category_id` WHERE material.`status` != 2";
                  $result = $con->query($sql);
                  if ($result) {
                    while ($rows = $result->fetch_assoc()) {?>
                     <tr>
                      <td><?=$rows['notes'];?></td>
                      <?php
                        if ($rows['material_format'] == 'text_format') { ?>
                            <td style="width: 300px;"><?=$rows['description'];?></td>
                    <?php  }
                        if ($rows['material_format'] == 'pdf_format') { ?>
                            <td><a href="../<?=$rows['description'];?>" target='_blank'>Notes in PDF</a></td>
                    <?php  } 
                        if ($rows['material_format'] == 'video_format') { ?>
                            <td><a href="../<?=$rows['description'];?>" target='_blank'>Notes in Video</a></td>
                    <?php  } 
                        if($rows['material_format'] == 'link_format'){?>
                           <td><a href="../<?=$rows['description'];?>" target='_blank'>Notes in Video Link</a></td>
                 <?php  } ?>
                      <td><?=$rows['category'];?></td>
                      <td><?=$rows['user_fname'].' '.$rows['user_lname'];?></td>
                        <?php
                        if ($rows['mstatus'] == 1) {?>
                          <td class="center">
                          <span class="label-success label label-default">Approved</span>
                        </td>
                      <?php  }
                      if ($rows['mstatus'] == 0) {?>
                        <td class="center">
                          <span class="label-danger label label-default">Not Approved</span>
                        </td>
                      <?php }?>
                        <?php
                        if ($rows['mstatus'] == 1) {?>
                          <td class="center">
                          <a href="logic.php?material=dis&id=<?=$rows['m_id']?>"><span class="label-danger label label-default">Disapprove</span></a>
                        </td>
                      <?php  }
                      if ($rows['mstatus'] == 0) {?>
                        <td class="center">
                          <a href="logic.php?material=app&id=<?=$rows['m_id'];?>"><span class="label-success label label-default">Approve</span></a>
                        </td>
                      <?php }?>
                      <td class="center">
                        <!-- <a class="btn btn-info edit-category" href="#" data-toggle="modal"  data-id='<?= $rows["m_id"]; ?>' data-tittle="<?=$rows['tittle'];?>">
                          <i class="glyphicon glyphicon-edit icon-white"></i>
                          Edit
                        </a> -->
                        <a class="btn btn-danger delete" href='view_material.php?id=<?=$rows['m_id']?>&del=yes'>
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
