<?php
	function get_title() {
		return 'Contact Us';
	}

	function display_content() {
		global $selected;

		echo '<main class="contact container">
				  <h1 class="heading">' . get_title() . '</h1>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <form method="post" action="">';
						  	  create_dropdown('category_id', 'inquiry_categories');
						echo '<input type="text" class="form-control" name="subject" placeholder="Subject">
							  <textarea class="form-control" name="message" rows="10" placeholder="Message"></textarea>
							  <div class="text-center">
							  	  <input type="submit" class="btn btn-primary" name="inquire" value="Submit">
							  </div>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
