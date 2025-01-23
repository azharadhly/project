<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h2>Register</h2>
    <form id="register-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required><br><br>

        <button type="submit">Register</button>
    </form>

    <div id="message"></div>


    <script>
    $(document).ready(function () {
        $('#register-form').on('submit', function (e) {
            e.preventDefault();

            // Collect form data and convert it into raw JSON
            let jsonData = JSON.stringify({
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val(),
            });

            // Send data as raw JSON to the API
            $.ajax({
                url: 'http://127.0.0.1:8000/api/register',
                type: 'POST',
                data: jsonData,
                contentType: 'application/json',  // Set content type to JSON
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#message').html('<p>Registration successful!</p>');
                },
                error: function (xhr) {
                    let errorMessage = '';

                    // Check if the error response is in JSON format
                    if (xhr.responseJSON) {
                        // If there are validation errors
                        if (xhr.responseJSON.errors) {
                            errorMessage = '<ul>';
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                errorMessage += '<li>' + value[0] + '</li>';
                            });
                            errorMessage += '</ul>';
                        } else if (xhr.responseJSON.message) {
                            // If the response contains a message (e.g., "validation failed")
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON.error) {
                            // If the response contains a generic error message
                            errorMessage = xhr.responseJSON.error;
                        }
                    } else {
                        // If the response is not JSON, display a general error
                        errorMessage = 'An unknown error occurred.';
                    }

                    // Display the error message on the page
                    $('#message').html('<p style="color: red;">Error: ' + errorMessage + '</p>');
                }
            });
        });
    });
</script>



</body>

</html>