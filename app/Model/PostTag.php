<?php
    class PostTag extends AppModel {
        public $useTable = 'post_tags';
        public $belongsTo = array(
            'Tag' => array(
                'className' => 'Tag',
                'foreignKey' => 'tag_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            'Post' => array(
                'className' => 'Post',
                'foreignKey' => 'post_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            )
        );
    }
?>