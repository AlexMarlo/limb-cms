<?php
lmb_require('limb/constructor/src/lmbProjectConstructor.class.php');

class ProjectConstructor extends lmbProjectConstructor
{
  protected function _getFinderDir()
  {
    return $this->_project_dir.'/src/finder';
  }

  function addFinder($name, $content)
  {
    $this->_addFile($this->_getFinderDir(), $name, $content);
  }
}
