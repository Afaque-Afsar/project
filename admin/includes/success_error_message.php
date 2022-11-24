<?php 
	error_reporting(0);
	session_start();

	if (isset($_SESSION['success']) && $_SESSION['success']){?>
		<div class="alert alert-success alert-dissmissible show" role="alert">
			<strong>SUCCESS !</strong><?php echo $_SESSION['message']; ?>
			<button type="button" class="close" data-dismiss="alert" aria-label='Close'>
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?php
		$_SESSION['success'] = false;
	}elseif (isset($_SESSION['error'])&& $_SESSION['error']){?>

		<div class="alert alert-danger alert-dissmissible show" role="alert">
			<strong>ERROR! </strong><?php echo $_SESSION['message']; ?>
			<button type="button" class="close" data-dismiss="alert" aria-label='Close'>
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?php
			$_SESSION['error'] = false;
	}
?>
