<?php
//espacio de controladores
namespace App\Controllers;
//interfaz para contenedor de dependencias
use Psr\Container\ContainerInterface as ContainerInterface;
//mandamos llamar al controlador abstracto
use \Psr\Http\Message\ServerRequestInterface as RequestInterface;
use \Psr\Http\Message\ResponseInterface as ResponseInterface;
use \Core\Controllers\Controller as Controller;


//controlador de inicio
class FileController extends Controller{
  /**********************************************/
  /*****Funciones de Intanciacion y constructor**/
  /**********************************************/
  public function __construct(ContainerInterface $container){

    //contenedor de dependencias
    $this->container=$container;
    //motor de plantillas
    $this->twig=$this->container['twig'];
    //variables de app
    $this->app=$this->container['app'];
    //ruta de archivos
    $this->files=$this->container['files'];
    //orm y entidades
    $this->entityManager = $this->container['entity-manager'];
    

  }
  /*******************************/
  /*****Funciones de Controlador**/
  /*******************************/
  public function uploadGet(RequestInterface $request,$response){

    //abrimos sesion de existir y si no redirigimos
    session_start();
    if(!isset($_SESSION['user'])){
      return $response->withRedirect($this->app['url'].'/user/signin');
    }
    
    //arreglo de datos para vista
    $view=[];

    //mandamos llamar usuario en base a sesion
    $user=$this->userRepository->findOneBY(['nickname'=>$_SESSION['user']]);

    //rendereamos formulario
    $view['user']=$user;
    $view['app']=$this->app;
    $this->twig->render($response,'layouts/file/index.php',$view);

  }

  public function uploadPost(RequestInterface $request,$response){
    
    
    //abrimos sesion de existir y si no redirigimos
    session_start();
    if(!isset($_SESSION['user'])){
      return $response->withRedirect($this->app['url'].'/user/signin');
    }
    
    //arreglo de datos para vista
    $view=[];

    //mandamos llamar usuario en base a sesion
    $user=$this->userRepository->findOneBY(['nickname'=>$_SESSION['user']]);

    //rendereamos
    $view['user']=$user;
    $view['app']=$this->app;
    $this->twig->render($response,'layouts/file/index.php',$view);

  }

}

?>