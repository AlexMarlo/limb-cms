<?php
lmb_require('limb-cms/constructor/src/AdminTemplatesConstructor.class.php');
lmb_require('limb-cms/constructor/src/FormConstructorHelper.class.php');

class TreeAdminTemplatesConstructor extends AdminTemplatesConstructor
{
  protected $_meta_fields = array('ctime', 'utime', 'kind', 'create_ip', 'is_published', 'priority', 'level', 'path');

  protected $_not_displayed_fields = array('is_published', 'reverse_id', 'priority', 'level', 'path');

  protected $_admin_templates_for_templates_path = 'tree/admin/templates/';

  function create()
  {
    $columns = $this->_table->getColumns();
    $columns_for_display = $this->_getColumnsForDisplay();

    $form_constructor = new FormConstructorHelper($columns);

    $vars = array(
      'model_name' => $this->_model_name,
      'model_url' => lmb_under_scores($this->_model_name),
      'columns' => $columns_for_display,
      'column_names' => array_diff($form_constructor->getColumnsNames(), $this->_meta_fields),
      'form_fields' => $form_constructor->createFormFields($columns),
      'fields_for_display' => $this->_getFieldsForDisplay($columns_for_display),
      'apply_publish_templates' => $this->_apply_publish_templates,
      'published_exist' => in_array('is_published', array_keys($this->_table->getColumns())),
      'attached_images' => ConstructorHelper :: detectAttachedImages($this->_table),
      'history_exist' => ConstructorHelper :: detectHistoryExists($this->_table),
      'priority_exist' => in_array('priority', array_keys($this->_table->getColumns())),
    );

    $content = $this->_createContentFromTemplate($this->_admin_templates_for_templates_path . 'display.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('display.phtml'), $content);

    $content = $this->_createContentFromTemplate($this->_admin_templates_for_templates_path . 'items_list.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('items_list.phtml'), $content);

    $content = $this->_createContentFromTemplate($this->_admin_templates_for_templates_path . 'create.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('create.phtml'), $content);

    $content = $this->_createContentFromTemplate($this->_admin_templates_for_templates_path . 'edit.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('edit.phtml'), $content);

    $content = $this->_createContentFromTemplate($this->_admin_templates_for_templates_path . 'form_fields.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('form_fields.phtml'), $content);
  }
}