<?php

// * Template files priority search
//lmb_env_setor('LIMB_TEMPLATES_INCLUDE_PATH', 'template;modules/*/template;limb-cms/*/template;limb/*/template');

// * Settings file priority search
lmbToolkit :: instance()->setConfIncludePath('settings;modules/*/settings;limb-cms/*/settings;limb/*/settings');

// * Translation files priority search
lmb_env_setor( 'LIMB_TRANSLATIONS_INCLUDE_PATH', 'i18n/translations;modules/*/i18n/translations;limb-cms/*/i18n/translations;limb/*/i18n/translations');

require_once('limb/core/common.inc.php');
lmb_require('limb/web_app/common.inc.php');

// * Model files pre include priority
lmb_require(dirname(__FILE__) . '/src/model/*.interface.php');
lmb_require(dirname(__FILE__) . '/src/model/*.class.php');
lmb_require(dirname(__FILE__) . '/modules/*/src/model/*.interface.php');
lmb_require(dirname(__FILE__) . '/modules/*/src/model/*.class.php');
lmb_require(dirname(__FILE__) . '/lib/limb-cms/*/src/model/*.interface.php');
lmb_require(dirname(__FILE__) . '/lib/limb-cms/*/src/model/*.class.php');

lmb_require('limb/web_app/src/controller/lmbController.class.php');
lmb_require('limb/fs/src/lmbFs.class.php');

lmb_require('limb/i18n/src/charset/driver.inc.php');
lmb_require('limb/i18n/utf8.inc.php');