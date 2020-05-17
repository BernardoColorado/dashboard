<?php

namespace App\Models\ORM\Validators;

use App\Models\ORM\Entities\User;
use Respect\Validation\Validator as Validator;
use Respect\Validation\Exceptions\NestedValidationException as NestedValidationException;
use Core\Models\ORM\Validators\EntityValidator as EntityValidator;
use Doctrine\ORM\EntityRepository as Repository;

class UserValidator extends EntityValidator{

  protected static $instance=null;
  protected $repository=null;
  protected $errors=[];
  protected $rules=[];

  public function __construct(Repository $repository){

    $this->repository = $repository;
    $this->rules['nickname'] = Validator::alnum()->notEmpty()->noWhitespace();
    $this->rules['password'] = Validator::alnum('@','#','$','*','&','*','-','+')->notEmpty()->noWhitespace();
    $this->rules['email'] = Validator::email()->notEmpty()->noWhitespace();
    $this->rules['code'] = Validator::digit()->notEmpty()->noWhitespace()->length(16,16);

  }

  public static function create($repository):UserValidator
  {
    if(!self::$instance instanceof self){
      self::$instance=new self($repository);
    }
    return self::$instance;
  }

  public function validateLoginForm(array $form):bool
  {

    $validation=true;
    try{
      $this->rules['nickname']->setName('nickname')->assert($form['nickname']);
    }
    catch(NestedValidationException $exception){
      $validation = false;
      $this->errors['nickname']=$exception->getMessages();
    }
    try{
      $this->rules['password']->setName('password')->assert($form['password']);
    }
    catch(NestedValidationException $exception){
      $validation = false;
      $this->errors['password']=$exception->getMessages();
    }
    return $validation;

  }

  public function validateCodeForm(array $form):bool
  {

    $validation=true;

    try{
      $this->rules['code']->setName('code')->assert($form['code']);
    }
    catch(NestedValidationException $exception){
      $validation = false;
      $this->errors['code']=$exception->getMessages();
    }

    return $validation;

  }

  public function validateCode(array $fields):bool
  {

    $code = $fields['code'];
    $nickname = $fields['nickname'];

    $user = $this->repository->findOneBy(['nickname'=>$nickname]);
    $activation = $user->getActivation();

    if($activation->verifyCode($code)){

      return true; 

    }
    else{

      $this->errors['code'][]='invalid code';

      return false;

    }

  }

  public function validateSignupForm(array $form):bool
  {

    $validation=true;
    try{
      $this->rules['nickname']->setName('nickname')->assert($form['nickname']);
    }
    catch(NestedValidationException $exception){
      $validation = false;
      $this->errors['nickname']=$exception->getMessages();
    }
    try{
      $this->rules['password']->setName('password')->assert($form['password']);
    }
    catch(NestedValidationException $exception){
      $validation = false;
      $this->errors['password']=$exception->getMessages();
    }
    try{
      $this->rules['email']->setName('email')->assert($form['email']);
    }
    catch(NestedValidationException $exception){
      $validation = false;
      $this->errors['email']=$exception->getMessages();
    }

    if($form['password']!==$form['password_confirm']){
      $validation=false;
      echo('bad');
      $this->errors['password']='both password and confirmation must be the same';
    }

    return $validation;

  }

  public function validatePassword(array $form):int
  {

    //tomamos nickname y password
    $nickname = $form['nickname'];
    $password = $form['password'];

    //mandamos llamar entidad de usuario
    $user=$this->repository->findOneBy(['nickname'=>$nickname]);

    //de no existir usuario
    if(!isset($user)){

      //guardamos error y regresamos -1
      $this->errors['nickname'][]='user doesnt exists';
      return -1;

    }
    //de existir usuario
    else{

      //de ser invalido el password
      if(!$user->verifyPassword($password)){

        //mostramos error y regregsamos 0
        $this->errors['password'][]='wrong password';
        return 0;

      }
      //de ser correcto el password
      else{

        //regresamos 1
        return 1;

      }

    }

  }
  public function alreadyExists(User $user):bool
  {

    //obtenemos el nickname y el email por separado
    $nickname = $user->getNickname();
    $email = $user->getEmail();

    //pedimos una instancia 
    $nicknameUser = $this->repository->findOneBy(['nickname'=>$nickname]);
    $emailUser = $this->repository->findOneBy(['email'=>$email]);

    //de estar ocupados ambos campos
    if(isset($nicknameUser)&&isset($emailUser)){

      //mostranmos errores de ambos campos e invalidamos
      $this->errors['nickname'][]='nickname already exists';
      $this->errors['email'][]='email already exists';

      return true;

    }
    //de estar ocupado el nickname
    else if(isset($nicknameUser)&&!isset($emailUser)){

      //mostramos error en nickname
      $this->errors['nickname'][]='nickname already exists';
      return true;

    }
    //de estar ocupado el email
    else if(!isset($nicknameUser)&&isset($emailUser)){

      //mostramos error en email
      $this->errors['email'][]='email already exists';
      return true;

    }
    else{

      return false;
      
    }

  }
  public function isActive(User $user):bool
  {

    if($user->getActivation()===null){

      return true;
    }
    else{

      return false;

    }
    
  }
  public function getValidationErrors():array
  {

    return $this->errors;

  }

}