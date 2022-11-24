<?php
require_once('required/session_maintanance.php');
include('../DB.php');

if ( isset($_GET['del_book']) && $_GET['del_book'] == 'yes' && isset($_GET['id']) ) {
    $id = $_GET['id'];
    if($con->query("UPDATE books SET status = 2 WHERE id = $id")){
      $_SESSION['msg'] = "Book DELETED successfully...";
    } else {
      $_SESSION['msg'] = "Book not DELETED, please try again...";
    }
    
    echo "<script>window.location.replace('view_book.php');</script>";
}
include_once('includes/header.php');
include_once('includes/navbar.php');
?>
<style>
    table{
        width: 100%;
    }
</style>
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
            <a href="#">Books</a>
          </li>
        </ul>
      </div>

      <div class="row">
        <div class="box col-md-12">
           <?php include('includes/success_error_message.php');?>

          <div class="box-inner">
            <div class="box-header well" data-original-title="">
              <h2><i class="glyphicon glyphicon-list"></i> Book List</h2>
            </div>
            <div class="box-content">
              
              <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <thead>
                  <tr class="d-flex">
                    <th>Cover</th>
                    <th>Tittle</th>
                    <th>Description</th>
                    <!--<th>Book</th>-->
                    <th>Added By</th>
                    <th>Status</th>
                    <th>Request</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT * FROM books INNER JOIN users 
                  ON books.`added_by` = users.`user_id` WHERE books.status != 2 ORDER BY id DESC";
                  $result = $con->query($sql);
                  if ($result) {
                    while ($rows = $result->fetch_assoc()) {?>
                     <tr class="d-flex">
                      <td><img src="../<?=$rows['cover_image'];?>" style="width: 70px; height: 70px;"></td>
                      <td style="padding-top: 27px;" class="tittle"><a href="../<?=$rows['book_pdf'];?>" target='_blank'><span><?=$rows['tittle'];?></span></a></td>
                      <td style="padding-top: 27px;"><textarea class="form-control" rows="4" readonly style="resize: none;"><?=$rows['description'];?></textarea></td>
                      <!--<td style="padding-top: 27px;"><a href="../<?=$rows['book_pdf'];?>" target='_blank'>Book</a></td>-->
                      <td style="padding-top: 27px;"><?=$rows['user_fname'].' '.$rows['user_lname'];?></td>
                        <?php
                        if ($rows['status'] == 1) {?>
                          <td class="center" style="padding-top: 27px;">
                           <span class="label-success" style="color:white;">Approved</span>
                          </td>
                          <td class="center" style="padding-top: 27px;">
                          <a href="logic.php?book=dis&id=<?=$rows['id']?>"><span class="label-danger label label-default">Disapprove</span></a>
                        </td>
                      <?php  }
                      if ($rows['status'] == 0) {?>
                        <td class="center" style="padding-top: 27px;">
                           <span class="label-danger" style="color:white;">Disapproved</span>
                        </td>
                        <td class="center" style="padding-top: 27px;">
                          <a href="logic.php?book=app&id=<?=$rows['id'];?>"><span class="label-success label label-default">Approve</span></a>
                        </td>
                      <?php }?>
                      <td class="center" style="padding-top: 27px;">
                        <a class="btn btn-info edit-category" href="edit_book.php?id=<?= $rows["id"]; ?>" data-toggle="modal"  data-id='<?= $rows["id"]; ?>' data-tittle="<?=$rows['tittle'];?>">
                          <i class="glyphicon glyphicon-edit icon-white"></i>
                          Edit
                        </a>
                        <a class="btn btn-danger delete" href='view_book.php?del_book=yes&id=<?= $rows["id"]; ?>' data-id='<?= $rows["id"]; ?>'>
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
<?php
include_once 'includes/footer.php';
?>
</body>
</html>
