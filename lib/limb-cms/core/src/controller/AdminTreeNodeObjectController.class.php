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

  function doDisplay()
  {
    if(!$id = $this->request->getInteger('id')  )
    {
      $this->is_root = true;
      $criteria = new lmbSQLCriteria('parent_id > 0');
      $criteria->addAnd(new lmbSQLCriteria('level = 1'));
      $this->item = lmbCmsActiveRecordTreeNode :: findRoot( $this->_object_class_name);
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

  function doPriority()
  {
    if( $this->request->has( 'parent_id'))
      $this->_changeItemsPriority( $this->_object_class_name, 'parent_id', $this->request->get('parent_id'));

    $this->_endDialog();
  }
}