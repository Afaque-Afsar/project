<?php 
include 'include/head.php';
include 'DB.php';
session_start();
?>

<body>
	<div class="wrapper" id="wrapper">
		<?php 
		include 'include/header.php'; 
		?>
		<div class="ht__bradcaump__area bg-image--11">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="bradcaump__inner text-center">
							<h2 class="bradcaump-title">Books Page</h2>
							<nav class="bradcaump-content">
								<a class="breadcrumb_item" href="index.php">Home</a>
								<span class="brd-separetor">/</span>
								<span class="breadcrumb_item active">Books</span>
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
					$category_id = $_GET['id'];
					$sql = "SELECT * FROM books WHERE status = 1 AND category_id = ".$category_id;
					$result = $con->query($sql);
					$rows = $result->num_rows;
					if ($rows > 0) {
						while ($row = $result->fetch_assoc()) {?>
							<div class="col-lg-4 col-md-4 col-sm-6 col-12 mt-3">
								<div class="d-flex justify-content-center">
									<a href="book_detail.php?id=<?=$row['id'];?>" class="text-center"><img src="<?=$row['cover_image'];?>" alt="book image" class="img-fluid" style="width: 250px;"></a>
								</div>
								<h4 class="text-center mt-2" ><?=$row['tittle'];?></h4>
							</div>
						<?php	}
					}
					else{
						echo "<h2 class='bg-danger text-white mx-auto'>No any Books Added !! </h2>";	
					}
					?>
				</div>
			</div>
		</section>

	</div>
    <?php include 'include/bottom_footer.php'; ?>

	<?php include 'include/footer.php';?>
<!-- 	<script type="text/javascript">
	$(document).ready(function() {
		var category_id = " ";
		$('#category').change(function(){
			category_id = $(this).val();
			$.ajax({
				type: 'POST',
				url: 'books_ajax.php',
				data: {'category_id': category_id},
				cache: false,
				success: function(result){
					$('#section').html(result);
				} 
			});
		});
	});
	</script> -->

</body>
</html>