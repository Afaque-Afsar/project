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
              <h2 class="bradcaump-title">Quiz Subject/Quiz Part</h2>
              <nav class="bradcaump-content">
                <a class="breadcrumb_item" href="index.php">Home</a>
                <span class="brd-separetor">/</span>
                <span class="breadcrumb_item active">Quiz Subject/Quiz Part</span>
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
          $quiz_id = $_GET['id'];
          
          $sql = "SELECT qp.id, qp.title, qp.quiz_id, qp.added_by, qp.created_at, u.user_fname, u.user_lname 
                    FROM `quiz_parts` qp 
                    INNER JOIN users u ON u.user_id = qp.added_by
                    WHERE qp.status = 1 AND qp.quiz_id = ".$quiz_id;
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
                        <td><a href="quiz.php?id=<?=$row['id'];?>"><h6><?= $row['title'];?> </h6> </a> </td>
                        <td><?= $row['user_fname']." ". $row['user_lname'];?></td>
                        <td><?= $row['created_at'];?></td>
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
        </div>
      </div>
    </div>
    <?php 
    include 'include/bottom_footer.php'; 
    ?>

  </div>
  <?php include 'include/footer.php';?>

  <script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchTable').DataTable();
    });
    </script>

</body>
</html>