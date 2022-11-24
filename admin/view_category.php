<?php
require_once('required/session_maintanance.php');
include_once('includes/header.php');
include_once('includes/navbar.php');
include('../DB.php');
if ( isset($_GET['del']) && isset($_GET['id']) ) {
    $id = $_GET['id'];
    if($con->query("UPDATE material_categories SET status = 2 WHERE id = $id")){
        $_SESSION['msg'] = "Category DELETED successfully...";
    } else {
        $_SESSION['msg'] = "Category not DELETED, please try again...";
    }

    echo "<script>window.location.replace('view_category.php');</script>";
}
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
            <a href="#">Categories</a>
          </li>
        </ul>
      </div>

      <div class="row">
        <div class="box col-md-12">
          <div class="box-inner">
            <div class="box-header well" data-original-title="">
              <h2><i class="glyphicon glyphicon-list"></i> Category List</h2>
            </div>
            <div class="box-content">
              <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <thead>
                  <tr>
                    <th>Tittle</th>
                    <th>Added By</th>
                    <th>Created On </th>
                    <th>Status</th>
                    <th>Actions</th>
                    <!-- <th>Delete</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM material_categories INNER JOIN users 
                  ON material_categories.`added_by` = users.`user_id` AND status != 2";
                  $result = $con->query($sql);
                  if ($result) {
                    while ($rows = $result->fetch_assoc()) {?>
                     <tr>
                      <td><?=$rows['tittle'];?></td>
                      <td><?=$rows['user_fname'].' '.$rows['user_lname'];?></td>
                      <td class="center"><?=$rows['created_at'];?></td>
                      <?php
                      if ($rows['status'] == 1) {?>
                        <td class="center">
                          <span class="label-success label label-default">Active</span>
                        </td>
                      <?php }
                      else{?> 
                        <td class="center">
                          <span class="label-warning label label-default">Pending</span>
                        </td>
                      <?php } ?>
                      <td class="center">
                        <a class="btn btn-info edit-category" href="#edit_category" data-toggle="modal"  data-id='<?= $rows["id"]; ?>' data-tittle="<?=$rows['tittle'];?>">
                           <!-- <i class="glyphicon glyphicon-edit icon-white"></i>  -->
                          Edit
                        </a>
                        <a class="btn btn-danger delete" href='view_category.php?id=<?=$rows['id']?>&del=yes' data-id='<?= $rows["id"]; ?>'>
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

<hr>
<div id="edit_category" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Category</h4>
      </div>
      <form action="logic.php" method="POST">  
        <div class="modal-body">
           <input class='form-control' type="hidden" id="id" name="id">
           <table>
            <tr>
              <td>Tittle</td>
              <td>
                <input class='form-control' type="text" name="tittle" id="tittle">
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
          <input type="submit" name="edit_category" class="btn btn-primary" value="Save Changes">
        </div>
      </form>
  </div>
</div>
</div>
 
 <script type="text/javascript">
    $(document).on("click", ".edit-category", function () {
      var id = $(this).data('id');
      var tittle = $(this).data('tittle');
      $(".modal-body input[name='id']").val(id);
      $(".modal-body #tittle").val(tittle);
    });
 </script>
<?php
include_once 'includes/footer.php';
?>
</body>
</html>
