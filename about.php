<?php
	function get_title() {
		return 'About Us';
	}

	function display_content() {
		echo '<main class="about container">
				  <h1 class="heading">' . get_title() . '</h1>
				  <div class="panel panel-default">
					  <div class="panel-heading"></div>
					  <div class="panel-body">
						  <p>
					  	  	  <span class="brand">J-Torrents</span> (NOT The Pirate Bay) is the worlds largest bittorrent indexer. Bittorrent is a filesharing protocol that in a reliable way enables big and fast file transfers.
					  	  	  <br><br>
							  No torrent files are saved at the server. That means no copyrighted and/or illegal material are stored by us. It is therefore not possible to hold the people behind <span class="brand">J-Torrents</span> (NOT The Pirate Bay) responsible for the material that is being spread using the site.
							  <br><br>
							  To contact <span class="brand">J-Torrents</span> (NOT The Pirate Bay) click <a href="contact.php">here</a>.
					  	  </p>
					  </div>
					  <div class="panel-footer"></div>
				  </div>
			  </main>';
	}

	require_once('template.php');
