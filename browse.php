<?php
	function get_title() {
		return 'Browse';
	}

	function display_content() {
		global $ascend;

		echo '<main class="browse container">
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <form method="post" action="">
							  <div class="input-group">
								  <input type="text" class="form-control" name="query" placeholder="Search">
								  <div class="input-group-btn basic-search">
									  <button type="submit" class="btn btn-default" name="search">
										  <img src="images/button/search.png" alt="Search">
									  </button>
								  </div>
							  </div>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">';
						  list_items('browse');
				echo '</div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
