<?php
    class Tag extends AppModel {
        public $useTable = 'tags';
        public $hasAndBelongsToMany = array(
            'Post' => array(
                'joinTable' => 'post_tags',
                'foreignKey'  => 'tag_id',
                'associationForeignKey'  => 'post_id',
                'with' => 'PostTag'
            )
        );
    }
?>