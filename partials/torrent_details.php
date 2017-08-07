<?php
echo '<div class="row">
		  <div class="col-sm-9 col-sm-push-3">
	  	  	  <h4 id="torrent_name">' . $torrent_name . '</h4>
		  	  <hr>
		  	  <p id="torrent_desc">' . $description . '</p>
		  </div>
	  	  <div class="col-sm-3 col-sm-pull-9">
	  	  	  <div class="row">
	  	  	  	  <div class="col-xs-6 col-xs-push-6 col-sm-12 col-sm-push-0">
			  	  	  <img id="cover" class="img-responsive" src="' . $cover . '" alt="' . $torrent_name . '" width="240" height="320">
			  	  	  <br><br>';

					  // Cover Modal
				echo '<div id="cover-modal" class="modal">
						  <img id="cover-img" class="modal-content">
						  <div id="cover-caption"></div>
						  <span id="cover-close">&times;</span>
					  </div>
				  </div>
				  <form class="form-horizontal col-xs-6 col-xs-pull-6 col-sm-12 col-sm-pull-0">
					  <div class="form-group">
						  <label class="control-label col-xs-4 col-sm-5 col-md-4">Category:</label>
						  <p class="form-control-static col-xs-8 col-sm-7 col-md-8">' . $category_name . '</p>
					  </div>
					  <div class="form-group">
						  <label class="control-label col-xs-4 col-sm-5 col-md-4">Files:</label>
						  <p class="form-control-static col-xs-8 col-sm-7 col-md-8">' . $file_count . '</p>
					  </div>
					  <div class="form-group">
						  <label class="control-label col-xs-4 col-sm-5 col-md-4">Size:</label>
						  <p class="form-control-static col-xs-8 col-sm-7 col-md-8">' . format_size($file_size) . '</p>
					  </div>
					  <div class="form-group">
						  <label class="control-label col-xs-4 col-sm-5 col-md-4">Uploader:</label>
						  <p class="form-control-static col-xs-8 col-sm-7 col-md-8">' . $username . '</p>
					  </div>
					  <div class="form-group">
						  <label class="control-label col-xs-4 col-sm-5 col-md-4">Uploaded:</label>
						  <p class="form-control-static col-xs-8 col-sm-7 col-md-8">' . format_date($torrent_date) . '</p>
					  </div>
					  <div class="form-group">
						  <label class="control-label col-xs-4 col-sm-5 col-md-4">Torrent:</label>
						  <div class="form-control-static col-xs-8 col-sm-7 col-md-8">
							  <a class="btn btn-success" href="' . $source . '" download>Download</a>
						  </div>
					  </div>
				  </form>
			  </div>
	  	  </div>
	  </div>';
