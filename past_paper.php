<?php 
include 'include/head.php';
include 'DB.php';    
?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
<style type="text/css">
  input[type="search"] {
    width: 170px;
    height: 30px;
  }
  .comment-scroll {
height:430px;
overflow-y:scroll;

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
              <h2 class="bradcaump-title">Past Paper Subject</h2>
              <nav class="bradcaump-content">
                <a class="breadcrumb_item" href="index.php">Home</a>
                <span class="brd-separetor">/</span>
                <span class="breadcrumb_item active">Past Paper Subject</span>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="page-blog-details section-padding--lg bg--white">
      <div class="container">
        <div class="row">
          <?php
          $subject_id = $_GET['id'];
          
          $sql = "SELECT *, pp.`status` AS 'pp_status', pp.`created_at` AS 'created'  FROM past_papers pp INNER JOIN users ON pp.`added_by` = users.`user_id` WHERE pp.`status` = 1 AND subject_id = ".$subject_id;
          $result = $con->query($sql);
          $arr_search = [];
          if ($result->num_rows > 0) {
            $arr_search = $result->fetch_all(MYSQLI_ASSOC);
          }
          ?>
          <div class="table-responsive mx-auto" style="width: 100%;">
            <table class="table table-hover" id="searchTable">
              <thead class="thead-dark">
                <tr>
                  <th>Tittle</th>
                  <th>Added By</th>
                  <th>Uploaded</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if (!empty($arr_search)) {
                  foreach($arr_search as $row){ ?>
                    
                      <tr>
                        <td><a href="past_paper_detail.php?id=<?=$row['id'];?>"><h6><?= $row['tittle'];?> </h6>  </a><small><?= mb_strimwidth($row['description'], 0, 70, '...');?></small></td>
                        <td><?= $row['user_fname']." ". $row['user_lname'];?></td>
                        <td><?= $row['created'];?></td>
                      </tr>
            <?php }   
                }
                else{
                  echo "<tr>";
                  echo "<td> <h2 class='bg-danger text-white mx-auto'>No any result Found !! </h2> </h2>";
                  echo "</tr>";
                }
              ?>
            </tbody>
            </table>
          </div>
        </div> <br>
        <?php
          include 'include/success_error_message.php';
        ?>
      </div>



    </div>
    <?php 
    include 'include/bottom_footer.php'; 
    
//     function humanTiming ($time)
// {
    
//     $time = time() - $time; // to get the time since that moment
//     $time = ($time<1)? 1 : $time;
//     $tokens = array (
//         31536000 => 'year',
//         2592000 => 'month',
//         604800 => 'week',
//         86400 => 'day',
//         3600 => 'hour',
//         60 => 'minute',
//         1 => 'second'
//     );

//     foreach ($tokens as $unit => $text) {
//         if ($time < $unit) continue;
//         $numberOfUnits = floor($time / $unit);
//         echo $numberOfUnits;
//         return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
//     }

// }  

?>


  </div>
  <?php include 'include/footer.php';?>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.3/jquery.timeago.js"></script>

  <script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchTable').DataTable();
    });
    </script>

    <script type="text/javascript">
     jQuery(document).ready(function() {
     $(".timeago").timeago();
     });
</script>

</body>
</html>