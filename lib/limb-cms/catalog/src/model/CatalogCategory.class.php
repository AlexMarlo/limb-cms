<?php
lmb_require('limb-cms/core/src/model/lmbCmsActiveRecordTreeNode.class.php');

class CatalogCategory extends lmbCmsActiveRecordTreeNode
{
  protected $_db_table_name = 'catalog_category';
  protected $_is_being_destroyed = false;

  protected $_uri;

  public $_history_stored_fields = array('title', 'identifier', 'description');

  function _defineRelations()
  {
    parent :: _defineRelations();

    $this->_has_many['products'] = array(
      'field' => 'category_id',
      'class' => 'CatalogProduct',
    );
  }

  function _createValidator()
  {
    $validator = parent :: _createValidator();

    if ($this->level !== 0)
      $validator->addRequiredRule('title', 'Поле "Заголовок" обязательно для заполнения');

    return $validator;
  }

  protected function _onAfterCopy($donor, $with_products = false)
  {
    if(!$with_products)
      return;

    foreach($donor->getProducts() as $product)
      $product->copy($this);
  }

  function getUri()
  {
    if(!$this->_uri)
      $this->_uri = '/catalog' . ($this->isRoot() ? '' : $this->getTree()->getPathToNode($this->getId()));

    return $this->_uri;
  }
}

