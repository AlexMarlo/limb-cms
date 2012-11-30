<?php
lmb_require('limb-cms/core/src/model/lmbCmsActiveRecord.class.php');

class Counter extends lmbCmsActiveRecord
{
  protected $_db_table_name = 'counter';

  protected $_default_sort_params = array('priority' => 'asc');

  public $_history_stored_fields = array('title', 'code');

  protected function _createValidator()
  {
    $validator = new lmbValidator();

    $validator->addRequiredRule('title', 'Поле "Заголовок" обязательно для заполнения');
    $validator->addRequiredRule('code', 'Поле "Код" обязательно для заполнения');

    return $validator;
  }

  protected function _onBeforeCreate()
  {
    parent :: _onBeforeCreate();

    $sql = "SELECT MAX(priority) FROM " . $this->_db_table_name . " ;";
    $this->set('priority', (lmbDBAL::fetchOneValue($sql) + 10));
  }

  static function findPublished()
  {
    $criteria = lmbSQLCriteria::equal('is_published', 1);
    return Counter :: find($criteria);
  }
}
