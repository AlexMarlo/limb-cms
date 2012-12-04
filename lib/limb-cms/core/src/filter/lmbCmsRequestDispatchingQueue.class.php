<?php
lmb_require('limb/core/src/lmbObject.class.php');

class lmbCmsRequestDispatchingQueue extends lmbObject
{
  static protected $_queue_top = array();
  static protected $_queue_medium = array();
  static protected $_queue_bottom = array();

  const TOP = 0;
  const MEDIUM = 1;
  const BOTTOM = 2;
  
  const INCLUDE_PATH_NAME = "include_path_name";
  const OBJECT_NAME = "object_name";
  const PARAMS_NAME = "params";

  static function add( $object, $position = self::MEDIUM)
  {
    if( $position == self::TOP)
      self::$_queue_top[] = $object;
    elseif( $position == self::MEDIUM)
      self::$_queue_medium[] = $object;
    elseif( $position == self::BOTTOM)
      self::$_queue_bottom[] = $object;
    else
      self::$_queue_medium[] = $object;
  }

  static function getQueue()
  {
    $queue = array_merge( self::$_queue_top, self::$_queue_medium, self::$_queue_bottom);
    return $queue;
  }
}