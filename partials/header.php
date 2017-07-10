<header>
	<div></div>
	<div>
		<div class="container">
			<div class="row">
				<div class="col-xs-6 col-sm-3">
					<a href="index.php">
						<img class="brand img-responsive" src="images/logo/brand.png" alt="J-Torrents">
					</a>
				</div>
				<div class="col-xs-6 col-sm-9">
<?php
		  if(isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['role_id'])) {
			  echo '<div class="user">
			  			<img src="images/user/avatar.png" alt="Avatar">
			  			<span>' . $_SESSION['username'] . '</span><br>';
			  if($_SESSION['role_id'] == 1) {
			  	  echo '<a href="admin.php">Admin Inbox</a><br>';
			  }
			  	  echo '<a href="change_pass.php">Change Password</a><br>
			  			<a href="?logout">Logout</a>
			  		</div>';
		  }
?>
				</div>
				<div class="col-sm-9">
					<?php require_once('partials/nav.php'); ?>
				</div>
			</div>
		</div>
	</div>
</header>
