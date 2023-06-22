<?php

class users
{
  #VARIABLES
  public $id_usr;
  public $name_usr;
  public $surnames;
  public $email;
  public $password;
  public $created_at;


  #CONSTRUCTOR
  public function __construct($name_usr, $surnames, $email, $password, $created_at)
  {
    
    $this->name_usr = $name_usr;
    $this->surnames = $surnames;
    $this->email = $email;
    $this->password = $password;
    $this->created_at = $created_at;
  }

  #GETTERS
  public function getName()
  {
    return $this->name_usr;
  }

  public function getSurnames()
  {
    return $this->surnames;
  }

  public function getEmail()
  {
    return $this->email;
  }
  public function getPassword()
  {
    return $this->password;
  }

  #SETTERS
  public function set_name($name_usr)
  {
    $this->name_usr = $name_usr;
  }

  public function set_surnames($surnames)
  {
    $this->surnames = $surnames;
  }

  public function set_email($email)
  {
    $this->email = $email;
  }

  public function set_password($password)
  {
    $this->password = $password;
  }

}
?>