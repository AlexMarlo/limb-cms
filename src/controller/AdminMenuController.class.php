<?php
lmb_require('limb-cms/core/src/controller/lmbAdminObjectController.class.php');
lmb_require('src/model/Menu.class.php');

class AdminMenuController extends lmbAdminObjectController
{
  protected $_object_class_name = 'Menu';

  function doDisplay($template_name = 'display.phtml')
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

    $this->items = lmbActiveRecord :: find( $this->_object_class_name, array('criteria' => $criteria, 'sort'=>array('priority'=>'ASC')));
    
    $this->_applySortParams();
  }
}

