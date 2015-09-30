<?php
App::uses('AppController', 'Controller');
/**
 * Multichats Controller
 *
 * @property Multichat $Multichat
 */
class MultichatsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Multichat->recursive = 0;
		$this->set('multichats', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Multichat->exists($id)) {
			throw new NotFoundException(__('Invalid multichat'));
		}
		$options = array('conditions' => array('Multichat.' . $this->Multichat->primaryKey => $id));
		$this->set('multichat', $this->Multichat->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {			
                       $user_id= $this->request->data['user_id'];
                       $to_user_id= $this->request->data['to_user_id'];
                       $sql = $this->Multichat->query("SELECT * FROM `multichats` WHERE `user_id`='$user_id' AND `to_user_id`='$to_user_id'");
                       if(empty ($sql)){
                           $arr1 = $this->Multichat->query("insert into `multichats` (`id`,`user_id`,`to_user_id`) values('','$user_id','$to_user_id')");
                           $arr2 = $this->Multichat->query("insert into `multichats` (`id`,`user_id`,`to_user_id`) values('','$to_user_id','$user_id')");                           
                       }
//                       $this->loadModel('Multichat');
//                       $onlinechats=$this->Multichat->find("all",array('conditions'=>array('Multichat.user_id'=>$this->Auth->User("id"))));
//                       $this->set("response",$onlinechats);
//                       $this->render('ajax','ajax');
                       
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
		if (!$this->Multichat->exists($id)) {
			throw new NotFoundException(__('Invalid multichat'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Multichat->save($this->request->data)) {
				$this->Session->setFlash(__('The multichat has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The multichat could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Multichat.' . $this->Multichat->primaryKey => $id));
			$this->request->data = $this->Multichat->find('first', $options);
		}
		$users = $this->Multichat->User->find('list');
		$toUsers = $this->Multichat->ToUser->find('list');
		$this->set(compact('users', 'toUsers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Multichat->id = $id;
		if (!$this->Multichat->exists()) {
			throw new NotFoundException(__('Invalid multichat'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Multichat->delete()) {
			$this->Session->setFlash(__('Multichat deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Multichat was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        public function del(){
           if ($this->request->is('post')) {			
                   $user_id= $this->request->data['user_id'];
                   $to_user_id= $this->request->data['to_user_id'];
                   $qry=$this->Multichat->query("DELETE FROM `multichats` where `user_id`='$user_id' AND `to_user_id`='$to_user_id'");
                   $qry1=$this->Multichat->query("DELETE FROM `multichats` where `user_id`='$to_user_id' AND `to_user_id`='$user_id'");
           }
            
        }
}
