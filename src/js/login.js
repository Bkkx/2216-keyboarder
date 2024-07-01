$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: 'process/process_login.php',
            type: 'POST',
            data: $(this).serialize(), // Serialize form data
            success: function (response) {
                if (response.includes("Redirecting")) {
                    window.location.href = 'index.php'; // Redirect on success
                } else {
                    $('#loginMessage').html(response); // Display error message
                }
            },
            error: function (xhr, status, error) {
                $('#loginMessage').html("Error: " + xhr.responseText);
            }
        });
    });
});