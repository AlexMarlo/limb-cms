<?php
lmb_require('limb/cms/src/model/lmbCmsUserRoles.class.php');

$editor = array(array('title' => lmb_i18n('Content', 'cms'), 'icon' => '/shared/cms/images/icons/menu_content.png',  'children' => array(
  array(
    'title' => 'Текстовые страницы',
    'url' => '/admin_document',
    'icon' => '/shared/cms/images/icons/page.png',
  ),
  array(
    'title' => 'Меню',
    'url' => '/admin_menu',
    'icon' => '/shared/cms/images/icons/link.png',
  ),
  array(
    'title' => 'Текстовые блоки',
    'url' => '/admin_text_block',
    'icon' => '/shared/cms/images/icons/layout.png',
  ),
  array(
    'title' => 'SEO',
    'url' => '/admin_seo',
    'icon' => '/shared/cms/images/icons/page_white_stack.png',
  ),
  array(
    'title' => 'Счетчики',
    'url' => '/admin_counter',
    'icon' => '/shared/cms/images/icons/layout.png',
  ),
)));

$only_admin = array(array('title' => lmb_i18n('Administration', 'cms'), 'icon' => '/shared/cms/images/icons/menu_service.png','children' => array(
  array(
    'title' => lmb_i18n('Administrators', 'cms'),
    'url' => '/admin_user',
    'icon' => '/shared/cms/images/icons/user.png',
  ),
  array(  
    'title' => lmb_i18n('Documentation', 'cms'),  
    'url' => '/admin_manual',  
    'icon' => '/shared/cms/images/icons/book.png',  
  ),
  array(
    'title' => lmb_i18n('Server Info', 'cms'),
    'url' => '/admin_server_info',
    'icon' => '/shared/cms/images/icons/server.png',
  ),
)));

$conf = array(
  lmbCmsUserRoles :: EDITOR  => $editor,
  lmbCmsUserRoles :: ADMIN  => array_merge_recursive($editor, $only_admin)
);

