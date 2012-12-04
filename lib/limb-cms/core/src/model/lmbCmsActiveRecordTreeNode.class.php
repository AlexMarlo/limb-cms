<?php

lmb_require('limb-cms/core/src/model/lmbCmsActiveRecord.class.php');
lmb_require('limb/tree/src/lmbMPTree.class.php');

/**
 * class lmbCmsActiveRecordTreeNode.
 *
 * @package core
 */

abstract class lmbCmsActiveRecordTreeNode extends lmbCmsActiveRecord
{
  protected $_tree;

  function __construct($magic_params = null, $conn = null)
  {
    parent :: __construct($magic_params, $conn);
    
    $this->_tree = $this->getTree();

    if(!$this->_tree->getRootNode())
      $this->_tree->initTree();
  }

  /**
   * @return lmbMPTree
   */
  function getTree()
  {
    if(!$this->_tree)
      $this->_tree = lmbToolkit :: instance()->getCmsTree($this->getTableName(), $this->_db_conn);

    return $this->_tree;
  }

  function loadByPath($path)
  {
    if(!$node = $this->getTree()->getNodeByPath($path));
      throw new lmbARException('Could not found element by path ' . $path);

    return $this->import($node);
  }

  function _defineRelations()
  {
    $this->_has_one = array('parent' => array('field' => 'parent_id',
                                               'class' => get_class($this),
                                               'can_be_null' => true,
                                               'cascade_delete' => false));

    $this->_has_many = array('kids' => array('field' => 'parent_id',
                                             'class' => get_class($this)));
  }

  protected function _insertDbRecord($values)
  {
    if($this->getParent() && $parent_id = $this->getParent()->getId())
      return $this->_tree->createNode($parent_id, $values);
    else
    {
      if(!$root = $this->_tree->getRootNode())
      {
        $this->_tree->initTree();
        $root = $this->_tree->getRootNode();
      }

      return $this->_tree->createNode($root, $values);
    }
  }

  protected function _updateDbRecord($values)
  {
    return $this->getTree()->updateNode($this->getId(), $values);
  }

  protected function _onAfterUpdate()
  {
    if($this->isDirtyProperty('parent'))
    {
      $this->getTree()->moveNode($this->getId(), $this->getParent()->getId());
    }
  }

  protected function _deleteDbRecord()
  {
    $this->getTree()->deleteNode($this->getId());
  }

  /**
   * @param integer $depth
   * @return lmbCollection
   */
  function getChildren($depth = 1)
  {
    return lmbActiveRecord :: decorateRecordSet($this->getTree()->getChildren($this->getId(), $depth),
                                                get_class($this),
                                                $this->_db_conn);
  }

  function getChildrenAll()
  {
    return lmbActiveRecord :: decorateRecordSet($this->getTree()->getChildrenAll($this->getId()),
                                                get_class($this),
                                                $this->_db_conn);
  }

  function move($target)
  {
    $this->getTree()->moveNode($this->getId(), $target);
  }

  static function findRoot($class_name = '')
  {
    if(!$class_name)
      $class_name = self :: _getCallingClass();
    
    $calling_class = new $class_name();

    if(!$calling_class->getTree()->getRootNode())
      $calling_class->getTree()->initTree();

    return lmbActiveRecord :: findOne( $class_name, lmbSQLCriteria::equal('parent_id', 0));
  }

  /**
   * @return bool
   */
  function isRoot()
  {
    if($this->isNew()) return false;
    return !((bool)$this->_getRaw('parent_id'));
  }

  /**
   *
   * @param lmbCmsActiveRecordTreeNode $node
   * @return bool
   */
  function isChildOf( lmbCmsActiveRecordTreeNode $node)
  {
    $rs = $this->getTree()->getParents($this);
    foreach($rs as $record)
    {
      if((int)$record['id']===(int)$node['id']) return true;
    }
    return false;
  }

  function getParents()
  {
    $rs = $this->getTree()->getParents($this);
    return lmbActiveRecord :: decorateRecordSet($rs,
                                                get_class($this),
                                                $this->_db_conn);
  }
  
  protected function _setPriority()
  {
    if(!$parent_id = $this->getParentId())
      $parent_id = $this->findRoot( $this->_db_table_name)->getId();
  
    $sql = "SELECT MAX(priority) FROM " . $this->_db_table_name . " WHERE parent_id = " . $parent_id;
    $max_priority = lmbDBAL :: fetchOneValue($sql);
    $this->setPriority($max_priority + 10);
  }
}
