<?php
lmb_require('limb-cms/core/src/controller/AdminTreeNodeObjectController.class.php');

class AdminCatalogController extends AdminTreeNodeObjectController
{
  protected $_object_class_name = 'CatalogCategory';

  function doDisplay()
  {
    parent :: doDisplay();

    //lmb_require('limb-cms/core/src/dataset/AdminTreeNodeRelationObjectsCountSetDecorator.class.php');
    //$this->items = new AdminTreeNodeRelationObjectsCountSetDecorator($this->items, $this->_object_class_name, 'products');

    $this->products = $this->item->getProducts();
    $this->_applySortParams($this->products, "product", array('field' => 'priority', 'direction' => 'asc'));
  }

}
