<?php
	function get_title() {
		return 'Issue Details';
	}

	function display_content() {
		global $conn;

		if(isset($_GET['idx'])) {
			$_SESSION['issue'] = $_SESSION['items'][$_GET['idx']];
			extract($_SESSION['issue']);
		}

		$issue_arr = [];
		$issue_arr['id'] = $message_id;
		$issue_arr['type'] = $item_type;
		$issue_arr['fkey'] = $item_id;
		$issue_arr['source'] = $item_src;
		$issue_arr['image'] = $item_img;
		$issue_arr['group'] = 'issue';

		echo '<main class="issue container">
				  <h1 class="heading">' . get_title() . '</h1>
				  <h3>Inbox Message:</h3>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <h4>Subject: ' . $message_subj . '</h4>
						  <p>From: ' . $username . '</p>
						  <p>Date: ' . format_date($message_date) . '</p>
						  <hr>
						  <p>' . $message_msg . '</p>
						  <br><br>
						  <div class="text-center">
							  <button type="button" id="admin_back" class="btn btn-default">Back</button>
							  <button type="button" id="delete_issue" class="btn btn-danger" data-toggle="modal" data-target="#delete-issue-modal">Delete</button>
						  </div>';

						  // Delete Issue Modal
					echo '<div id="delete-issue-modal" class="modal fade" role="dialog">';
							  create_modal_content($issue_arr);
					echo '</div>
					  </div>
					  <div class="panel-footer"></div>
				  </div>';

			if($item_type == 'Torrent' || $item_type == 'Comment') {
				$issue_arr['group'] = 'item';
				$username = get_name('users', $item_user_id);

			echo '<br>
				  <h3>Reported ' . $item_type . ':</h3>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">';

				if($item_type == 'Torrent') {
					$torrent_name = $item_heading;
					$description = $item_body;
					$torrent_date = $item_date;
					$source = $item_src;
					$cover = $item_img;
					$category_name = get_name('torrent_categories', $item_category_id);

					echo '<div id="torrent_off">';
							  require_once('partials/torrent_details.php');
					echo '</div>
						  <form method="post" action="admin.php" enctype="multipart/form-data">
						  	  <div id="torrent_on">';
								  create_dropdown('category_id', 'torrent_categories');
							echo '<div class="input-group">
									  <span class="input-group-addon">
									  	  <img src="images/icon/image.png" alt="Image">
									  </span>
									  <div class="upload_file">
										  <input type="file" id="upload_cover" class="form-control" name="cover">
									  </div>
								  </div>
								  <div class="after-file"></div>
								  <div class="form-group">
									  <label class="control-label col-sm-2 text-right">Current Image:</label>
									  <p class="file-name form-control-static col-sm-10">' . basename($item_img) . '</p>
								  </div>
								  <div class="input-group">
									  <span class="input-group-addon">
									  	  <img src="images/icon/torrent.png" alt="Torrent">
									  </span>
									  <div class="upload_file">
									  	  <input type="file" id="upload_torrent" class="form-control" name="torrent">
									  </div>
								  </div>
								  <div class="after-file"></div>
								  <div class="form-group">
									  <label class="control-label col-sm-2 text-right">Current Torrent:</label>
									  <p class="file-name form-control-static col-sm-10">' . basename($item_src) . '</p>
								  </div>
								  <input type="text" id="update_name" class="form-control after-file" name="update_name" value="' . $item_heading . '" placeholder="Torrent Name">
								  <textarea id="update_desc" class="form-control" name="update_desc" rows="10" placeholder="Description">' . $item_body . '</textarea>
								  <input type="hidden" id="update_src" name="update_src" value="' . $item_src . '">
								  <input type="hidden" id="update_img" name="update_img" value="' . $item_img . '">
								  <input type="hidden" id="item_category_id" name="item_category_id" value="' . $item_category_id . '">
					  	  	  </div>';
				}
				elseif($item_type == 'Comment') {
					echo '<div class="row">
							  <h4 class="list-group-item-heading col-xs-6">' . $username . '</h4>
							  <h4 class="list-group-item-heading col-xs-6 text-right">' . format_date($message_date) . '</h4>
						  </div>
						  <hr>
						  <p id="comment_msg">' . $item_body . '</p>
						  <form method="post" action="admin.php" enctype="multipart/form-data">
						  	  <textarea id="update_msg" class="form-control" name="update_msg" rows="10" placeholder="Message">' . $item_body . '</textarea>';
				}
						echo '<br><br>
							  <div class="text-center">
								  <div id="update_off">
									  <button type="button" id="update_item" class="btn btn-primary">Update</button>
								  	  <button type="button" id="delete_item" class="btn btn-danger" data-toggle="modal" data-target="#delete-item-modal">Delete</button>
								  </div>
								  <div id="update_on">
								  	  <input type="hidden" id="item_id" name="item_id" value="' . $item_id . '">
								  	  <input type="hidden" id="item_type" name="item_type" value="' . $item_type . '">
									  <input type="submit" id="update_save" class="btn btn-success" name="update_save" value="Save">
								  	  <button type="button" id="update_undo" class="btn btn-default">Undo</button>
								  	  <button type="button" id="update_cancel" class="btn btn-default">Cancel</button>
								  </div>
							  </div>
						  </form>';

						  // Delete Item Modal
					echo '<div id="delete-item-modal" class="modal fade" role="dialog">';
							  create_modal_content($issue_arr);
					echo '</div>
					  </div>
					  <div class="panel-footer"></div>
				  </div>';
			}

		echo '</main>';
	}

	require_once('template.php');
