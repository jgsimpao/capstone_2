<?php
	function get_title() {
		return 'Admin Inbox';
	}

	function display_content() {
		global $ascend;

		echo '<main class="admin container">
				  <h1 class="heading">' . get_title() . '</h1>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
					  	  <div class="row list-heading">
					  	  	  <div class="col-xs-3 col-sm-6">
					  	  	  	  <a href="?';
							  	  if($ascend)
							  	  	  echo 'asc=message_subj';
							  	  else
							  	  	  echo 'desc=message_subj';
							  	  echo '">Subject</a>
					  	  	  </div>
					  	  	  <div class="col-xs-3 col-sm-2">
					  	  	  	  <a href="?';
							  	  if($ascend)
							  	  	  echo 'asc=item_type';
							  	  else
							  	  	  echo 'desc=item_type';
							  	  echo '">Issue</a>
					  	  	  </div>
					  	  	  <div class="col-xs-3 col-sm-2">
					  	  	  	  <a href="?';
							  	  if($ascend)
							  	  	  echo 'asc=username';
							  	  else
							  	  	  echo 'desc=username';
							  	  echo '">From</a>
					  	  	  </div>
					  	  	  <div class="col-xs-3 col-sm-2">
					  	  	  	  <a href="?';
							  	  if($ascend)
							  	  	  echo 'asc=message_date';
							  	  else
							  	  	  echo 'desc=message_date';
							  	  echo '">Date</a>
					  	  	  </div>
					  	  </div>';
						  list_items('admin');
				echo '</div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
