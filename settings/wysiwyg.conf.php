<?php

$conf = array(
  'default_profile' => 'cms_document',

  'enabled' => true,

  'cms_document' => array(
    'type' => 'fckeditor',    
    'Config' => array('CustomConfigurationsPath' => '/shared/cms/js/fckconfig.js?' . lmbToolkit::instance()->getConf('common')->get('static_files_version')),
    'ToolbarSet' => 'cms_document'
  ),
  
  'simple' => array(
    'type' => 'fckeditor',
    'Config' => array('CustomConfigurationsPath' => '/shared/cms/js/fckconfig.js?' . lmbToolkit::instance()->getConf('common')->get('static_files_version')),
    'ToolbarSet' => 'Basic'
  ),
  
);