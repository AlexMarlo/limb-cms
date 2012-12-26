<?php
lmb_require('limb-cms/core/src/controller/AdminObjectController.class.php');
lmb_require('limb/validation/src/rule/lmbMatchRule.class.php');

class AdminUserController extends AdminObjectController
{
  protected $_object_class_name = 'lmbCmsUser';

  function doChangePassword()
  {
    if(!$this->request->hasPost())
      return;

    $this->useForm('user_form');
    $this->setFormDatasource($this->request);

    $user = new lmbCmsUser($this->request->getInteger('id'));
    $this->_validatePasswordFields($user);

    $user->setPassword($this->request->get('new_password'));
    $user->trySave($this->error_list);

    if($this->error_list->isValid())
    {
      $user->logout();
      $this->closePopup();
    }
  }

  /**
   * @param lmbCmsUser $user
   */
  protected function _validatePasswordFields($user)
  {
    $validator = new lmbValidator($this->error_list);

    $validator->addRequiredRule('password', 'Поле "Пароль" обязательно для заполнения');
    $validator->addRequiredRule('repeat_new_password', 'Поле "Подтверждение пароля" обязательно для заполнения');

    if(!$user->isPasswordCorrect($this->request->get('password')))
      $this->error_list->addError("Выбран некорректный пароль");

    $validator->addRule(new lmbMatchRule('password', 'repeat_password', 'Значения полей "Пароль" и "Подтверждение пароля" не совпадают'));
    $validator->validate($this->request);
  }

  function doDelete()
  {
    if(!$this->request->hasPost())
      $ids = $this->request->get('ids');
    else
      $ids = $this->request->getPost('ids');
    
    if(!is_array($ids))
      $ids = array($ids);
    
    $this->items = lmbActiveRecord::findByIds( $this->_object_class_name, $ids);
    
    $this->_onBeforeDelete();
    
    foreach ($this->items as $item)
    {
      if($item->getId() == $this->toolkit->getCmsUser()->getId())
        return $this->flashErrorAndRedirect('Запрещено удалять свою учетную запись', '/admin_user');
      else
        $item->destroy();
    }

    $this->_onAfterDelete();
    
    $this->_endDialog();
  }
}

