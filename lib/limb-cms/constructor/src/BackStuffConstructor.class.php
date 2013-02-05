<?php
lmb_require('limb/constructor/src/lmbAbstractConstructor.class.php');
lmb_require('limb-cms/constructor/src/ConstructorHelper.class.php');
lmb_require('limb-cms/constructor/src/FormConstructorHelper.class.php');

class BackStuffConstructor extends lmbAbstractConstructor
{
  protected $_back_stuff_controller_template = 'plain/back/controller.phtml';
  protected $_back_stuff_templates_for_templates_dir = 'plain/back/templates/';

  protected $_model_name;

  protected $_meta_fields = array('ctime', 'utime', 'kind', 'create_ip', 'is_published');

  /**
   * @param lmbProjectConstructor $project
   * @param lmbDbInfo $database_info
   * @param lmbDbTableInfo $table
   * @param string $model_name
   */
  function __construct($project, $database_info, $table, $model_name = null, $templates_dir = null)
  {
    parent::__construct($project, $database_info, $table, $templates_dir);

    if(is_null($model_name))
      $model_name = lmb_camel_case($table->getName());

    $this->_model_name = $model_name;
  }

  function getControllerFileName()
  {
    return 'User' . $this->_model_name . 'Controller.class.php';
  }

  protected function _getResultTemplatePath($name)
  {
    return 'user_' . lmb_under_scores($this->_model_name) . '/' . $name;
  }

  function create()
  {
    $columns = $this->_table->getColumns();
    $form_constructor = new FormConstructorHelper($columns);

    $vars = array(
      'model_name' => $this->_model_name,
      'model_url' => lmb_under_scores($this->_model_name),
      'columns' => $columns,
      'column_names' => array_diff($form_constructor->getColumnsNames(), $this->_meta_fields),
      'form_fields' => $form_constructor->createFormFields($columns),
      'attached_images' => ConstructorHelper :: detectAttachedImages($this->_table),
    );

    $content = $this->_createContentFromTemplate($this->_back_stuff_controller_template, $vars);
    $this->_project->addController($this->getControllerFileName(), $content);

    $content = $this->_createContentFromTemplate($this->_back_stuff_templates_for_templates_dir . 'display.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('display.phtml'), $content);

    $content = $this->_createContentFromTemplate($this->_back_stuff_templates_for_templates_dir . 'create.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('create.phtml'), $content);

    $content = $this->_createContentFromTemplate($this->_back_stuff_templates_for_templates_dir . 'edit.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('edit.phtml'), $content);

    $content = $this->_createContentFromTemplate($this->_back_stuff_templates_for_templates_dir . 'form_fields.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('form_fields.phtml'), $content);
  }
}