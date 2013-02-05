<?php
lmb_require('limb/dbal/src/criteria/lmbSQLCriteria.class.php');

class ConstructorHelper
{
  static protected $_not_history_stored_fiels = array('path');

  static function detectHistoryStoredFields($table)
  {
    $history_stored_fields = array();
    foreach($table->getColumns() as $column)
    {
      if(
        !in_array($column->getName(), self :: $_not_history_stored_fiels) && (
          $column->getType() === lmbDbTypeInfo::TYPE_CLOB ||
          ( ($column->getType() === lmbDbTypeInfo::TYPE_CHAR || $column->getType() === lmbDbTypeInfo::TYPE_VARCHAR) && !strstr($column->getName(), '_ext') )
        )
      )
      {
        $history_stored_fields[] = $column->getName();
      }
    }

    return $history_stored_fields;
  }

  static function detectHistoryExists($table)
  {
    return (bool) count(self::detectHistoryStoredFields($table));
  }

  static function detectAttachedImages($table)
  {
    $attached_images = array();
    foreach($table->getColumns() as $column)
    {
      if( ($column->getType() === lmbDbTypeInfo::TYPE_CHAR || $column->getType() === lmbDbTypeInfo::TYPE_VARCHAR) &&
          strstr($column->getName(), '_ext') )
      {
        $attached_images[] = str_replace('_ext', '', $column->getName());
      }
    }

    return $attached_images;
  }

  static function detectDefaultSortParams($table)
  {
    $columns_names = array_keys($table->getColumns());

    if(in_array('priority', $columns_names))
      return array('field' => 'priority', 'direction' => 'ASC');

    else if(in_array('reverse_id', $columns_names))
      return array('field' => 'reverse_id', 'direction' => 'ASC');

    else if(in_array('title', $columns_names))
      return array('field' => 'title', 'direction' => 'ASC');

    return array('field' => 'id', 'direction' => 'DESC');
  }

  static function addCpModule($model_name, $project_dir)
  {
    self :: createAdminNavigationItem($model_name);
    self :: mergeAllowedController($model_name, $project_dir);
  }

  static function createAdminNavigationItem($model_name)
  {
//     $criteria = lmbSQLCriteria::equal('title', $model_name);
//     if(lmbActiveRecord :: findOne('AdminNavigationItem', array('criteria' => $criteria)))
//       return;

//     $groups = AdminNavigationGroup :: findAllItems();
//     $groups->rewind();

//     $group = $groups->current();
//     $controller_name = 'admin_' . lmb_under_scores($model_name);
//     $icon = '/shared/base/images/icons/brick.png';

//     AdminNavigationItem :: create($model_name, $group->getIdentifier(), $model_name, '/' . $controller_name, $icon, $controller_name);
  }

  static function mergeAllowedController($model_name, $project_dir)
  {
//     $file = $project_dir . '/settings/admin_user_group.conf.php';
//     $stuff_name = lmb_under_scores($model_name);
//     $file_content = file_get_contents($file);

//     if(strpos($file_content, $stuff_name) || !strpos($file_content, "//-- admin_allowed_controllers_list"))
//       return;

//     $content = str_replace("//-- admin_allowed_controllers_list", "'admin_" . $stuff_name . "', //-- admin_allowed_controllers_list", $file_content);
//     lmbFS :: safeWrite($file, $content);
  }

  static function mergeDispatcher($model_name, $project_dir)
  {
//     $file = $project_dir . '/src/filter/ProjectRequestDispatchingFilter.class.php';
//     $stuff_name = lmb_under_scores($model_name);
//     $file_content = file_get_contents($file);
//     $stuff_dispatcher_str = "\$dispatcher->addDispatcher(new TreeRequestDispatcher('" . $stuff_name . "', '" . $stuff_name . "', 'item', '" . $stuff_name . "'));";

//     if(strpos($file_content, $stuff_dispatcher_str) || !strpos($file_content, "//-- tree_stuff_request_dispatcher"))
//       return;

//     $content = str_replace("//-- tree_stuff_request_dispatcher", $stuff_dispatcher_str . PHP_EOL . "    //-- tree_stuff_request_dispatcher", $file_content);
//     lmbFS :: safeWrite($file, $content);
  }
}