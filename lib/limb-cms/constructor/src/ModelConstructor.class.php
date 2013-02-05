<?php
lmb_require('limb/constructor/src/lmbModelConstructor.class.php');
lmb_require('limb-cms/constructor/src/ConstructorHelper.class.php');

class ModelConstructor extends lmbModelConstructor
{
  protected $_model_template_file = 'plain/model/model.phtml';
  protected $_test_template_file = 'plain/model/test.phtml';

  protected $_model_name;

  function create($vars = null)
  {
    if(empty($vars))
      $vars = array();

    $vars['history_stored_fields'] = ConstructorHelper :: detectHistoryStoredFields($this->_table);
    $vars['attached_images'] = ConstructorHelper :: detectAttachedImages($this->_table);
    $vars['default_sort_params'] = ConstructorHelper :: detectDefaultSortParams($this->_table);
    $vars['priority_exist'] = in_array('priority', array_keys($this->_table->getColumns()));

    if(count($vars['attached_images']))
      $vars['relations_exist'] = true;

    parent :: create($vars);
  }
}