$(document).ready(function () {
    $('#registerForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: 'process/process_register.php',
            type: 'POST',
            data: $(this).serialize(), // Serialize form data
            success: function (response) {
                if (response.includes("Registration successful")) {
                    window.location.href = 'verify.php'; // Redirect on success
                } else {
                    $('#registerMessage').html(response); // Display error message
                }
            },
            error: function (xhr, status, error) {
                $('#registerMessage').html("Error: " + xhr.responseText);
            }
        });
    });
});
