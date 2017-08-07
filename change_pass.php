<?php
	function get_title() {
		return 'Change Password';
	}

	function display_content() {
		echo '<main class="change_pass container">
				  <h1 class="heading">' . get_title() . '</h1>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <form method="post" action="">
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/user/password.png" alt="Old Password">
								  </span>
								  <input type="password" class="form-control" name="old_password" placeholder="Old Password">
							  </div>
							  <hr>
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/user/password.png" alt="New Password">
								  </span>
								  <input type="password" class="form-control" name="new_password" placeholder="New Password">
							  </div>
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/user/password.png" alt="Confirm New Password">
								  </span>
								  <input type="password" class="form-control" name="conf_password" placeholder="Confirm New Password">
							  </div>
							  <div>
								  <input type="submit" class="btn btn-primary" name="change_pass" value="Submit">
								  <input type="reset" class="btn btn-default" value="Reset">
							  </div>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
