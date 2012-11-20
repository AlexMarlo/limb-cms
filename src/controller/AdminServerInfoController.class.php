<?php
lmb_require('limb-cms/core/src/controller/lmbAdminObjectController.class.php');
lmb_require('limb/validation/src/rule/lmbEmailRule.class.php');

class AdminServerInfoController extends lmbAdminObjectController
{
  protected $_object_class_name = 'AdminServerInfoController';

  protected function _flush($path)
  {
    if(file_exists($path))
      lmbFS :: rm($path);
    $this->_endDialog();
  }

  function doDisplay() {}

  function doEnv() {}

  function doPhpInfo()
  {
    echo phpinfo();
    exit;
  }

  function doFlushErrorLog()
  {
    $this->_flush($this->_getErrorLogFilePath());
  }

  function doFlushLog()
  {
    $logs_path = LIMB_VAR_DIR . "log";
    $this->_flush($logs_path);
  }

  function doFlushCompiled()
  {
    $compiled_path = LIMB_VAR_DIR . "compiled";
    $this->_flush($compiled_path);
  }

  function doFlushCache()
  {
    $cache_path = LIMB_VAR_DIR . "cache";
    $this->_flush($cache_path);
  }

  function doFlushI18n()
  {
    $cache_path = LIMB_VAR_DIR . "i18n-qt";
    $this->_flush($cache_path);
  }

  function doFlushVar()
  {
    $handle = @opendir(LIMB_VAR_DIR);
    while(($file = readdir($handle)) !== false)
    {
      if($file == '.' ||  $file == '..')
        continue;
      lmbFS :: rm(LIMB_VAR_DIR . $file);
    }
    $this->_endDialog();
  }

  function doErrorLog()
  {
    $this->errors = array();
    $error_log_style = $this->_getErrorLogStyle();

    if(!file_exists($this->_getErrorLogFilePath()))
      return;

    $errors = file_get_contents($this->_getErrorLogFilePath());

    $errors = explode($this->_getErrorLogSeparator(), $errors);
    $errors = array_diff($errors, array(''));

    $this->errors = array();
    for($i = count($errors); $i > 0 ; $i-=2)
    {
      $error = &$this->errors[];
      $title = $errors[$i - 1];
      $error['title'] = $title;

      switch($error_log_style)
      {
        default:
        case 0:
          preg_match("/\[(.*)\]\[(.*) - (.*)\] \[(.*)\]/", $title, $matches);
          $error['ip'] = $matches[1];
          $error['request_method'] = $matches[2];
          $error['url'] = $matches[3];
          $error['date'] = $matches[4];
        break;
        case 1:
          $title_arr = explode('][', substr($title, 1 , strlen($title) - 2));
          $error['date'] = $title_arr[0];
          $error['ip'] = $title_arr[1];
          $error['url'] = $title_arr[2];
        break;
      }

      $error['content'] = $errors[$i];;
    }
  }

  function _getErrorLogFilePath()
  {
    $conf = lmbToolkit :: instance()->getConf('server_info');
    return $conf['error_log']['file_path'];
  }

  function _getErrorLogSeparator()
  {
    $conf = lmbToolkit :: instance()->getConf('server_info');
    return $conf['error_log']['separator'];
  }

  function _getErrorLogStyle()
  {
    $conf = lmbToolkit :: instance()->getConf('server_info');
    return $conf['error_log']['error_log_style'];
  }

  function doTestEmail()
  {
    $this->mail_config = lmbToolkit::instance()->getMailConf();

    $this->UseForm('test_email');
    $this->setFormDataSource($this->request);
    if($this->request->hasPost())
    {
      $this->validator->addRule(new lmbEmailRule('sender'));
      $this->validator->addRule(new lmbEmailRule('recipient'));

      $this->validator->addRequiredRule('sender');
      $this->validator->addRequiredRule('recipient');
      $this->validator->addRequiredRule('subject');
      $this->validator->addRequiredRule('content');

      $this->validator->validate($this->request);
      if($this->validator->isValid())
      {
        $mailer_name = $this->mail_config->get('mailer', 'lmbMailer');
        lmb_require('limb/mail/src/'.$mailer_name.'.class.php');
        $mailer = new $mailer_name($this->mail_config);

        try
        {
          $mailer->sendHtmlMail($this->request->getPost('recipient'),
                                $this->request->getPost('sender'),
                                $this->request->getPost('subject'),
                                $this->request->getPost('content'));
        }
        catch(lmbExeception $e)
        {
          return $this->flash('При отсылке почты произошли ошибки!');
        }
        return $this->flash('Отсылка почты прошла успешно!');
      }
    }
  }

  function doViewFile()
  {
    $this->content = null;
    $this->type = null;

    $this->UseForm('view_file');
    $this->setFormDataSource($this->request);
    if($this->request->hasPost())
    {
      if(!$file_path = $this->request->getPost('file_path', false))
        return $this->addError('Файл не указан!');

      $file_path = CMS_DIR . $file_path;

      if(!file_exists($file_path))
        return $this->addError('Файл не найден!');

      try
      {
        if(is_file($file_path))
        {
          $file_name = array_pop(explode(DIRECTORY_SEPARATOR, $file_path));
          if(strstr($file_name, '.'))
          {
            $ext = strtolower(array_pop(explode('.', $file_path)));
            if(in_array($ext, array('gif', 'jpg', 'png', 'jpeg', 'bmp', )))
            {
              $this->type = 'image';
              $this->content = "/admin_server_info/get_file?file_path=$file_path";
            }
            elseif(in_array($ext, array('swf', )))
            {
              $this->type = 'flash';
              $this->content = "/admin_server_info/get_file?file_path=$file_path";
            }
            elseif(in_array($ext, array('txt', 'php', 'htmml', 'phtml', 'bmp')))
            {
              $this->type = 'text';
              $this->content = file_get_contents($file_path);
            }
            else
            {
              $this->type = 'file';
              $this->content = file_get_contents($file_path);
            }
          } 
          else
          {
            $this->type = 'file';
            $this->content = file_get_contents($file_path);
          }
        }
        elseif(is_dir($file_path))
        {
          $this->content = scandir($file_path);
          $this->type = 'dir';
        }
      }
      catch(lmbExeception $e)
      {
        return $this->addError('Ошибка при чтении файлы: ' . $e->getMessage());
      }
    }
  }

  function doGetFile()
  {
    if(!$file_path = $this->request->getGet('file_path', false))
      return '404';

    $mode = $this->request->getGet('mode', 'view');

    $ext = strtolower(array_pop(explode('.', $file_path)));
    $mime_type = lmbMimeType :: getMimeType($ext);
    $file_size = filesize($file_path);
    $file_name = array_pop(explode(DIRECTORY_SEPARATOR, $file_path));

    header("Content-type: {$mime_type}");
    if($mode == 'get')
      header("Content-Disposition: attachment; filename=\"{$file_name}\"");
    header("Content-Length: {$file_size}");
    readfile($file_path);
  }

  function doSql()
  {
    $this->content = null;
    $this->UseForm('sql');
    $this->setFormDataSource($this->request);
    if($this->request->hasPost())
    {
      if(!$sql = $this->request->getPost('sql', false))
        return $this->addError('Запрос не указан!');

      try
      {
        if($this->request->getPost('execute'))
          $this->content = lmbDBAL :: execute($sql);
        else
          $this->content = lmbDBAL :: fetch($sql);
      }
      catch(lmbDbException $e)
      {
        return $this->addError('Ошибка при выполнении запроса: ' . $e->getMessage());
      }
    }
  }
}
