<?php
    include('required/session_maintanance.php');
require_once('../DB.php');
session_start();
$category_id = $_POST['category_id'];
$sql = "SELECT * FROM material WHERE category_id = ".$category_id. " AND status != 2";
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
              <a href="edit_material.php?id=<?= $row['id']; ?>" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-edit"></i></a>
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
              <hr>
              <?php
                if ($row['material_format'] == 'text_format') {?>
                    <p><?=$row['description'];?></p>
           <?php  } 
                if($row['material_format'] == 'pdf_format'){
                    echo "<a href='../".$row['description']."' target='_BLANK' >PDF Description</a>";
                }
                if($row['material_format'] == 'video_format'){
                    echo "<a href='../".$row['description']."' target='_BLANK' >Video Description</a>";
                }
                if($row['material_format'] == 'link_format'){?>
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe src="<?=$row['description'];?>" class="embed-responsive-item" controls>
                      </iframe>
                    </div>
         <?php  }
                ?>
            </div>
          </div> 
        </div>
      </div>
    </div>
    <?php
  }
} 
else {
  ?>
  <div class="alert alert-danger alert-dissmissible show" role="alert" style="margin: 18px;">
    <strong>Oopss! </strong>No any material added yet
  </div>
  <?php
}

?>
