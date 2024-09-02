const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }).then(stream => {
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
            document.location.href = code.data;
        } else {
            console.log('No QR code detected');
        }
    }
    requestAnimationFrame(tick);
}
