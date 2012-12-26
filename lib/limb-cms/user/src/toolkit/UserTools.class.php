<?php
lmb_require('limb/toolkit/src/lmbAbstractTools.class.php');

class UserTools extends lmbAbstractTools
{
  protected $user;

  function getUser()
  {
    return lmbToolkit::instance()->getVisitorUser('User');
  }
  
  function resetUser()
  {
    lmbToolkit::instance()->reserVisitorUser('User');
  }
  
  function setUser($user)
  {
    lmbToolkit::instance()->setVisitorUser($user);
  }
}
