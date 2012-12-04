<?php
lmb_require('limb-cms/core/src/model/lmbCmsActiveRecord.class.php');

class CatalogProduct extends lmbCmsActiveRecord
{
  protected $_db_table_name = 'catalog_product';

  public $_history_stored_fields = array('title', 'price', 'article', 'description');

  protected function _defineRelations()
  {
    parent :: _defineRelations();

    $this->_many_belongs_to['category'] = array(
      'field' => 'category_id',
      'class' => 'CatalogCategory',
    );

    $this->_composed_of['image'] = array(
      'class' => 'Image',
      'mapping' => array(
        'object_id' => 'id',
        'extension' => 'image_ext',
      ),
      'setup_method' => 'setupImage',
    );
  }

  function _createValidator()
  {
    lmb_require('limb-cms/core/src/validation/rule/lmbCmsUniqueFieldRule.class.php');

    $validator = new lmbValidator();

    $validator->addRequiredRule('title', 'Поле "Заголовок" обязательно для заполнения');
    $validator->addRequiredRule('price', 'Поле "Цена" обязательно для заполнения');

    $validator->addRequiredRule('article', 'Поле "Артикул" обязательно для заполнения');
    $validator->addRule(new lmbCmsUniqueFieldRule('article', get_class($this), $this, 'Товар со значением поля "Артикул" уже существует'));

    return $validator;
  }

  function _onBeforeCreate()
  {
    parent :: _onBeforeCreate();

    $sql = "SELECT MAX(priority) FROM {$this->_db_table_name} WHERE category_id = " . $this->category->id . ";";
    $this->set('priority', (lmbDBAL::fetchOneValue($sql) + 10));

    $this->set('is_published', 0);
  }

  function setupImage($image)
  {
    $image->setup(lmbToolkit::instance()->getConf('catalog')->get('image'));
    return $image;
  }

  function getUri()
  {
    return '/catalog/product/' . $this->id;
  }
}
