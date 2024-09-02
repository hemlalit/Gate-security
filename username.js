// tooltip script

var p = document.getElementById('username');

function myFunction() {
    var copyText = p.textContent;
    navigator.clipboard.writeText(copyText);

    var tooltip = document.getElementById("myTooltip");
    tooltip.innerHTML = "Copied - " + copyText;
}

function outFunc() {
    var tooltip = document.getElementById("myTooltip");
    tooltip.innerHTML = "Copy to clipboard";
}
