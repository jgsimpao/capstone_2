<?php
	function get_title() {
		return 'Browse Torrents';
	}

	function display_content() {
		global $ascend;

		echo '<main class="browse container">
				  <h1 class="heading">' . get_title() . '</h1>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <form method="post" action="">
							  <div class="input-group basic-search">
								  <input type="text" class="form-control" name="basic-bar" placeholder="Search">
								  <div class="input-group-btn">
									  <button type="submit" class="btn btn-default" name="basic-search">
										  <img src="images/button/search.png" alt="Search">
									  </button>
								  </div>
							  </div>
							  <a class="advanced-link" href="#advanced" data-toggle="collapse">Advanced Search</a>
							  <div id="advanced" class="collapse">
							  	  <input type="text" class="form-control advanced-search" name="advanced-bar" placeholder="Search">';
								  create_checkboxes('category_id', 'torrent_categories');
							echo '<div>
								  	  <input type="submit" class="btn btn-primary advanced-btn" name="advanced-search" value="Submit">
							  	  </div>
							  </div>
							  <a class="basic-link" href="#advanced" data-toggle="collapse">Basic Search</a>
						  </form>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
					  	  <div class="row list-heading">
					  	  	  <div class="col-xs-3 col-sm-6">
					  	  	  	  <a href="?';
							  	  if($ascend)
							  	  	  echo 'asc=torrent_name';
							  	  else
							  	  	  echo 'desc=torrent_name';
							  	  echo '">Name</a>
					  	  	  </div>
					  	  	  <div class="col-xs-3 col-sm-2">
					  	  	  	  <a href="?';
							  	  if($ascend)
							  	  	  echo 'asc=file_size';
							  	  else
							  	  	  echo 'desc=file_size';
							  	  echo '">Size</a>
					  	  	  </div>
					  	  	  <div class="col-xs-3 col-sm-2">
					  	  	  	  <a href="?';
							  	  if($ascend)
							  	  	  echo 'asc=username';
							  	  else
							  	  	  echo 'desc=username';
							  	  echo '">Uploader</a>
					  	  	  </div>
					  	  	  <div class="col-xs-3 col-sm-2">
					  	  	  	  <a href="?';
							  	  if($ascend)
							  	  	  echo 'asc=torrent_date';
							  	  else
							  	  	  echo 'desc=torrent_date';
							  	  echo '">Uploaded</a>
					  	  	  </div>
					  	  </div>';
						  list_items('browse');
				echo '</div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
