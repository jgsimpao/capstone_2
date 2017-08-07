<?php
	function get_title() {
		return 'Registration';
	}

	function display_content() {
		echo '<main class="registration container">
				  <h1 class="heading">' . get_title() . '</h1>
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
							  <hr>
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/user/password.png" alt="Password">
								  </span>
								  <input type="password" class="form-control" name="password" placeholder="Password">
							  </div>
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/user/password.png" alt="Confirm Password">
								  </span>
								  <input type="password" class="form-control" name="conf_password" placeholder="Confirm Password">
							  </div>
							  <hr>
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/user/email.png" alt="Email">
								  </span>
								  <input type="email" class="form-control" name="email" placeholder="Email">
							  </div>
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/user/email.png" alt="Confirm Email">
								  </span>
								  <input type="email" class="form-control" name="conf_email" placeholder="Confirm Email">
							  </div>
							  <div>
								  <input type="submit" class="btn btn-primary" name="register" value="Register">
								  <input type="reset" class="btn btn-default" value="Reset">
							  </div>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
