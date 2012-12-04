<?php
lmb_require('limb/core/src/lmbArrayHelper.class.php');

class AdminTreeNodeChildrenCountSetDecorator extends lmbCollectionDecorator
{
  protected $_db_table_name;
  protected $_kids_counts = array();

  function __construct($iterator, $object_class_name)
  {
    $calling_item = new $object_class_name();
    $this->_db_table_name = $calling_item->getTableName();
    
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

    $sql = " SELECT `parent_id` as `parent_id`, count(`id`) as `count` " .
           " FROM `{$this->_db_table_name}` WHERE `parent_id` IN (" . implode(',', $items_ids) . ") " .
           " GROUP BY `parent_id`; ";

    $this->_kids_counts = lmbCollection::toFlatArray(lmbDBAL::fetch($sql)->getArray(), 'parent_id');

    parent :: rewind();
  }

  function current()
  {
    $current = $this->iterator->current();
    
    if(array_key_exists($current->id, $this->_kids_counts))
      $current['loaded_kids_count'] = $this->_kids_counts[$current->id]['count'];

    return $current;
  }
}
