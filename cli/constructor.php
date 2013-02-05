<?php

function lmb_cli_ask_for_accept($question)
{
  do
  {
    fputs(STDOUT, "{$question} [y/n]: ");
    $user_in = trim(fgets(STDIN));
  }
  while($user_in != 'y' && $user_in != 'n');

  return $user_in == 'y' ? true : false;
}

/**
 *@always
 */
function task_init_constructor()
{
  lmb_require('limb-cms/constructor/src/ProjectConstructor.class.php');
  $override_files = taskman_propor('OVERRIDE', false);
  $project_constructor = new ProjectConstructor(taskman_prop('CMS_DIR'), $override_files);
  taskman_propset('CONSTRUCTOR', $project_constructor);
  taskman_sysmsg("Constructor initialized...\n");
}

function _filter_tables($tables, $filter)
{
  foreach ($tables as $key => $table)
    if(strstr($table->getName(), $filter))
    {
      taskman_msg('FILTER: table \'' . $table->getName() . '\' filtered by rule \''.$filter.'\''.PHP_EOL);
      unset($tables[$key]);
    }
  return $tables;
}

/**
 *@todo must be "always", but always dont receive args by default
 */
function task_parse_table_argument($args)
{
  $database_info = lmbToolkit :: instance()->getDefaultDbConnection()->getDatabaseInfo();
  taskman_msg('DATABASE: '.$database_info->getName().PHP_EOL);

  if('all' !== $args[0])
    $tables = array($database_info->getTable($args[0]));
  else
    $tables = _filter_tables($database_info->getTables(), 'lmb_');

  if(!count($tables))
  {
    taskman_sysmsg('No tables found in '.$args[0]);
    exit(1);
  }

  taskman_propset('TABLES', $tables);
}

function _createAndRunConstructor($constructor_name)
{
  $database_info = lmbToolkit :: instance()->getDefaultDbConnection()->getDatabaseInfo();

  foreach(taskman_prop('TABLES') as $table)
  {
    $constructor = new $constructor_name(
      $project = taskman_prop('CONSTRUCTOR'),
      $database_info,
      $table,
      $model_name = lmb_camel_case($table->getName()),
      $templates_dir = taskman_prop('TEMPLATES_DIR')
    );
    $constructor->create();
    taskman_msg('CONSTRUCTOR: ' . $constructor_name . ' on table ' . $table->getName() . PHP_EOL);
  }
}


//-- plain view

/**
 * @desc create model specified by table name
 * @param table_name|all
 * @deps parse_table_argument
 */
function task_create_model()
{
  _createAndRunConstructor('ModelConstructor');
  _createAndRunConstructor('ConfigConstructor');
}


/**
 * @desc create admin controller and admin templates for entity specified by table name
 * @param table_name|all
 * @deps parse_table_argument
 */
function task_create_admin()
{
  task_create_model();
  _createAndRunConstructor('AdminControllerConstructor');
  _createAndRunConstructor('AdminTemplatesConstructor');
}


/**
 * @desc create front controller and front templates for entity specified by table name
 * @param table_name|all
 * @deps parse_table_argument
 */
function task_create_front()
{
  task_create_model();
  _createAndRunConstructor('FrontStuffConstructor');
}


/**
 * @desc create back controller and back templates for entity specified by table name
 * @param table_name|all
 * @deps parse_table_argument
 */
function task_create_back()
{
  task_create_model();
  _createAndRunConstructor('BackStuffConstructor');
}


/**
 * @desc create model, front and admin controllers, front and admin templates for entity specified by table name
 * @param table_name|all
 * @deps parse_table_argument
 */
function task_create()
{
  task_create_model();
  task_create_admin();
  task_create_front();
  task_create_back();
}


//-- tree view

/**
 * @desc create tree_model specified by table name
 * @param table_name|all
 * @deps parse_table_argument
 */
function task_create_tree_model()
{
  _createAndRunConstructor('TreeModelConstructor');
  _createAndRunConstructor('ConfigConstructor');
}


/**
 * @desc create tree_admin controller and tree_admin templates for entity specified by table name
 * @param table_name|all
 * @deps parse_table_argument
 */
function task_create_tree_admin()
{
  task_create_tree_model();
  _createAndRunConstructor('TreeAdminControllerConstructor');
  _createAndRunConstructor('TreeAdminTemplatesConstructor');
}


/**
 * @desc create tree_front controller and tree_front templates for entity specified by table name
 * @param table_name|all
 * @deps parse_table_argument
 */
function task_create_tree_front()
{
  task_create_tree_model();
  _createAndRunConstructor('TreeFrontStuffConstructor');
}


/**
 * @desc create model, front and admin controllers, front and admin templates for entity specified by table name
 * @param table_name|all
 * @deps parse_table_argument
 */
function task_create_tree()
{
  task_create_tree_model();
  task_create_tree_admin();
  task_create_tree_front();
}


//-- runner

$project_dir = realpath(dirname(__FILE__) . '/../');

$_ENV['LIMB_VAR_DIR'] = $project_dir . '/var/constructor';
require_once($project_dir . '/setup.php');

lmb_require('limb/taskman/taskman.inc.php');
lmb_require('limb/constructor/src/*');
lmb_require('limb-cms/constructor/src/*');

taskman_propset('CMS_DIR', $project_dir);
taskman_propset('TEMPLATES_DIR', $project_dir . '/lib/limb-cms/constructor/template/');

taskman_run();

lmbFs :: rm(lmb_env_get('LIMB_VAR_DIR'));