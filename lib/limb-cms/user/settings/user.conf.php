<?php

$conf = array(
  'photo' => array(
    'allowed_file_types' => array('image/jpeg', 'image/gif', 'image/png', 'image/pjpeg'),
    'max_file_size' => 2000000,

    'store_rules' => array(
      'path' => lmb_env_get('PROJECT_DIR') . '/www/media/user/',
      'url' =>  '/media/user/',
    ),

    'variations' => array(
      array(
        'name' => 'large',
        'method' => 'resize_fixed_width',
        'frame' => array('width' => 640, 'height' => 480),
      ),

      array(
        'name' => 'avatar',
        'method' => 'resize_fixed_width',
        'frame' => array('width' => 200, 'height' => 150),
      ),

      array(
        'name' => 'userpic',
        'method' => 'resize_fixed_width',
        'frame' => array('width' => 64, 'height' => 64),
      ),
    ),
  ),
);