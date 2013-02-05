<?php
lmb_require('limb/constructor/src/lmbAdminTemplatesConstructor.class.php');
lmb_require('limb-cms/constructor/src/FormConstructorHelper.class.php');

class AdminTemplatesConstructor extends lmbAdminTemplatesConstructor
{
  protected $_meta_fields = array('ctime', 'utime', 'kind', 'create_ip', 'is_published');

  protected $_not_displayed_fields = array('is_published', 'reverse_id');

  protected $_admin_templates_for_templates_path = 'plain/admin/templates/';

  protected function _getColumnsForDisplay()
  {
    $columns_for_display = array();
    foreach($this->_table->getColumns() as $column)
    {
      if
      ( ( $column->getType() === lmbDbTypeInfo::TYPE_CLOB) ||
        ( ($column->getType() === lmbDbTypeInfo::TYPE_CHAR || $column->getType() === lmbDbTypeInfo::TYPE_VARCHAR) &&
          (255 < $column->getSize() || strstr($column->getName(), '_ext')) ) ||
        ( in_array($column->getName(), $this->_not_displayed_fields) )
      )
      {
        continue;
      }

      $columns_for_display[] = $column;
    }

    return $columns_for_display;
  }

  protected function _getFieldsForDisplay($columns_for_display)
  {
    $fields_for_display = array();
    $this->_apply_publish_templates = '';

    foreach($columns_for_display as $column)
    {
      $column_name = $column->getName();

      if( $column->getType() === lmbDbTypeInfo::TYPE_BIT ||
          $column->getType() === lmbDbTypeInfo::TYPE_BOOLEAN ||
          $column->getType() === lmbDbTypeInfo::TYPE_SMALLINT
      )
      {
        $fields_for_display[$column_name] =
          "<? if(\$item->get('" . $column_name . "')) { ?>" .
            "<img src='/shared/base/images/icons/flag_yellow.png' title='true' />" .
          "<? } else { ?>" .
            "<img src='/shared/base/images/icons/flag_red.png' title='false' />" .
          "<? } ?>";
      }

      else if('create_ip' == $column_name)
        $fields_for_display[$column_name] = '[$item.' . $column_name . '|decode_ip]';

      else if(strstr($column_name, 'time') || strstr($column_name, 'date'))
        $fields_for_display[$column_name] = '[$item.' . $column_name . '|date:"d.m.Y H:i:s"]';

      else if('priority' == $column_name)
        $fields_for_display[$column_name] = '[[apply template="object_priority_input" item="[$item]" /]]';

      else
        $fields_for_display[$column_name] = '[$item.' . $column_name . ']';
    }

    return $fields_for_display;
  }

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

    $content = $this->_createContentFromTemplate($this->_admin_templates_for_templates_path . 'create.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('create.phtml'), $content);

    $content = $this->_createContentFromTemplate($this->_admin_templates_for_templates_path . 'edit.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('edit.phtml'), $content);

    $content = $this->_createContentFromTemplate($this->_admin_templates_for_templates_path . 'form_fields.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('form_fields.phtml'), $content);
  }
}