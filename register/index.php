<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location:/admin");
    die();
}
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require '../vendor/autoload.php';

include_once '../assets/setup/db.php';
$msg = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $code = mysqli_real_escape_string($conn, bin2hex(random_bytes(16))); // Generate a random code

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
    } else {
        if ($password === $confirm_password) {
            $hashed_password = mysqli_real_escape_string($conn, password_hash($password, PASSWORD_DEFAULT));
            $sql = "INSERT INTO users (name, email, password, is_verified) VALUES ('{$name}', '{$email}', '{$hashed_password}', 0)";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $user_id = mysqli_insert_id($conn); // Get the last inserted user ID

                $token = mysqli_real_escape_string($conn, bin2hex(random_bytes(16))); // Generate a random token
                $token_sql = "INSERT INTO auth_tokens (user_id, token) VALUES ('{$user_id}', '{$token}')";
                $token_result = mysqli_query($conn, $token_sql);

                if ($token_result) {
                    // Create an instance of PHPMailer
                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_OFF;// disable verbose debug output
                        $mail->isSMTP(); // Send using SMTP
                        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                        $mail->SMTPAuth = true; // Enable SMTP authentication
                        $mail->Username = 'godfreymatagaro@gmail.com'; // SMTP username
                        $mail->Password = 'mhvqburbbnerazpd'; // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
                        $mail->Port = 465; // TCP port to connect to

                        // Recipients
                        $mail->setFrom('godfreymatagaro@gmail.com', 'Mailer');
                        $mail->addAddress($email);

                        // Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = 'Verify your email address';
                        $mail->Body = 'Please click on the following link to verify your email address: <b><a href="http://localhost/guka/verify/?token=' . $token . '">http://localhost/guka/verify/?token=' . $token . '</a></b>';

                        $mail->send();
                        $msg = "<div class='alert alert-info'>We've sent a verification link to your email address. Please check your inbox.</div>";
                    } catch (Exception $e) {
                        $msg = "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Something went wrong while generating the verification token.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong while inserting the user record.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
        }
    }
    // if (!$result) {
    //     $error = mysqli_error($conn);
    //     $msg = "<div class='alert alert-danger'>Error: {$error}</div>";
    // }
    //for debugging the register form -----matagaro//
    
}
?>
<!-- Rest of the HTML and PHP code remains the same -->

<style>

.w3l-mockup-form {
    background-color: #f7f7f7;
    padding: 50px 0;
}

.w3l-mockup-form .container {
    max-width: 600px;
    margin: 0 auto;
}

.w3l-mockup-form .main-mockup {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 40px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.w3l-mockup-form h2 {
    font-size: 24px;
    font-weight: 600;
    color: #333333;
    margin-bottom: 20px;
}

.w3l-mockup-form p {
    font-size: 14px;
    color: #666666;
    margin-bottom: 20px;
}

.w3l-mockup-form form input[type="text"],
.w3l-mockup-form form input[type="email"],
.w3l-mockup-form form input[type="password"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #dddddd;
    border-radius: 4px;
    font-size: 14px;
    color: #555555;
    margin-bottom: 15px;
}

.w3l-mockup-form form button {
    background-color: #dcdcdc;
    color: #333333;
    padding: 12px 30px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.w3l-mockup-form form button:hover {
    background-color: #b9b9b9;
}

.w3l-mockup-form .social-icons {
    font-size: 14px;
    color: #666666;
}

.w3l-mockup-form .social-icons a {
    color: #888888;
    text-decoration: none;
}

</style>
<?php require_once('../assets/layouts/header.php'); ?>
<br>
<br>

  <!-- form section start -->
  <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image2.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="name" placeholder="Enter Your Name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="../login">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->
    <?php require_once('../assets/layouts/footer.php'); ?>