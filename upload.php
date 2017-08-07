<?php
	function get_title() {
		return 'Upload Torrent';
	}

	function display_content() {
		global $selected;

		echo '<main class="upload container">
				  <h1 class="heading">' . get_title() . '</h1>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <form method="post" action="" enctype="multipart/form-data">';
							  create_dropdown('category_id', 'torrent_categories');
						echo '<div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/icon/image.png" alt="Image">
								  </span>
								  <input type="file" id="upload_cover" class="form-control" name="cover">
							  </div>
							  <div class="after-file"></div>
							  <div class="input-group">
								  <span class="input-group-addon">
								  	  <img src="images/icon/torrent.png" alt="Torrent">
								  </span>
								  <input type="file" id="upload_torrent" class="form-control" name="torrent">
							  </div>
							  <input type="text" class="form-control after-file" name="name" value="' . 
							  (isset($_POST['name']) ? $_POST['name'] : '') . '" placeholder="Torrent Name">
							  <textarea class="form-control" name="description" rows="10" placeholder="Description">' . 
							  (isset($_POST['description']) ? $_POST['description'] : '') . '</textarea>
							  <div class="text-center">
							  	  <input type="submit" class="btn btn-primary" name="upload" value="Upload">
							  </div>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
