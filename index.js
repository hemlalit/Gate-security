
// let popup = document.getElementById("popup");
// function openPopup() {
//     popup.classList.add("open-popup");
// }

// function closePopup(){
//     window.location.href = "../logpage/log.html"
// }

// click outside to remove form and toggle menu css

const popup = document.querySelector(".popup");
const parent = document.querySelector(".parent");
const visitor = document.querySelector(".visitor");
const vendor = document.querySelector(".vendor");
const optBtn = document.querySelectorAll(".show-login");


optBtn.forEach(item => item.addEventListener('click', () => {
    console.log('Before toggle:', popup.classList);
    popup.classList.remove('hide');
    console.log('After toggle:', popup.classList);
    console.log('Clicked item:', item);
}));

document.querySelector(".popup .close-btn").addEventListener("click", function () {
    popup.classList.add('hide');
})

document.addEventListener('click', e => {
    if (!popup.contains(e.target) && e.target !== parent && e.target !== visitor && e.target !== vendor) {
        popup.classList.add('hide');
    }
})



document.querySelector(".parent").addEventListener("click", function () {

    document.getElementById('cid').style.display = 'block';
    document.getElementById('p_user').style.display = 'block';
    document.getElementById('cname').style.display = 'none';
    document.getElementById('v_user').style.display = 'none';
    document.getElementById('ve_user').style.display = 'none';
    document.getElementById('visitor').disabled = true;
    document.getElementById('vendor').disabled = true;
    document.getElementById('c-name').disabled = true;
});

document.querySelector(".vendor").addEventListener("click", function () {

    document.getElementById('cname').style.display = 'block';
    document.getElementById('ve_user').style.display = 'block';
    document.getElementById('cid').style.display = 'none';
    document.getElementById('p_user').style.display = 'none';
    document.getElementById('v_user').style.display = 'none';
    document.getElementById('visitor').disabled = true;
    document.getElementById('parent').disabled = true;
    document.getElementById('c-id').disabled = true;
});

document.querySelector(".visitor").addEventListener("click", function () {

    document.getElementById('v_user').style.display = 'block';
    document.getElementById('cid').style.display = 'none';
    document.getElementById('cname').style.display = 'none';
    document.getElementById('p_user').style.display = 'none';
    document.getElementById('ve_user').style.display = 'none';
    document.getElementById('vendor').disabled = true;
    document.getElementById('parent').disabled = true;
});

// popup staff

document.addEventListener('DOMContentLoaded', function () {

    const popupOverlay = document.getElementById('popupOverlay');

    const closePopup = document.getElementById('closePopup');

    const emailInput = document.getElementById('emailInput');

    const collegeIcon = document.querySelector(".container .info .logo");

    // Function to open the popup

    function openPopup() {

        popupOverlay.style.display = 'block';

    }

    // Function to close the popup

    function closePopupFunc() {

        popupOverlay.style.display = 'none';

    }

    // Function to submit the signup form

    function submitForm() {

        const email = emailInput.value;

        // Add your form submission logic here

        console.log(`Email submitted: ${email}`);

        closePopupFunc(); // Close the popup after form submission

    }

    // Event listeners

    // Trigger the popup to open (you can call this function on a button click or any other event)

    collegeIcon.addEventListener('click', (evt) => {
        if (evt.detail === 5) {
            openPopup();
        }
    });

    let numberOfTaps = 0;
    const tapThreshold = 1000; // Set your desired time threshold for taps (in milliseconds)

    // for touch screen devices
    
    collegeIcon.addEventListener('touchstart', (event) => {
        // Increment the tap count
        numberOfTaps++;

        // Reset the tap count after the threshold time
        setTimeout(() => {
            numberOfTaps = 0;
        }, tapThreshold);

        // Check if it's a triple tap
        if (numberOfTaps === 5) {
            // Your custom logic for triple tap
            openPopup();
            // Reset the tap count
            numberOfTaps = 0;
        }
    });


    // Close the popup when the close button is clicked

    closePopup.addEventListener('click', closePopupFunc);

});

$(document).ready(function (){
    $('#ve_user').css('display', 'none');
    $('#v_user').css('display', 'none');
    $('#p_user').css('display', 'none');
});



