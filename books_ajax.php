<?php
include 'DB.php';
?>
<div class="container">
	<div class="row">

		<?php
		$category_id = $_POST['category_id'];
		$sql = "SELECT * FROM books WHERE status = 1 AND category_id = ".$category_id;
		$result = $con->query($sql);
		if ($result) {
			while ($row = $result->fetch_assoc()) {?>
				<div class="col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
					<div class="d-flex justify-content-center">
						<a href="<?=$row['book_pdf'];?>" class="text-center" download><img src="<?=$row['cover_image'];?>" alt="book image" class="img-fluid" style="width: 250px;"></a>
					</div>
					<h4 class="text-center mt-2" ><?=$row['tittle'];?></h4>
				</div>
			<?php	}
		}
		?>
	</div>
</div>