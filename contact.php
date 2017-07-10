<?php
	function get_title() {
		return 'Contact';
	}

	function display_content() {
		global $selected;

		echo '<main class="contact container">
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <form method="post" action="">';
						  	  create_dropdown('category_id', 'inquiry_categories');
						echo '<input type="text" class="form-control" name="subject" placeholder="Subject">
							  <textarea class="form-control" name="message" rows="10" placeholder="Message"></textarea>
							  <input type="submit" class="btn btn-default" name="inquire" value="Submit">
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
