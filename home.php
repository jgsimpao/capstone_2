<?php
	function get_title() {
		return 'Latest Torrents';
	}

	function display_content() {
		echo '<main class="home container">
				  <h1 class="heading">' . get_title() . '</h1>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">';
						  list_items('home');
				echo '</div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
