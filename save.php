<!-- made by Matthew Riffle  -->
 <?php
	include 'connectdatabase.php';

	$url = $_SERVER['REQUEST_URI'];

	$url_array;
	$url_grids;
	
	$url_array = explode("?", $url)[1];
	// $url_grids = explode("&", $url_array)[1];
	$url_array = explode("&", $url_array);
	$url_grids = explode("=", $url_array[0])[1];
	$url_name = explode("=", $url_array[1])[1];
	$url_sketch = explode("=", $url_array[2])[1];

	// echo $url_grids;
	// echo "<br>";
	// echo $url_name;
	// echo "<br>";
	// echo $url_sketch;

	// echo count(explode(":", $url_grids));
	// echo count(explode("?", $url));

	if(count(explode("?", $url)) != 2) {
		header("Location: /");
	} else {
		$connec = connectDatabase();
		
		$single_query = "INSERT INTO array (colors, name, author) VALUES ('${url_grids}', '${url_name}', '${url_sketch}')";
	
		if ($connec->query($single_query) === TRUE) {
			echo "New record created successfully<br>";
		} else {
			echo "Error: " . $single_query . "<br>" . $connec->error;
		}
	
		$connec->close();
	}
?> 
<div id="timer"></div>

<script>
	var countDownDate = new Date().getTime() + 5000;

var timer = setInterval(function() {
	var now = new Date().getTime();
	var distance = countDownDate - now;
	var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	document.querySelector("#timer").innerHTML = `Redirecting to the view page in ${seconds} seconds`;

	if (distance < 0) {
		clearInterval(timer);
		document.querySelector("#timer").innerHTML = "Redirecting...";
		window.location=`/view.php`;
	}
}, 1000);
</script>
