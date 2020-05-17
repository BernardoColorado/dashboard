<?php

namespace App\Models\ORM\Repositories;

use App\Models\ORM\Entities\Activation;
use App\Models\ORM\Entities\User as User;
use App\Models\ORM\Helpers\UserMailer;
use App\Models\ORM\Validators\UserValidator;
use Core\Tools\MailBuilder;
use DateTime;
use Doctrine\ORM\EntityRepository as Repository;

class UserRepository extends Repository{

  protected $mailer;

  public function createEntity(string $nickname=null,string $password=null,string $email=null):User
  {
    return new User($nickname,$password,$email);
  }
  //
  public function setMailer(MailBuilder $mailer){

    $this->mailer=$mailer;

  }
  //
  public function getValidator():UserValidator
  {
    return  UserValidator::create($this);
  }
  //
  public function createActivationEntity(User $user){

    return new Activation($user);

  }
  //
  public function getUserMailer(){

    return new UserMailer($this->mailer);

  }

}
