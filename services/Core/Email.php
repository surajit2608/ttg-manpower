<?php

namespace Core;

use Exception;
use Swift_Mailer;
use Swift_Message;
use Swift_Attachment;
use Swift_SmtpTransport;
use Swift_SendmailTransport;

class Email
{

  public $mailer;

  public function send($to, $subject, $message, $headers = false, $cc = [])
  {
    if (DEBUG) {
      $to = DEVELOPER_EMAIL;
    }
    $headers = (object)$headers;
    $mailer = $this->getInstance($headers);
    $message = $this->setMessage($to, $subject, $message, $headers);
    $message->setCc($cc);
    try {
      $send = $mailer->send($message);
      return $send;
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }

  public function message($template, $data)
  {
    $view = Load('Core\View');
    return $view->get('emails.' . $template, $data);
  }

  private function setMessage($to, $subject, $message, $headers)
  {
    $sender = [($headers->from_email ?? SMTP_FROMEMAIL) => ($headers->from_name ?? SMTP_FROMNAME)];
    if (!is_array($to)) {
      $to = [$to];
    }
    $message = (new Swift_Message($subject))
      ->setFrom($sender)
      ->setTo($to)
      ->setBody($message);

    $attachments = $headers->attachments ?? [];
    foreach ($attachments as $attachment) {
      $attachment = (object)$attachment;
      $message->attach(Swift_Attachment::fromPath($attachment->path)->setFilename($attachment->name));
    }

    $message->setContentType("text/html");

    return $message;
  }

  private function getInstance($headers = null)
  {
    if ($this->mailer) {
      return $this->mailer;
    }

    $host = $headers->host ?? SMTP_HOST;
    $port = $headers->port ?? SMTP_PORT;
    $secure = $headers->secure ?? SMTP_SECURE;
    $username = $headers->username ?? SMTP_USERNAME;
    $password = $headers->password ?? SMTP_PASSWORD;

    $transporter = new Swift_SmtpTransport($host, $port, $secure);

    if ($username && $password) {
      $transporter->setUsername($username);
      $transporter->setPassword($password);
    }

    $this->mailer = new Swift_Mailer($transporter);

    return $this->mailer;
  }

  public function getDomain($email)
  {
    return substr(strrchr($email, "@"), 1);
  }
}
