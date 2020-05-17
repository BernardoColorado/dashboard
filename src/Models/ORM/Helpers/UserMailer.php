<?php

//
namespace App\Models\ORM\Helpers;

//
use App\Models\ORM\Entities\Activation;
use Core\Tools\MailBuilder;

class UserMailer{

  public function __construct(MailBuilder $mailer)
  {
    $this->mailer = $mailer;
  }
  public function sendActivationMail(Activation $activation){

    $user = $activation->getUser();
    $mail = $user->getEmail();
    $code = $activation->getCode();
    $this->mailer->setReceivers([$mail]);
    $this->mailer->setSubject('ACTIVATION CODE');
    $this->mailer->setMessage('<p> your activation code is '.$code.' </p>');
    $this->mailer->send();

  }

}