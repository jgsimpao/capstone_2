<?php
	function get_title() {
		return 'Torrent Details';
	}

	function display_content() {
		if(isset($_GET['idx']) && !isset($_SESSION['torrent'])) {
			$_SESSION['torrent'] = $_SESSION['items'][$_GET['idx']];
		}

		extract($_SESSION['torrent']);

		echo '<main class="torrent container">
				  <h1 class="heading">' . get_title() . '</h1>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">';

					  	  require_once('partials/torrent_details.php');
					echo '<form method="post" action="" class="text-right">
							  <img class="report-icon" src="images/icon/report.png" alt="Report Torrent">
							  <a href="#torrent" data-toggle="collapse">Report Torrent</a>
							  <div id="torrent" class="collapse">
								  <input type="text" class="form-control" name="subject" placeholder="Subject">
								  <textarea class="form-control" name="message" rows="10" placeholder="Message"></textarea>
							  	  <input type="hidden" name="torrent_id" value="' . $torrent_id . '">
							  	  <input type="submit" class="btn btn-primary" name="report_torrent" value="Submit">
							  </div>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
					  	  <h3>Add Comment:</h3>
					  	  <form method="post" action="">
							  <textarea class="form-control" name="message" rows="10" placeholder="Message"></textarea>
							  <input type="hidden" name="torrent_id" value="' . $torrent_id . '">
							  <button type="submit" class="btn btn-primary" name="post_comment">Submit</button>
						  </form>
						  <br><br>
						  <h3>Comments:</h3>';
						  list_items('torrent');
				echo '</div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
