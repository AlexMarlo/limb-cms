<?php
lmb_require('limb-cms/core/src/controller/AdminTreeNodeObjectController.class.php');
lmb_require('limb-cms/menu/src/model/Menu.class.php');

class AdminMenuController extends AdminTreeNodeObjectController
{
  protected $_object_class_name = 'Menu';

  function doDisplay( $template_name = 'display.phtml')
  {
    $this->setTemplate('admin_menu/' . $template_name);
    if(!$id = $this->request->getInteger('id')  )
    {
      $this->is_root = true;
      $criteria = new lmbSQLCriteria('parent_id > 0');
      $criteria->addAnd(new lmbSQLCriteria('level = 1'));
      $this->item = Menu :: findRoot();
    }
    else
    {
      $this->is_root = false;
      if(!$this->item = $this->_getObjectByRequestedId())
        return $this->forwardTo404();
      $criteria = new lmbSQLCriteria('parent_id = ' . $this->item->getId());
    }

    $this->items = lmbActiveRecord :: find( $this->_object_class_name, array('criteria' => $criteria, 
                                                                             'sort' => array('priority'=>'ASC')));
    $this->_applySortParams();
  }
  
  function doCreate()
  {
    parent::doCreate();
    $parent_id = $this->request->getInteger('id');

    if( lmbActiveRecord :: findById( $this->_object_class_name, $parent_id))
      $this->item->parent_id = $parent_id;
    else
      $this->item->parent_id = 0;
  }
}

