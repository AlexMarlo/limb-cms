<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2012 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */
class lmbWysiwygTools extends lmbAbstractTools
{
  function isWysiwygFileUploaderEnabled()
  {
    lmbToolkit :: instance()->getSession()->start();
    if( !lmbToolkit::instance()->getCmsUser()->isLoggedIn())
      return false;

    $enabled = lmbToolkit::instance()->getConf('wysiwyg')->get('enabled');
    return $enabled;
  }
}