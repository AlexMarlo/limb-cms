<?php

class User extends lmbCmsActiveRecord
{
  protected $_db_table_name = 'user';
  protected $is_logged_in = false;

  protected function _createValidator()
  {
    lmb_require('limb/validation/src/rule/lmbEmailRule.class.php');
    lmb_require('limb/validation/src/rule/lmbPatternRule.class.php');
    lmb_require('limb-cms/core/src/validation/rule/lmbCmsUniqueFieldRule.class.php');

    $validator = new lmbValidator();

    $validator->addRequiredRule('name', 'Поле "Имя" обязательно для заполнения');

    $validator->addRequiredRule('email', 'Поле "Email" обязательно для заполнения');
    $validator->addRule(new lmbEmailRule('email', 'Формат поля "Email" не верен'));
    $validator->addRule(new lmbCmsUniqueFieldRule('email', "User", $this, 'Пользователь со значением поля "Email" уже существует'));

    $validator->addRequiredRule('password', 'Поле "Пароль" обязательно для заполнения');

    return $validator;
  }

  function isLoggedIn()
  {
    return $this->is_logged_in;
  }

  function setLoggedIn($is_logged_in)
  {
    $this->is_logged_in = $is_logged_in;
  }
}
