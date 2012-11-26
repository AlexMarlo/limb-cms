<?php
lmb_require('limb-cms/core/src/model/lmbCmsActiveRecordTreeNode.class.php');

class Menu extends lmbCmsActiveRecordTreeNode
{
  protected $_db_table_name = 'lmb_cms_menu';

  function _createValidator()
  {
    lmb_require('limb/validation/src/rule/lmbPatternRule.class.php');
    lmb_require('limb-cms/core/src/validation/rule/lmbTreeIdentifierRule.class.php');

    $validator = new lmbValidator();

    if ($this->level !== 0)
    {
      $validator->addRequiredRule('title', 'Поле "Заголовок" обязательно для заполнения');
      $validator->addRequiredRule('identifier', 'Поле "Идентификатор" обязательно для заполнения');
    }

    $validator->addRule(new lmbPatternRule('identifier', "/^[a-zA-Z0-9_-]+$/i", 'Поле "Идентификатор" может содержать только цифры, символы латинского алфавита и символы `_` и `-`'));
    $validator->addRule(new lmbTreeIdentifierRule('identifier', $this));

    return $validator;
  }

  function isReadOnly()
  {
    $conf = lmbToolkit :: instance()->getConf('menu');
    $read_only_identifiers = $conf['forms']['read_only_identifiers'];

    return in_array($this->identifier, $read_only_identifiers);
  }
}
