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

    $this->container=$container;
    $this->twig=$this->container['twig'];
    $this->app=$this->container['app'];
    $this->files=$this->container['files'];
    $this->entityManager = $this->container['entity-manager'];
    

  }
  /*******************************/
  /*****Funciones de Controlador**/
  /*******************************/
  public function uploadGet(RequestInterface $request, ResponseInterface $response){

    $this->twig->render($response,'layouts/file/index.php',[]);

  }

  public function uploadPost(RequestInterface $request, ResponseInterface $response){

    $file = $request->getUploadedFiles()['file_upload'];

    $this->twig->render($response,'layouts/file/index.php',[]);

  }

}

?>