<?php
session_start();

// Check if the necessary session variables are set
if (!isset($_SESSION['SESSION_EMAIL']) || !isset($_SESSION['PASSWORD_RESET_COMPLETED'])) {
    // Redirect the user to the appropriate page
    header("Location: ../forgot-password");
    exit();
}

// Clear the session variables related to password reset
unset($_SESSION['SESSION_EMAIL']);
unset($_SESSION['PASSWORD_RESET_COMPLETED']);

require_once('../assets/layouts/header.php');
?>






<style>
    .container3 {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        width: 400px;
        padding: 30px;
        text-align: center;
        background-color: #f8f8f8;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .alert {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #cce5ff;
        border: 1px solid #b8daff;
        border-radius: 5px;
        color: #004085;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<div class="container3">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Password Reset Email Sent</h2>
            <div class="alert alert-info">We've sent a password reset link to your email address. Please check your inbox.</div>
            
            <a href="../home" class="btn btn-primary">Go to Home Page</a>
        </div>
    </div>
</div>

<?php require_once('../assets/layouts/footer.php'); ?>
