<?php

namespace App\Models\ORM\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Models\ORM\Repositories\UserRepository")
 * @ORM\Table(name="users")
 */
class User{
  /** 
   * @ORM\Id
   * @ORM\Column(type="integer", name="id")
   * @ORM\GeneratedValue
   */
  protected $id;
  /** 
   * @ORM\Column(type="string", length=64, name="nickname", unique=true) 
   */
  protected $nickname;
  /** 
   * @ORM\Column(type="string", length=256, name="password") 
   */
  protected $password;
  /** 
   * @ORM\Column(type="string", length=256, name="email", unique=true)
   */
  protected $email;
  /**
   * @ORM\Column(name="created_at", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
   */
  protected $createdAt;
  /**
   * @ORM\OneToOne(targetEntity="Activation", mappedBy="user")
   */ 
  protected $activation;
    /**
   * @ORM\OneToOne(targetEntity="Reset", mappedBy="user")
   */ 
  protected $reset;

  public function __construct(string $nickname=null,string $password=null,string $email=null)
  {
    $this->nickname=$nickname;
    $this->password=password_hash($password,PASSWORD_BCRYPT,['cost'=>10]);
    $this->email=$email;
    $this->createdAt=new DateTime;
  }

  public function getId():?int
  {
    return $this->id;
  }
  public function setId(int $id)
  {
    $this->id=$id;
  }
  public function getNickname():?string
  {
    return $this->nickname;
  }
  public function setNickname(string $nickname)
  {
    $this->nickname=$nickname;
  }
  public function verifyPassword($password):?bool
  {
    return password_verify($password,$this->password);
  }
  public function setPassword(string $password)
  {
    $this->password=password_hash($password,PASSWORD_BCRYPT,['cost'=>10]);
  }
  public function setCreatedAt(DateTime $createdAt)
  {
    $this->createdAt=$createdAt;
  }
  public function getCreatedAt():?DateTime
  {
    return $this->createdAt;
  }
  public function setEmail(string $email)
  {
    $this->email=$email;
  }
  public function getEmail():?string
  {
    return $this->email;
  }
  public function getActivation():?Activation
  {
    return $this->activation;
  }

}