<?php
App::uses('AppController', 'Controller');
/**
 * Inboxes Controller
 *
 * @property Inbox $Inbox
 */
 App::uses('CakeEmail', 'Network/Email');
class InboxesController extends AppController {

/**
 * index method
 *
 * @return void
 */
    
        public function inbox($type='inbox') {
			//Configure::write("debug",2);
			$this->set('t',$type);
			$user_email = $this->Auth->User('email');
			$this->set('user_email',$user_email);
			//$this->set('inbox',$this->Inbox->find('all',array('conditions'=>array('Inbox.to'=>$user_email,'Inbox.delete_from_user_id'=>(int)0), 'order' => array('Inbox.id'=> 'DESC'))));
			$this->Inbox->recursive = 1;
			$this->paginate = array(
			'limit' => 6,
			'order' => array('Inbox.id' => 'DESC')
			);
			if($type  == 'inbox'){
					$this->set('inbox', $this->paginate('Inbox',array('Inbox.to'=>$user_email,'Inbox.delete_from_user_id'=>(int)0)));
			}	else if($type  == 'sent'){
					$this->set('outbox', $this->paginate('Inbox',array('Inbox.from'=>$user_email,'Inbox.delete_to_user_id'=>(int)0)));
			}	else if($type  == 'trash'){
				$this->set('trash', $this->paginate('Inbox',array('OR'=>array(array('Inbox.to'=>$user_email,'Inbox.delete_from_user_id'=>(int)1),array('Inbox.from'=>$user_email,'Inbox.delete_to_user_id'=>(int)1)))));
			}
			//$this->set('outbox',$this->Inbox->find('all',array('conditions'=>array('Inbox.from'=>$user_email,'Inbox.delete_to_user_id'=>(int)0), 'order' => array('Inbox.id'=> 'DESC'))));
			//$this->set('trash',$this->Inbox->find('all',array('conditions'=>array('OR'=>array(array('Inbox.to'=>$user_email,'Inbox.delete_from_user_id'=>(int)1),array('Inbox.from'=>$user_email,'Inbox.delete_to_user_id'=>(int)1))))));
			
			//$this->set('trash',$this->Inbox->query("SELECT * from inboxes where ('inboxes.to'='".$user_email."' AND 'inboxes.delete_from_user_id'='1') OR ('inboxes.from'='".$user_email."' AND 'inboxes.delete_to_user_id'='0')"));
			$this->set('Unread',$this->Inbox->find('all',array('conditions'=>array('Inbox.to'=>$user_email,'Inbox.delete_from_user_id'=>(int)0,'Inbox.status'=>'Unread'))));
			$this->set("userid",  $this->Auth->user('id'));
		}
		
		####### View message by ajax on 29.03.2015#########
		
		
		function get_inbox_count($user_email){
			$this->loadModel('Friend');			
			$inboxCount = $this->Inbox->find('count',array('conditions'=>array('Inbox.to'=>$user_email,'Inbox.delete_from_user_id'=>(int)0,'Inbox.status'=>'Unread')));
			//debug($inboxCount);
			echo 	'Inbox ('.$inboxCount.')';
			$this->autoRender = false;
			exit();
	}
	
		public function showInbox() {
			if($_REQUEST['showInbox']=='yes'){
				echo 'true';
			}
			else{
				echo 'false';
			}
			$this->autoRender = false;
		}
		
		
		####### Send message to user 29.03.2015#########
		public function sendMessageToUser() {
			if ($this->request->is('post')) {
				$to =  $this->data['Inbox']['to'];
				$getExpld = explode(',',$to);
				if(isset($getExpld[1])){
				$this->request->data['Inbox']['to'] = trim($getExpld[1]);
				}
				$this->Inbox->create();
				if ($this->Inbox->save($this->request->data)) {
					echo  'true';
				}
				else{
					echo 'false';
				}
			}
			$this->autoRender = false;
		}
		
		
		#View inbox messages with ajax return
		public function viewInboxMessage(){
				$getID = $_REQUEST['id'];
				$getReadMsg = $this->Inbox->find('first',array('conditions'=>array('Inbox.id'=>$getID)));
				 //debug($getReadMsg); 
				if(!empty($getReadMsg)){
							
					if($getReadMsg['Inbox']['status']=='Unread'){
						$update['Inbox']['id'] = $getID; 
						$update['Inbox']['status'] = 'Read';
						$this->Inbox->save($update);
					}
					echo '<div class="fullWidth">
							<label>From</label>
							<div class="labelInfo">							
							<div class="userName">'.$getReadMsg['Inbox']['from'].'</div>
							</div>
							</div>';
							
						echo '<div class="fullWidth">
							<label>To</label>
							<div class="labelInfo">							
							<div class="userName">'.$getReadMsg['Inbox']['to'].'</div>
							</div>
						</div>';
						echo '<div class="fullWidth">
							<label>Subject</label>
							<div class="labelInfo">'.$getReadMsg['Inbox']['subject'].'</div>
						</div>';
						echo '<div class="fullWidth">
							<label>Message</label>
							<div class="labelInfo mobfull">'.$getReadMsg['Inbox']['message'].'</div>';
				}
				$this->autoRender = false;
				exit;
		}
		
		#View outbox messages with ajax return
		public function viewOubboxMessage(){
				$getID = $_REQUEST['id'];
				$getReadMsg = $this->Inbox->find('first',array('conditions'=>array('Inbox.id'=>$getID)));
				if(!empty($getReadMsg)){
							echo '<div class="fullWidth">
									<label>From</label>
									<div class="labelInfo">
									<div class="userName">'.$getReadMsg['Inbox']['from'].'</div>
									</div>
									</div>';
									
								echo '<div class="fullWidth">
									<label>To</label>
									<div class="labelInfo">
									<div class="userName">'.$getReadMsg['Inbox']['to'].'</div>
									</div>
								</div>';
								echo '<div class="fullWidth">
									<label>Subject</label>
									<div class="labelInfo">'.$getReadMsg['Inbox']['subject'].'</div>
								</div>';
								echo '<div class="fullWidth">
									<label>Message</label>
									<div class="labelInfo mobfull">'.$getReadMsg['Inbox']['message'].'</div>';
				}
				$this->autoRender = false;
		}
    
    
        public function trash($id = null,$type){
			$this->Inbox->id = $id;
			if ($this->Inbox->exists()) {
				
				if($type=="inbox"){
						$x = $this->Inbox->save(array(
							'Inbox' => array(
								'delete_from_user_id' => (int)1
							)
						));
				} else {
						$x = $this->Inbox->save(array(
							'Inbox' => array(
								'delete_to_user_id' => (int)1
							)
						));
				}
				
				$this->Session->setFlash("The mail has been moved to the trash.",'default',array('class'=>'successfully'));
				$this->redirect(array(
					'controller'=>'inboxes',
					'action' => 'inbox'
				));
			} else {
				$this->Session->setFlash("Unable to move to the trash.",'default',array('class'=>'errormsg'));
			   $this->redirect(array(
					'controller'=>'inboxes',
					'action' => 'inbox'
				));
			}        
    }
    
    
    public function deleteall($id = null){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        foreach ($this->request['data']['Inbox'] as $k) {
            $this->Inbox->id = (int) $k;
            if ($this->Inbox->exists()) {
                $this->Inbox->delete();
            }
            
        }
        
        $this->Session->setFlash(__('Selected messages were removed.'));
        $this->redirect(array(
                'controller'=>'inboxes',
                'action' => 'inbox'
            ));
    }
    
    
    
     public function restore($id = null){
        $this->Inbox->id = $id;
        if ($this->Inbox->exists()) {
            $x = $this->Inbox->save(array(
                'Inbox' => array(
                    'status' => 'Read'
                )
            ));
            $this->Session->setFlash("The mail has been moved to the trash.");
            $this->redirect(array(
                'controller'=>'inboxes',
                'action' => 'inbox'
            ));
        } else {
            $this->Session->setFlash("Unable to move to the trash.");
            $this->redirect(array(
                'controller'=>'inboxes',
                'action' => 'inbox'
            ));
        }
        
    }
    
    
    public function read(){
       if ($this->request->is('post')) {
            $this->Inbox->id = $this->request->data['id'];
            if ($this->Inbox->exists()) {
                $x = $this->Inbox->save(array(
                    'Inbox' => array(
                        'status' => 'Read'
                    )
                ));
            } 
       } 
    }
        
        
        
    
	public function index() {
		$this->Inbox->recursive = 0;
		$this->set('inboxes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Inbox->id = $id;
		if (!$this->Inbox->exists()) {
			throw new NotFoundException(__('Invalid inbox'));
		}
		$this->set('inbox', $this->Inbox->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() { 
		if ($this->request->is('post')) {
			$this->Inbox->create();
                        $to = $this->request->data['Inbox']['to'];
                        $from = $this->request->data['Inbox']['from'];
                        $subject = $this->request->data['Inbox']['subject'];
                        $message = $this->request->data['Inbox']['message'];
			if ($this->Inbox->save($this->request->data)) {
                            $l  = new CakeEmail();
			$l->emailFormat('html')->template('signup', 'fancy')->subject("Academatch".$subject)->to($to)->from($from)->send($message);
			$this->set('smtp_errors', "none");
			    $this->Session->setFlash(__('The Mail has been sent.'));
				$this->redirect(array('action' => 'inbox'));
			} else {
				$this->Session->setFlash(__('Please, try again.'));
			}
		}
		$users = $this->Inbox->User->find('list');
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
		$this->Inbox->id = $id;
		if (!$this->Inbox->exists()) {
			throw new NotFoundException(__('Invalid inbox'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Inbox->save($this->request->data)) {
				$this->Session->setFlash(__('The inbox has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inbox could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Inbox->read(null, $id);
		}
		$users = $this->Inbox->User->find('list');
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
		$this->Inbox->id = $id;
		if (!$this->Inbox->exists()) {
			throw new NotFoundException(__('Invalid message.'));
		}
		if ($this->Inbox->delete()) {
			$this->Session->setFlash(__('Messages deleted'));
			$this->redirect(array('action' => 'inbox'));
		}
		$this->Session->setFlash(__('Messages was not deleted'));
		$this->redirect(array('action' => 'inbox'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Inbox->recursive = 0;
		$this->set('inboxes', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Inbox->id = $id;
		if (!$this->Inbox->exists()) {
			throw new NotFoundException(__('Invalid inbox'));
		}
		$this->set('inbox', $this->Inbox->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Inbox->create();
			if ($this->Inbox->save($this->request->data)) {
				$this->Session->setFlash(__('The inbox has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inbox could not be saved. Please, try again.'));
			}
		}
		$users = $this->Inbox->User->find('list');
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
		$this->Inbox->id = $id;
		if (!$this->Inbox->exists()) {
			throw new NotFoundException(__('Invalid inbox'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Inbox->save($this->request->data)) {
				$this->Session->setFlash(__('The inbox has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inbox could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Inbox->read(null, $id);
		}
		$users = $this->Inbox->User->find('list');
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
		$this->Inbox->id = $id;
		if (!$this->Inbox->exists()) {
			throw new NotFoundException(__('Invalid inbox'));
		}
		if ($this->Inbox->delete()) {
			$this->Session->setFlash(__('Inbox deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Inbox was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        
        
        public function today_news(){
            
        }
}
