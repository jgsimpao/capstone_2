<?php
	function get_title() {
		return 'About';
	}

	function display_content() {
		global $ascend;

		echo '<main class="about container">';
			  require_once('partials/alert.php');

			echo '<div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
					  	  <p>
					  	  	  <strong>J-Torrents</strong> (NOT The Pirate Bay) is the worlds largest bittorrent indexer. Bittorrent is a filesharing protocol that in a reliable way enables big and fast file transfers.
					  	  	  <br><br>
							  No torrent files are saved at the server. That means no copyrighted and/or illegal material are stored by us. It is therefore not possible to hold the people behind <strong>J-Torrents</strong> (NOT The Pirate Bay) responsible for the material that is being spread using the site.
							  <br><br>
							  To contact <strong>J-Torrents</strong> (NOT The Pirate Bay) click <a href="contact.php">here</a>.
					  	  </p>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
