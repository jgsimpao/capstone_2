<?php
echo '<div class="row">
	  	  <div class="col-sm-3">
	  	  	  <img id="cover" src="' . $cover . '" alt="Cover Image" width="200">';

			  // Cover Modal
		echo '<div id="cover-modal" class="modal">
				  <img id="cover-img" class="modal-content">
				  <div id="cover-caption"></div>
				  <span id="cover-close">&times;</span>
			  </div>

			  <form class="form-horizontal">
				  <div class="form-group">
					  <label class="control-label col-sm-4">Category:</label>
					  <p class="form-control-static col-sm-8">' . $category_name . '</p>
				  </div>
				  <div class="form-group">
					  <label class="control-label col-sm-4">Files:</label>
					  <p class="form-control-static col-sm-8">' . $file_count . '</p>
				  </div>
				  <div class="form-group">
					  <label class="control-label col-sm-4">Size:</label>
					  <p class="form-control-static col-sm-8">' . format_size($file_size) . '</p>
				  </div>
				  <div class="form-group">
					  <label class="control-label col-sm-4">Uploader:</label>
					  <p class="form-control-static col-sm-8">' . $username . '</p>
				  </div>
				  <div class="form-group">
					  <label class="control-label col-sm-4">Uploaded:</label>
					  <p class="form-control-static col-sm-8">' . format_date($torrent_date) . '</p>
				  </div>
				  <div class="form-group">
					  <label class="control-label col-sm-4">Torrent:</label>
					  <div class="form-control-static col-sm-8">
						  <a class="btn btn-default" href="' . $source . '" download>Download</a>
					  </div>
				  </div>
			  </form>
	  	  </div>
	  	  <div class="col-sm-9">
	  	  	  <h4 id="torrent_name">' . $torrent_name . '</h4>
		  	  <hr>
		  	  <p id="torrent_desc">' . $description . '</p>
		  </div>
	  </div>';
