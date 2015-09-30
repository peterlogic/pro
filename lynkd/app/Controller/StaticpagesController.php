<?php
App::uses('AppController', 'Controller');
/**
 * Sitesettings Controller
 *
 * @property Sitesetting $Sitesetting
 */
class StaticpagesController extends AppController {
         public function beforeFilter(){
		            parent::beforeFilter();
					$this->Auth->allow(array('view'));                        
	     }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Staticpage->recursive = 0;
		$this->set('staticpages', $this->paginate());	
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) 
	{
	//debug ($id);exit;
		$this->Staticpage->id = $id;
		
		if (!$this->Staticpage->exists()) 
		{
			throw new NotFoundException(__('Invalid Staticpage'));
		}
		$this->set('Staticpage', $this->Staticpage->read(null, $id));
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
	//debug($this->request->data);die;
		$this->Staticpage->recursive = 0;
		$this->set('staticpages', $this->paginate());
       

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
	public function admin_add() 
	{
		if ($this->request->is('post')) 
		{
		//debug($this->request->data);die;
			$this->Staticpage->create();
			if ($this->Staticpage->save($this->request->data)) 
			{
		
           $this->Session->setFlash(__('The Staticpage has been saved'));
		 // $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Staticpage could not be saved. Please, try again.'));
			}
		} 
		$this->set('action_type','Add New');
		$this->viewPath="Staticpages";
		$this->render('admin_edit');
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Staticpage->id = $id;
		if (!$this->Staticpage->exists()) {
			throw new NotFoundException(__('Invalid Staticpage'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
		
			
			if ($this->Staticpage->save($this->request->data)) 
			{			
			     
				$this->Session->setFlash(__('The Staticpage has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Staticpage could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Staticpage->read(null, $id);
		}
			$this->set('action_type','Edit');
			$this->viewPath='Staticpages';
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
		$this->Staticpage->id = $id;
		if (!$this->Staticpage->exists()) {
			throw new NotFoundException(__('Invalid Staticpage'));
		}
		if ($this->Staticpage->delete()) {
			$this->Session->setFlash(__('Staticpage deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Staticpage was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
		
		
		
    	 public function admin_deleteall($id = null){
                if (!$this->request->is('Ajax')) {
                    throw new MethodNotAllowedException();
                }

                foreach ($this->request['data']['Staticpage'] as $k) {
                        $this->Staticpage->id = (int) $k;
                        if ($this->Staticpage->exists()) {
                                $this->Staticpage->delete();
                        }
                 }
                        $this->Session->setFlash(__('Selected Blogs were removed.')); 
                       
                        $this->autoRender = false;
            }
	
	
	
	
	public function admin_activate($id = null)
    {
        $this->Staticpage->id = $id;
        if ($this->Staticpage->exists()) {
            $x = $this->Staticpage->save(array(
                'Staticpage' => array(
                    'status' => '1'
                )
            ));
            $this->Session->setFlash("Staticpage activated successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to activate Staticpage.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }        
    }
    
    
    public function admin_block($id = null)
    {
        $this->Staticpage->id = $id;
        if ($this->Staticpage->exists()) {
            $x = $this->Staticpage->save(array(
                'Staticpage' => array(
                    'status' => '0'
                )
            ));
            $this->Session->setFlash("Staticpage blocked successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to block Staticpage.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
    }
	
	public function admin_activateall($id = null){
		if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
        }        
		
        foreach ($this->request['data']['Staticpage'] as $v) {		
			$this->Staticpage->id = $v;
			if ($this->Staticpage->exists()) {
				$x = $this->Staticpage->save(array(
					'Staticpage' => array(
						'status' => "1"
					)					
				));	        
			} 		  	          
        }
		$this->Session->setFlash(__('Selected Blogs Activated Successfully.', true));
		$this->autoRender = false;
    }
		
		
	public function admin_deactivateall($id = null){
            if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
                }
                
                foreach ($this->request['data']['Staticpage'] as $v) {	
                                $this->Staticpage->id = $v;
                                $x = $this->Staticpage->save(array(
                                        'Staticpage' => array(
                                                'status' => "0"
                                        )					
                                ));	          
                }
                        $this->Session->setFlash(__('Selected Blogs were deactivated successfully.', true));
                        $this->autoRender = false;		
            }
		
		
		
}
