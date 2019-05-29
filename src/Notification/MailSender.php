<?php

namespace StudentAssignmentScheduler\Notification;

use PHPMailer\PHPMailer\PHPMailer;

class MailSender
{
    protected $mailer;
    protected $from_email;

    public function __construct(PHPMailer $mailer, string $from_email, $password, string $host)
    {
        $this->mailer = $mailer;
        $this->mailer->isSMTP();
        $this->mailer->Host = $host;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $from_email;
        $this->mailer->Password = $password;
        $this->mailer->SMTPSecure = "tls";
        $this->mailer->Port = 587;
        $this->mailer->setFrom($from_email);

        $this->from_email = $from_email;

        $this->mailer->Subject = "Student Assignment";
    }

    public function __clone()
    {
        $this->mailer = clone $this->mailer;
    }

    public function withRecipient(string $email, string $fullname = "")
    {
        $copy = clone $this;
        $copy->resetRecipients();
        $copy->mailer->addAddress($email, $fullname);
        return $copy;
    }

    private function resetRecipients()
    {
        $this->mailer->clearAllRecipients();
    }

    public function setEmailToUser(): self
    {
        $copy = clone $this;
        $copy->mailer->addAddress($copy->from_email);
        return $copy;
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

    public function addSubject(string $subject)
    {
        $copy = clone $this;
        $copy->mailer->Subject = $subject;
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
        $copy = clone $this;
        $copy->mailer->send();
        return $copy;
    }

    public function withMailer(PHPMailer $Mailer): self
    {
        $copy = clone $this;
        $copy->mailer = $Mailer;
        return $copy;
    }
}
