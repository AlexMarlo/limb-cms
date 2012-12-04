<?php
lmb_require('limb/core/src/lmbArrayHelper.class.php');

class AdminTreeNodeRelationObjectsCountSetDecorator extends lmbCollectionDecorator
{
  protected $_relation_info;
  protected $_objects_counts = array();

  function __construct($iterator, $object_class_name, $relation)
  {
    $calling_item = new $object_class_name();
    $this->_relation_info = $calling_item->getRelationInfo($relation);
    
    $relation_calling_item = new $this->_relation_info['class']();
    $this->_relation_info['db_table_name'] = $relation_calling_item->getTableName(); 
    
    parent :: __construct($iterator);
  }

  function rewind()
  {
    $items_ids = lmbArrayHelper :: getColumnValues('id', $this->iterator);
    
    if(!count($items_ids))
    {
      parent :: rewind();
      return;
    }
    
    $sql = " SELECT `{$this->_relation_info['field']}` as `{$this->_relation_info['field']}`, count(`id`) as `count` " .
           " FROM `{$this->_relation_info['db_table_name']}` WHERE `{$this->_relation_info['field']}` IN (" . implode(',', $items_ids) . ") " .
           " GROUP BY `{$this->_relation_info['field']}`; ";

    $this->_objects_counts = lmbCollection::toFlatArray(lmbDBAL::fetch($sql)->getArray(), $this->_relation_info['field']);

    parent :: rewind();
  }

  function current()
  {
    $current = $this->iterator->current();
    
    if(array_key_exists($current->id, $this->_objects_counts))
      $current['loaded_relation_objects_count'] = $this->_objects_counts[$current->id]['count'];

    return $current;
  }
}
