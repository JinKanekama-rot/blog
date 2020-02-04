<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class PostsController extends AppController {


	public $name = 'Posts';  
	public $uses = array('Post', 'Category', 'Tag');
	//コンポーネント
	public $components = array('Paginator', 'Session', 'Flash', 'Search.Prg');
	public $presetVars = array(  
		'title' => array('type' => 'value'),  
		'category' => array('type' => 'value'),  
		'tag' => array('type' => 'value'),
	  ); 
	public $helpers = array('Html', 'Form');

	
	//コールバック
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view');
		// ページャ設定  
		$pager_numbers = array(  
			'before' => ' - ',  
			'after'=>' - ',  
			'modulus'=> 10,  
			'separator'=> ' ',  
			'class'=>'pagenumbers'  
		);  
		$this->set('pager_numbers', $pager_numbers);  
	}

	//承認　要修正！
	// public function isAuthorized($user) {
	// 	// 登録済ユーザーは投稿できる
	// 	if ($this->action === 'add') {
	// 		return true;
	// 	}
	
	// 	// 投稿のオーナーは編集や削除ができる
	// 	if (in_array($this->action, array('edit', 'delete'))) {
	// 		$postId = (int) $this->request->params['pass'][0];
	// 		if ($this->Post->isOwnedBy($postId, $user['id'])) {
	// 			return true;
	// 		}
	// 	}
	
	// 	return parent::isAuthorized($user);
	// }

	//投稿一覧表示
	public function index() {
		$this->loadModel('Tag');
		$this->Prg->commonProcess();

		
		$conditions = $this->Post->parseCriteria($this->passedArgs);
		$this->paginate = array(  
			'conditions' => $conditions,
			'limit' => 8 ,
			'order' => array('Post.id' => 'asc')
		);
		$this->set('posts', $this->paginate('Post'));  
		$tagcheck =  $this->Tag->find( 'list', array( 
			'fields' => array( 'id', 'name')
		));
		
		$this->set( 'tagCheck', $tagcheck);
	}

	//詳細表示
	public function view($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}

		$post = $this->Post->findById($id);
		if (!$post) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->set('post', $post);
	}

	//投稿
	public function add() {
		$this->loadModel('Category');
		$this->loadModel('Tag');

		$select = $this->Category->find('list', array('fields' => array('id', 'name')));
		$this->set('select', $select);
		
		$this->set( 'check', $this->Tag->find( 'list', array( 
			'fields' => array( 'id', 'name')
		)));

		//postで受信
		if ($this->request->is('post')) {
			$this->Post->create();
			$this->request->data['Post']['user_id'] = $this->Auth->user('id');
			//デバッグ
			Debugger::dump($this->request->data['Image']);
			//アップロード検証
			for ($i=0; $i<3; $i++) {
				if (!$this->Post->isUploadedFile($this->request->data['Image'][$i]['name'])){
					unset($this->request->data['Image'][$i]);
				}
			}
			if ($this->Post->saveAll($this->request->data, array('deep' => true))) {
				
				$this->Flash->success(__('Your post has been saved.'));
				return $this->redirect(array('action' => 'index'));
				
			}  
		}
	}

	//編集機能
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid post'));
		}

		$post = $this->Post->findById($id);
		if (!$post) {
			throw new NotFoundException(__('Invalid post'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->Post->id = $id;
			if ($this->Post->save($this->request->data)) {
				$this->Flash->success(__('Your post has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Flash->error(__('Unable to update your post.'));
		}

		if (!$this->request->data) {
			$this->request->data = $post;
		}
	}

	//削除機能
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		$post = $this->Post->findById($id);
		$images = $post['Image'];
		if ($this->Post->delete($id)) {
			foreach ($images as $i){
				$dir_path = "/var/www/html/blogapp/app/webroot/files/image/name/".$i['image_dir'];
				$files = array_diff(scandir($dir_path), array('.','..'));
				foreach ($files as $file) {
					$file_path =  $dir_path ."/".$file;
					if (is_file($file_path)) { 
						// ファイルを削除
						unlink($file_path);
					}
				}
				if (is_dir($dir_path)) {
					//ディレクトリを削除
					rmdir($dir_path);
				} 
			}
			$this->Flash->success(
				__('The post with id: %s has been deleted.', h($id))
			);
		} else {
			$this->Flash->error(
				__('The post with id: %s could not be deleted.', h($id))
			);
		}

		return $this->redirect(array('action' => 'index'));
	}
}
