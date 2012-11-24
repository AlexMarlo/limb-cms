<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2012 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */

lmb_require('limb-cms/core/src/model/lmbCmsActiveRecordTreeNode.class.php');

/**
 * class lmbCmsDocument.
 *
 * @package cms-document
 */
class lmbCmsDocument extends lmbCmsActiveRecordTreeNode
{
  protected $_db_table_name = 'lmb_cms_document';
  protected $_lazy_attributes = array('content');
  protected $_is_being_destroyed = false;
  /**
   * @var lmbMPTree
   */
  protected $_tree;

  function _createValidator()
  {
    $validator = new lmbValidator();

    $validator->addRequiredRule('title', 'Поле "Заголовок" обязательно для заполнения');
    $validator->addRequiredRule('content', 'Поле "Текст" обязательно для заполнения');
    $validator->addRequiredRule('identifier', 'Поле "Идентификатор" обязательно для заполнения');

    lmb_require('limb-cms/core/src/validation/rule/lmbTreeIdentifierRule.class.php');
    $validator->addRule(new lmbTreeIdentifierRule('identifier'));

    return $validator;
  }

  function getUri()
  {
    $uri = ($this->getParent() && !$this->getParent()->isRoot()) ? $this->getParent()->getUri() : '';
    return  $uri . '/' . $this->identifier;
  }

  /**
   * @param string $uri
   * @return lmbCmsDocument
   */
  static function findByUri($uri)
  {
    $identifiers = explode('/', rtrim($uri,'/'));
    $criteria = new lmbSQLCriteria('level = 0');
    $level = 0;
    foreach($identifiers as $identifier)
    {
      $identifier_criteria = lmbSQLCriteria::equal('identifier', $identifier);
      $identifier_criteria->addAnd(lmbSQLCriteria::equal('level', $level));
      $criteria->addOr($identifier_criteria);
      $level++;
    }
    $documents = lmbActiveRecord :: find( 'lmbCmsDocument', $criteria);
    
    $parent_id = 0;
    foreach($identifiers as $identifier)
    {
      if(!$document = self :: _getNodeByParentIdAndIdentifier($documents, $parent_id, $identifier))
        return false;
      $parent_id = $document->getId();
    }
    return $document;
  }
  
  static function _getNodeByParentIdAndIdentifier($documents, $parent_id, $identifier)
  {
    foreach($documents as $document)
    {
      if(($document->getParentId() == $parent_id) and ($document->getIdentifier() == $identifier))
        return $document;
    }
    return false;
  }
}


