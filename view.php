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
		.hidden-php {
			display: none;
		}
	</style>

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
	<div class="hidden-php">
		<?php
			include 'connectdatabase.php';

			$connec = connectDatabase();

			$sql_query = "SELECT * FROM array";
			$res = $connec->query($sql_query);

			$arr[] = (object) array();

			if ($res->num_rows > 0) {
				$i = 0;
				while($row = $res->fetch_assoc()) {
					$sketch = new stdClass();
				
					$sketch->id = $row["id"];
					$sketch->name = $row["name"];
					$sketch->author = $row["author"];
					$sketch->colors = $row["colors"];
					
					$arr[$i] = $sketch;

					echo "<div id='sketch-num-{$i}'>";
					echo "<h1>{$sketch->name}</h1>";
					echo "<h2>{$sketch->author}</h2>";
					echo "<p>{$sketch->colors}</p>";
					echo "<h3>{$sketch->id}</h3>";
					echo "</div>";
					
					$i++;
				}
			} else $arr = 0;
			
			$connec->close();

			// echo "console.log('". $arr[0]->colors . "')";
		?>
	</div>

	<div id="main-container" class="container">
	</div>

	<script>
		let stuff = [];

		document.querySelectorAll(".hidden-php > div").forEach((el) => {
			stuff.push({
				"name": el.querySelector("h1").textContent,
				"author": el.querySelector("h2").textContent,
				"colors": el.querySelector("p").textContent,
				"id": el.querySelector("h3").textContent
			});
		});

		// console.log(stuff);
		
		const mainCont = document.querySelector("#main-container");
		for(let i = 0; i < stuff.length; ++i) {
			const singleGrid = document.createElement("div");
			const gridContainer = document.createElement("div");
			singleGrid.id = `grid-container-${i}`;
			gridContainer.classList.add("grid");
			gridContainer.style.gridTemplateColumns = `repeat(${Math.sqrt(stuff[i]["colors"].split(":").length)}, 1fr)`;

			const name = document.createElement("h1");
			name.textContent = stuff[i]["name"];
			const author = document.createElement("h2");
			author.textContent = stuff[i]["author"];

			singleGrid.appendChild(name);
			singleGrid.appendChild(author);

			let colors = stuff[i]["colors"].split(":");
			for(let j = 0; j < colors.length; ++j) {
				const gridElement = document.createElement("div");
				gridElement.id = `grid-element-${i}-${j}`;
				gridElement.classList.add("grid-element");
				c = colors[j].split(",");

				if(c[0] == '0' && c[1] == '0' && c[2] == '0') {
					c = ['255', '255', '255'];
				}

				gridElement.style.backgroundColor = `rgb(${parseInt(c[0])}, ${parseInt(c[1])}, ${parseInt(c[2])})`;
				gridContainer.appendChild(gridElement);
			}
			singleGrid.appendChild(gridContainer);
			mainCont.appendChild(singleGrid);
		}
	</script>
</body>
</html>
