<?php
lmb_require('limb/web_app/src/request/lmbRequestDispatcher.interface.php');
lmb_require('limb/tree/src/lmbMPTree.class.php');

class TreeRequestDispatcher implements lmbRequestDispatcher
{
  protected $_db_table_name;
  protected $_controller_name;
  protected $_action_name;
  protected $_prefix;

  function __construct($db_table_name, $controller_name, $action_name = 'item', $prefix = null)
  {
    $this->_db_table_name = $db_table_name;
    $this->_controller_name = $controller_name;
    $this->_action_name = $action_name;

    if($prefix)
      $this->_prefix = str_replace('/', '', $prefix);
  }

  function dispatch($request)
  {
    $toolkit = lmbToolkit :: instance();
    $uri = $toolkit->request->getUri()->toString();
    if(substr($uri, 0, 6) == '/admin')
      return;

    $tree = new lmbMPTree($this->_db_table_name);
    $node_path = $this->_getNodePath($request);

    if(!$node = $tree->getNodeByPath($node_path))
      return;
    
    if(!$this->_prefix && $node['parent_id'] == 0)
      return;

    if(!$node['is_published'] && $node['level'] != 0)
        return;

    return array(
      'controller' => $this->_controller_name,
      'action' => $this->_action_name,
      'id' => $node['id']
    );
  }

  protected function _getNodePath($request)
  {
    $node_path = preg_replace('~\/+~', '/', $request->getUriPath());

    if($this->_prefix)
    {
      if($this->_prefix == substr($node_path, 1, strlen($this->_prefix)))
        $node_path = substr_replace($node_path, '', 1, strlen($this->_prefix));
      else
        return '';
    }

    $node_path = preg_replace('~\/+~', '/', $node_path);
    return $node_path;
  }
}


