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


