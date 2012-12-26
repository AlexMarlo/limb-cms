<?php
lmb_require('limb/validation/src/rule/lmbMatchRule.class.php');
lmb_require('limb/validation/src/rule/lmbValidValueRule.class.php');

lmb_require('src/service/UserMailService.class.php');
lmb_require('limb-cms/core/src/helper/VisitorAuthorizationHelper.class.php');
lmb_require('limb-cms/user/src/finder/UserFinder.class.php');

class UserAuthController extends lmbController
{
  protected $_object_class_name = 'User';

  private $selected_user;

  function doRegistration()
  {
    $this->useForm('register_form');
    $this->setFormDatasource($this->request);

    if(!$this->request->hasPost())
      return;

    $this->user = new User();
    $this->user->import($this->request->getPost(array('name', 'email', 'password')));

    $this->user->validate($this->error_list);

    $this->validator->addRule(new lmbMatchRule('password', 'password_repeat', 'Пароли в обоих полях должны совпадать'));
    $this->validator->addRequiredRule('captcha', 'Поле "Проверочный код" обязательно для заполнения');
    $this->validator->addRule(new lmbValidValueRule('captcha', $this->toolkit->getSession()->get('captcha_keystring'), 'Текст, изображенный на картинке, не совпадает с введенным вами'));

    $this->validator->validate($this->request);

    if(!$this->error_list->isEmpty())
      return;

    $this->user->save();

    $activate_link = 'http://'.lmb_env_get('BASE_PROJECT_HOST').'/user_auth/activate/'.$this->user->id.'?key='.VisitorAuthorizationHelper::getActivationKeyFor($this->user);

    $mail_service = new UserMailService();
    $mail_service->sendMail(
      'user_register_ok',
      $this->user,
      array(
        'activate_url' => $activate_link,
        'name' => $this->user->name,
      )
    );

    return $this->redirect('/user_auth/registration_success');
  }

  function doActivate()
  {
    if(!$this->user = $this->_getUserByRequestedId())
      return $this->flash('Такой пользователь не зарегистрирован или срок активации прошел.');

    if(VisitorAuthorizationHelper::getActivationKeyFor($this->user) !== $this->request->get('key')) {
      return $this->flash('Неверный код.');
    }
    else
    {
      $this->user->setIsActivated(1);
      $this->user->save();

      $mail_service = new UserMailService();
      $mail_service->sendMail(
        'user_activated',
        $this->user,
        array(
          'name' => $this->user->name,
          'email' => $this->user->email,
          'password' => $this->user->password,
        )
      );

      $this->user->setPassword(
        VisitorAuthorizationHelper::cryptPasswordFor($this->user, $this->user->password)
      );

      $this->user->save();

      VisitorAuthorizationHelper::loginUser($this->user);
      $this->redirect('/user_auth/activation_success');
    }
  }

  function doForgotPassword()
  {
    if(!$this->request->hasPost())
      return;

    $this->useForm('forgot_password_form');
    $this->setFormDatasource($this->request);

    if(!$email = $this->request->getPost('email'))
      return $this->error_list->addError("Введите адрес электронной почты, указанный Вами при регистрации");

    if(!$this->user = UserFinder::findForEmail($email, $is_activated = false))
      return $this->error_list->addError("Пользователь с таким адресом электронной почты не зарегистрирован");

    $activate_link = 'http://'.lmb_env_get('BASE_PROJECT_HOST').'/user_auth/new_password/'.$this->user->getId().'?key='.VisitorAuthorizationHelper::getOneDayKeyFor($this->user);

    $mail_service = new UserMailService();
    $mail_service->sendMail(
      'user_forgot_password',
      $this->user,
      array(
        'activate_url' => $activate_link,
        'name' => $this->user->name,
      )
    );

    $this->response->redirect('/user_auth/forgot_password_success');
  }

  function doNewPassword()
  {
    $this->show_password_form = false;

    $this->useForm('forgot_password_form');
    $this->setFormDatasource($this->request);

    if(!$user = $this->_getUserByRequestedId())
      return $this->error_list->addError('Такой пользователь не зарегистрирован');

    if(VisitorAuthorizationHelper::getOneDayKeyFor($user) !== $this->request->get('key'))
      return $this->error_list->addError('Код неправильный. Адью!');
    else
      $this->show_password_form = true;

    if(!(bool)$user->getIsActivated())
    {
      $user->setIsActivated(1);
      $user->save();
    }

    if(!$this->request->hasPost())
      return;

    $this->validator->addRequiredRule('password', 'Вы должны ввести новое значение пароля');
    $this->validator->addRequiredRule('password_repeat', 'Вы должны ввести подтверждение нового значения пароля');
    $this->validator->addRule(new lmbMatchRule('password', 'password_repeat', 'Пароли в обоих полях должны совпадать'));

    $this->validator->validate($this->request);

    if(!$this->error_list->isEmpty())
      return;

    $user->setPassword(VisitorAuthorizationHelper::cryptPasswordFor($user, $this->request->get('password')));
    $user->save();

    VisitorAuthorizationHelper::loginUser($user);
    $this->redirect('/');
  }

  function doLogin()
  {
    if(!$this->request->hasPost())
      return;

    $this->useForm('login_form');
    $this->setFormDatasource($this->request);

    $this->validator->addRequiredRule('email', 'Укажите email');
    $this->validator->addRequiredRule('password', 'Укажите пароль');

    if(!$this->validator->validate($this->request))
      return;

    if($this->_attemptToLogin())
      $this->response->redirect('/');
    else
      $this->error_list->addError('Мы искали, но не смогли найти пользователя с таким сочетанием email и пароля');
  }

  protected function _attemptToLogin()
  {
    $email = $this->request->get('email');
    $password = $this->request->get('password');
    $autologin = (bool) $this->request->get('remember_me');

    $loaded_user = UserFinder :: findForEmail($email);

    if(!$loaded_user || $loaded_user->getIsBanned() || !VisitorAuthorizationHelper::isPasswordCorrectForUser($loaded_user, $password))
      return false;

    VisitorAuthorizationHelper::loginUser($loaded_user, $autologin);
    return true;
  }

  function doLogout()
  {
    $user = $this->toolkit->getUser();

    if($user->isLoggedIn())
      VisitorAuthorizationHelper::logoutUser($user);

    $this->response->redirect('/');
  }

  protected function _getUserByRequestedId()
  {
    if(!$user = lmbActiveRecord::findById('User', (int)$this->request->get('id'), $throw_exception = false))
      return null;

    return $user;
  }
}
