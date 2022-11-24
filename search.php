<?php
include 'DB.php';
include 'include/head.php';
if (isset($_POST['search'])) {
	$keyword = $_POST['keyword'];
	$sql = "(SELECT id, tittle, category_id, 'Book' as type FROM books WHERE tittle LIKE '%".$keyword."%')
	UNION
	(SELECT id, tittle, category_id, 'Material' as type FROM material WHERE tittle LIKE '%".$keyword."%')
	UNION
	(SELECT id, tittle, added_by, 'Category' as type FROM material_categories WHERE tittle LIKE '%".$keyword."%')
	UNION
	(SELECT id, comment, discussion_id, 'Comment' as type FROM comments WHERE comment LIKE '%".$keyword."%')
	UNION
	(SELECT id, subject, added_by, 'Discuss' as type FROM discussion WHERE subject LIKE '%".$keyword."%')";
	$result = $con->query($sql);
	$arr_search = [];
	if ($result->num_rows > 0) {
    $arr_search = $result->fetch_all(MYSQLI_ASSOC);
  }
	?>
 <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"/>
<style type="text/css">
	input[type="search"] {
		width: 170px;
		height: 30px;
	}
	table thead {
  display:table;
  width: 100%;
  }
  table tbody {
  display:table;
  width: 100%;
  }

</style>
<body>
	<div class="wrapper" id="wrapper">
		<?php 
		include 'include/header.php'; 
		?>

		<br>
		<section class="wn__product__area brown--color pt--80  pb--30" id="section">
			<div class="container">
				<div class="row">
					<div class="table-responsive mx-auto" style="width: 100%;">
						<table class="table table-responsive" id="searchTable" >
							<thead class="thead-dark" style="display: none;">
								<tr>
									<th>Search Result</th>
									<th>Search Type</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($arr_search)) {
                  foreach($arr_search as $row){ ?>
										<tr>
											<td> <?= $row['tittle']; ?></td>
											<td class="text-center"> <?= $row['type']; ?></td>
											<td class="text-center">
											<?php if ($row['type'] == 'Book') {?>
																 <a href="book_detail.php?id=<?=$row['id'];?>" class="btn btn-primary btn-sm text-white">View</a>
											<?php } ?>
											<?php if ($row['type'] == 'Material') {?>
																 <a href="material_detail.php?id=<?=$row['id'];?>" class="btn btn-primary btn-sm text-white">View</a>
											<?php } ?>
											<?php if ($row['type'] == 'Comment') {?>
																 <a href="#" class="btn btn-primary btn-sm text-white">View</a>
											<?php } ?>
											<?php if ($row['type'] == 'Category') {?>
																 <a href="books.php?id=<?=$row['id'];?>" class="btn btn-info btn-sm text-white">Book</a>
																  <a href="material.php?id=<?=$row['id'];?>" class="btn btn-warning btn-sm text-white">Material</a>
											<?php } ?>
											<?php if ($row['type'] == 'Discuss') {?>
																 <a href="discussion-details.php?id=<?=$row['id'];?>" class="btn btn-primary btn-sm text-white">View</a>
											<?php } ?>

											</td>
										</tr>
					<?php		}
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

	<?php include 'include/footer.php';?>
	<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchTable').DataTable();
    });
    </script>

</body>
<?php } ?>