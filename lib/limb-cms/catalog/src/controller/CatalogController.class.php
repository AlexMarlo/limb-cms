<?php
lmb_require('limb-cms/catalog/src/finder/CatalogFinder.class.php');

class CatalogController extends lmbController
{
  function doCategory()
  {
    if(!$this->item = CatalogFinder :: findById((int)$this->request->get('id')))
      return $this->forwardTo404();
    
    $this->children = CatalogFinder :: findChildren($this->item);
    
    $this->products = CatalogFinder :: findProducts($this->item);
  }
  
  function doProduct()
  {
    if(!$this->item = CatalogFinder :: findProductById((int)$this->request->get('id')))
      return $this->forwardTo404();
  }
}