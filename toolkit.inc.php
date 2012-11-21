<?php

require_once('limb/web_app/toolkit.inc.php');
require_once('limb/i18n/toolkit.inc.php');

lmbToolkit::instance()->setSupportedViewTypes(array('.phtml' => 'lmbMacroView'));

require_once('limb-cms/core/src/toolkit/lmbCmsTools.class.php');
lmbToolkit :: merge(new lmbCmsTools());

require_once('limb/acl/src/toolkit/lmbAclTools.class.php');
lmbToolkit :: merge(new lmbAclTools());
