<?php 
include 'include/head.php';
include 'DB.php';
session_start();
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
							<h2 class="bradcaump-title">Past Paper</h2>
							<nav class="bradcaump-content">
								<a class="breadcrumb_item" href="index.php">Home</a>
								<span class="brd-separetor">/</span>
								<span class="breadcrumb_item active">Past Paper</span>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<section class="wn__product__area brown--color pt--80  pb--30" id="section">
			<div class="container">
				<div class="row">

					<?php
					$sql = '';
					$category_id = $_GET['id'];
					if ($category_id != '') {
							$sql = "SELECT * , pc.`created_at` AS 'created' FROM past_paper_categories pc INNER JOIN users ON pc.`added_by` = users.`user_id` WHERE status = 1 AND category_id = ".$category_id;
					}
					if ($category_id == '') {
						$sql = "SELECT * , pc.`created_at` AS 'created' FROM past_paper_categories pc INNER JOIN users ON pc.`added_by` = users.`user_id` WHERE status = 1";
					}
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
												<td> <a href="past_paper_subject.php?id=<?=$row['id'];?>"><h6><?= $row['tittle'];?> </h6> </a> <small><?= mb_strimwidth($row['description'], 0, 70, '...');?></small></td>
												<td><?= $row['user_fname']." ". $row['user_lname'];?></td>
												<td><?= $row['created'];?></td>
											</tr>
						<?php	}		
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
		</section>

	</div>
	 <?php include 'include/bottom_footer.php'; ?>
	<?php include 'include/footer.php';?>
<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchTable').DataTable();
    });
    </script>
</body>
</html>