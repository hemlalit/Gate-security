
const loader = document.querySelector('.preloader')
window.addEventListener('load', function () {
    loader.style.display = "none"
})


const searchBar = document.querySelector(" .search input"),
    searchBtn = document.querySelector(" .search button");

searchBtn.onclick = () => {
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
    searchBar.value = "";
}

// by cliking outside remove menu bar
const menu = document.querySelector(".menu");
const profile = document.querySelector(".profile-pic");

profile.addEventListener('click', () => {
    menu.classList.toggle('hide');
})

document.addEventListener('click', e => {
    if (!menu.contains(e.target) && e.target !== profile) {
        menu.classList.add('hide');
    }
})


// Ajax...

var depObject = {
    "IT": ["instructer1", "instructer2", "instructer3", "instructer4"],
    "BBA": ["teacher1", "teacher2", "teacher3"],
};

window.onload = function () {
    var selectedDep = document.getElementById("dep");
    var selectedIns = document.getElementById("ins");

    // Populate department dropdown
    for (var dep in depObject) {
        selectedDep.options[selectedDep.options.length] = new Option(dep, dep);
    }

    selectedDep.onchange = function () {
        // Empty 'Ins' dropdown
        selectedIns.length = 1;

        // Display correct values
        var selectedDepValue = this.value;
        for (var i = 0; i < depObject[selectedDepValue].length; i++) {
            var instructor = depObject[selectedDepValue][i];
            selectedIns.options[selectedIns.options.length] = new Option(instructor, instructor);
        }
    };
};


$(document).ready(function () {
    // Assuming your button is inside a form
    $('.btn').on('click', function (e) {

        let purpose = document.forms["visitForm"]["purpose"].value;
        var dropdownDep = document.getElementById("dep");
        // var dropdownIns = document.getElementById("ins");
        var dropdownDate = document.getElementById("date");

        if (dropdownDep.value === "" || dropdownDate.value === "") {
            alert("Please select an option from the dropdown.");
            return false;
        }
        if (purpose == "") {
            alert("purpose must be given");
            return false;
        }

        var button = $(this);

        // Add the class to disable and fade the button
        button.addClass('disable-btn');

        // Show the loader
        $('#loader').addClass('loader');

        // Simulate an asynchronous action (e.g., AJAX request)
        setTimeout(function () {
            // Optionally remove the loader after completion
            $('#loader').removeClass('loader');

        }, 8000); // Adjust the timeout as needed to simulate the process
    });
});
