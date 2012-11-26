<?php
lmb_require('limb-cms/core/src/controller/AdminController.class.php');

class AdminManualController extends AdminController
{
  function doDisplay()
  {
    $main_doc_file_name = 'ru.html';
    $this->content = file_get_contents( $this->_getDocPath() . '/' . $main_doc_file_name );
  }
  
  private function _getDocPath()
  {
    return CMS_DIR . '/docs';
  }
}
