<?php
lmb_require('limb/constructor/src/lmbFrontStuffConstructor.class.php');

class FrontStuffConstructor extends lmbFrontStuffConstructor
{  
  protected $_front_stuff_controller_template = 'plain/front/controller.phtml';
  protected $_front_stuff_finder_template = 'plain/front/finder.phtml';
  protected $_front_stuff_templates_for_templates_dir = 'plain/front/templates/';

  protected $_invisible_columns = array('id', 'is_published', 'priority');

  protected $_model_name;

  function create()
  {
    $columns = $this->_table->getColumns();

    $vars = array(
      'model_name' => $this->_model_name,
      'model_url' => lmb_under_scores($this->_model_name),
      'columns' => $columns,
      'column_names' => $this->_getAllColumnNames($columns),
      'invisible_columns' => $this->_invisible_columns,
    );

    $content = $this->_createContentFromTemplate($this->_front_stuff_controller_template, $vars);
    $this->_project->addController($this->getControllerFileName(), $content);        
           
    $content = $this->_createContentFromTemplate($this->_front_stuff_templates_for_templates_dir . 'display.phtml', $vars, false);
    $this->_project->addTemplate($this->_getResultTemplatePath('display.phtml'), $content);    
    
    $content = $this->_createContentFromTemplate($this->_front_stuff_templates_for_templates_dir . 'item.phtml', $vars, false);    
    $this->_project->addTemplate($this->_getResultTemplatePath('item.phtml'), $content);    
    
    $content = $this->_createContentFromTemplate($this->_front_stuff_finder_template, $vars);
    $this->_project->addFinder($this->getFinderFileName(), $content);
  }
  
  protected function _getAllColumnNames($columns)
  {
    $names = array();
    
    foreach($columns as $column)
      $names[] = $column->getName();
    
    return $names;
  }

  function getFinderFileName()
  {
    return $this->_model_name . 'Finder.class.php';
  } 
}
