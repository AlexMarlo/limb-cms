<?php

class CatalogFinder
{
  static function findById($id)
  {
    return CatalogCategory :: findById($id, false);
  }

  static function findChildren($parent)
  {
    $sql = "SELECT * FROM `catalog_category` WHERE `parent_id` = {$parent->id} AND `is_published` = 1 ORDER BY priority ASC";

    return CatalogCategory :: findBySql($sql);
  }

  static function findProductById($id)
  {
    return CatalogProduct :: findById($id, false);
  }

  static function findProducts($category)
  {
    $sql = "SELECT * FROM `catalog_product` WHERE `category_id` = {$category->id} AND `is_published` = 1 ORDER BY priority ASC";

    return CatalogProduct :: findBySql($sql);
  }
}


