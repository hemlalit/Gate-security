
// let profilePic = document.querySelector(".profile img");

// inputFile.onchange = function(){
//     profilePic.src = URL.createObjectURL(inputFile.files[0]);
// }

let loadFile = document.getElementById("file");
// console.log(URL.createObjectURL(loadFile.files[0]));
loadFile.onchange = function (event) {
    var image = document.getElementById("output");
    image.src = URL.createObjectURL(loadFile.files[0]);
};


function openViewer(img) {
    var viewer = $('#imageViewer');
    var viewerImg = $('#viewerImage');
    viewer.css('display', 'block');
    viewerImg.attr('src', $(img).attr('src'));
}

function closeViewer() {
    var viewer = $('#imageViewer');
    viewer.css('display', 'none');
}




