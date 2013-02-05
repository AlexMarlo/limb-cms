<?php
lmb_require('limb/constructor/src/lmbFormConstructorHelper.class.php');

class FormConstructorHelper extends lmbFormConstructorHelper
{
  protected function _createFieldDatetime($column)
  {
    return ' <? $value = $this->item->get("%%%") ? $this->item->get("%%%") : date(); ?> '.
           ' [[date3Select id="%%%" name="%%%" title="%%%" class="date3select" lang="ru" value="[$value]" format="%s" /]]';
  }

  protected function _createFieldUploadImageFile($column)
  {
    return  ' <? $object_name = str_replace("_ext", "", "%%%"); ?> ' . 
            ' [[include file="_admin_include/upload_image_tpl.phtml" /]] ' . 
            ' [[apply template="upload_image" host_object="[$#item]" object_name="[$object_name]" prewiew_variation="preview" /]] ';
  }

  /**
   * @param lmbDbColumnInfo $column
   */
  protected function _createFormFieldHtmlWithoutColumnName($column)
  {
    if($column->getType() === lmbDbTypeInfo::TYPE_CLOB)
      return $this->_createFieldWysiwyg($column);

    if($column->getType() === lmbDbTypeInfo::TYPE_CHAR || $column->getType() === lmbDbTypeInfo::TYPE_VARCHAR)
    {
      if(strstr($column->getName(), '_ext'))
        return $this->_createFieldUploadImageFile($column);
      
      else if(255 >= $column->getSize())
        return $this->_createFieldInput($column);
      
      else
        return $this->_createFieldTextArea($column);
    }

    if( $column->getType() === lmbDbTypeInfo::TYPE_BIT ||
        $column->getType() === lmbDbTypeInfo::TYPE_BOOLEAN ||
        $column->getType() === lmbDbTypeInfo::TYPE_SMALLINT
    )
      return $this->_createFieldCheckbox($column);

    if( strstr($column->getName(), 'time') ||
        strstr($column->getName(), 'date')
    )
      return $this->_createFieldDatetime($column);

    return $this->_createFieldInput($column);
  }
}