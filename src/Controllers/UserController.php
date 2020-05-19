<?php

//espacio de controladores
namespace App\Controllers;

//
use App\Models\ORM\Entities\Activation;
use Psr\Container\ContainerInterface as ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Core\Controllers\Controller as Controller;
use App\Models\ORM\Entities\User as User;
use DateTime;

//controlador de inicio
class UserController extends Controller{

  public function __construct(ContainerInterface $container){

    //contenedor
    $this->container=$container;
    //motor de plantilla
    $this->twig=$this->container['twig'];
    //datos globales
    $this->app=$this->container['app'];
    //orm
    $this->entityManager = $this->container['entity-manager'];
    $this->userRepository = $this->entityManager->getRepository(User::class);
    $this->userRepository->setMailer($this->container['mailer']);
    $this->userMailer = $this->userRepository->getUserMailer();
    $this->userValidator = $this->userRepository->getValidator();

  }

  public function signinGet(RequestInterface $request,$response){

    //de existir sesion
    session_start();
    if(isset($_SESSION['user'])){

      //redirigimos a inicio
      return $response->withRedirect($this->app['url'].'/');

    }
    //de no existir sesion
    else{

      //rendereamos formulario login
      $this->twig->render($response,'layouts/user/signin.php',[]);

    }

  }

  public function signinPost(RequestInterface $request, $response){

    //datos de vista vacios por default
    $view=[];

    //obtenemos array de formulario
    $userRequest = $request->getParsedBody();
    
    //de fallar la validacion mostramos errores en el mismo formulario
    if(!$this->userValidator->validateLoginForm($userRequest)){

      //mostramos errores en el formulario
      $view['errors']=$this->userValidator->getValidationErrors();
      $this->twig->render($response,'layouts/user/signin.php',$view);

    }
    else{

      // tomamos de formulario usuario y password
      $nickname = $userRequest['nickname'];
      $password = $userRequest['password'];

      //validamos password 
      switch ($this->userValidator->validatePassword($nickname,$password)) {    

        //en caso de no existir:
        case -1:

          //mostramos errores en el formulario
          $view['errors']=$this->userValidator->getValidationErrors();
          $this->twig->render($response,'layouts/user/signin.php',$view);
          break;

        //en caso de ser invalido el password:
        case 0:

          //mostramos errores en el formulario
          $view['errors']=$this->userValidator->getValidationErrors();
          $this->twig->render($response,'layouts/user/signin.php',$view);
          break;

        //en caso de ser correcto:
        case 1:

          //mandamos llamar usuario en base al nickname
          $user=$this->userRepository->findOneBY(['nickname'=>$userRequest['nickname']]);

          //creamos sesion
          session_start();
          $_SESSION['user'] = $user->getNickname();
          return $response->withRedirect($this->app['url'].'/'); 

      }
      
    }

  }

  public function signupGet(RequestInterface $request, $response){

    //renderizamos el template
    $this->twig->render($response,'layouts/user/signup.php',[]);

  }

  public function signupPost(RequestInterface $request, $response){

    //datos de vista vacios por default
    $view=[];

    //obtenemos array de formulario
    $userRequest = $request->getParsedBody();

    //de fallar la validacion de formulario mostramos errores en el
    if(!$this->userValidator->validateSignupForm($userRequest)){

      //mostramos errores en vista y rendereizamos
      $view['errors']=$this->userValidator->getValidationErrors();
      $this->twig->render($response,'layouts/user/signup.php',$view);

    }
    //de ser exitosa validacion de formulario procedemos a crear entidad
    else{

      $nickname = $userRequest['nickname'];
      $email=$userRequest['email'];
      $password=$userRequest['password'];

      //en caso de existir la entidad
      if($this->userValidator->alreadyExists($nickname,$email)){

        //mostramos errores en vista y rendereizamos
        $view['errors']=$this->userValidator->getValidationErrors();
        $this->twig->render($response,'layouts/user/signup.php',$view);

      }

      //en caso de no existir la entidad guardamos el usuario
      else{

        //creamos entidad
        $user = $this->userRepository->createEntity($nickname,$email,$password);

        //persitimos y ejecutamos, anulamos entidad despues de flush
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        unset($user);

        //creamos usuario a partir de usuario guardado
        $user = $this->userRepository->findOneBy(['email'=>$userRequest]);

        //creamos activacion
        $activation = $this->userRepository->createActivationEntity($user);
        $this->userMailer->sendActivationMail($activation);
        $activation->encryptCode();
        $this->entityManager->persist($activation);
        $this->entityManager->flush();

        //iniciamos sesion
        session_start();
        $_SESSION['user'] = $user->getNickname();

        //redirigimos
        return $response->withRedirect($this->app['url'].'/user/activation');

      }
    }
  }
  public function activationGet(RequestInterface $request, $response){

    //de no existir sesion
    session_start();
    if(!isset($_SESSION['user'])){

      //redirigimos al login
      return $response->withRedirect($this->app['url'].'/user/signin'); 

    }

    //arreglo de contenido de vista vacio
    $view=[];

    //mandamos llamar usuario y lo incluimos en la lista
    $user = $this->userRepository->findOneBy(['nickname'=>$_SESSION['user']]);
    $view['user']=$user;
    $this->twig->render($response,'layouts/user/activation.php',$view);

  }
  public function activationPost(RequestInterface $request, $response){

    //de no existir sesion
    session_start();
    if(!isset($_SESSION['user'])){

      //redirigimos al login
      return $response->withRedirect($this->app['url'].'/user/signin'); 

    }

    //tomamos datos de formulario
    $codeRequest=$request->getParsedBody();

    //arreglo de contenido de vista vacio
    $view=[];

    //validamos formulario
    if(!$this->userValidator->validateCodeForm($codeRequest)){

      //mostramos errores
      $view['errors']=$this->userValidator->getValidationErrors();
      $this->twig->render($response,'layouts/user/activation.php',$view);

    }

    else {

      $code=$codeRequest['code'];
      $nickname['nickname']=$_SESSION['user'];
  
      //de ser invalido el codigo de activacion
      if(!$this->userValidator->validateCode($nickname,$code)){
  
        //mostramos errores
        $view['errors']=$this->userValidator->getValidationErrors();
        $this->twig->render($response,'layouts/user/activation.php',$view);
  
      }
      //de ser valido
      else{
  
        //mandamos llamar usuario
        $user=$this->userRepository->findOneBy(['nickname'=>$_SESSION['user']]);
        $activation = $user->getActivation();
  
        //eliminamos activacion
        $this->entityManager->remove($activation);
        $this->entityManager->flush();
  
        //redireccionamos al index
        return $response->withRedirect($this->app['url'].'/'); 
        
      }

    }

  }
  public function signout(RequestInterface $request, $response){

    //abrimos sesion de existir
    session_start();
    //destruimos sesion
    session_destroy();
    //redirigimos a inicio de sesion
    return $response->withRedirect($this->app['url'].'/user/signin'); 

  }
  
}
?>