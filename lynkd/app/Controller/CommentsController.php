<?php
App::uses('AppController', 'Controller');
/**
 * Comments Controller
 *
 * @property Comment $Comment
 */
class CommentsController extends AppController {


   public function beforeFilter(){
		            parent::beforeFilter();
					$this->Auth->allow(array('postcomment'));
                         
	     }
		 
		 
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		$this->set('comment', $this->Comment->read(null, $id));
	}

	 public function postcomment(){
          $id = $this->request->query['blog_id'];
          //debug($id);exit;
        $res1 = $this->Comment->find('all',array('conditions'=>array('Comment.blog_id'=>$id)));   
       //debug($res1);exit;
        $this->set('response',$res1);
        $this->render('ajax', 'ajax');

    }
/**
 * add method
 *
 * @return void
 */
	/*public function add() {
		if ($this->request->is('post')) {
			$id= $this->Auth->user('id');
			$this->request->data['Comment']['user_id']= $id;
			$this->Comment->create();
			if ($this->Comment->save($this->request->data)) {          
              $response['error'] = '0';
              $response['message'] = 'posting successfully';
              $response['redirect'] = '/Users/welcome/';              
              $this->set('response',$response);
			  } else {
				$response['error'] = '1';
				$response['message'] = 'Please Try Again.';
				$this->set('response',$response);
			}
		}
	}*/
         
        public function add() 
		{
		if ($this->request->is('post')) 
		{ 

			$id= $this->Auth->user('id');
			$this->request->data['Comment']['user_id']= $id;
                        $this->request->data['Comment']['status']= 1;
			$this->request->data['Comment']['comment']= $_REQUEST['comment'];
                        $this->request->data['Comment']['blog_id']= $_REQUEST['blog_id'];
			
			$this->Comment->create();
			if ($this->Comment->save($this->request->data)) {          
				echo 'true'; exit;
			  } 
			else {
				echo 'false'; exit;
			} 
						
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Comment->read(null, $id);
		}
		$users = $this->Comment->User->find('list');
		$parentComments = $this->Comment->ParentComment->find('list');
		$this->set(compact('users', 'parentComments'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete() {
            $this->layout = "ajax";
                if ($this->request->is('post')) {
                    $id =  $this->request->data['id'];
                    $this->Comment->id =$id;
                    if ($this->Comment->delete()) {
                         $response['error'] = '0';				
                            $response['message'] = 'Comment has been deleted.';                            
                            $this->set('response',$response);
                    }
                }
		//$this->Session->setFlash(__('Groupcomment was not deleted'));
		//$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		$this->set('comment', $this->Comment->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Comment->create();
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
			}
		}
		$users = $this->Comment->User->find('list');
		$parentComments = $this->Comment->ParentComment->find('list');
		$this->set(compact('users', 'parentComments'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Comment->read(null, $id);
		}
		$users = $this->Comment->User->find('list');
		$parentComments = $this->Comment->ParentComment->find('list');
		$this->set(compact('users', 'parentComments'));
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->Comment->delete()) {
			$this->Session->setFlash(__('Comment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Comment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
