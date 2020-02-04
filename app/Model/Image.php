<?php
    class Image extends AppModel {
        public $useTable = 'images';

        public $actsAs = array(
            'Upload.Upload' => array(
              'name' => array(
                'fields' => array(
                  'dir' => 'image_dir'
                ),
                'thumbnailSizes' => array(
                  'xvga' => '1024x768',
                  'vga' => '640x480',
                  'thumb' => '80x80',
                ),
              ),
            ),
          );
        
        public $belongsTo = array(
            'Post' => array(
                'foreignKey' => 'post_id'    
            )
        );
    }
?>