<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property User $User
 */
class Post extends AppModel {
	//searchプラグイン
	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
		array('name' => 'title', 'type' => 'like', 'field' => 'Post.title', 'connectorAnd' => ' ', 'connectorOr' => ','),
		array('name' => 'category', 'type' => 'like', 'field' => 'Category.name', 'connectorAnd' => ' ', 'connectorOr' => ','),
		array('name' => 'tag', 'type' => 'subquery', 'field' => 'Post.id', 'method' => 'findByTags')
	);

	public function findByTags($data = array()) {
		$this->PostTag->Behaviors->attach('Containable', array('autoFields' => false));
		$this->PostTag->Behaviors->attach('Search.Searchable');
		//入力検索でのタグ検索の場合は以下の通り
		//$tagId2 = $this->Tag->query("select id from tags where name = '". $data['tag'] ."';");
		// $options = array(
		//     'conditions' => array(
		//         'Tag.name Like' => '%'. $data['tag']. '%'
		//     ),
		//     'fields' => array('Tag.id')
		// );
		// $tagId = $this->Tag->find('all', $options);
		$query = $this->PostTag->getQuery('all', array(
		'conditions' => array('tag_id' => $data['tag']),
		'fields' => array('post_id'),
		'contain' => $this->Tag->alias,
		));
		return $query;
	}

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

	//バリデーション
	public $validate = array(
		'title' => array(
			'allowEmpty' => true,
			'rule' => 'notBlank'
		),
		'body' => array(
			'rule' => 'notBlank'
		)
	);

	//アソシエーション
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'foreignKey' => 'category_id'   
		)
	);


	public $hasMany = array(
		'Image' => array(
			'foreignKey' => 'post_id'    
		)
	);
	public $hasAndBelongsToMany = array(
		'Tag' => array(
			'joinTable' => 'post_tags',
			'foreignKey'  => 'post_id',
			'associationForeignKey'  => 'tag_id',
			'with' => 'PostTag'
		)
	);

	//認証　要修正！
	// public function isOwnedBy($post, $user) {
	// 	return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
	// }

	//アップロード検証
	public function isUploadedFile($params) {
		if ((isset($params['error']) && $params['error'] == 0) ||
			(!empty( $params['tmp_name']) && $params['tmp_name'] != 'none')
		) {
			return is_uploaded_file($params['tmp_name']);
		}
		return false;
	}

}
