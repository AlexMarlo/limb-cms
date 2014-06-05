<?php
lmb_require('limb/tree/src/lmbTreeNestedCollection.class.php');
lmb_require('limb/tree/src/lmbTreeHelper.class.php');
lmb_require('limb-cms/menu/src/model/Menu.class.php');

class MenuFinder
{
  static private function _sortTree($rs, $parent_id, $sort_params, $id_hash = 'id', $parent_hash = 'parent_id')
  {
    $tree_array = lmbTreeHelper :: _convertRs2Array($rs);

    $item = reset($tree_array);
    $parent_id;

    $sorted_tree_array = array();

    lmbTreeHelper :: _doSort($tree_array, $sorted_tree_array, $sort_params, $parent_id, $id_hash, $parent_hash);

    return new lmbCollection($sorted_tree_array);
  }

  static function findByUrl($url = null, $criteria = null)
  {
    if(!$url)
      return;
    $url = lmbFS :: normalizePath($url);

    $result_criteria = lmbSQLCriteria::equal('is_published', 1)
                ->addAnd(lmbSQLCriteria::equal('url', $url));

    if(!is_null($criteria))
      $result_criteria->addAnd($criteria);

    if($node = Menu :: findFirst($result_criteria))
      return $node;

    return null;
  }

  static function findOneByIdentifier($identifier)
  {
    if($node = Menu :: findFirst(lmbSQLCriteria :: equal('identifier', $identifier)))
      return $node;
    
    return null;
  }
  
  static function findChildrenTree($node = null)
  {
    if(!$node)
      return new lmbCollection();
    
    $iterator = self :: _sortTree( self::findChildrenArrayForFront($node), $node->id, array('priority' => 'ASC'));
    $iterator = new lmbTreeNestedCollection($iterator);
    
    $iterator->setChildrenField('preloaded_children');
    $iterator->rewind();
    
    return $iterator; 
  }
  
  static function findChildrenArrayForFront($node = null)
  {
    if(!$node)
      return new lmbSQLCriteria();
    
    $criteria = lmbSQLCriteria::equal('is_published', 1)
                ->addAnd(lmbSQLCriteria::like('path', $node->path . '%'))
                ->addAnd(new lmbSQLCriteria('id <> ' . $node->id));
    
    return Menu :: find( array('criteria' => $criteria, 'sort' => array( 'priority' => 'ASC')));
  }
}
