<?php

namespace App\Models\ORM\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="resets")
 */
class Reset{
  /** 
   * @ORM\Id
   * @ORM\Column(type="integer", name="id")
   * @ORM\GeneratedValue
   */
  protected $id;
  /** 
   * @ORM\Column(type="string", length=256, name="code") 
   */
  protected $code;
  /**
   * @ORM\OneToOne(targetEntity="User",inversedBy="reset")
   * @ORM\JoinColumn(name="user_id",referencedColumnName="id", onDelete="CASCADE")
   */
  protected $user;

  public function __construct(User $user)
  {
    $this->user=$user;
    $this->generateCode();
  }
  public function getId():?int
  {
    return $this->id;
  }
  public function setId(int $id)
  {
    $this->id=$id;
  }
  public function compareCode(string $code):bool
  {
    return password_verify($this->code,$code);
  }
  public function encryptCode(){

    $this->code = password_hash($this->code,PASSWORD_BCRYPT,['cost'=>10]);

  }
  public function generateCode()
  {
    $code = '';
    for($i = 0; $i<16; $i++){
      $number = rand(0,9);
      $digit = strval($number);
      $code.=$digit;
    }
    $this->code = $code;
  }
  public function getUser():?User{

    return $this->user;

  }
  public function getCode(){

    return $this->code;
    
  }
  public function verifyCode($code):bool
  {

    return password_verify($code,$this->code);

  }

}