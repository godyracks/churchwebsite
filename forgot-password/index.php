<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location:../admin");
    die();
}

require '../vendor/autoload.php';
include_once '../assets/setup/db.php';

$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "SELECT * FROM users WHERE email='{$email}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];

        // Generate a random token
        $token = mysqli_real_escape_string($conn, bin2hex(random_bytes(16)));

        // Store the token in the database
        $token_sql = "INSERT INTO password_reset_tokens (user_id, token) VALUES ('{$user_id}', '{$token}')";
        $token_result = mysqli_query($conn, $token_sql);

        if ($token_result) {
            // Send the password reset link to the user's email
            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = SMTP::DEBUG_OFF;

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'godfreymatagaro@gmail.com';
                $mail->Password = 'mhvqburbbnerazpd';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('godfreymatagaro@gmail.com', 'Mailer');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Reset your password';
                $mail->Body = 'Please click on the following link to reset your password: <b><a href="http://localhost/sdacraterchurch/reset_password?token=' . $token . '">http://localhost/sdacraterchurch/reset_password?token=' . $token . '</a></b>';

                $mail->send();

                // Display success message as a styled dialog
                $msg = "<div id='success-msg' class='dialog'>
                            <h3 class='dialog-title'>Password Reset Link Sent</h3>
                            <p class='dialog-message'>We've sent a password reset link to your email address. Please check your inbox.</p>
                            <div class='dialog-btn-container'>
                                <button id='dialog-ok' class='dialog-btn'>OK</button>
                            </div>
                        </div>";

            } catch (Exception $e) {
                $msg = "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong while generating the password reset token.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid email address.</div>";
    }
}
?>


<?php require_once('../assets/layouts/header.php'); ?>
<style>
.container3 {
  max-width: 400px;
  margin: 0 auto;
}

.content-wthree {
  text-align: center;
}

h2 {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
}

.input-container3 {
  position: relative;
  margin-bottom: 20px;
}

.input-container3.blur {
  filter: blur(4px);
  pointer-events: none;
}

.email {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  background-color: #337ab7;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.dialog {
  display: none;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #f5f5f5;
  padding: 20px;
  border-radius: 4px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  z-index: 9999;
}

.dialog-title {
  font-size: 20px;
  font-weight: bold;
  margin-top: 0;
}

.dialog-message {
  margin-bottom: 0;
}

.dialog-btn-container {
  text-align: center;
  margin-top: 20px;
}

.dialog-btn {
  display: inline-block;
  padding: 10px 20px;
  background-color: #337ab7;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

</style>

<br>
<br>
<br>
<br>

<div class="container3">
    <div class="content-wthree">
        <h2>Forgot Password</h2>
        <?php echo $msg; ?>
        <form action="" method="post">
            <div class="input-container3">
                <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                <button name="submit" class="btn" type="submit">Reset Password</button>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Include the jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

<!-- Custom JavaScript -->
<script>
    $(document).ready(function() {
        // Check if the success message is present
        if ($('#success-msg').length > 0) {
            // Display the success message as a styled dialog
            $('.input-container3').addClass('blur');
            $('#success-msg').fadeIn();

            // Redirect to the home page after the user clicks "OK"
            $('#dialog-ok').click(function() {
                window.location.href = '../home';
            });
        }
    });
</script>

<?php require_once('../assets/layouts/footer.php'); ?>
