<?php
	function get_title() {
		return 'Latest Torrents';
	}

	function display_content() {
		global $ascend;

		echo '<main class="home container">';
			  require_once('partials/alert.php');

			echo '<div class="panel panel-default">
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
						  list_items('home');
				echo '</div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
