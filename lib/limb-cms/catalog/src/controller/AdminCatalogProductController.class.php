<?php
lmb_require('limb-cms/core/src/controller/AdminObjectController.class.php');

class AdminCatalogProductController extends AdminObjectController
{
  protected $_object_class_name = 'CatalogProduct';

  protected function _onCreate()
  {
    parent :: _onCreate();

    if(!$this->category = CatalogCategory :: findById((int)$this->request->get('host_category_id'), false))
      $this->category = lmbCmsActiveRecordTreeNode::findRoot('CatalogCategory');

    $this->item->set('category', $this->category);
  }
}
