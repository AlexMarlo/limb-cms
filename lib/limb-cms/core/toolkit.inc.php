<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */

/**
 * @package cms
 * @version $Id: toolkit.inc.php 6598 2007-12-07 08:01:45Z pachanga $
 */
lmb_require('limb/toolkit/src/lmbToolkit.class.php');
lmb_require('limb-cms/core/src/toolkit/lmbCmsTools.class.php');
lmbToolkit :: merge(new lmbCmsTools());

function get_toolkit()
{
  return lmbToolkit::instance();
}