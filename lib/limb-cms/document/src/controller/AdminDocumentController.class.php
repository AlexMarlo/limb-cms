<?php
/**
 * Limb Web Application Framework
 *
 * @link http://limb-project.com
 *
 * @copyright  Copyright &copy; 2004-2009 BIT
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 * @version    $Id$
 * @package    cms
 */
lmb_require('limb-cms/core/src/controller/AdminTreeNodeObjectController.class.php');
lmb_require('limb-cms/core/src/model/lmbCmsDocument.class.php');

class AdminDocumentController extends AdminTreeNodeObjectController
{
  protected $_object_class_name = 'lmbCmsDocument';

  function doDisplay()
  {
    if(!$id = $this->request->getInteger('id')  ){
      $this->is_root = true;
      $criteria = new lmbSQLCriteria('parent_id > 0');
      $criteria->addAnd(new lmbSQLCriteria('level = 1'));
      $this->item = lmbCmsDocument :: findRoot();
    }
    else {
      $this->is_root = false;
      if(!$this->item = $this->_getObjectByRequestedId())
        return $this->forwardTo404();
      $criteria = new lmbSQLCriteria('parent_id = ' . $this->item->getId());
    }

    $this->items = lmbActiveRecord :: find($this->_object_class_name, array('criteria' => $criteria, 'sort'=>array('priority'=>'ASC')));
    $this->_applySortParams();
  }

  function doCreate()
  {
    if(!$this->parent = $this->_getObjectByRequestedId())
      $this->forwardTo404();

    $this->item = new $this->_object_class_name();

    $this->_onCreate();

    $this->useForm($this->_form_name);
    $this->setFormDatasource($this->item);

    if($this->request->hasPost())
    {
      $this->_import();
      $this->item->setParent($this->parent);
      $this->_validateAndSave($create = true);
    }
    else
      $this->_initCreateForm();
  }

  protected function _validateAndSave($is_create = false)
  {
    try
    {
      parent :: _validateAndSave($is_create);
    }
    catch (lmbException $e)
    {
      $this->error_list->addError('Документ со значением поля "Идентификатор" уже существует на данном уровне вложения');
    }
  }

}


