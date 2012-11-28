<?php
lmb_require('limb-cms/core/src/controller/AdminObjectController.class.php');

abstract class AdminTreeNodeObjectController extends AdminObjectController
{
  protected $_default_sort = array('field' => 'priority', 'direction' => 'asc');

  protected function _onBeforeImport()
  {
    $identifier = lmb_translit_russian( $this->item->identifier);
    $identifier = strtolower( trim( $identifier));

    $this->item->set('identifier', $identifier);
    $this->item->set('title', trim($this->item->title));
  }

  function doPriority()
  {
    if( $this->request->has( 'parent_id'))
      $this->_changeItemsPriority( $this->_object_class_name, 'parent_id', $this->request->get('parent_id'));

    $this->_endDialog();
  }
}