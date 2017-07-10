<?php
	function get_title() {
		return 'Torrent';
	}

	function display_content() {
		if(isset($_GET['idx']) && !isset($_SESSION['torrent'])) {
			$_SESSION['torrent'] = $_SESSION['items'][$_GET['idx']];
		}

		extract($_SESSION['torrent']);

		echo '<main class="torrent container">
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">';

					  	  require_once('partials/torrent_details.php');
					echo '<form method="post" action="" class="text-right">
							  <a href="#torrent" data-toggle="collapse">Report</a>
							  <div id="torrent" class="collapse">
								  <input type="text" class="form-control" name="subject" placeholder="Subject">
								  <textarea class="form-control" name="message" rows="10" placeholder="Message"></textarea>
							  	  <input type="hidden" name="torrent_id" value="' . $torrent_id . '">
							  	  <input type="submit" class="btn btn-default" name="report_torrent" value="Submit">
							  </div>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
					  	  <h4>Add Comment</h4>
						  <textarea id="comment_msg" class="form-control" name="comment_msg" rows="10" placeholder="Message"></textarea>
						  <input type="hidden" id="torrent_id" value="' . $torrent_id . '">
						  <button type="button" id="post_comment" class="btn btn-default">Submit</button>
						  <br><br>';
						  list_items('torrent');
				echo '</div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
