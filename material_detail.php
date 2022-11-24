<?php 
include 'include/head.php';
include 'DB.php';    
?>
<style type="text/css">
  #video{
    display: none;
  }
  #linkvideo{
    display: none;
  }
</style>
<body>
  <div class="wrapper" id="wrapper">
    <?php 
    include 'include/header.php'; 
    ?>
    <div class="ht__bradcaump__area bg-image--10">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="bradcaump__inner text-center">
              <h2 class="bradcaump-title">Material Detail</h2>
              <nav class="bradcaump-content">
                <a class="breadcrumb_item" href="index.php">Home</a>
                <span class="brd-separetor">/</span>
                <span class="breadcrumb_item active">Material Detail</span>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-blog-details section-padding--lg bg--white">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-12">
            <?php
            include 'include/success_error_message.php';
            $id = $_GET['id'];
            $sql = "SELECT * , m.`id` AS 'm_id' , m.`tittle` AS 'm_tittle', m.`created_at` AS 'created' FROM material m INNER JOIN material_categories mc ON mc.`id` = m.`category_id` INNER JOIN users ON m.`added_by` = users.`user_id`  WHERE m.`id` = ".$id;
            $result = $con->query($sql);
            $row = $result->fetch_assoc();
            ?>
            <div class="blog-details content">
              <div class="row">
                <div class="col-12  table-responsive">
                  <table class="table">
                    <thead>
                      <th>Tittle</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>Added By</th>
                      <th>Created On</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?=$row['m_tittle'];?></td>
                        <?php
                        if ($row['material_format'] == 'text_format') {
                            $description = strip_tags($row['description']);
                          ?>
                         <td> <textarea class="form-control" rows="6"><?=$description;?></textarea> </td> 
                        <?php }?>
                        <?php  if ($row['material_format'] == 'pdf_format') {?>
                          <td> <a href="<?=$row['description'];?>" target='_blank' style="color:blue;">Description in PDF</a></td>
                        <?php }?>
                        <?php  if ($row['material_format'] == 'video_format') {?>
                            <td> <a href="#video" class="video-show" style="color:blue;">Description in Video</a></td>
                        <?php }?>
                        <?php  if ($row['material_format'] == 'link_format') {?>
                            <td> <a href="#linkvideo" class="link-video" style="color:blue;">Description in Link</a></td>
                        <?php }?>
                        <td><?=$row['tittle'];?></td>
                        <td><?=$row['user_fname']. ' '. $row['user_lname'];?>
                        </td>
                        <td><?=$row['created'];?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div id="video">
                <div class="embed-responsive embed-responsive-16by9">
                  <video class="embed-responsive-item" controls>
                      <source src="<?=$row['description'];?>">
                  </video>
                </div>
              </div>
              <div id="linkvideo">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe src="<?=$row['description'];?>" class="embed-responsive-item" controls>
                  </iframe>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php 
    include 'include/bottom_footer.php'; 
    ?>

  </div>
  <?php include 'include/footer.php';?>
  <script type="text/javascript">
    $(".video-show").click(function(e) {
    var des = $(this).attr("href");
    $(des).show();
});
    $(".link-video").click(function(e) {
    var des = $(this).attr("href");
    $(des).show();
});
  </script>

</body>
</html>