<?php
lmb_require('limb/net/src/lmbIp.class.php');

class VisitorAuthorizationHelper
{
  const COOKIES_LIFE_TIME = 1209600; //60*60*24*14 (2 week)

  static function getCookieNameId($user)
  {
    return 'bit_cms_' . get_class($user) . '_id';
  }
  
  static function getCookieNameHash($user)
  {
    return 'bit_cms_' . get_class($user) . '_hash';
  }
  
  static function generatePassword($length = 9)
  {
    $alphabet = array(
        array('b','c','d','f','g','h','g','k','l','m','n','p','q','r','s','t','v','w','x','z',
              'B','C','D','F','G','H','G','K','L','M','N','P','Q','R','S','T','V','W','X','Z'),
        array('a','e','i','o','u','y','A','E','I','O','U','Y'),
    );

    $new_password = '';
    for($i = 0; $i < $length ;$i++)
    {
      $j = $i%2;
      $min_value = 0;
      $max_value = count($alphabet[$j]) - 1;
      $key = rand($min_value, $max_value);
      $new_password .= $alphabet[$j][$key];
    }
    return $new_password;
  }

  static function getActivationKeyFor($user)
  {
    return md5(md5($user->getPassword()) . $user->getCtime() . 'add_somE_sOlt');
  }

  static function getOneDayKeyFor($user)
  {
    return md5(md5($user->getPassword()) . date('z') . 'add_somE_sOlt');
  }

  static function getTemporalyKeyWithIpFor($user)
  {
    return md5($user->getId() . md5($user->getPassword()) . lmbIp::getRemoteIp() . 'add_somE_sOlt');
  }

  static function cryptPasswordFor($user, $password)
  {
    if(!$user->getCtime())
      $user->setCtime(time());
    
    return md5(md5($password) . 'salt' . $user->getCtime());
  }

  static function isPasswordCorrectForUser($user, $password)
  {
    return ($user->getPassword() == self :: cryptPasswordFor($user, $password));
  }

  static function enableAutologinFor($user)
  {
    $domain = lmb_env_get('BASE_PROJECT_HOST');
    $expire_time = time() + self::COOKIES_LIFE_TIME;
    
    lmbToolkit::instance()->getResponse()->setCookie(
      self::getCookieNameId($user), $user->getId(), $expire_time, $path = '/', $domain
    );

    lmbToolkit::instance()->getResponse()->setCookie(
      self::getCookieNameHash($user), self::getTemporalyKeyWithIpFor($user), $expire_time,  $path = '/', $domain
    );
  }

  static function disableAutologinFor($user)
  {
    $domain = lmb_env_get('BASE_PROJECT_HOST');
    
    lmbToolkit::instance()->getResponse()->removeCookie(
      self::getCookieNameId($user), $user->getId(), $path = '/', $domain
    );

    lmbToolkit::instance()->getResponse()->removeCookie(
      self::getCookieNameHash($user), self::getTemporalyKeyWithIpFor($user), $path = '/', $domain
    );
  }

  static function loginUser($user, $with_autologin = false)
  {
    if($with_autologin)
      self::enableAutologinFor($user);

    $user->setLoggedIn(true);
    lmbToolkit::instance()->setVisitorUser($user);
  }

  static function logoutUser($user)
  {
    $toolkit = lmbToolkit::instance();
    $domain = lmb_env_get('BASE_PROJECT_HOST');

    $toolkit->resetVisitorUser(get_class($user));
    
    $toolkit->getResponse()->removeCookie(self::getCookieNameId($user), $path = '/', $domain);
    $toolkit->getResponse()->removeCookie(self::getCookieNameHash($user), $path = '/', $domain);

    $toolkit->getSession()->reset();
  }
}