<?php 
include 'include/head.php';
include 'DB.php';
session_start();
$user_id='';
if (isset($_SESSION['user']['user_id'])) {
	$user_id = $_SESSION['user']['user_id'];
}
?>

<body>
	<div class="wrapper" id="wrapper">
		<?php 
		include 'include/header.php'; 
		?>
		<div class="ht__bradcaump__area bg-image--12">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="bradcaump__inner text-center">
							<h2 class="bradcaump-title">Quiz</h2>
							<nav class="bradcaump-content">
								<a class="breadcrumb_item" href="index.php">Home</a>
								<span class="brd-separetor">/</span>
								<span class="breadcrumb_item active">Quiz</span>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<section class="wn__product__area brown--color pt--80  pb--30" id="section">
			<div class="container">
					<?php include 'include/success_error_message.php';?>
				<?php
					// if ($_SESSION['user']['user_id'] != '') {
			
					// 	$qs = "SELECT * FROM quiz_submit WHERE submit_by = ".$user_id;
					//   	$res = $con->query($qs);
					//   	$rw = $res->fetch_assoc();
					//   	$rws = $res->num_rows;
					//   	if ($rws == 1) {
					  		?>
					  		<!-- 	<div style="text-align: center;">
					  				
					  			<h4 class="bg-warning mx-auto" style="width: 350px; padding: 15px;" >Result Card Of Quiz</h4>
					  			</div>
					  			<br/>
					  			<table class="table table-borderd" >
					  					<thead>
					  						<th>Total Question</th>
					  						<th>Correct</th>
					  						<th>Wrong</th>
					  					</thead>
					  					<tbody>
					  						<tr>
					  							<td><?=$w['correct'] + $rw['wrong'];?></td>
					  							<td><?=$rw['correct'];?></td>
					  							<td><?=$rw['wrong'];?></td>
					  							<td><a href="#" style="color: blue;">View Attempted Quiz Question</a></td>
					  						</tr>
					  					</tbody>
					  			</table> -->
				 <?php	
				// }
					// }
				?>
				<div class="row">

					<?php
					$id = $_GET['id'];
					$i = 1;
					$sql = "SELECT * FROM questions WHERE quiz_part_id = ".$id;
					$result = $con->query($sql);
					$rows = $result->num_rows;
					if ($rows > 0) {?>
						<form action="logic.php" method="POST" style="width: 100%;">
							<input type="hidden" name="quiz_part_id" value="<?=$id;?>">
						<?php
						while ($row = $result->fetch_assoc()) {?>
								<table class="table table-borderless">
									<thead>
										<th class="table-danger text-white" style="background-color: black;">Ques &nbsp; <?=$i;?>  : &nbsp; <?= $row['question'];?></th>
									</thead>
									<tbody>
										<tr class="table-warning">
											<td>&nbsp; &nbsp;<input type="radio" name="option[<?= $row['id'];?>]" value="<?=  $row['optionA']; ?>"> &nbsp; <?=  $row['optionA']; ?></td>
										</tr>
										<tr class="table-warning">
											<td>&nbsp; &nbsp;<input type="radio" name="option[<?= $row['id'];?>]" value="<?=  $row['optionB']; ?>"> &nbsp; <?=  $row['optionB']; ?></td>
										</tr>
										<tr class="table-warning">
											<td>&nbsp; &nbsp;<input type="radio" name="option[<?= $row['id'];?>]" value="<?=  $row['optionC']; ?>"> &nbsp; <?=  $row['optionC']; ?></td>
										</tr>
										<tr class="table-warning">
											<td>&nbsp; &nbsp;<input type="radio" name="option[<?= $row['id'];?>]" value="<?=  $row['optionD']; ?>"> &nbsp; <?=  $row['optionD']; ?></td>
										</tr>
										<tr class="table-info">
											<td><a href="#" class="btn btn-success btn-sm correct-option" value="Show Answer">Show Answer</a></td>
										</tr>
										<tr id="correct_option" style="display:none;">
										    
										    <?php
										        $option = 'option'.$row['answer'];
										        $ans ='';
										        foreach($row as $field => $value){
										         if($field == $option){
										             $ans = $value;
										         }
										            
										        }
										    ?>
										    <td>Correct answer is :  <strong><?=$ans;?></strong>
										        <br>
										        <span><?=$row['description'];?></span>
										    </td>
										</tr>
										<input type="hidden" name="answer[<?=$row['id'];?>]" value="<?= $row['answer'];?>">
									</tbody>
								</table>
					  <?php $i++; } 
					    
        					 if ($_SESSION['user']['user_id'] == '') {?>
        					  		<div>
        							    <h4 class="bg-danger mx-auto text-white" style="width: 400px; padding: 10px;" >Note: Login First To Attemp Quiz !!!!</h4>	  		
        					  		</div>
        				 <?php	}
				 			else{
				 				$qs = "SELECT * FROM quiz_submit WHERE quiz_part_id = $id AND submit_by = ".$_SESSION['user']['user_id'];
				 				$rz = $con->query($qs);
				 				$rw = $rz->num_rows;
				 				$res = $rz->fetch_assoc();
				 			    
				 				if ($rw == 1) {?>
				 					<div class="text-center">
										<a href="#" class="btn btn-danger btn-sm">Quiz Result </a>
								  </div>
				        	<?php	}
				     			else{ ?>
					                <div class="text-center">
							            <input type="submit" name="quiz_submit" class="btn btn-success btn-sm" value="Submit">		  		
					  	            </div>
				 		    <?php	}
					       } ?>
					  </form>
	<?php	}
				else{
						echo "<h2 class='bg-danger text-white mx-auto'>No any Quiz Added !! </h2>";	
					}
					?>
				</div>
			</div>
		</section>

	</div>
<?php include 'include/bottom_footer.php'; ?>

<?php include 'include/footer.php';?>
<script>


$(document).on("click", ".correct-option", function() {
  
  $(this).text($(this).text() == 'Show Answer' ? 'Hide Answer' : 'Show Answer');
  $(this).closest("tr").next().toggle();
  return false;
});
    
</script>
</body>
</html>