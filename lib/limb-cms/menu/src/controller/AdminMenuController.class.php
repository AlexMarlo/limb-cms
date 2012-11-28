<?php
lmb_require('limb-cms/core/src/controller/AdminTreeNodeObjectController.class.php');
lmb_require('limb-cms/menu/src/model/Menu.class.php');

class AdminMenuController extends AdminTreeNodeObjectController
{
  protected $_object_class_name = 'Menu';
}

