<header>
	<div></div>
	<div>
		<div class="container">
			<div class="row">
				<div class="col-xs-6 col-sm-3">
					<a href="home.php">
						<img class="brand img-responsive" src="images/logo/brand.png" alt="J-Torrents">
					</a>
				</div>
				<div class="col-xs-6 col-sm-9">
<?php
		  if(isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['role_id'])) {
			  echo '<div class="user">';

		  			if($_SESSION['role_id'] == 1) {
					  	$issue_ctr = 0;

					  	$sql = '(SELECT COUNT(*) issue_count FROM inquiries)
					  	  		  UNION ALL
					  	  		  (SELECT COUNT(*) FROM torrent_reports)
					  	  		  UNION ALL
					  	  		  (SELECT COUNT(*) FROM comment_reports)';
						$result = mysqli_query($conn, $sql);

						if(mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								extract($row);

								$issue_ctr += $issue_count;
							}
						}

						if($issue_ctr)
							echo '<img class="alert" src="images/icon/alert.png" alt="Alert">';
					}

				  echo '<img class="avatar" src="images/user/avatar.png" alt="Avatar">
				  		<div class="dropdown">
							<a href="#" data-toggle="dropdown" role="button">
								<span class="username">' . $_SESSION['username'] . '</span>
							</a>

					  		<ul class="dropdown-menu dropdown-menu-right">';

					  if($_SESSION['role_id'] == 1) {
						  echo '<li>
									<a href="admin.php">
										Admin Inbox ';
							  if($issue_ctr)
								  echo '<span class="badge">' . $issue_ctr . '</span>';

							  echo '</a>
								</li>';
					  }
						  echo '<li>
							  		<a href="change_pass.php">Change Password</a>
							  	</li>
								<li>
									<a href="?logout">Logout</a>
								</li>
							</ul>
						</div>
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
