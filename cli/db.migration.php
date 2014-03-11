#!/usr/bin/php
<?php
error_reporting(E_ALL);
ini_set("display_errors", "on");
ini_set("log_errors", "on");
//ini_set("error_log", "/var/log/php_errors.log");

define('CMS_ROOT', dirname(__FILE__) . '/..');
define('DB_MIGRATION_ROOT', CMS_ROOT . '/lib/limb-app-dbman');
define('SETTINGS_PATH', CMS_ROOT . '/settings');
define('DB_MIGRATION_LIB',  DB_MIGRATION_ROOT . '/src');

require_once(DB_MIGRATION_LIB . '/CliRunner.class.php');

$runner = new CliRunner();
$runner->setCliParams( $argv);
$runner->applyParamsFromFile( SETTINGS_PATH . '/migration.conf.override.php');
$runner->applyParamsFromFile( SETTINGS_PATH . '/migration.conf.php');

if(!$runner->IsCommandAsked() || $runner->isUsageAsked())
{
  $runner->showUsage();
  exit;
}

$runner->run();
