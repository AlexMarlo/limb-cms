<?php
lmb_require('limb/tree/src/lmbTreeNestedCollection.class.php');
lmb_require('limb/tree/src/lmbTreeHelper.class.php');

class MenuFinder
{
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
    
    $iterator = lmbTreeHelper :: sort(self::findChildrenArrayForFront($node), array('priority' => 'ASC'));
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
    
    return Menu :: find($criteria);
  }
}
