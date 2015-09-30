<?php
App::uses('AppController', 'Controller');
/**
 * Connections Controller
 *
 * @property Connection $Connection
 */
class ConnectionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Connection->recursive = 0;
		$this->set('connections', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Connection->id = $id;
		if (!$this->Connection->exists()) {
			throw new NotFoundException(__('Invalid connection'));
		}
		$this->set('connection', $this->Connection->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Connection->create();
			if ($this->Connection->save($this->request->data)) {
				$this->Session->setFlash(__('Connection Successfully'));
				$this->redirect(array('controller'=>'users','action' => 'other_people'));
			} else {
				$this->Session->setFlash(__('The connection could not be created. Please, try again.'));
			}
		}
		$users = $this->Connection->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Connection->id = $id;
		if (!$this->Connection->exists()) {
			throw new NotFoundException(__('Invalid connection'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Connection->save($this->request->data)) {
				$this->Session->setFlash(__('The connection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The connection could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Connection->read(null, $id);
		}
		$users = $this->Connection->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Connection->id = $id;
		if (!$this->Connection->exists()) {
			throw new NotFoundException(__('Invalid connection'));
		}
		if ($this->Connection->delete()) {
			$this->Session->setFlash(__('Connection deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Connection was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Connection->recursive = 0;
		$this->set('connections', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Connection->id = $id;
		if (!$this->Connection->exists()) {
			throw new NotFoundException(__('Invalid connection'));
		}
		$this->set('connection', $this->Connection->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Connection->create();
			if ($this->Connection->save($this->request->data)) {
				$this->Session->setFlash(__('The connection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The connection could not be saved. Please, try again.'));
			}
		}
		$users = $this->Connection->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Connection->id = $id;
		if (!$this->Connection->exists()) {
			throw new NotFoundException(__('Invalid connection'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Connection->save($this->request->data)) {
				$this->Session->setFlash(__('The connection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The connection could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Connection->read(null, $id);
		}
		$users = $this->Connection->User->find('list');
		$this->set(compact('users'));
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
		$this->Connection->id = $id;
		if (!$this->Connection->exists()) {
			throw new NotFoundException(__('Invalid connection'));
		}
		if ($this->Connection->delete()) {
			$this->Session->setFlash(__('Connection deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Connection was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
