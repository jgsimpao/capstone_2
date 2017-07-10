<?php
	function get_title() {
		return 'Issue';
	}

	function display_content() {
		global $conn;

		if(isset($_GET['idx'])) {
			$_SESSION['issue'] = $_SESSION['items'][$_GET['idx']];
			extract($_SESSION['issue']);
		}

		$id = $message_id;
		$fkey = $category_id;
		$image = $cover;
		$category = $category_name;
		$type = 'issue';

		echo '<main class="issue container">
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <h4>' . $message_subj . '</h4>
						  <p>From: ' . $username . '</p>
						  <p>Date: ' . format_date($message_date) . '</p>
						  <hr>
						  <p>' . $message_msg . '</p>
						  <form method="post" action="">
							  <input type="hidden" name="id" value="' . $id . '">
							  <input type="hidden" name="fkey" value="' . $fkey . '">
							  <input type="hidden" name="source" value="' . $source . '">
							  <input type="hidden" name="image" value="' . $image . '">
							  <input type="hidden" name="category" value="' . $category . '">
							  <input type="hidden" name="type" value="' . $type . '">
							  <button type="submit" class="btn btn-danger" name="delete_ok" value="' . $type . '">Delete</button>
							  <button type="button" id="issue_back" class="btn btn-default">Back</button>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>';

			if($category_name == 'Torrent' || $category_name == 'Comment') {
				$issue_arr['type'] = 'item';

			echo '<div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">';

				if($category_name == 'Torrent') {
					$torrent_name = $item_heading;
					$description = $item_body;
					$torrent_date = $item_date;
					$torrent_categories = [];

					$sql = 'SELECT * FROM torrent_categories ORDER BY id ASC';
					$result = mysqli_query($conn, $sql);

					if(mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							extract($row);
							$torrent_categories[] = $name;
						}

						$category_name = $torrent_categories[$item_category_id - 1];
					}

					echo '<div id="torrent_off">';
							  require_once('partials/torrent_details.php');
					echo '</div>
						  <div id="torrent_on">
						  	  <form method="post" action="" enctype="multipart/form-data">';
								  create_dropdown('category_id', 'torrent_categories');
							echo '<input type="text" id="update_name" class="form-control after-file" name="name" value="' . $torrent_name . '" placeholder="Torrent Name">
								  <textarea id="update_desc" class="form-control" name="description" rows="10" placeholder="Description">' . $description . '</textarea>
								  <div class="after-file"></div>
							  </form>
					  	  </div>';

					    $category_name = $category;
				}

				elseif($category_name == 'Comment') {
					echo '<h4>' . $username . '</h4>
						  <p id="comment_msg">' . $item_body . '</p>
						  <textarea id="update_msg" class="form-control" name="message" rows="10" placeholder="Message">' . $item_body . '</textarea>';
				}
					echo '<div id="update_off">
						  	  <button type="button" id="update_item" class="btn btn-default">Update</button>
						  </div>
						  <div id="update_on">
						  	  <input type="hidden" id="item_id" value="' . $category_id . '">
							  <button type="button" id="update_save" class="btn btn-default" value="' . $category_name . '">Save</button>
						  	  <button type="button" id="update_undo" class="btn btn-default">Undo</button>
						  	  <button type="button" id="update_cancel" class="btn btn-default">Cancel</button>
						  </div>';
				echo '</div>
					  <div class="panel-footer"></div>
				  </div>';
			}

		echo '</main>';
	}

	require_once('template.php');
