<?php

namespace Main\Controllers;

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


    public function sendPasswordResetEmail($data) {
        
        die;

        $message = "";
        $subject = "";
        $target = "";

        $Mailer = self::setMailParameters($message, $subject, $target);
        $Mailer->send();

        return json_encode("SUCCESS");
    }

}
