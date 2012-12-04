<?php
$conf = array();

//-- attached image file
$conf['image'] = array(

  'allowed_file_types' => array('image/jpeg', 'image/gif', 'image/png', 'image/pjpeg'),
  'max_file_size' => 10000000, // 10Mb

  'store_rules' => array(
    'path' => lmb_env_get('PROJECT_DIR') . '/www/media/catalog_storage/',
    'url' => '/media/catalog_storage/',
   ),

  'variations' => array(
    array(
      'name' => '',
      'method' => 'resize_full_frame',
      'frame' => array('width' => 300, 'height' => 200)),

    array(
      'name' => 'preview',
      'method' => 'resize_full_frame',
      'frame' => array('width' => 150, 'height' => 100)),
    ),
);


//-- csv mapping
$conf['csv_fields_mapping'] = array(
  'article' => 'Артикул',
  'title' => 'Название',
  'price' => 'Цена',
  'description' => 'Описание',
);


//-- csv import file
$conf['csv_file'] = array(
  'allowed_file_types' => array('text/csv', 'text/txt'),
  'max_file_size' => 10000000, // 10Mb
);
