<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2012 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */

date_default_timezone_set('Europe/Moscow');

set_include_path(implode(PATH_SEPARATOR,
  array(
    dirname(__FILE__),
    dirname(__FILE__) . '/lib/',
    get_include_path()
  )
));

require_once('limb/core/common.inc.php');

lmb_app_mode(LIMB_APP_PRODUCTION);

if(file_exists(dirname(__FILE__) . '/setup.override.php'))
  require_once(dirname(__FILE__) . '/setup.override.php');

lmb_env_setor('CMS_DIR', dirname(__FILE__));
lmb_env_setor('LIMB_VAR_DIR', CMS_DIR . '/var/');

//lmb_env_set('LIMB_CMS_PACKAGES_DIR', CMS_DIR . "/modules/;" . CMS_DIR . "/limb-cms/");

lmb_package_require('core', 'limb-cms');

lmb_cms_load_packages('modules');
lmb_cms_load_packages('limb-cms');

require_once('common.inc.php');