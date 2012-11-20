<?php

if(file_exists( SETTINGS_PATH . '/db.conf.override.php'))
  require_once( SETTINGS_PATH . '/db.conf.override.php');
else
  require_once( SETTINGS_PATH . '/db.conf.php');

$migration_conf = array(
  'dsn' => $conf['dsn'],
  'schema' => CMS_ROOT . '/sql/schema.sql',
  'data' => CMS_ROOT . '/sql/data.sql',
  'migrations' => CMS_ROOT . '/sql/migrations/',
);
