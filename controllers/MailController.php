<?php

namespace Main\Controllers;

use Main\Models\CreateModel;
use PHPMailer\PHPMailer\PHPMailer;

session_start();

class MailController {

    public function setMailParameters($message, $subject, $target) {
        $sender_email = "upcc@eneioarzew.online";
        $sender_name = "UPCC";

        $Mailer = new PHPMailer(true);
        $Mailer->isSMTP();
        $Mailer->Host = "mail.eneioarzew.online";
        $Mailer->SMTPAuth = true;
        $Mailer->Username = "upcc@eneioarzew.online";
        $Mailer->Password = "upcc2022A!";
        $Mailer->SMTPOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        );
        $Mailer->SMTPSecure = "ssl";
        $Mailer->Port = 465;
        $Mailer->setFrom($sender_email, $sender_name);
        $Mailer->addAddress($target);

        $Mailer->isHTML(true);
        $Mailer->Subject = $subject;
        $Mailer->Body = $message;

        return $Mailer;
    }


    public function sendMail($message, $subject, $target) {
        $Mailer = self::setMailParameters($message, $subject, $target);
        $Mailer->send();

        return json_encode("SUCCESS");
    }


    public function sendPasswordResetEmail() {

        $email = $_POST["email"];

        $FetchController = new FetchController();
        $response = $FetchController->isAccountEmail($email);

        if ($response["status"] !== 200) {
            header("Location: ../error/500");
            return;
        }

        if(count($response["rows"]) < 1) {
            header("Location: ../login/reset-email-sent");
            return;
        }

        date_default_timezone_set("Asia/Manila");

        $token = bin2hex(random_bytes(64));
        $expiryDate = date_add(date_create(date("Y-m-d H:i:s")), date_interval_create_from_date_string("5 minutes"));
        $expiryDate = $expiryDate->format("Y-m-d H:i:s");

        $CreateModel = new CreateModel();
        $response = $CreateModel->token($token, $expiryDate, $email);

        if($response["status"] !== 200) {
            header("Location: ../error/500");
            return;
        }

        // generate link containing token to be put in the email for password reset.

        var_dump($response);
        die;

        $link = "";
        $customerServiceEmail = "";
        $html = "<style>body { font-family: Arial; }</style><h2>UPCC Account Password Reset</h2>\n<p>To reset your account's password, either copy and paste the link below, or simply click it to proceed: \n$link</p><p>If you did not request a password reset, disregard this email. For other concerns about your account, you may reach customer service at $customerServiceEmail.</p>";

        $message = $html;
        $subject = "UPCC | Account Password Reset Request";

        $Mailer = self::setMailParameters($message, $subject, $email);
        $Mailer->send();

        return header("Location: ../login/reset-email-sent");
    }

}
