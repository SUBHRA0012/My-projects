<?php
session_start();
include '../../partials/_dbconnect.php';
if (!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) exit;

if (isset($_POST['sno'])) {
    $sno = $_POST['sno'];
    $reply = nl2br($_POST['replyMessage']);

    $htmlBody = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; 
        border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
            <div style="background-color: #0d5c25; padding: 20px; text-align: center;">
                <h2 style="color: #ffffff; margin: 0; font-size: 24px;">PureGrocery</h2>
            </div>
            
            <div style="padding: 30px; color: #333333; line-height: 1.6; font-size: 16px;">
                <p>Hello,</p>
                <p>Thank you for reaching out to us. Here is the update regarding your inquiry:</p>
                
                <div style="background-color: #f8f9fa; padding: 15px 20px; border-left: 4px 
                solid #0d5c25; margin: 25px 0; border-radius: 0 4px 4px 0;">
                    ' . $reply . '
                </div>
                
                <p>If you have any further questions, feel free to reply to this email.</p>
                
                <p style="margin-top: 30px;">
                    Best Regards,<br>
                    <strong>The PureGrocery Support Team</strong>
                </p>
            </div>
        </div>
        ';


    $result = mysqli_query($conn, "SELECT email, subject FROM message_customer WHERE sno = '$sno'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $subject = $row['subject'];

        //=============
        //PHP Mailer
        //=============

        require '../../partials/PHPMailer/Exception.php';
        require '../../partials/PHPMailer/PHPMailer.php';
        require '../../partials/PHPMailer/SMTP.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'billubiraj@gmail.com';
            $mail->Password = 'vxlvxqvhxbzqnrjc';
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('billubiraj@gmail.com', 'PureGrocery');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Replying to your issue - ' . $subject;

            $mail->Body = $htmlBody;

            $mail->send();
            
            $result2 = mysqli_query($conn, "UPDATE message_customer SET status = 1 WHERE sno = '$sno'");
            echo 'success';
        } catch (Exception $e) {
            echo "no mail send: {$mail->ErrorInfo}";
        }
    }
}
