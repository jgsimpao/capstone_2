<?php
	if($msg_arr) {
		echo '<div class="alert alert-dismissable fade in ';
			if($msg_arr['type'])
				echo 'alert-success';
			else
				echo 'alert-danger';
			echo '">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' .
				  $msg_arr['message'] . '
			  </div>';
	}
