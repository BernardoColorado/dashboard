<?php 

namespace Core\Tools;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailBuilder{

  protected $mail;
  protected $adress;
  protected $password;
  protected $alias;
  protected $receivers =[];
  protected $withCopy=[];
  protected $withHiddenCopy=[];
  protected $files = [];
  protected $subject;
  protected $dir;
  protected $errors=[];

  /**
   * @param string $adress
   * @param string $password
   * @param string $alias
   * @param string $dir
   */
  public function __construct(string $adress,string $password,string $alias, string $dir=null){

    $this->mail = new PHPMailer(true);
    $this->adress=$adress;
    $this->password=$password;
    $this->alias=$alias;
    $this->dir=$dir;
    
  }
  /**
   * @param array $receivers
   * @param array $withCopy
   * @param array $withHiddenCopy
   */
  public function setReceivers(array $receivers,array $withCopy=[],array $withHiddenCopy=[]){

    $this->receivers=$receivers;
    $this->withCopy=$withCopy;
    $this->withHiddenCopy=$withHiddenCopy;

  }
  /**
   * @param array $files
   */
  public function setFiles(array $files=[]){

    $this->files=$files;

  }
  /**
   * @param string $subject
   */
  public function setSubject(string $subject){

    $this->subject=$subject;

  }
  /**
   * @param string $message
   */
  public function setMessage(string $message){

    $this->message=$message;

  }
  /**
   * @return bool
   */
  public function send():bool
  {

    try {
      //configuracion de email
      $this->mail->SMTPDebug = 0;                                       
      $this->mail->isSMTP();                                           
      $this->mail->Host       = 'smtp.gmail.com';
      $this->mail->SMTPAuth   = true;                  
      $this->mail->Username   = $this->adress;
      $this->mail->Password   = $this->password;
      $this->mail->SMTPSecure = 'ttl';
      $this->mail->Port       = 587;
      $this->mail->setFrom($this->adress,$this->alias);
      //agregamos receptores
      foreach ($this->receivers as $receiver) {
        $this->mail->addAddress($receiver);    
      }
      //agregamos con copia
      foreach ($this->withCopy as $wc) {
        $this->mail->addCC($wc);    
      }
      //agregamos copia oculta
      foreach ($this->withHiddenCopy as $whc) {
        $this->mail->addBCC($whc);    
      }
      //agregamos archivos
      foreach ($this->files as $file) {

        $this->mail->addAttachment($this->dir.'/'.strval($file)); 

      }
      //configuracion de mensaje
      $this->mail->isHTML(true);
      $this->mail->Subject = $this->subject;
      $this->mail->Body    = $this->message;
      $this->mail->AltBody = 'default';
      $this->mail->send();

    } 
    catch (Exception $e) {

        $this->errors['error']=$this->mail->ErrorInfo;
        $this->errors['exception']=$e;
        return false;
    }

    return true;

  }
  /**
   * @return array
   */
  public function getErrors():array
  {
    return $this->errors;
  }

}