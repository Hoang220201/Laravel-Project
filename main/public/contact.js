$(document).ready(function () {
    var icon = document.querySelector(".mail-icon");

    $("#name").on("input", function () {
        validateForm();
    });
    $("#email").on("input", function () {
        validateForm();
    });
    $("#message").on("input", function () {
        validateForm();
    });

    function validateForm() {
        // Get the values of the email input and select element
        var name = $("#name").val();
        var email = $("#email").val();
        var message = $("#message").val();

        // Check if both the email input and select element have valid values
        if (email.endsWith("@gmail.com") && message && name) {
            // Enable the submit button
            $("#submit").prop("disabled", false);
        } else {
            // Disable the submit button
            $("#submit").prop("disabled", true);
        }
    }

    $("#submit").click(function postContact() {
        $("#submit").prop("disabled", true);
        var name = $("#name").val();
        var email = $("#email").val();
        var message = $("#message").val();
        $.ajax({
            url: "main/public/contactsubmit",
            method: "POST",
            data: {
                name: name,
                email: email,
                message: message,
                token: $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function () {
                $("#contactform").hide();
                $("#thankyou").append(
                    "<h1 >Thank you " +
                        name +
                        " for contacting us!</h1>" +
                        "<p>You will get a response from our team soon.</p>"
                );
                icon.removeAttribute("hidden");
            },
            error: function (xhr, status, error) {
                $("#submit").prop("disabled", false);
                alert("Submit failed. Please try again.");
            },
        });
    });
});
