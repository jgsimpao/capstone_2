<?php
	function get_title() {
		return 'Login';
	}

	function display_content() {
		echo '<main class="login container">
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <form method="post" action="">
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/user/username.png" alt="Username">
								  </span>
								  <input type="text" class="form-control" name="username" placeholder="Username">
							  </div>
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/user/password.png" alt="Password">
								  </span>
								  <input type="password" class="form-control" name="password" placeholder="Password">
							  </div>
							  <div>
								  <input type="submit" class="btn btn-default" name="login" value="Login">
								  <input type="reset" class="btn btn-default" value="Reset">
							  </div>
							  <div>
								  <a href="registration.php">Register New Account</a>
							  </div>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
