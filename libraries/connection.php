<?php
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'jtorrents';

	$conn = mysqli_connect($host, $username, $password, $database);

	if($conn) {
		// echo 'connected successfully<br>';
	}
