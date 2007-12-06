<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com 
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html 
 */

/**
 * class lmbMacroTextNode.
 *
 * @package macro
 * @version $Id$
 */
class lmbMacroTextNode extends lmbMacroNode
{
  protected $contents;

  function __construct($location, $text)
  {
    parent :: __construct($location);
    $this->contents = $text;
  }

  function generate($code_writer)
  {
    $code_writer->writeHtml($this->contents);
    parent :: generate($code_writer);
  }

  function getText()
  {
    return $this->contents;
  }
}

