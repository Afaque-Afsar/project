<?php
    require_once('required/session_maintainance.php');
require_once('../DB.php');
session_start();
// $page = 1;
// if ( isset($_GET['page']) ) {
//   $page = $_GET['page']; 
// }
// $limit = ( ($page - 1) * 2 );
$category_id = $_POST['category_id'];
$subcategory_id = $_POST['subcategory_id'];
$subject_id = $_POST['subject_id'];

$added_by = $_SESSION['user']['user_id'];

$sql = "SELECT * FROM past_papers WHERE subject_id = ".$subject_id. " AND added_by = ".$added_by." AND status != 2";
$res = $con->query($sql);
if ( $res && $res->num_rows > 0 ) {
  while( $row = $res->fetch_assoc() ){
    ?>
    <div class="row" style="margin: 5px;">
      <div class="col-sm-12">
        <div class="box-inner">
          <div class="box-header well">
            <?php
            if( $row['status'] == 1 ){
              ?>
              <span class="label-success label label-default">Approved</span>
              <?php
            } else {
              ?>
              <span class="label-warning label label-default">Not Approved</span>
              <?php
            }
            ?>
            <a class="btn btn-setting btn-round btn-danger delete" data-id="<?= $row['id']; ?>" href="#"><i class="glyphicon glyphicon-trash"></i></a>
            <div class="box-icon">
              <a href="edit_paper.php?id=<?= $row['id']; ?>" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-edit"></i></a>
              <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
              <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
          </div> 
          <div class="box-content row">
            <div class="col-sm-12">
              <h1 class="mt-2">
                <small>
                  <?= $row['tittle']; ?>
                </small>
              </h1>
              <p><?=$row['description'];?></p>
              <a href="../<?=$row['paper_image'];?>" target="_BLANK"> Past Paper image </a>
              <hr>
              
            </div>
          </div> 
        </div>
      </div>
    </div>
    <?php
  }
} 
else {
  if (($_POST['subject_id'] == 0 || $_POST['subcategory_id'] == 0)) { ?>
      <div class="alert alert-danger alert-dissmissible show" role="alert" style="margin: 18px;">
        <strong>Oopss! </strong>No any material added yet
      </div>
  
  <?php }
  ?>
  <?php
}

?>
