<?php
lmb_require('bitcms/base/src/service/MailService.class.php');

class UserMailService extends MailService
{
  function sendMail($mail_template_identifier, $user, $extra_data = array())
  {
    $data = new lmbSet($user->export());
    $data->import($extra_data);

    $mail_template = MailTemplate::findOneItem($mail_template_identifier);

    $body = $mail_template['content'];
    $subject = $mail_template['subject'];
    foreach($data->export() as $key => $replace)
    {
      if(!is_object($replace))
        $body = str_replace("%" . $key . "%", $replace, $body);

      if(!is_object($replace))
        $subject = str_replace("%" . $key . "%", $replace, $subject);
    }

    $mailer = $this->_createMailer();
    return $mailer->sendHtmlMail($user->getEmail(), $mail_template['sender'], $subject, $body);
  }
}
