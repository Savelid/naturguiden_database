<?php

$titel = 'View groups';
include 'res/header.inc.php';
?>

  <?php
	session_start();

	if(isset($_SESSION['alert']) && isset($_SESSION['showalert']) && $_SESSION['showalert'] == 'true') {
		$_SESSION['showalert'] = 'false';
		echo '
		<section class="content hidden-print">
		<div class="alert alert-warning alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		';
		echo $_SESSION['alert'];
		echo '
		</div>
		</section>
		';
	}

	$path = 'admin_view_groups.php';
  ?>

<section class="content">
	<form action= <?php echo htmlspecialchars($path); ?> method="post" class="form-horizontal">

		<div class="row">
			<div class="col-xs-12">

				<h4>Login</h4>

				<div class="form-group col-xs-12">
					<label for="user">Username</label>
					<div>
						<input type="text" class="form-control" name="username" <?= !empty($_SESSION['username']) ? 'value="' . $_SESSION['username'] . '"' : ''; ?> required />
					</div>
				</div>
				<div class="form-group col-xs-12">
					<label for="password">Password</label>
					<div>
						<input type="password" class="form-control" name="password" required />
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">

				<button type="submit" class="btn btn-default">Login</button>

			</div>
		</div>

	</form>
</section>

<?php include 'res/footer.inc.php'; ?>
