<?php

namespace App\Models\ORM\Validators;

use App\Models\ORM\Entities\User;
use Respect\Validation\Validator as Validator;
use Respect\Validation\Exceptions\NestedValidationException as NestedValidationException;
use Core\Models\ORM\Validators\EntityValidator as EntityValidator;
use Doctrine\ORM\EntityRepository as Repository;

class UserValidator extends EntityValidator{

  //instancia unica
  protected static $instance=null;
  //repositorio anidado
  protected $repository=null;
  //errores
  protected $errors=[];
  //reglas de validacion
  protected $rules=[];

  public function __construct(Repository $repository){

    //instanciamos repositorio
    $this->repository = $repository;
    //reglas de validacion
    $this->rules['nickname'] = Validator::alnum()->notEmpty()->noWhitespace();
    $this->rules['password'] = Validator::alnum('@','#','$','*','&','*','-','+')->notEmpty()->noWhitespace();
    $this->rules['email'] = Validator::email()->notEmpty()->noWhitespace();
    $this->rules['code'] = Validator::digit()->notEmpty()->noWhitespace()->length(16,16);

  }

  public static function create($repository):UserValidator
  {
    //de no existir instancia la creamos
    if(!self::$instance instanceof self){
      self::$instance=new self($repository);
    }
    //regresamos instancia unica
    return self::$instance;
  }

  public function validateLoginForm(array $form):bool
  {

    //validamos al inicio
    $validation=true;

    //validamos reglas
    //en caso de fallar validacion:
    //invalidamos todo el formulario
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

    //valido al inicio
    $validation=true;

    //validamos reglas
    //en caso de fallar validacion:
    //invalidamos todo el formulario
    try{
      $this->rules['code']->setName('code')->assert($form['code']);
    }
    catch(NestedValidationException $exception){
      $validation = false;
      $this->errors['code']=$exception->getMessages();
    }

    return $validation;

  }

  public function validateCode(string $nickname, string $code):bool
  {

    //mandamos llamar entidades
    $user = $this->repository->findOneBy(['nickname'=>$nickname]);
    $activation = $user->getActivation();

    //en caso de ser valido el codigo
    if($activation->verifyCode($code)){

      //validamos
      return true; 

    }
    //en caso de ser invalido el codigo
    else{

      //invalidamos y guardamos error
      $this->errors['code'][]='invalid code';
      return false;

    }

  }

  public function validateSignupForm(array $form):bool
  {

    //valido al inicio
    $validation=true;
    
    //validamos regla de cada campo del formulario:
    //en caso de fallar invalidamos formulario y mostramos errores
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
    //regresamos validacion
    return $validation;

  }

  public function validatePassword(string $nickname,string $password):int
  {

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
  public function alreadyExists(string $nickname,string $email):bool
  {

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
    //en caso de no existir ninguna
    else{

      //regresamos que no existe
      return false;
      
    }

  }
  public function isActive(User $user):bool
  {

    //de no existir activacion pendiente
    if($user->getActivation()===null){

      //validamos
      return true;
    }
    //de existir validacion pendiente
    else{

      //invalidamos
      return false;

    }
    
  }
  public function getValidationErrors():array
  {

    //mostramos errores guardados
    return $this->errors;

  }

}