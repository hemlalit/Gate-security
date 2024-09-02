
const body = document.querySelector('body'),
    sidebar = body.querySelector('nav'),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    searchInput = body.querySelector(".search-box input"),
    modeSwitch = body.querySelector(".toggle-switch"),
    modeText = body.querySelector(".mode-text");
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
})
searchBtn.addEventListener("click", () => {
    sidebar.classList.remove("close");
    searchInput.focus();
})

modeSwitch.addEventListener("click", () => {
    body.classList.toggle("dark");
    if (body.classList.contains("dark")) {
        modeText.innerText = "Light mode";
    } else {
        modeText.innerText = "Dark mode";
    }
});




$(document).ready(function () {
    $('.dashboard').on("click", function () {
        /* Get input value on change */
        // var inputVal = $(this).val();
        var container = $("#responseContainer");
        $.get("dashBoard/dashBoard.php").done(function (data) {
            // Display the returned data in browser
            console.log(data)
            container.html(data);
        });
    });

});



// popup staff
document.addEventListener('DOMContentLoaded', function () {
    const popupOverlay = document.getElementById('popupOverlay');
    const closePopup = document.getElementById('closePopup');
    const scanQRbtn = document.getElementById('qr-scan');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    let stream = null;

    // Function to open the popup
    function openPopup() {
        popupOverlay.style.display = 'block';

        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }).then(mediaStream => {
            stream = mediaStream;
            video.srcObject = stream;
            video.setAttribute('playsinline', true); // required to tell iOS safari we don't want fullscreen
            video.play();
            requestAnimationFrame(tick);
        }).catch(err => {
            console.error('Error accessing camera: ', err);
        });

        function tick() {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.height = video.videoHeight;
                canvas.width = video.videoWidth;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: 'dontInvert',
                });
                if (code) {
                    // document.location.href = ;
                    const a = document.createElement('a');
                    a.href = code.data;
                    a.target = '_blank';
                    a.click();
                } else {
                    console.log('No QR code detected');
                }
            }
            requestAnimationFrame(tick);
        }
    }

    // Function to close the popup
    function closePopupFunc() {
        popupOverlay.style.display = 'none';
        if (stream) {
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }
    }

    // Event listeners
    scanQRbtn.addEventListener('click', openPopup);
    closePopup.addEventListener('click', closePopupFunc);
});
