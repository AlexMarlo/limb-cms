<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2012 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */

lmb_require('limb/active_record/src/lmbActiveRecord.class.php');

/**
 * class lmbCmsActiveRecord.
 *
 * @package core
 */

abstract class lmbCmsActiveRecord extends lmbActiveRecord
{
  protected $_db_table_name;
  protected $_priority_field_name = 'priority';
  

  protected function _onBeforeCreate()
  {
    lmb_require('limb/net/src/lmbIp.class.php');
    if($this->has('create_ip'))
      $this->create_ip = lmbIp::encode(lmbIp::getRealIp());
  }

  protected function _onBeforeSave()
  {
    $this->save();
  }

  function _onCreate()
  {
    if($this->has( $this->_priority_field_name))
      $this->_setPriority();
  }

  protected function _setPriority()
  {
    $sql = "SELECT MAX(" . $this->_priority_field_name . ") FROM " . $this->_db_table_name;
    $max_priority = lmbDBAL :: fetchOneValue( $sql);
    $this->setPriority( $max_priority + 10);
  }
}