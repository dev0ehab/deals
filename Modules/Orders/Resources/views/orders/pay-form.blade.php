<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Redirect</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Payment Processing</h1>
        <div id="successMessage" class="message success">
            <p>Payment Successful!</p>
            <p>Redirecting...</p>
        </div>
        <div id="failureMessage" class="message failure">
            <p>Payment Failed!</p>
            <p>Please try again.</p>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>


<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
    }

    .container {
        text-align: center;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .message {
        display: none;
        padding: 20px;
        border-radius: 8px;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .failure {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Simulate payment success or failure (you would replace these with actual logic)
        const paymentSuccessful = true; // Change to false to simulate failure

        if (paymentSuccessful) {
            document.getElementById("successMessage").style.display = "block";
            setTimeout(() => {
                // Redirect to success page (replace 'success.html' with your actual success page)
                window.location.href = "{{ route('home') }}";
            }, 3000); // Redirect after 3 seconds
        } else {
            document.getElementById("failureMessage").style.display = "block";
            setTimeout(() => {
                // Redirect to failure page (replace 'failure.html' with your actual failure page)
                window.location.href = 'failure.html';
            }, 3000); // Redirect after 3 seconds
        }
    });
</script>
 