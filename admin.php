<?php
	function get_title() {
		return 'Admin';
	}

	function display_content() {
		global $ascend;

		// if(isset($_GET['idx'])) {
		// 	$_SESSION['inquiry_report'] = $_SESSION['items'][$_GET['idx']];
		// }

		// extract($_SESSION['inquiry_report']);

		echo '<main class="admin container">
				  <div class="panel panel-default">
					  <div class="panel-heading">
					  	  <a href="';
					  	  if($ascend)
					  	  	  echo '?ascend=subject';
					  	  else
					  	  	  echo '?descend=subject';
					  	  echo '">Subject</a>
					  	  <a href="';
					  	  if($ascend)
					  	  	  echo '?ascend=date_created';
					  	  else
					  	  	  echo '?descend=date_created';
					  	  echo '">Date Created</a>
					  </div>
					  <div class="panel-body">';
						  list_items('admin');
				echo '</div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
