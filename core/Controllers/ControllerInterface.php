<?php
//
namespace Core\Controllers;
use Psr\Container\ContainerInterface as ContainerInterface;
//
interface ControllerInterface{
  
  //construction using dependency inyection
  public function __construct(ContainerInterface $container);

}