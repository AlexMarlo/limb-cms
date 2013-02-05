<?php
lmb_require('limb/constructor/src/lmbAdminControllerConstructor.class.php');
lmb_require('limb-cms/constructor/src/ConstructorHelper.class.php');
lmb_require('limb-cms/base/src/model/Module.class.php');

class AdminControllerConstructor extends lmbAdminControllerConstructor
{
  protected $_admin_controller_template_file = 'plain/admin/controller.phtml';

  protected $_model_name;

  function create()
  {
    $vars = array(
      'model_name' => $this->_model_name,
      'default_sort_params' => ConstructorHelper :: detectDefaultSortParams($this->_table),
      'history_exists' => ConstructorHelper :: detectHistoryExists($this->_table),
      'attached_images' => ConstructorHelper :: detectAttachedImages($this->_table),
    );
    $content = $this->_createContentFromTemplate($this->_admin_controller_template_file, $vars);
    $this->_project->addController($this->getControllerFileName(), $content);

    ConstructorHelper :: addCpModule($this->_model_name, $this->_project->getProjectDir());
  }
}