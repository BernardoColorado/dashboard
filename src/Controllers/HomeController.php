<?php
//espacio de controladores
namespace App\Controllers;

//
use Psr\Container\ContainerInterface as ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as RequestInterface;
use \Psr\Http\Message\ResponseInterface as ResponseInterface;
use \Core\Controllers\Controller as Controller;
use App\Models\ORM\Entities\User as User;

//controlador de inicio
class HomeController extends Controller{

  public function __construct(ContainerInterface $container){

    //contenedor
    $this->container=$container;
    $this->twig=$this->container['twig'];
    $this->app=$this->container['app'];
    //orm y entidades
    $this->entityManager = $this->container['entity-manager'];
    $this->userRepository = $this->entityManager->getRepository(User::class);
    $this->userValidator = $this->userRepository->getValidator();


  }

  public function index(RequestInterface $request, $response){

    //abrimos sesion de existir y si no redirigimos
    session_start();
    if(!isset($_SESSION['user'])){
      return $response->withRedirect($this->app['url'].'/user/signin');
    }

    //arreglo de datos para vista
    $view=[];

    //mandamos llamar usuario en base a sesion
    $user=$this->userRepository->findOneBY(['nickname'=>$_SESSION['user']]);

    //de tener usario inactivo
    if(!$this->userValidator->isActive($user)){

      //cargamos vista y rendereamos
      $view['user']=$user;
      $this->twig->render($response,'layouts/user/activation.php',$view);

    }
    //de tener usuario activo
    else{

      //cargamos vista y rendereamos
      $view['user']=$user;      
      $this->twig->render($response,'layouts/home/index.php',$view);

    }

  }

  public function info(RequestInterface $request, $response){

    //revisamos que la sesion este activa y de no estar redirigimos a inicio de sesion
    session_start();
    if(!isset($_SESSION['user'])){
      return $response->withRedirect($this->app['url'].'/user/signin');
    }

    //arreglo de datos para vista
    $view=[];

    //mandamos llamar usuario en base a sesion
    $user=$this->userRepository->findOneBY(['nickname'=>$_SESSION['user']]);

    //de tener el usuario inactivo
    if(!$this->userValidator->isActive($user)){

      //cargamos vista
      $view['user']=$user;
      $this->twig->render($response,'layouts/user/activation.php',$view);

    }
    //de tener un usuario activo
    else{

      //informacion en base a funcion info.php
      echo('<a href = "'.$this->app['url'].'" >RETURN</a>');
      echo('<br/>');
      phpinfo();
    
    }

  }
  
}

?>