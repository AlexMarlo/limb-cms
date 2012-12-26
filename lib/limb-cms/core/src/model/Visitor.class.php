<?php
lmb_require('limb/core/src/lmbObject.class.php');

class Visitor extends lmbObject
{
  protected $user_id;
  protected $user_class_name;
  
  protected $user;
  protected $is_logged_in;
  
  function __construct($user_class_name)
  {
    parent :: __construct();
    $this->user_class_name = $user_class_name;
  } 

  function getUser()
  {
    if(is_object($this->user))
      return $this->user;

    if($this->_isValid())
    {
      $this->user = lmbActiveRecord :: findById($this->user_class_name, $this->user_id);
      $this->user->setLoggedIn($this->is_logged_in);
    }
    else
      $this->user = new $this->user_class_name();

    return $this->user;
  }

  function setUser($user)
  {
    $this->user = $user;
  }

  protected function _isValid()
  {
    return is_integer($this->user_id);
  }

  function __sleep()
  {
    $user = $this->getUser();
    $this->user_id = $user->id;
    $this->user_class_name = get_class($user);
    $this->is_logged_in = $user->isLoggedIn();
    
    return array('user_id', 'user_class_name', 'is_logged_in');
  }
}
