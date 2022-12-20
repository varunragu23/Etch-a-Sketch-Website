<!-- made by Varun Ragunath -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<link rel="stylesheet" href="style.css" />

	<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			nav {
				display: flex;
				align-items: center;
				justify-content: space-between;
				height: 60px;
				background-color: #333;
				color: #fff;
				font-size: 1rem;
			}

			.logo {
				color: #fff;
				text-decoration: none;
				font-size: 1.5rem;
				font-weight: bold;
				margin-left: 1rem;
			}

			.nav-links {
				display: flex;
				list-style: none;
				margin-right: 1rem;
			}

			.nav-links li {
				margin: 0 1rem;
			}

			.nav-links a {
				color: #fff;
				text-decoration: none;
			}

			.burger {
				cursor: pointer;
				display: none;
			}

			.burger div {
				width: 25px;
				height: 3px;
				background-color: #fff;
				margin: 5px;
			}

			@media screen and (max-width: 768px) {
				.nav-links {
					display: none;
				}
				.burger {
					display: block;
				}
			}

			.title {
				width: 100%;
				height: auto;
				text-align: center;
				margin: 1em 0em;
			}

			.form-container {
				width: 100%;
				display: flex;
				justify-content: center;
				align-items: center;
			}

			/* .sketch-container {
				display: flex;
				justify-content: center;
				align-items: center;
				width: 100%;
			} */
			
			h1 {
				text-align: center;
				margin-top: 1em;
			}
		</style>
</head>
<body>
	<nav>
		<a href="#" class="logo">ETCH A SKETCH</a>
		<ul class="nav-links">
			<li><a href="/view.php">View Sketches</a></li>
			<li><a href="/search.php">Search</a></li>
		</ul>
		<div class="burger">
			<div class="line1"></div>
			<div class="line2"></div>
			<div class="line3"></div>
		</div>
	</nav>

	<h1 class="title">Search for sketch</h1>
	<div class="form-container">
		<form action="search.php" method="GET">
			<select name="data">
				<option value="name">Sketch Title</option>
				<option value="author">Sketch Artist</option>
			</select>
			<input type="text" name="query" placeholder="Query">
			<input type="submit" value="Search">
		</form>
	</div>

	<?php 
		include 'connectdatabase.php';

		if(count($_GET) > 0) {			
			$connec = connectDatabase();
			
			$query = "SELECT * FROM array WHERE " . mysqli_real_escape_string($connec, $_GET["data"]) . " like '%" . mysqli_real_escape_string($connec, $_GET["query"]) . "%'";

			$res = $connec->query($query);

			$arr[] = (object) array();

			if ($res && $res->num_rows > 0) {
				$i = 0;
				while($row = $res->fetch_assoc()) {
					// echo "id: " . $row["movie_id"]. " - title: " . $row["title"] . " - genre: " . $row["genre"]. "<br />";
					$arr_obj = new stdClass();
				
					$arr_obj->id = $row["id"];
					$arr_obj->title = $row["name"];
					$arr_obj->author = $row["author"];
					$arr_obj->colors = $row["colors"];
				
					$arr[$i] = $arr_obj;

					$i++;
				}
			} else $arr = 0;

			$connec->close();

			$i = 0;
			if($arr != 0) {
				echo "<h1>Results for sketches with the " . $_GET["data"] . " of \"" . $_GET["query"] . "\"</h1>";
				echo "<div class='sketch-container'>";
				while($i < count($arr)) {
					echo "<div class='sketch'>";
					echo "<h2><strong>Title:</strong> {$arr[$i]->title}</h2>";
					echo "<div><p><strong>Author:</strong> {$arr[$i]->author}</p></div>";
					echo "<div class='container'><div id='colors-{$i}' style='display:none'>{$arr[$i]->colors}</div></div>";
					$i++;
				}
				echo "</div>";
			} else {
				echo "<h1>No sketches with the ". $_GET["data"] . " of \"" . $_GET["query"] . "\"</h1>";
			}
		}
	?>

	<script>
		const colors = document.querySelectorAll(".container");

		colors.forEach((elem, idx) => {
			let str = elem.querySelector(`#colors-${idx}`).textContent;
			elem.querySelector(`#colors-${idx}`).textContent = "";
			const gridContainer = elem.querySelector(`#colors-${idx}`);

			str = str.split(":");

			const realGrid = document.createElement("div");
			for(let i = 0; i < str.length; ++i) {
				realGrid.classList.add("grid");
				realGrid.style.gridTemplateColumns = `repeat(${Math.sqrt(str.length)}, 1fr)`;

				const gridElement = document.createElement("div");
				gridElement.id = `grid-element-${i}`;
				gridElement.classList.add("grid-element");
				c = str[i].split(",");

				if(c[0] == '0' && c[1] == '0' && c[2] == '0') {
					c = ['255', '255', '255'];
				}

				gridElement.style.backgroundColor = `rgb(${parseInt(c[0])}, ${parseInt(c[1])}, ${parseInt(c[2])})`;
				realGrid.appendChild(gridElement);

			}
			gridContainer.style.display = "block";
			gridContainer.appendChild(realGrid);
		})
	</script>
</body>
</html>
