<?php

namespace Main\Controllers;

use Main\Models\CreateModel;
use Main\Models\FetchModel;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;

session_start();

class MailController {

    public function setMailParameters($message, $subject, $target) {
        $sender_email = "upcc-password@industrialsalesassist.com";
        $sender_name = "UPCC";

        $Mailer = new PHPMailer(true);
        $Mailer->isSMTP();
        $Mailer->Host = "mail.industrialsalesassist.com";
        $Mailer->SMTPAuth = true;
        $Mailer->Username = "upcc-password@industrialsalesassist.com";
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

        $CreateModel = new CreateModel();
        $response = $CreateModel->token($email);

        if($response["status"] !== 200) {
            header("Location: ../error/500");
            return;
        }

        $token = $response["token"];

        $host = $_SERVER["HTTP_HOST"];
        $link = "http://$host/auth/password-reset?token=$token";
        $customerServiceEmail = "inquiries@industrialsalesassist.com";
        $message = "<style>body { font-family: Arial; }</style><h2>UPCC Account Password Reset</h2>\n<p>To reset your account's password, either copy and paste the link below, or simply click it to proceed: \r\n<a href='$link'>$link</a></p><p>If you did not request a password reset, disregard this email. For other concerns about your account, you may reach our customer service at <a href='mailto:$customerServiceEmail'>$customerServiceEmail</a>.</p>";
        $subject = "UPCC | Account Password Reset Request";

        $Mailer = self::setMailParameters($message, $subject, $email);
        $Mailer->send();

        header("Location: ../login/reset-email-sent");
        return;
    }


    function sendToRandomAgent($orderId, $clientId, $productIds, $items) {
        $firstName = $_SESSION["first_name"];
        $lastName = $_SESSION["last_name"];
        $clientEmail = $_SESSION["email"];

        $message = "Order #$orderId | $firstName $lastName $clientEmail <br>";

        $FetchModel = new FetchModel();
        $response = $FetchModel->getProductNamesFromIds($productIds);
        $rows = $response["rows"];

        foreach ($rows as $row) {
            $message .= sprintf("Product #%s: %s<br>", $row["id"], $row["name"]);
        }

        $response = $FetchModel->agentEmails();
        $rows = $response["rows"];

        $agentEmail = $rows[rand(0, count($rows)-1)]["email"];
        
        try {
            $Mailer = self::setMailParameters($message, "Order #$orderId", $agentEmail);
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()];
        }

        $Mailer->ClearReplyTos();

        try {
            $Mailer->addReplyTo($clientEmail, "$firstName $lastName");
        } catch (PHPMailerException $e) {
            return ["status" => 500, "message" => $e->getMessage(), "stack_trace" => $e->getTraceAsString()];
        }
        
        $Mailer->send();

        return ["status" => 200];
    }

}
