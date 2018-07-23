<?php

namespace TalkSlipSender;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSender
{
    protected $mailer;
    protected $from_email;
    protected $password;

    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
        $this->mailer->isSMTP();
        $this->mailer->Host = "smtp.mail.me.com";
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->from_email;
        $this->mailer->Password = $this->password;
        $this->mailer->SMTPSecure = "tls";
        $this->mailer->Port = 587;
        $this->mailer->setFrom($this->from_email);

        $this->mailer->Subject = "Student Assignment";
    }

    public function loadEmailAddressOfSender(string $from_email)
    {
        $this->from_email = $from_email;
    }

    public function loadEmailServicePassword(string $password)
    {
        $this->password = $password;
    }
    
    public function addAddress(string $email, string $fullname = "")
    {
        $copy = clone $this;
        $copy->mailer->addAddress($email, $fullname);
        return $copy;
    }

    public function addAttachment(string $path)
    {
        $copy = clone $this;
        $copy->mailer->addAttachment($path);
        return $copy;
    }

    public function addBody(string $body)
    {
        $copy = clone $this;
        $copy->mailer->Body = $body;
        return $copy;
    }

    public function send()
    {
        $this->mailer->send();
    }

    public function getMailer()
    {
        return $this->mailer;
    }
}
