<?php
lmb_require('limb-cms/core/src/controller/AdminObjectController.class.php');

class AdminCounterController extends AdminObjectController
{
  protected $_object_class_name = 'Counter';
  protected $_default_sort = array('field' => 'priority', 'direction' => 'asc');
}
