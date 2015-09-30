<?php
App::uses('AppController', 'Controller');
/**
 * Sitesettings Controller
 *
 * @property Sitesetting $Sitesetting
 */
class SitesettingsController extends AppController {
         public function beforeFilter(){
		            parent::beforeFilter();
                            $this->Auth->allow(array('admin_webservices'));
		 

	     }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Sitesetting->recursive = 0;
		$this->set('sitesettings', $this->paginate());

		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Sitesetting->id = $id;
		if (!$this->Sitesetting->exists()) {
			throw new NotFoundException(__('Invalid sitesetting'));
		}
		$this->set('sitesetting', $this->Sitesetting->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Sitesetting->create();
			if ($this->Sitesetting->save($this->request->data)) {
				$this->Session->setFlash(__('The sitesetting has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sitesetting could not be saved. Please, try again.'));
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
		$this->Sitesetting->id = $id;
		if (!$this->Sitesetting->exists()) {
			throw new NotFoundException(__('Invalid sitesetting'));
		}
		
		

		
		$one = $this->request->data['Sitesetting']['web_logo'];
		$this->request->data['Sitesetting']['web_logo'] = $one['name'];
		
	
		
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Sitesetting->save($this->request->data)) {
			       if ($one['error'] == 0) {
							 $pth = 'files' . DS .$one['name'];
							 move_uploaded_file($one['tmp_name'], $pth);                   
					   }
				$this->Session->setFlash(__('The sitesetting has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sitesetting could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Sitesetting->read(null, $id);
		}
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
		$this->Sitesetting->id = $id;
		if (!$this->Sitesetting->exists()) {
			throw new NotFoundException(__('Invalid sitesetting'));
		}
		if ($this->Sitesetting->delete()) {
			$this->Session->setFlash(__('Sitesetting deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sitesetting was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Sitesetting->recursive = 0;
		$this->set('sitesettings', $this->paginate());
       

	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Sitesetting->id = $id;
		if (!$this->Sitesetting->exists()) {
			throw new NotFoundException(__('Invalid sitesetting'));
		}
		$this->set('sitesetting', $this->Sitesetting->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Sitesetting->create();
			if ($this->Sitesetting->save($this->request->data)) {
				$this->Session->setFlash(__('The sitesetting has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sitesetting could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Sitesetting->id = $id;
		if (!$this->Sitesetting->exists()) {
			throw new NotFoundException(__('Invalid sitesetting'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
		 @$site_logo = $this->Sitesetting->find('first',array('fields'=>array('web_logo')));	

			
			$one = $this->request->data['Sitesetting']['web_logo'];
			if($one['name']){
			$this->request->data['Sitesetting']['web_logo'] = $one['name'];
			}else{$this->request->data['Sitesetting']['web_logo']= @$site_logo['Sitesetting']['web_logo'];
			}

			if ($this->Sitesetting->save($this->request->data)) 
			{			if ($one['error'] == 0) {
			$pth = 'files' . DS .$one['name'];
			move_uploaded_file($one['tmp_name'], $pth);                   
			}
			     
				$this->Session->setFlash(__('The sitesetting has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sitesetting could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Sitesetting->read(null, $id);
			$siteimage = $this->Sitesetting->find('first',array('fields'=>array('web_logo')));
           $this->set('site', $siteimage);
		}
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
		$this->Sitesetting->id = $id;
		if (!$this->Sitesetting->exists()) {
			throw new NotFoundException(__('Invalid sitesetting'));
		}
		if ($this->Sitesetting->delete()) {
			$this->Session->setFlash(__('Sitesetting deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sitesetting was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        public function admin_webservices() {
            
        }
}
