<!-- made by Varun Ragunath -->
<?php
	function connectDatabase() {
		// var_dump($_ENV);

		// DB CONFIG
		$servername = "localhost";
		$username = "varunr";
		$password = "suiiiii";
	
		// Create connection
		$conn = new mysqli($servername, $username, $password, "sketchdb");
	
		// Check connection
		if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
		// else echo "Success";

		return $conn;
	}
?>
