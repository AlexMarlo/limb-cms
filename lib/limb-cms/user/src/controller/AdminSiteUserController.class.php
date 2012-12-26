<?php
lmb_require('limb-cms/core/src/controller/AdminObjectController.class.php');
lmb_require('src/finder/UserFinder.class.php');
lmb_require('limb-cms/core/src/helper/VisitorAuthorizationHelper.class.php');

class AdminSiteUserController extends AdminObjectController
{
  protected $_object_class_name = 'User';

  protected $_filtered_fields = array('name', 'email', 'is_banned', 'is_activated');

  function doLoginLike()
  {
    if(!$this->item = $this->_getObjectByRequestedId())
      return $this->forwardTo404();

    VisitorAuthorizationHelper::loginUser($this->item);
    $this->redirect('/user_home');
  }

  protected function _onAfterImport()
  {
    if( $this->item->is_activated)
    {
     // echo 1; exit;
      $password = VisitorAuthorizationHelper::cryptPasswordFor( $this->item, $this->item->password);
      $this->item->setPassword( $password);
    }
  }
}