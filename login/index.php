<?php
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    // Check if the user is already logged in
    header("Location:../admin");
    die();
}

include_once '../assets/setup/db.php';
$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='{$email}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            if ($row['is_verified'] == 1) {
                if ($email == 'onyinkwagodfrey68@gmail.com') {
                    // Check if the user is an admin
                    $_SESSION['SESSION_EMAIL'] = $email;
                    $_SESSION['SESSION_NAME'] = $row['name'];
                    header("Location:../admin");
                    die();
                } else {
                    $msg = "You do not have admin privileges.";
                }
            } else {
                $msg = "Your email is not verified yet. Please check your inbox for the verification link.";
            }
        } else {
            $msg = "Invalid email or password.";
        }
    } else {
        $msg = "Invalid email or password.";
    }
}
?>
<?php require_once('../assets/layouts/header.php'); ?>
<style>
    .container4 {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    margin-top: 90px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  }
  
  .container4 h2 {

    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }
  
  .container4 .alert {
    margin-bottom: 20px;
  }
  
  .container4 form input[type="email"],
  .container4 form input[type="password"] {
    width: 90%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    color: #555;
    margin-bottom: 15px;
  }
  
  .container4 form button {
    background-color: #555;
    color: #fff;
    padding: 12px 30px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
  }
  
  .container4 form button:hover {
    background-color: #333;
  }
  
  .container4 .social-icons {
    margin-top: 20px;
    text-align: center;
    font-size: 14px;
    color: #666;
  }
  
  .container4 .social-icons a {
    color: #888;
    text-decoration: none;
  }
  
  .dialog {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease-in-out;
  }
  
  .dialog.active {
    opacity: 1;
    pointer-events: auto;
  }
  
  .dialog-content {
    max-width: 400px;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  }
  
  .dialog-content h2 {
    margin-bottom: 20px;
    color: #333;
  }
  
  .dialog-content p {
    margin-bottom: 20px;
    color: #666;
  }
  
  .dialog-content button {
    background-color: #555;
    color: #fff;
    padding: 12px 30px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
  }
  
  .dialog-content button:hover {
    background-color: #333;
  }
</style>

<!-- Rest of the HTML code -->

<div class="container4">
    <div class="content-wthree">
        <h2>Login</h2>
        <?php if (!empty($msg)) : ?>
        <div class="dialog active">
            <div class="dialog-content">
                <h2>Error</h2>
                <p><?php echo $msg; ?></p>
                <button onclick="location.href='../home'">OK</button>
            </div>
        </div>
        <?php endif; ?>
        <form action="" method="post">
            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
            <p><a href="../forgot-password" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>
            <button name="submit" class="btn" type="submit">Login</button>
        </form>
        <div class="social-icons">
            <p>Don't have an account? <a href="../register">Register</a>.</p>
        </div>
    </div>
</div>

<!-- Rest of the HTML code -->

<?php require_once('../assets/layouts/footer.php'); ?>
