<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2012 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
lmb_require('limb/web_app/src/request/lmbRequestDispatcher.interface.php');
lmb_require('limb-cms/document/src/model/lmbCmsDocument.class.php');

/**
 * class lmbCmsDocumentRequestDispatcher.
 *
 * @package cms-document
 */
class lmbCmsDocumentRequestDispatcher implements lmbRequestDispatcher
{
  function dispatch($request)
  {
	$path = $request->getUriPath();
	if ($path == '/')
		return;
		
    if(!$document = lmbCmsDocument::findByUri($path))
      return;

    if(!$document->getIsPublished())
    {
      if(lmbToolkit::instance()->isWebAppDebugEnabled())
        throw new lmbException('Page not published');
      else
        return;
    }

    return array(
        'controller' => 'document',
        'action' => 'item',
        'id' => $document->getId()
    );
  }
}


