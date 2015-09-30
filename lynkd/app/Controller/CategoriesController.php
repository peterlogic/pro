<?php
App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

	public $components= array('RequestHandler');
	var $uses= array('Category','Categoryoption','Customer','Customeranswer');

 
	public function beforeFilter(){
		parent::beforeFilter();
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
		} else {
			if(!$this->Session->check('Customer')){
				$this->Session->setFlash('Please enter your information again to continue.','error_msg');
				$this->redirect(array('controller'=>'homes','action'=>'splash'));
			} else {
				$customerID = $this->Session->read('Customer.Customer.id');
				$customerData = $this->Customer->findByid($customerID);
				$this->set(compact('customerData'));
			}
		}
		$this->Auth->allow(array('index','view_detail','vote_submit','submitServey'));
	}

    public function index()
	{		
		$categoryData = $this->Category->find('all',array('conditions'=>array('Category.status'=>(int)1),'order'=>array('Category.order'=>'asc')));	
		$this->set(compact('categoryData'));		
	}
	
	public function view_detail($catID)
	{		
		$catData = $this->Category->find('all',array('conditions'=>array('AND'=>array('Category.status'=>(int)1)),'order'=>array('Category.order'=>'asc')));		
		$catList = $this->Category->findByid($catID);
		
		$this->set(compact('catList','catData'));		
	}
	
		
	public function admin_index() {
		if($this->request->is('post')){
			$keyword = trim($this->request->data['keyword']);
			$records = $this->Category->find('all', array('conditions' => array("Category.title LIKE" => "%$keyword%")));
			
				
			$this->set("users",$records,$this->paginate());
			if(count($records) == 0){
				$this->Session->setFlash("No Record found with this keyword please use another one.");
			}		
			
	} else {
			$this->Category->recursive = 0;
                        $this->paginate = array('order' => array('Category.order' => 'asc'),'limit' =>10);
			$this->set('users', $this->paginate());
		}
	}

	public function admin_sortRows(){
	
			
		if (isset($_POST['orders'])) {
	
			$orders = explode('&', $_POST['orders']);
			$array = array();
	
			foreach($orders as $item) {
				$item = explode('=', $item);
				$item = explode('_', $item[1]);
				$array[] = $item[1];
			}
	
			try {

				
				foreach($array as $key => $value) {
					$key = $key + 1;
						
					$this->Category->query("UPDATE `categories` SET `order` = '".$key."' WHERE `id` = '".$value."'");		
					
						
				}
				
				echo json_encode(array('error' => false));
	
			} catch(Exception $e) {
	
				echo json_encode(array('error' => true));
		
			}
	
		} else {
			echo json_encode(array('error' => true));
		}
	
        }
	public function admin_view($id = null) {
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->Category->read(null, $id));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->request->data['Category']['title'] = ucfirst($this->request->data['Category']['title']) ;
			$this->request->data['Category']['created'] = date('Y-m-d');			
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The Category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Category could not be saved. Please, try again.'));
			}
		}
        $this->set('action_type','Add New');
		$this->viewPath="Categories";
		$this->render('admin_edit');
	}

	public function admin_edit($id = null) {
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid Category'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {		
		                 	
			if ($this->Category->save($this->request->data)) { 	
				$this->Session->setFlash(__('The Category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Category could not be saved. Please, try again.'));
			}
		} else {
			//$this->Venue->contain(array('City'=>array('State'=>array('Country'))));
			$this->request->data = $this->Category->read(null, $id);
		}
			
			
			$this->set('action_type','Edit');
			$this->viewPath='Categories';
			
	}

	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Category->id = $id;
		$userData = $this->Category->find('first',array('conditions'=>array('Category.id'=>$id)));
		
		//$this->Profile->user_id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid Category'));
		}
		if ($this->Category->delete()) {
			$this->Session->setFlash(__('Category deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Category was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	 public function admin_deleteall($id = null){
                if (!$this->request->is('Ajax')) {
                    throw new MethodNotAllowedException();
                }

                foreach ($this->request['data']['Category'] as $k) {
                        $this->Category->id = (int) $k;
                        if ($this->Category->exists()) {
                                $this->Category->delete();
								$this->Customeranswer->query("delete from customer_answers where category_id='".$k."'");
								$this->Customeranswer->query("delete from category_options where category_id='".$k."'");

                        }
                 }
                        $this->Session->setFlash(__('Selected Categories were removed.')); 
                       
                        $this->autoRender = false;
            }
	
	
	
	
	public function admin_activate($id = null)
    {
        $this->Category->id = $id;
        if ($this->Category->exists()) {
            $x = $this->Category->save(array(
                'Category' => array(
                    'status' => '1'
                )
            ));
            $this->Session->setFlash("Category activated successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to activate Category.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }        
    }
    
    
    public function admin_block($id = null)
    {
        $this->Category->id = $id;
        if ($this->Category->exists()) {
            $x = $this->Category->save(array(
                'Category' => array(
                    'status' => '0'
                )
            ));
            $this->Session->setFlash("Category blocked successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to block Category.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
    }
	
	public function admin_activateall($id = null){
		if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
        }        
		
        foreach ($this->request['data']['Category'] as $v) {		
			$this->Category->id = $v;
			if ($this->Category->exists()) {
				$x = $this->Category->save(array(
					'Category' => array(
						'status' => "1"
					)					
				));	        
			} 		  	          
        }
		$this->Session->setFlash(__('Selected Categories Activated Successfully.', true));
		$this->autoRender = false;
    }
		
		
	public function admin_deactivateall($id = null){
            if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
                }
                
                foreach ($this->request['data']['Category'] as $v) {	
                                $this->Category->id = $v;
                                $x = $this->Category->save(array(
                                        'Category' => array(
                                                'status' => "0"
                                        )					
                                ));	          
                }
                        $this->Session->setFlash(__('Selected Categories were deactivated successfully.', true));
                        $this->autoRender = false;		
            }
	
}
?>
