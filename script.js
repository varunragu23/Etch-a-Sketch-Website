// made by Matthew Riffle and Shashwat Prasad

let SZ = 32;
window.addEventListener("load", setSize(SZ));

function setSize(siz) {
	console.log("here");
	console.log(siz);
	clearGrid();
	setGridSize(siz);
	fillGrid(siz);
}

function clearGrid() {
	const gridContainer = document.querySelector("#grid-container");
	const gridChilds = Array.from(gridContainer.childNodes);
	gridChilds.forEach((gridChild) => {
		gridContainer.removeChild(gridChild);
	});
}

function setGridSize(siz) {
	const gridContainer = document.querySelector("#grid-container");
	gridContainer.style.gridTemplateColumns = `repeat(${siz}, 1fr)`;
}

function fillGrid(size) {
	for (let i = 0; i < size * size; i++) {
		const gridElement = document.createElement("div");
		const gridContainer = document.querySelector("#grid-container");
		gridElement.id = `grid-element-${i}`;
		gridElement.classList.add("grid-element");
		gridElement.style = `hsl(0,0%,0%)`;
		gridElement.addEventListener("mouseover", changeColor);
		gridContainer.appendChild(gridElement);
	}
}

function randInt(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

function changeColor(e) {
	var h = randInt(0, 360);
	var s = randInt(42, 98);
	var l = randInt(40, 90);

	e.target.style.backgroundColor = `hsl(${h},${s}%,${l}%)`;
}

const buttons = document.querySelectorAll(".grid-selector");

buttons.forEach((button) => {
	button.addEventListener("click", () => {
		// SZ = siz;
		setSize(button.id);
	});
});

document.querySelector(".send").addEventListener("click", () => {
	const array = [];
	const grids = document.querySelectorAll(".grid-element");
	grids.forEach((elem) => {
		array.push(elem.style.backgroundColor == "" ? "rgb(0,0,0)" : elem.style.backgroundColor);
	});

	// for (let i = 0; i < array.length; ++i) {
	// 	console.log(array[i]);
	// }

	// console.log(
	// 	array
	// 		.join(":")
	// 		.split(" ")
	// 		.join("")
	// 		.split("rgb")
	// 		.join("")
	// 		.split("(")
	// 		.join("")
	// 		.split(")")
	// 		.join("")
	// );

	const name = document.querySelector("input[name='name']").value;
	const sketch = document.querySelector("input[name='sketch']").value;

	// console.log(`name=${name.split(" ").join("-")}&sketch=${sketch.split(" ").join("-")}`);

	window.location = `/save.php?stuff=${array
		.join(":")
		.split(" ")
		.join("")
		.split("rgb")
		.join("")
		.split("(")
		.join("")
		.split(")")
		.join("")}&name=${name.split(" ").join("-")}&sketch=${sketch.split(" ").join("-")}`;
});
