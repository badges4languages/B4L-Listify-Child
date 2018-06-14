/*
	This is the file that contain my JS functions.
*/

//Toggle button to display or not (by clicking) the search form in the archive badge page
function toggle() {
    var x = document.getElementById("filter-form");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}