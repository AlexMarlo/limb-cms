<?php
lmb_require('limb/web_app/src/request/lmbRequestDispatcher.interface.php');

class LocaleRequestDispatcher implements lmbRequestDispatcher
{
  protected $_allowed_locales = array('en_US', 'ru_RU');
  protected $_default_locale ='ru_RU';
  protected $_admin_locale_cookies_name = "admin_language";
  protected $_locale_cookies_name = "language";
  
  function dispatch( $request)
  {
    $toolkit = lmbToolkit :: instance();

    if( strstr($toolkit->request->getUri()->toString(), '/admin'))
      $locale_cookies_name = $this->_admin_locale_cookies_name;
    else
      $locale_cookies_name = $this->_locale_cookies_name;

    $cookies = $request->getCookie( $locale_cookies_name);
    if($cookies)
      $locale = $cookies;
    else
      $locale = $this->_default_locale;
  
    $toolkit->getResponse()->setCookie( $locale_cookies_name, $locale);
  
    if( in_array( $locale, $this->_allowed_locales))
      $toolkit->set('locale', $locale);
    else
      $toolkit->set('locale', $this->_default_locale);
  }
}