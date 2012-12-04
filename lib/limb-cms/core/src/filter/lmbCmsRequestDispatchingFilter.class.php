<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
lmb_require('limb/web_app/src/filter/lmbRequestDispatchingFilter.class.php');
lmb_require('limb/web_app/src/request/lmbCompositeRequestDispatcher.class.php');

/**
 * class lmbCmsRequestDispatchingFilter.
 *
 * @package cms
 * @version $Id$
 */
class lmbCmsRequestDispatchingFilter extends lmbRequestDispatchingFilter
{
  function __construct($default_controller_name = 'not_found')
  {
    $dispatcher = new lmbCompositeRequestDispatcher();
    
    $dispatcherQueue = lmbCmsRequestDispatchingQueue::getQueue();
    
    foreach( $dispatcherQueue as $subDispatcher)
      $dispatcher->addDispatcher( $subDispatcher);

    parent :: __construct($dispatcher, $default_controller_name);
  }
}


