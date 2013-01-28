<?php

/**
 * @package cms-catalog
 */
require_once('limb/core/common.inc.php');

lmb_package_require('core', 'limb-cms/');

lmb_package_register('catalog', dirname(__FILE__));

lmb_require("limb-cms/core/src/request/TreeRequestDispatcher.class.php");
lmbCmsRequestDispatchingQueue::add( new TreeRequestDispatcher( 'catalog_category', 'catalog', 'category', 'catalog'), lmbCmsRequestDispatchingQueue::TOP);