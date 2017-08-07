<?php
	session_start();
	$bcoder = new \Bhutanio\BEncode\BEncode();
	$msg_arr = [];

	foreach($_POST as $key => $value) {
		if(is_string($value)) {
			$_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
		}
	}

	if(isset($_SESSION['msg_arr'])) {
		$msg_arr = $_SESSION['msg_arr'];
		unset($_SESSION['msg_arr']);
	}

	if(!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['role_id'])) {
		$file_name = basename($_SERVER['SCRIPT_NAME'], '.php');
		if($file_name != 'index' && $file_name != 'registration') {
			$_SESSION['msg_arr'] = get_alert_msg('Please login to access the website');
			header('location: index.php');
		}
	}

	if(isset($_GET['asc'])) {
		$ascend = false;
	}
	else {
		$ascend = true;
	}

	// Login
	if(isset($_POST['login'])) {
		$username = $_POST['username'];
		$password = sha1($_POST['password']);

		$sql = 'SELECT * FROM users WHERE username = "' . $username . '" AND password = "' . $password . '"';
		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				extract($row);
				$_SESSION['user_id'] = $id;
				$_SESSION['username'] = $username;
				$_SESSION['role_id'] = $role_id;

				$_SESSION['msg_arr'] = get_alert_msg('Account successfully logged in', 1);
				header('location: home.php');
			}
		}
		else {
			$msg_arr = get_alert_msg('Invalid username or password');
		}
	}

	// Logout
	if(isset($_GET['logout'])) {
		foreach($_SESSION as $key => $value) {
			if($key != 'msg_arr') {
				unset($_SESSION[$key]);
			}
		}

		$_SESSION['msg_arr'] = get_alert_msg('Account successfully logged out', 1);
		header('location: index.php');
	}

	// Registration
	if(isset($_POST['register'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$conf_password = $_POST['conf_password'];
		$email = $_POST['email'];
		$conf_email = $_POST['conf_email'];

		if(strlen($username) >= 4) {
			if(strlen($password) >= 4) {
				if(strlen($username) <= 8) {
					if($password == $conf_password) {
						if($email == $conf_email) {
							$sql = 'SELECT * FROM users WHERE username = "' . $username . '"';
							$result = mysqli_query($conn, $sql);

							if(mysqli_num_rows($result) == 0) {
								$sql = 'SELECT * FROM users WHERE email = "' . $email . '"';
								$result = mysqli_query($conn, $sql);

								if(mysqli_num_rows($result) == 0) {
									$password = sha1($password);

									$sql = 'INSERT INTO users (username, password, email, role_id) VALUES ("' . $username . '", "' . $password . '", "' . $email . '", 2)';
									mysqli_query($conn, $sql);

									$_SESSION['msg_arr'] = get_alert_msg('Account successfully registered', 1);
									header('location: index.php');
								}
								else
									$msg_arr = get_alert_msg('Email already exists');
							}
							else
								$msg_arr = get_alert_msg('Username already exists');
						}
						else
							$msg_arr = get_alert_msg('Email and Confirm Email do not match');
					}
					else
						$msg_arr = get_alert_msg('Password and Confirm Password do not match');
				}
				else
					$msg_arr = get_alert_msg('Username must be not more than 8 characters long');
			}
			else
				$msg_arr = get_alert_msg('Password must be at least 4 characters long');
		}
		else
			$msg_arr = get_alert_msg('Username must be at least 4 characters long');
	}

	// Change Password
	if(isset($_POST['change_pass'])) {
		$old_password = sha1($_POST['old_password']);
		$new_password = $_POST['new_password'];
		$conf_password = $_POST['conf_password'];

		if(strlen($new_password) >= 4) {
			if($new_password == $conf_password) {
				$sql = 'SELECT * FROM users WHERE id = ' . $_SESSION['user_id'] . ' AND password = "' . $old_password . '"';
				$result = mysqli_query($conn, $sql);

				if(mysqli_num_rows($result) > 0) {
						$new_password = sha1($new_password);

						$sql = 'UPDATE users SET password = "' . $new_password . '" WHERE id = ' . $_SESSION['user_id'];
						mysqli_query($conn, $sql);

						$msg_arr = get_alert_msg('Password successfully changed', 1);
				}
				else
					$msg_arr = get_alert_msg('Old Password is incorrect');
			}
			else
				$msg_arr = get_alert_msg('New Password and Confirm New Password do not match');
		}
		else
			$msg_arr = get_alert_msg('New Password must be at least 4 characters long');
	}

	// Upload Torrent
	if(isset($_POST['upload'])) {
		$category_id = (int)$_POST['category_id'];
		$name = $_POST['name'];
		$description = $_POST['description'];

		$torrent_arr = validate_upload($category_id, $name, $description);

		if(!$torrent_arr['message']) {
			$sql = 'INSERT INTO torrents (name, description, file_count, file_size, source, cover, user_id, torrent_category_id) VALUES ("' . $name . '", "' . $description . '", ' . $torrent_arr['file_count'] . ', ' . $torrent_arr['file_size'] . ', "' . $torrent_arr['torrent'] . '", "' . $torrent_arr['cover'] . '", ' . $_SESSION['user_id'] . ', ' . $category_id . ')';
			mysqli_query($conn, $sql);

			$msg_arr = get_alert_msg('Torrent successfully uploaded', 1);
		}
		else {
			$msg_arr = $torrent_arr;
		}
	}

	// Inquiry
	if(isset($_POST['inquire'])) {
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		$category_id = $_POST['category_id'];

		if($category_id > 0) {
			$msg_arr = validate_message($subject, $message);

			if(!$msg_arr) {
				$id = get_msg_id($subject, $message);

				$sql = 'INSERT INTO inquiries (inquiry_category_id, message_id) VALUES (' . $category_id . ', ' . $id . ')';
				mysqli_query($conn, $sql);

				$msg_arr = get_alert_msg('Inquiry successfully sent', 1);
			}
		}
		else
			$msg_arr = get_alert_msg('No category selected');
	}

	// Report Torrent
	if(isset($_POST['report_torrent'])) {
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		$torrent_id = $_POST['torrent_id'];

		$msg_arr = validate_message($subject, $message);

		if(!$msg_arr) {
			$id = get_msg_id($subject, $message);

			$sql = 'INSERT INTO torrent_reports (torrent_id, message_id) VALUES (' . $torrent_id . ', ' . $id . ')';
			mysqli_query($conn, $sql);

			$msg_arr = get_alert_msg('Torrent report successfully submitted', 1);
		}
	}

	// Post Comment
	if(isset($_POST['post_comment'])) {
		$message = $_POST['message'];
		$torrent_id = $_POST['torrent_id'];

		if(strlen($message) >= 10) {
			$sql = 'INSERT INTO comments (message, user_id, torrent_id) VALUES ("' . $message . '", ' . $_SESSION['user_id'] . ', ' . $torrent_id . ')';
			mysqli_query($conn, $sql);

			$_SESSION['msg_arr'] = get_alert_msg('Comment successfully posted', 1);
		}
		else
			$_SESSION['msg_arr'] = get_alert_msg('Message must be at least 10 characters long');
	}

	// Report Comment
	if(isset($_POST['report_comment'])) {
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		$comment_id = $_POST['comment_id'];

		$msg_arr = validate_message($subject, $message);

		if(!$msg_arr) {
			$id = get_msg_id($subject, $message);

			$sql = 'INSERT INTO comment_reports (comment_id, message_id) VALUES (' . $comment_id . ', ' . $id . ')';
			mysqli_query($conn, $sql);

			$_SESSION['msg_arr'] = get_alert_msg('Comment report successfully submitted', 1);
		}
		else {
			$_SESSION['msg_arr'] = $msg_arr;
		}
	}

	// Send Response
	if(isset($_POST['send_response'])) {
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		$message_id = $_POST['message_id'];

		$msg_arr = validate_message($subject, $message);

		if(!$msg_arr) {
			$sql = 'INSERT INTO messages (subject, message, user_id, message_id) VALUES ("' . $subject . '", "' . $message . '", ' . $_SESSION['user_id'] . ', ' . $message_id . ')';
			mysqli_query($conn, $sql);

			$msg_arr = get_alert_msg('Response successfully sent', 1);
		}
	}

	// Update Item
	if(isset($_POST['update_save'])) {
		$type = $_POST['item_type'];
		$fkey = $_POST['item_id'];

		if($type == 'Torrent') {
			$category_id = $_POST['category_id'];
			$name = $_POST['update_name'];
			$description = $_POST['update_desc'];
			$source = $_POST['update_src'];
			$image = $_POST['update_img'];

			$torrent_arr = validate_upload($category_id, $name, $description, $source, $image);

			if(!$torrent_arr['message']) {
				$sql = 'UPDATE torrents SET name = "' . $name . '", description = "' . $description . '", file_count = ' . $torrent_arr['file_count'] . ', file_size = ' . $torrent_arr['file_size'] . ', source = "' . $torrent_arr['torrent'] . '", cover = "' . $torrent_arr['cover'] . '", torrent_category_id = ' . $category_id . ' WHERE id = ' . $fkey;

				mysqli_query($conn, $sql);

				$msg_arr = get_alert_msg('Item successfully updated', 1);
			}
			else {
				$msg_arr = $torrent_arr;
			}
		}
		elseif($type == 'Comment') {
			$message = $_POST['update_msg'];

			$sql = 'UPDATE comments SET message = "' . $message . '" WHERE id = ' . $fkey;
			mysqli_query($conn, $sql);

			$msg_arr = get_alert_msg('Item successfully updated', 1);
		}
	}

	// Delete Message, Issue, or Item
	if(isset($_POST['delete_ok'])) {
		$id = $_POST['id'];
		$group = $_POST['group'];

		if($group != 'response') {
			$fkey = $_POST['fkey'];
			$source = $_POST['source'];
			$image = $_POST['image'];
			$type = $_POST['type'];

			if($type == 'Torrent') {
				if($group == 'issue') {
					$sql = 'DELETE tr FROM torrent_reports tr WHERE tr.id = ' . $id;
				}
				else {
					$sql = 'DELETE tr, t FROM torrent_reports tr JOIN torrents t ON tr.torrent_id = t.id WHERE t.id = ' . $fkey;
					mysqli_query($conn, $sql);

					unlink($source);
					unlink($image);

					$sql = 'DELETE cr, c FROM comment_reports cr JOIN comments c ON cr.comment_id = c.id WHERE c.torrent_id = ' . $fkey;
				}
			}
			elseif($type == 'Comment') {
				if($group == 'issue') {
					$sql = 'DELETE cr FROM comment_reports cr WHERE cr.id = ' . $id;
				}
				else {
					$sql = 'DELETE cr, c FROM comment_reports cr JOIN comments c ON cr.comment_id = c.id WHERE c.id = ' . $fkey;
				}
			}
			else {
				$sql = 'DELETE i FROM inquiries i WHERE i.id = ' . $id;
			}
		}
		else {
			$sql = 'DELETE FROM messages WHERE id = ' . $id;
		}

		mysqli_query($conn, $sql);
		$_SESSION['msg_arr'] = get_alert_msg('Item successfully deleted', 1);
	}

	// Basic Search
	if(isset($_POST['basic-search'])) {
		header('location: ?search=' . $_POST['basic-bar']);
	}

	// Advanced Search
	if(isset($_POST['advanced-search'])) {
		$filter = '';

		if($_POST['category_id']) {
			$filter .= '&filter=';

			foreach($_POST['category_id'] as $category_id) {
				$filter .= $category_id . ',';
			}

			$filter = rtrim($filter, ',');
		}

		header('location: ?search=' . $_POST['advanced-bar'] . $filter);
	}

	// Get Alert Message
	function get_alert_msg($message, $type = 0) {
		if($type) {
			$message = '<strong>Success!</strong> ' . $message . '.';
		}
		else {
			$message = '<strong>Error!</strong> ' . $message . '.';
		}

		return ['message' => $message, 'type' => $type];
	}

	// Get Self-reference Message ID
	function get_msg_id($subject, $message) {
		global $conn;

		$sql = 'INSERT INTO messages (subject, message, user_id, message_id) VALUES ("' . $subject . '", "' . $message . '", ' . $_SESSION['user_id'] . ', NULL)';
		mysqli_query($conn, $sql);

		$sql = 'SELECT id FROM messages WHERE id > 1 AND message_id IS NULL';
		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				extract($row);

				$sql = 'UPDATE messages SET message_id = ' . $id . ' WHERE id = ' . $id;
				mysqli_query($conn, $sql);
			}
		}

		return $id;
	}

	// Format Date
	function format_date($date) {
		$date = strtotime($date);
		$date = date('d M y, H:i', $date);

		return $date;
	}

	// Format Size
	function format_size($bytes) {
		if($bytes >= 1073741824)
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		elseif($bytes >= 1048576)
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		elseif($bytes >= 1024)
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		elseif($bytes > 1)
			$bytes = $bytes . ' bytes';
		elseif($bytes == 1)
			$bytes = $bytes . ' byte';
		else
			$bytes = '0 bytes';

		return $bytes;
	}

	// Validate Message
	function validate_message($subject, $message) {
		$msg_arr = [];

		if(strlen($subject) >= 5) {
			if(strlen($message) >= 10) {
			}
			else
				$msg_arr = get_alert_msg('Message must be at least 10 characters long');
		}
		else
			$msg_arr = get_alert_msg('Subject must be at least 5 characters long');

		return $msg_arr;
	}

	// Validate Torrent File
	function validate_torrent($torrent) {
		global $bcoder;

		if($bcoder->bdecode_file($torrent) != null) {
			$torrent = $bcoder->bdecode_file($torrent);

			if(isset($torrent['info'])) {
				$torrent = $torrent['info'];

				if((isset($torrent['length']) || isset($torrent['files'])) &&
					isset($torrent['name']) && isset($torrent['piece length']) && isset($torrent['pieces'])) {
					return true;
				}
			}
		}

		return false;
	}

	// Validate Upload
	function validate_upload($category_id, $name, $description, $source = '', $image = '') {
		global $bcoder;

		$msg_arr = [];
		$keep_cover = false;
		$keep_torrent = false;

		if($category_id) {
			if(strlen($name) >= 5) {
				if(strlen($description) >= 10) {
				}
				else
					$msg_arr = get_alert_msg('Torrent description must be at least 10 characters long');
			}
			else
				$msg_arr = get_alert_msg('Torrent name must be at least 5 characters long');
		}
		else
			$msg_arr = get_alert_msg('Please select a category');

		if(!$msg_arr) {
			$cover_tmp = $_FILES['cover']['tmp_name'];
			$torrent_tmp = $_FILES['torrent']['tmp_name'];

			if((!isset($_FILES['cover']) || !is_uploaded_file($cover_tmp)) && $image) {
				$keep_cover = true;
			}

			if((!isset($_FILES['torrent']) || !is_uploaded_file($torrent_tmp)) && $source) {
				$keep_torrent = true;
			}

			// Check if no file has been chosen
			if($keep_cover || (isset($_FILES['cover']) && is_uploaded_file($cover_tmp))) {
				if($keep_torrent || (isset($_FILES['torrent']) && is_uploaded_file($torrent_tmp))) {

					// Check if file is an actual or fake file
					if($keep_cover || getimagesize($cover_tmp)) {
						if($keep_torrent || validate_torrent($torrent_tmp)) {
							$cover = 'torrents/cover/' . basename($_FILES['cover']['name']);
							$torrent = 'torrents/torrent/' . basename($_FILES['torrent']['name']);

							// Check if file already exists
							if($keep_cover || !file_exists($cover)) {
								if($keep_torrent || !file_exists($torrent)) {

									// Check file size
									if($keep_cover || $_FILES['cover']['size'] < 500000) {
										if($keep_torrent || $_FILES['torrent']['size'] < 500000) {
											$cover_type = pathinfo($cover, PATHINFO_EXTENSION);
											$torrent_type = pathinfo($torrent, PATHINFO_EXTENSION);

											// Allow certain file formats
											if($keep_cover || ($cover_type == 'jpg' || $cover_type == 'png' || $cover_type == 'jpeg' || $cover_type == 'gif')) {
												if($keep_torrent || $torrent_type == 'torrent') {
													$image_size = getimagesize($cover_tmp);
													$image_ratio = $image_size[0] / $image_size[1];

													// Check if image meets the required dimensions
													if($keep_cover || $image_size[0] >= 240) {
														if($keep_cover || ($image_ratio >= 0.6 && $image_ratio <= 0.9)) {

															// If everything is ok, try to upload files
															if($keep_cover) {
																$cover = $image;
															}
															else {
																if(file_exists($image)) {
																	unlink($image);
																}

																move_uploaded_file($cover_tmp, $cover);
															}

															if($keep_torrent) {
																$torrent = $source;
															}
															else {
																if(file_exists($source)) {
																	unlink($source);
																}

																move_uploaded_file($torrent_tmp, $torrent);
															}
														}
														else
															$msg_arr = get_alert_msg('Image file must be a portrait with a width:height ratio of 0.6 - 0.9');
													}
													else
														$msg_arr = get_alert_msg('Image file must be at least 240 pixels wide');
												}
												else
													$msg_arr = get_alert_msg('Torrent file: Only TORRENT files are allowed');
											}
											else
												$msg_arr = get_alert_msg('Image file: Only JPG, JPEG, PNG & GIF files are allowed');
										}
										else
											$msg_arr = get_alert_msg('Torrent file is too large');
									}
									else
										$msg_arr = get_alert_msg('Image file is too large');
								}
								else
									$msg_arr = get_alert_msg('Torrent file already exists');
							}
							else
								$msg_arr = get_alert_msg('Image file already exists');
						}
						else
							$msg_arr = get_alert_msg('Torrent file is not a valid torrent');
					}
					else
						$msg_arr = get_alert_msg('Image file is not a valid image');
				}
				else
					$msg_arr = get_alert_msg('No torrent file chosen');
			}
			else
				$msg_arr = get_alert_msg('No image file chosen');
		}

		if(!$msg_arr) {
			$bdecode = $bcoder->bdecode_file($torrent);
			$bdecode = $bdecode['info'];

			if(isset($bdecode['length'])) {
				$file_count = 1;
				$file_size = $bdecode['length'];
			}
			else {
				$file_count = count($bdecode['files']);
				$file_size = 0;

				foreach ($bdecode['files'] as $file) {
					$file_size += $file['length'];
				}
			}

			$torrent_arr['file_count'] = $file_count;
			$torrent_arr['file_size'] = $file_size;
			$torrent_arr['torrent'] = $torrent;
			$torrent_arr['cover'] = $cover;
			$torrent_arr['message'] = '';

			return $torrent_arr;
		}

		return $msg_arr;
	}

	// Create Dropdown
	function create_dropdown($name_attr, $table) {
		global $conn;

		$sql = 'SELECT * FROM ' . $table . ' ORDER BY id ASC';
		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0) {
			echo '<select class="form-control" name="' . $name_attr . '">
					  <option value="0">Select Category</option>';

			while($row = mysqli_fetch_assoc($result)) {
				extract($row);

				echo '<option value="' . $id . '"' . 
					  (isset($_POST['category_id']) && (int)$_POST['category_id'] == $id ? ' selected' : '') . '>' . $name . '</option>';
			}
		}
			echo '</select>';
	}

	// Create Checkboxes
	function create_checkboxes($name_attr, $table) {
		global $conn;

		$sql = 'SELECT * FROM ' . $table . ' ORDER BY id ASC';
		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				extract($row);

				echo '<label class="checkbox-inline">
						  <input type="checkbox" name="' . $name_attr . '[]" value="' . $id . '">' . $name . 
					 '</label>';
			}
		}
	}

	// Get Name based on ID
	function get_name($table, $id) {
		global $conn;

		$sql = 'SELECT * FROM ' . $table . ' WHERE id = ' . $id;
		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				extract($row);

				if($table == 'users') {
					$target_name = $username;
				}
				else {
					$target_name = $name;
				}
			}
		}

		return $target_name;
	}

	// Create Modal Content
	function create_modal_content($array) {
		extract($array);

		echo '<div class="modal-dialog">
				  <div class="modal-content">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">
						  	  <strong>Confirm Delete</strong>
						  </h4>
					  </div>
					  <div class="modal-body">
						  <p></p>
						  <p></p>
					  </div>
					  <div class="modal-footer">
					  	  <input type="hidden" id="' . $group . '_id" value="' . $id . '">';
				if($group != 'response') {
					echo '<input type="hidden" id="' . $group . '_type" value="' . $type . '">
						  <input type="hidden" id="' . $group . '_fkey" value="' . $fkey . '">
						  <input type="hidden" id="' . $group . '_source" value="' . $source . '">
						  <input type="hidden" id="' . $group . '_image" value="' . $image . '">';
				}
					echo '<input type="hidden" id="' . $group . '_group" value="' . $group . '">
						  <button type="button" id="' . $group . '_ok" class="btn btn-danger" data-dismiss="modal" value="' . $group . '">OK</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					  </div>
				  </div>
			  </div>';
	}

	// List Items
	function list_items($file_name) {
		global $conn;

		$items = [];
		$select = $where = $order = '';
		$search = $filter = $torrent = $sort = $issue = '';

		if($file_name == 'home' || $file_name == 'browse') {
			$select = 'SELECT t.id torrent_id, t.name torrent_name, description, file_count, file_size, source, cover, t.date_created torrent_date, u.id user_id, username, tc.id category_id, tc.name category_name FROM torrents t JOIN users u ON t.user_id = u.id JOIN torrent_categories tc ON t.torrent_category_id = tc.id';
		}
		elseif($file_name == 'torrent') {
			$select = 'SELECT c.id comment_id, message, c.date_created comment_date, u.id user_id, username, t.id torrent_id, t.name torrent_name FROM comments c JOIN users u ON c.user_id = u.id JOIN torrents t ON c.torrent_id = t.id';
		}
		elseif($file_name == 'admin') {
			$select = 'SELECT * FROM (
				(SELECT i.id message_id, m.subject message_subj, m.message message_msg, m.date_created message_date, u.id user_id, username, "Inquiry" item_type, null item_id, null item_heading, null item_body, null item_date, ic.id item_category_id, null file_count, null file_size, null item_src, null item_img, null item_user_id FROM inquiries i JOIN messages m ON i.message_id = m.id JOIN users u ON m.user_id = u.id JOIN inquiry_categories ic ON i.inquiry_category_id = ic.id)
				UNION ALL
				(SELECT tr.id, m.subject, m.message, m.date_created, u.id, username, "Torrent", t.id, t.name, t.description, t.date_created, t.torrent_category_id, t.file_count, t.file_size, t.source, t.cover, t.user_id FROM torrent_reports tr JOIN messages m ON tr.message_id = m.id JOIN users u ON m.user_id = u.id JOIN torrents t ON tr.torrent_id = t.id)
				UNION ALL
				(SELECT cr.id, m.subject, m.message, m.date_created, u.id, username, "Comment", c.id, null, c.message, c.date_created, c.torrent_id, null, null, null, null, c.user_id FROM comment_reports cr JOIN messages m ON cr.message_id = m.id JOIN users u ON m.user_id = u.id JOIN comments c ON cr.comment_id = c.id)
				) A';
		}

		if(isset($_GET['search'])) {
			$search = $_GET['search'];
			$where .= 't.name LIKE "%' . $search . '%"';
			$search = '&search=' . $search;
		}

		if(isset($_GET['filter'])) {
			if($where) {
				$where .= ' AND ';
			}
			$filter = $_GET['filter'];
			$where .= 'tc.id IN (' . $filter . ')';
			$filter = '&filter=' . $filter;
		}

		if(isset($_GET['torrent'])) {
			if($where) {
				$where .= ' AND ';
			}
			$torrent = $_GET['torrent'];
			$where .= 't.id =' . $torrent;
			$torrent = '&torrent=' . $torrent;
		}

		if(isset($_GET['issue'])) {
			if($where) {
				$where .= ' AND ';
			}

			$issue = $_GET['issue'];
			$where .= 'item_type = "' . $issue . '"';
			$issue = '&issue=' . $issue;
		}

		if($file_name == 'home' || $file_name == 'browse') {
			$order = ' ORDER BY torrent_date DESC';
		}
		elseif($file_name == 'torrent') {
			$order = ' ORDER BY comment_date DESC';
		}
		elseif($file_name == 'admin') {
			$order = ' ORDER BY message_date DESC';
		}

		if(isset($_GET['asc'])) {
			$sort = $_GET['asc'];
			$order = ' ORDER BY ' . $sort . ' ASC';
			$sort = '&asc=' . $sort;
		}
		else {
			if(isset($_GET['desc'])) {
				$sort = $_GET['desc'];
				$order = ' ORDER BY ' . $sort . ' DESC';
				$sort = '&desc=' . $sort;
			}
		}

		if($where) {
			$where = ' WHERE ' . $where;
		}

		$query_string = $search . $filter . $torrent . $sort . $issue;

		$sql = $select . $where . $order;
		$result = mysqli_query($conn, $sql);

		// var_dump($sql);

		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$items[] = $row;
			}

			if($file_name == 'home') {
				$max_items = 12;
			}
			else {
				$max_items = 6;
			}

			$total_items = count($items);

			if(isset($_GET['page'])) {
				$curr_page = (int)$_GET['page'];
				$idx = ($curr_page - 1) * $max_items;
			}
			else {
				$curr_page = 1;
				$idx = 0;
			}

			echo '<div class="list-group">';

			for($i = $idx; $i < $idx + $max_items && $i < $total_items; $i++) {
				$idx_arr = array_keys($items, $items[$i]);
				extract($items[$i]);

				if($file_name == 'home') {
					unset($_SESSION['torrent']);

					if(strlen($torrent_name) > 25) {
						$torrent_name = substr($torrent_name, 0, 25) . '...';
					}

					echo '<figure>
							  <a href="torrent.php?idx=' . $idx_arr[0] . '&torrent=' . $torrent_id . '">
								  <img src="' . $cover . '" alt="' . $torrent_name . '" width="240" height="320">
							  </a>
							  <figcaption class="text-center">
							  	  <h4>' . $torrent_name . '</h4>
							  	  <p>(' . $category_name . ')</p>
							  </figcaption>
						  </figure>';
				}
				elseif($file_name == 'browse') {
					unset($_SESSION['torrent']);

					if(strlen($torrent_name) > 40) {
						$torrent_name = substr($torrent_name, 0, 40) . '...';
					}
					if(strlen($description) > 80) {
						$description = substr($description, 0, 80) . '...';
					}

					echo '<div class="input-group list-item">
							  <div class="input-group-btn">
								  <a href="?filter=' . $category_id . '" class="btn btn-default ' . strtolower($category_name) . '" data-toggle="tooltip" data-placement="left" title="' . $category_name . '">
									  <img src="images/torrent/' . strtolower($category_name) . '.png" alt="' . $category_name . '">
								  </a>
							  </div>
							  <a href="torrent.php?idx=' . $idx_arr[0] . '&torrent=' . $torrent_id . '" class="list-group-item ';
								  if($i % 2)
								  	  echo 'even-row';
								  else
								  	  echo 'odd-row';
								  echo '">
								  <div class="row">
								  	  <h4 class="list-group-item-heading col-sm-6 item_name">' . $torrent_name . '</h4>
								  	  <h4 class="list-group-item-heading col-xs-4 col-sm-2">' . format_size($file_size) . '</h4>
								  	  <h4 class="list-group-item-heading col-xs-4 col-sm-2">' . $username . '</h4>
								  	  <h4 class="list-group-item-heading col-xs-4 col-sm-2 format_date">' . format_date($torrent_date) . '</h4>
								  	  <p class="list-group-item-text hidden-xs col-sm-12 item_desc">' . $description . '</p>
							  	  </div>
							  </a>
						  </div>
						  <input type="hidden" class="item_date" value="' . $torrent_date . '">';
				}
				elseif($file_name == 'torrent') {
					echo '<span class="list-group-item ';
							  if($i % 2)
							  	  echo 'even-row';
							  else
							  	  echo 'odd-row';
							  echo '">
							  <div class="row">
								  <h4 class="list-group-item-heading col-xs-6">' . $username . '</h4>
								  <h4 class="list-group-item-heading col-xs-6 text-right">' . format_date($comment_date) . '</h4>
							  </div>
							  <hr>
							  <p class="list-group-item-text">' . $message . '</p>
							  <div class="text-right">
							  	  <img class="report-icon" src="images/icon/report.png" alt="Report Comment">
								  <a href="#comment_' . $idx_arr[0] . '" data-toggle="collapse">Report Comment</a>
								  <div id="comment_' . $idx_arr[0] . '" class="collapse">
									  <input type="text" id="subject_' . $idx_arr[0] . '" class="form-control" name="subject" placeholder="Subject">
									  <textarea id="message_' . $idx_arr[0] . '" class="form-control" name="message" rows="10" placeholder="Message"></textarea>
								  	  <input type="hidden" id="comment_id_' . $idx_arr[0] . '" name="comment_id" value="' . $comment_id . '">
								  	  <button type="button" class="btn btn-primary" name="report_comment" value="' . $idx_arr[0] . '">Submit</button>
								  </div>
							  </div>
						  </span>';
				}
				elseif($file_name == 'admin') {
					if($item_type == 'Inquiry') {
						$full_type = $item_type . ': ' . get_name('inquiry_categories', $item_category_id);
					}
					else {
						$full_type = $item_type . ' Report';
					}

					if(strlen($message_subj) > 40) {
						$message_subj = substr($message_subj, 0, 40) . '...';
					}
					if(strlen($message_msg) > 80) {
						$message_msg = substr($message_msg, 0, 80) . '...';
					}

					echo '<div class="input-group">
							  <div class="input-group-btn">
								  <a href="?issue=' . $item_type . '" class="btn btn-default ' . strtolower($item_type) . '">
									  <img src="images/issue/' . strtolower($item_type) . '.png" alt="' . $item_type . '">
								  </a>
							  </div>
							  <a href="issue.php?idx=' . $idx_arr[0] . '" class="list-group-item ';
								  if($i % 2)
								  	  echo 'even-row';
								  else
								  	  echo 'odd-row';
								  echo '">
							  	  <div class="row">
								  	  <h4 class="list-group-item-heading col-sm-6 item_name">' . $message_subj . '</h4>
								  	  <h4 class="list-group-item-heading col-xs-4 col-sm-2">' . $item_type . '</h4>
								  	  <h4 class="list-group-item-heading col-xs-4 col-sm-2">' . $username . '</h4>
								  	  <h4 class="list-group-item-heading col-xs-4 col-sm-2 format_date">' . format_date($message_date) . '</h4>
								  	  <p class="list-group-item-text hidden-xs col-sm-12 item_desc">' . $message_msg . '</p>
							  	  </div>
							  </a>
						  </div>
						  <input type="hidden" class="item_date" value="' . $message_date . '">';
				}
			}

			echo '</div>';

		if($file_name != 'home') {
			echo '<div class="text-center">
					  <ul class="pagination">';
				$pages = ceil($total_items / $max_items);

				if($curr_page > 1) {
					echo '<li><a href="?page=1' . $query_string . '">First</a></li>
						  <li><a href="?page=' . ($curr_page - 1) . $query_string . '">Prev</a></li>';
				}

				for($i = 1; $i <= $pages; $i++) {
					echo '<li';
					if($i == $curr_page) {
						echo ' class="active"';
					}
					echo '><a href="?page=' . $i . $query_string . '">' . $i . '</a></li>';
				}

				if($curr_page < $pages) {
					echo '<li><a href="?page=' . ($curr_page + 1) . $query_string . '">Next</a></li>
						  <li><a href="?page=' . $pages . $query_string . '">Last</a></li>';
				}

				echo '</ul>
				  </div>';
		}

			$_SESSION['items'] = $items;
		}
	}
