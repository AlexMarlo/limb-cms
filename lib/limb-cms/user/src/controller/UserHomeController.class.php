<?php

lmb_require('limb-cms/core/src/helper/VisitorAuthorizationHelper.class.php');
  
class UserHomeController extends lmbController
{
  function doDisplay()
  {
    $this->user = $this->toolkit->getUser();
    if(!$this->user->isLoggedIn())
      return $this->forwardTo404();
  }

  function doEditProfile()
  {
    $this->user = $this->toolkit->getUser();

    if(!$this->user->isLoggedIn())
      return $this->forwardTo404();

    $dataset = new lmbSet();
    $dataset->import($this->user->export());
    $dataset->import($this->request->getPost());

    $this->useForm('profile_form');
    $this->setFormDatasource($dataset);

    if(!$this->request->hasPost())
      return;

    $this->user->import($this->request->getPost(array(
      'name', 'email',
    )));

    $this->validator->validate($this->request);

    UploadImageFileHelper :: validateImageFile(
      $this->user, 'photo',
      $this->request->getFile('photo_file')->getFilePath(),
      $this->error_list
    );

    if(!$this->error_list->isEmpty())
      return;

    $this->user->save();

    UploadImageFileHelper :: attachOrDeleteImageFile(
      $this->user, 'photo',
      $this->request->getFile('photo_file')->getFilePath(),
      (bool)$this->request->get('photo_file_delete')
    );

    $this->flash('Профиль успешно изменен');
  }

  function doNewPassword()
  {
    $this->user = $this->toolkit->getUser();

    if(!$this->user->isLoggedIn())
      return $this->forwardTo404();

    $this->useForm('forgot_password_form');
    $this->setFormDatasource($this->request);

    if(!$this->request->hasPost())
      return;

    $this->validator->addRequiredRule('password', 'Вы должны ввести новое значение пароля');
    $this->validator->addRequiredRule('password_repeat', 'Вы должны ввести подтверждение нового значения пароля');

    lmb_require('limb/validation/src/rule/lmbMatchRule.class.php');
    $this->validator->addRule(new lmbMatchRule('password', 'password_repeat', 'Пароли в обоих полях должны совпадать'));

    $crypted_old_password = VisitorAuthorizationHelper::cryptPasswordFor($this->user, $this->request->getPost('old_password'));
    if($crypted_old_password != $this->user->password)
      $this->error_list->addError('Старый пароль введен неправильно');

    $this->validator->validate($this->request);

    if(!$this->error_list->isEmpty())
      return;

    $this->user->setPassword(VisitorAuthorizationHelper::cryptPasswordFor($this->user, $this->request->get('password')));
    $this->user->save();

    VisitorAuthorizationHelper::loginUser($this->user);

    $this->flash('Пароль успешно изменен');
    $this->redirect('/');
  }
}
