
$(document).ready(function () {
    // otp-btn handling on return
    // $('.otp-btn').removeClass('loading')


    // Search functionality
    $('.search-box input[type="text"]').on("keyup input", function () {
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if (inputVal.length) {
            $.get("searchVisits.php", { term: inputVal }).done(function (data) {
                resultDropdown.html(data);
            });
        } else {
            resultDropdown.empty();
        }
    });

    // Function to send data via AJAX
    async function sendData(data, url) {
        return $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "html",
            success: function (response) {
                document.getElementById("responseContainer").innerHTML = response;
            },
            error: function (xhr, status, error) {
                console.error("Error:", status, error);
            }
        });
    }

    // Handle search result click
    $(document).on("click", ".result p", async function () {
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
        var text = $(this).text();
        data = { username: text };
        await sendData(data, "../homePage/detailsTemplate.php");
    });


    // Handle click event for OTP button 

    // const html = '<input class="otp-input" type="text" placeholder="Enter OTP" />'
    //     + '< button class="otp-btn" name = "otp-verification" > Verify</button >'
    //     + '   <div>'
    //     + ' <button class="txt-btn" name="resend-otp">Resend</button>'
    //     + '</div>';

    $('.otp-btn').click(function () {
        $('#loader').addClass('loading');
        $(this).addClass("disable-btn");
    });

    // progress bar     
    // var i = 0;
    // $('#progress-btn').on("click", function () {
    //     if (i == 0) {
    //         i = 1;
    //         var elem = document.getElementById("myBar");
    //         var width = 1;
    //         var id = setInterval(frame, 10);
    //         function frame() {
    //             if (width >= 100) {
    //                 clearInterval(id);
    //                 i = 0;
    //             } else {
    //                 width++;
    //                 elem.style.width = width + "%";
    //                 if (width == 100) window.location.replace( 'staff.php' );

    //             }
    //         }
    //     }
    // });





});
