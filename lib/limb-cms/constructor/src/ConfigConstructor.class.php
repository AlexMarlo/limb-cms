<?php
lmb_require('limb/constructor/src/lmbConfigConstructor.class.php');
lmb_require('limb-cms/constructor/src/ConstructorHelper.class.php');

class ConfigConstructor extends lmbConfigConstructor
{
  protected $_config_template_file = 'settings/config.phtml';

  protected $_model_name;

  function create()
  {
    $can_be_created = false;

    $vars = array();
    $vars['table_name'] = $this->_table->getName();

    $vars['attached_images'] = ConstructorHelper :: detectAttachedImages($this->_table);
    if(count($vars['attached_images']))
      $can_be_created = true;

    if(!$can_be_created)
      return;

    $config_content = $this->_createContentFromTemplate($this->_config_template_file, $vars);
    $this->_project->addConfig($this->getConfigFileName(), $config_content);
  }
}
