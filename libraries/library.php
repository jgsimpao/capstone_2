<?php
	session_start();
	$bcoder = new \Bhutanio\BEncode\BEncode();
	$msg_arr = [];

	foreach($_POST as $key => $value) {
		$_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
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

	if(isset($_GET['ascend'])) {
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
		// session_unset();
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

		if(strlen($username) >= 5) {
			if(strlen($password) >= 5) {
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
				$msg_arr = get_alert_msg('Password must be at least 5 characters long');
		}
		else
			$msg_arr = get_alert_msg('Username must be at least 5 characters long');
	}

	// Change Password
	if(isset($_POST['change_pass'])) {
		$old_password = sha1($_POST['old_password']);
		$new_password = $_POST['new_password'];
		$conf_password = $_POST['conf_password'];

		if(strlen($new_password) >= 5) {
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
			$msg_arr = get_alert_msg('New Password must be at least 5 characters long');
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

		if(strlen($subject) >= 5) {
			if(strlen($message) >= 10) {
				if($category_id > 0) {
					$id = get_msg_id($subject, $message);

					$sql = 'INSERT INTO inquiries (inquiry_category_id, message_id) VALUES (' . $category_id . ', ' . $id . ')';
					mysqli_query($conn, $sql);

					$msg_arr = get_alert_msg('Inquiry successfully sent', 1);
				}
				else
					$msg_arr = get_alert_msg('No category selected');
			}
			else
				$msg_arr = get_alert_msg('Message must be at least 10 characters long');
		}
		else
			$msg_arr = get_alert_msg('Subject must be at least 5 characters long');
	}

	// Report Torrent
	if(isset($_POST['report_torrent'])) {
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		$torrent_id = $_POST['torrent_id'];

		if(strlen($subject) >= 5) {
			if(strlen($message) >= 10) {
				$id = get_msg_id($subject, $message);

				$sql = 'INSERT INTO torrent_reports (torrent_id, message_id) VALUES (' . $torrent_id . ', ' . $id . ')';
				mysqli_query($conn, $sql);

				$msg_arr = get_alert_msg('Torrent report successfully submitted', 1);
			}
			else
				$msg_arr = get_alert_msg('Message must be at least 10 characters long');
		}
		else
			$msg_arr = get_alert_msg('Subject must be at least 5 characters long');
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

		if(strlen($subject) >= 5) {
			if(strlen($message) >= 10) {
				$id = get_msg_id($subject, $message);

				$sql = 'INSERT INTO comment_reports (comment_id, message_id) VALUES (' . $comment_id . ', ' . $id . ')';
				mysqli_query($conn, $sql);

				$_SESSION['msg_arr'] = get_alert_msg('Comment report successfully submitted', 1);
			}
			else
				$_SESSION['msg_arr'] = get_alert_msg('Message must be at least 10 characters long');
		}
		else
			$_SESSION['msg_arr'] = get_alert_msg('Subject must be at least 5 characters long');
	}

	// Send Response
	if(isset($_POST['send_response'])) {
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		$message_id = $_POST['message_id'];

		$sql = 'INSERT INTO messages (subject, message, user_id, message_id) VALUES ("' . $subject . '", "' . $message . '", ' . $_SESSION['user_id'] . ', ' . $message_id . ')';
		mysqli_query($conn, $sql);

		$_SESSION['msg_arr'] = get_alert_msg('Response successfully sent', 1);
	}

	// Update Item
	if(isset($_POST['update_save'])) {
		$category = $_POST['category'];
		$fkey = $_POST['fkey'];

		if($category == 'Torrent') {
			$category_id = $_POST['category_id'];
			$name = $_POST['name'];
			$description = $_POST['description'];

			$sql = 'UPDATE torrents SET name = "' . $name . '", description = "' . $description . '", torrent_category_id = ' . $category_id . ' WHERE id = ' . $fkey;
			echo $sql;
			mysqli_query($conn, $sql);

			$_SESSION['msg_arr'] = get_alert_msg('Item successfully updated', 1);
		}
		elseif($category == 'Comment') {
			$message = $_POST['message'];

			$sql = 'UPDATE comments SET message = "' . $message . '" WHERE id = ' . $fkey;
			mysqli_query($conn, $sql);

			$_SESSION['msg_arr'] = get_alert_msg('Item successfully updated', 1);
		}
	}

	// Delete Issue
	if(isset($_POST['delete_ok'])) {
		$type = $_POST['type'];
		$id = $_POST['id'];

		if($type != 'response') {
			$fkey = $_POST['fkey'];
			$source = $_POST['source'];
			$image = $_POST['image'];
			$category = $_POST['category'];

			if($category == 'Torrent') {
				if($type == 'issue') {
					$sql = 'DELETE tr, m FROM torrent_reports tr JOIN messages m ON tr.message_id = m.id WHERE m.id = ' . $id;
				}
				else {
					$sql = 'DELETE tr, t, c, cr, m FROM torrent_reports tr JOIN torrents t ON tr.torrent_id = t.id JOIN comments c ON c.torrent_id = t.id JOIN comment_reports cr ON cr.comment_id = c.id JOIN messages m ON tr.message_id = m.id OR cr.message_id = m.id WHERE t.id = ' . $fkey;
					unlink($source);
					unlink($image);
				}
			}
			elseif($category == 'Comment') {
				if($type == 'issue') {
					$sql = 'DELETE cr, m FROM comment_reports cr JOIN messages m ON cr.message_id = m.id WHERE m.id = ' . $id;
				}
				else {
					$sql = 'DELETE cr, c, m FROM comment_reports cr JOIN comments c ON cr.comment_id = c.id JOIN messages m ON cr.message_id = m.id WHERE c.id = ' . $fkey;
				}
			}
			else {
				$sql = 'DELETE i, m FROM inquiries i JOIN messages m ON i.message_id = m.id WHERE m.id = ' . $id;
			}
		}
		else {
			$sql = 'DELETE FROM messages WHERE id = ' . $id;
		}

		mysqli_query($conn, $sql);
		$_SESSION['msg_arr'] = get_alert_msg('Item successfully deleted', 1);
		header('location: admin.php');
	}

	// Basic Search
	if(isset($_POST['search'])) {
		header('location: ?query=' . $_POST['query']);
	}

	// Advanced Search
	if(isset($_POST['advanced'])) {
		$filter = '';

		foreach($_POST['category_id'] as $category_id) {
			$filter .= $category_id . ',';
		}

		header('location: ?filter=' . rtrim($filter, ','));
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

	// Validate Torrent File
	function validate_torrent($torrent) {
		global $bcoder;

		if($torrent = $bcoder->bdecode_file($torrent)) {
			if($torrent = $torrent['info']) {
				if((isset($torrent['length']) || isset($torrent['files'])) &&
					isset($torrent['name']) && isset($torrent['piece length']) && isset($torrent['pieces'])) {
					return true;
				}
			}
		}

		return false;
	}

	// Validate Upload
	function validate_upload($category_id, $name, $description) {
		global $bcoder;

		// $input_ok = false;
		$msg_arr = [];

		if($category_id) {
			if(strlen($name) >= 5) {
				if(strlen($description) >= 10) {
					if(isset($_FILES['cover'])) {
						if(isset($_FILES['torrent'])) {
							// $input_ok = true;
						}
						else
							$msg_arr = get_alert_msg('No torrent file chosen');
					}
					else
						$msg_arr = get_alert_msg('No image file chosen');
				}
				else
					$msg_arr = get_alert_msg('Torrent description must be at least 10 characters long');
			}
			else
				$msg_arr = get_alert_msg('Torrent name must be at least 5 characters long');
		}
		else
			$msg_arr = get_alert_msg('Please select a category');

		// if($input_ok) {
		if(!$msg_arr) {
			$cover_tmp = $_FILES['cover']['tmp_name'];
			$torrent_tmp = $_FILES['torrent']['tmp_name'];
			// $input_ok = false;

			// Check if file is an actual or fake file
			if($_FILES['cover']['error'] != 4) {
				if(getimagesize($cover_tmp)) {
					if(validate_torrent($torrent_tmp)) {
						$cover = 'torrents/cover/' . basename($_FILES['cover']['name']);
						$torrent = 'torrents/torrent/' . basename($_FILES['torrent']['name']);

						// Check if file already exists
						if (!file_exists($cover)) {
							if (!file_exists($torrent)) {

								// Check file size
								if ($_FILES['cover']['size'] < 500000) {
									if ($_FILES['torrent']['size'] < 500000) {
										$cover_type = pathinfo($cover, PATHINFO_EXTENSION);
										$torrent_type = pathinfo($torrent, PATHINFO_EXTENSION);

										// Allow certain file formats
										if($cover_type == 'jpg' || $cover_type == 'png' || $cover_type == 'jpeg' || $cover_type == 'gif') {
											if($torrent_type == 'torrent') {

												// If everything is ok, try to upload files
												if (move_uploaded_file($cover_tmp, $cover)
													&& move_uploaded_file($torrent_tmp, $torrent)) {
													// $input_ok = true;
												}
												else
													$msg_arr = get_alert_msg('There was an error uploading your files');
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
				$msg_arr = get_alert_msg('No image file selected');
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

				foreach($bdecode['files'] as $file) {
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

				echo '<option value="' . $id . '">' . $name . '</option>';
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

				echo '<input type="checkbox" name="' . $name_attr . '[]" value="' . $id . '">' . $name;
			}
		}
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
					  	  <input type="hidden" id="' . $type . '_id" value="' . $id . '">';

				if($type != 'response') {
					echo '<input type="hidden" id="' . $type . '_fkey" value="' . $fkey . '">
						  <input type="hidden" id="' . $type . '_source" value="' . $source . '">
						  <input type="hidden" id="' . $type . '_image" value="' . $image . '">
						  <input type="hidden" id="' . $type . '_category" value="' . $category . '">';
				}
					echo '<input type="hidden" id="' . $type . '_type" value="' . $type . '">
						  <button type="button" id="' . $type . '_ok" class="btn btn-danger" data-dismiss="modal" value="' . $type . '">OK</button>
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
		$query = $filter = $torrent = $sort = '';

		if($file_name == 'home' || $file_name == 'browse') {
			$select = 'SELECT t.id torrent_id, t.name torrent_name, description, file_count, file_size, source, cover, t.date_created torrent_date, u.id user_id, username, tc.id category_id, tc.name category_name FROM torrents t JOIN users u ON t.user_id = u.id JOIN torrent_categories tc ON t.torrent_category_id = tc.id';
		}
		elseif($file_name == 'torrent') {
			$select = 'SELECT c.id comment_id, message, c.date_created comment_date, u.id user_id, username, t.id torrent_id, t.name torrent_name FROM comments c JOIN users u ON c.user_id = u.id JOIN torrents t ON c.torrent_id = t.id';
		}
		elseif($file_name == 'admin') {
			$select = 'SELECT m.id message_id, m.subject message_subj, m.message message_msg, m.date_created message_date, u.id user_id, username, ic.id category_id, ic.name category_name, null item_heading, null item_body, null item_date, null item_category_id, null file_count, null file_size, null source, null cover FROM inquiries i JOIN messages m ON i.message_id = m.id JOIN users u ON m.user_id = u.id JOIN inquiry_categories ic ON i.inquiry_category_id = ic.id
				UNION ALL
				SELECT m.id, m.subject, m.message, m.date_created, u.id, username, t.id, "Torrent", t.name, t.description, t.date_created, t.torrent_category_id, t.file_count, t.file_size, t.source, t.cover FROM torrent_reports tr JOIN messages m ON tr.message_id = m.id JOIN users u ON m.user_id = u.id JOIN torrents t ON tr.torrent_id = t.id
				UNION ALL
				SELECT m.id, m.subject, m.message, m.date_created, u.id, username, c.id, "Comment", null, c.message, c.date_created, c.torrent_id, null, null, null, null FROM comment_reports cr JOIN messages m ON cr.message_id = m.id JOIN users u ON m.user_id = u.id JOIN comments c ON cr.comment_id = c.id';
		}
		elseif($file_name == 'inbox') {
			$select = 'SELECT m1.id message_id_1, m1.subject message_subj_1, m1.message message_msg_1, m1.date_created message_date_1, u1.id user_id_1, u1.username username_1, m2.id message_id_2, m2.subject message_subj_2, m2.message message_msg_2, m2.date_created message_date_2, u2.id user_id_2, u2.username username_2 FROM messages m1 JOIN messages m2 ON m1.message_id = m2.id JOIN users u1 ON m1.user_id = u1.id JOIN users u2 ON m2.user_id = u2.id';
		}

		if($file_name == 'home') {
			$where .= 't.date_created >= NOW() - INTERVAL 1 DAY';
		}

		if(isset($_GET['query'])) {
			$query = $_GET['query'];
			$where .= 't.name LIKE "%' . $query . '%"';
			$query = '&query=' . $query;
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

		if(isset($_GET['ascend'])) {
			$sort = $_GET['ascend'];
			$order = ' ORDER BY ' . $sort . ' ASC';
			$sort = '&ascend=' . $sort;
		}
		else {
			if(isset($_GET['descend'])) {
				$sort = $_GET['descend'];
				$order = ' ORDER BY ' . $sort . ' DESC';
				$sort = '&descend=' . $sort;
			}
		}

		if($where) {
			$where = ' WHERE ' . $where;
		}

		$query_string = $query . $filter . $torrent . $sort;

		$sql = $select . $where . $order;
		$result = mysqli_query($conn, $sql);

		// var_dump($sql);

		if(mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$items[] = $row;
			}

			$max = 6;
			$total = count($items);

			if(isset($_GET['page'])) {
				$curr = (int)$_GET['page'];
				$idx = ($curr - 1) * $max;
			}
			else {
				$curr = 1;
				$idx = 0;
			}

			echo '<div class="list-group">';

			for($i = $idx; $i < $idx + $max && $i < $total; $i++) {
				$idx_arr = array_keys($items, $items[$i]);
				extract($items[$i]);

				if($file_name == 'home' || $file_name == 'browse') {
					unset($_SESSION['torrent']);

					if(strlen($torrent_name) > 50) {
						$torrent_name = substr($torrent_name, 0, 50) . '...';
					}
					if(strlen($description) > 100) {
						$description = substr($description, 0, 100) . '...';
					}

					echo '<div class="input-group">
							  <div class="input-group-btn">
								  <a href="?filter=' . $category_id . '" class="btn btn-default">
									  <img src="images/torrent/' . strtolower($category_name) . '.png" alt="' . $category_name . '">
								  </a>
							  </div>
							  <a href="torrent.php?idx=' . $idx_arr[0] . '&torrent=' . $torrent_id . '" class="list-group-item ';
								  if($i % 2)
								  	  echo 'even-row';
								  else
								  	  echo 'odd-row';
								  echo '">
								  <h4 class="list-group-item-heading">' . $torrent_name . '</h4>
								  <p class="list-group-item-text">' . $description . '</p>
							  </a>
						  </div>';
				}
				elseif($file_name == 'torrent') {
					echo '<span class="list-group-item">
							  <h4 class="list-group-item-heading">' . $username . '</h4>
							  <p class="list-group-item-text">' . $message . '</p>
							  <div class="text-right">
								  <a href="#comment_' . $idx_arr[0] . '" data-toggle="collapse">Report</a>
								  <div id="comment_' . $idx_arr[0] . '" class="collapse">
									  <input type="text" id="subject_' . $idx_arr[0] . '" class="form-control" name="subject" placeholder="Subject">
									  <textarea id="message_' . $idx_arr[0] . '" class="form-control" name="message" rows="10" placeholder="Message"></textarea>
								  	  <input type="hidden" id="comment_id_' . $idx_arr[0] . '" name="comment_id" value="' . $comment_id . '">
								  	  <button type="button" class="btn btn-default" name="report_comment" value="' . $idx_arr[0] . '">Submit</button>
								  </div>
							  </div>
						  </span>';
				}
				elseif($file_name == 'admin') {
					if($category_name != 'Torrent' && $category_name != 'Comment') {
						$category = 'Inquiry';
					}
					else {
						$category = $category_name;
					}

					if(strlen($message_subj) > 50) {
						$message_subj = substr($message_subj, 0, 50) . '...';
					}
					if(strlen($message_msg) > 100) {
						$message_msg = substr($message_msg, 0, 100) . '...';
					}

					echo '<a href="issue.php?idx=' . $idx_arr[0] . '" class="list-group-item">
							  <h4 class="list-group-item-heading">' . $message_subj . '</h4>
							  <p class="list-group-item-text">' . $category . '</p>
							  <p class="list-group-item-text">' . $message_msg . '</p>
						  </a>';
				}
				elseif($file_name == 'inbox') {
					echo '<a href="notification.php?idx=' . $idx_arr[0] . '" class="list-group-item">
							  <h4 class="list-group-item-heading">' . $message_subj_1 . '</h4>
							  <p class="list-group-item-text">' . $message_msg_1 . '</p>
						  </a>';
				}
			}

			echo '</div>
				  <div class="text-center">
					  <ul class="pagination">';
				$pages = ceil($total / $max);

				if($curr > 1) {
					echo '<li><a href="?page=1' . $query_string . '">First</a></li>
						  <li><a href="?page=' . ($curr - 1) . $query_string . '">Prev</a></li>';
				}

				for($i = 1; $i <= $pages; $i++) {
					echo '<li><a href="?page=' . $i . $query_string . '">' . $i . '</a></li>';
				}

				if($curr < $pages) {
					echo '<li><a href="?page=' . ($curr + 1) . $query_string . '">Next</a></li>
						  <li><a href="?page=' . $pages . $query_string . '">Last</a></li>';
				}

				echo '</ul>
				  </div>';

			$_SESSION['items'] = $items;
		}
	}
