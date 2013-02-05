<?php
lmb_require('limb/constructor/src/lmbModelConstructor.class.php');
lmb_require('limb-cms/constructor/src/ConstructorHelper.class.php');

class TreeModelConstructor extends lmbModelConstructor
{
  protected $_model_template_file = 'tree/model/model.phtml';
  protected $_test_template_file = 'tree/model/test.phtml';

  protected $_model_name;

  function create($vars = null)
  {
    if(empty($vars))
      $vars = array();

    $vars['model_url'] = ConstructorHelper :: detectAttachedImages($this->_table);
    $vars['history_stored_fields'] = ConstructorHelper :: detectHistoryStoredFields($this->_table);
    $vars['attached_images'] = ConstructorHelper :: detectAttachedImages($this->_table);

    if(count($vars['attached_images']))
      $vars['relations_exist'] = true;

    parent :: create($vars);
  }
}