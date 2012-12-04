<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2012 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */

/**
 * @package cms-document
 */
require_once('limb/core/common.inc.php');

lmb_package_require('core', 'limb-cms/');

lmb_package_register('document', dirname(__FILE__));

lmb_require("limb-cms/core/src/request/TreeRequestDispatcher.class.php");
lmbCmsRequestDispatchingQueue::add( new TreeRequestDispatcher('lmb_cms_document', 'document'), lmbCmsRequestDispatchingQueue::TOP);