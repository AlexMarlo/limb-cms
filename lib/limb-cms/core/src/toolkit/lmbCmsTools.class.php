<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
lmb_require('limb/toolkit/src/lmbAbstractTools.class.php');
lmb_require('limb/tree/src/lmbMPTree.class.php');
lmb_require('limb-cms/core/src/model/lmbCmsSessionUser.class.php');

/**
 * class lmbCmsTools.
 *
 * @package cms
 * @version $Id: lmbCmsTools.class.php 7619 2009-02-10 15:07:35Z step $
 */
class lmbCmsTools extends lmbAbstractTools
{
  protected $tree;
  protected $user;
  protected $visitor;
  protected $html_sanitizer;
  protected $mailer_conf;
  
  protected function _getVisitorObjectName($user_class_name)
  {
    return 'Visitor' . $user_class_name;
  }
  
  function getVisitor($user_class_name)
  {
    $session = lmbToolkit::instance()->getSession();
  
    if(!$this->visitor = $session->get($this->_getVisitorObjectName($user_class_name)))
      $this->visitor = new Visitor($user_class_name);
  
    $session->set($this->_getVisitorObjectName($user_class_name), $this->visitor);
  
    return $this->visitor;
  }
  
  function getVisitorUser($user_class_name)
  {
    try
    {
      $user = lmbToolkit::instance()->getVisitor($user_class_name)->getUser();
      return $user;
    }
    catch(lmbARNotFoundException $e)
    {
      $this->resetVisitorUser($user_class_name);
      return null;
    }
  }
  
  function resetVisitorUser($user_class_name)
  {
    $session = lmbToolkit :: instance()->getSession();
    $session->destroy($this->_getVisitorObjectName($user_class_name));
  }
  
  function setVisitorUser($user)
  {
    $visitor = $this->getVisitor(get_class($user));
    $visitor->setUser($user);
  
    lmbToolkit::instance()->getSession()->set($this->_getVisitorObjectName(get_class($user)), $visitor);
  }

  function getCmsTree($tree_name = 'node')
  {
    if(isset($this->tree[$tree_name]) && is_object($this->tree[$tree_name]))
      return $this->tree[$tree_name];

    $this->tree[$tree_name] = new lmbMPTree($tree_name);

    return $this->tree[$tree_name];
  }

  function setCmsTree($tree)
  {
    $this->tree = $tree;
  }

  function getCmsUser()
  {
    if(is_object($this->user))
      return $this->user;

    $session = lmbToolkit :: instance()->getSession();
    if(!is_object($session_user = $session->get('lmbCmsSessionUser')))
    {
      $session_user = new lmbCmsSessionUser();
      $session->set('lmbCmsSessionUser', $session_user);
    }

    $this->user = $session_user->getUser();

    return $this->user;
  }

  function resetCmsUser()
  {
    $this->setCmsUser(null);
    $session = lmbToolkit :: instance()->getSession();
    $session->destroy('lmbCmsSessionUser');
  }

  function setCmsUser($user)
  {
    $this->user = $user;
  }
  
  function isWysiwygFileUploaderEnabled()
  { 
    lmbToolkit :: instance()->getSession()->start();
    return lmbToolkit::instance()->getCmsUser()->isLoggedIn();    
  }

  function getMailConf()
  {
    if(!is_object($this->mailer_conf))
      $this->mailer_conf = lmbToolkit::instance()->getConf('mail');

    return $this->mailer_conf;
  }
  
  function getObjectClassName( $controller_name = null)
  {
    if( $controller_name == null)
      $controller_name = lmbToolkit::instance()->getDispatchedController()->getName();

    $controller =  lmb_camel_case( $controller_name) . 'Controller';
    $controller_info = new $controller();
    $object_class_name =  $controller_info->getObjectClassName();
    return $object_class_name;
  }
}


