<?php
	function get_title() {
		return 'Upload';
	}

	function display_content() {
		global $selected;

		echo '<main class="upload container">
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <form method="post" action="" enctype="multipart/form-data">';
							  create_dropdown('category_id', 'torrent_categories');
						echo '<input type="file" id="upload_cover" class="form-control" name="cover">
							  <input type="text" class="form-control after-file" name="name" placeholder="Torrent Name">
							  <textarea class="form-control" name="description" rows="10" placeholder="Description"></textarea>
							  <input type="file" id="upload_torrent" class="form-control" name="torrent">
							  <div class="after-file">
							  	  <input type="submit" class="btn btn-default" name="upload" value="Upload">
							  </div>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
