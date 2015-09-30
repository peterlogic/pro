<?php
App::uses('AppController', 'Controller');
App::uses('File', 'Utility');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {

	public $components= array('RequestHandler');
	var $uses= array('User');
	
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow(array('send_friend_request','get_profile_link','admin_login','admin_forget','admin_reset','login','reset','register','forgot','get_states','get_cities','dashboard','checkuseralreadyexist','checkemailalreadyexist','blog','profile','donation','contact','admin_contactus','contactus','admin_contactusedit','admin_reply','getPasswordStatus','following','upload_video','browse_video','video','video_comment','postcomment','video_like','delete_video','repost_video'));
	}

	function get_profile_link(){
			$detailArr = explode(',',$this->data['User']['friends']);
			$email = trim($detailArr[1]);
			$userData = $this->User->findByemail($email);
			$this->redirect(array('controller'=>'users','action'=>'profile', $userData['User']['id']));
			//debug($userData);
			$this->autoRender = false;
	}
	
	function send_friend_request(){
		if($this->request->is('ajax')){				
				$this->loadModel('Friend');
				//debug($this->data);
				$this->Friend->create();
				$this->Friend->set('from_user_id',$this->Auth->user('id'));
				$this->Friend->set('to_user_id',$this->data['id']);
				if($this->Friend->save()){
					echo 'SUCCESS';
				} else {
					echo 'ERROR';
				}
				
		}	
		$this->autoRender = false;
	}
	
	function get_user_lists(){
		
		$keyword = $this->request->query['term'];
		//$this->User->contain(array('ToFriend'));
		$userData = $this->User->find('all',array('conditions'=>array('OR'=>array('User.name LIKE'=>'%'.$keyword.'%','User.username LIKE'=>'%'.$keyword.'%','User.email LIKE'=>'%'.$keyword.'%'),'AND'=>array('User.status'=>'1', 'User.id <>'=>$this->Auth->user('id'))),'limit'=>10));
		
		$c = array();
		foreach($userData as $user){
	
			$c[] = ucfirst($user['User']['name']).' '.$user['User']['last_name'].', '.$user['User']['email'];
		}
		$cData = json_encode($c);
		echo $cData;
		$this->autoRender = false;
		exit();
	}
	
	function get_friend_notifications($user_id)
	{
			$this->loadModel('Friend');
			$friendCount = $this->Friend->find('count',array('conditions'=>array('Friend.to_user_id'=>$user_id,'Friend.status'=>(int)0,'Friend.seen'=>(int)0)));
			echo $friendCount;	
			$this->autoRender = false;
			exit();
	}
	
	function get_friend_count($user_id){
			$this->loadModel('Friend');
			
			$friend_lists = $this->Friend->find('count',array('conditions'=>array('AND'=>array('Friend.status'=>(int) 1),'OR'=>array(array(
					'AND' => array(
						array('Friend.to_user_id' => $this->Auth->User('id'))
					)
				),
				array(
					'AND' => array(
						array('Friend.from_user_id' => $this->Auth->User('id'))
					)
				))),'order'=>array('Friend.status'=>'asc')));
			echo 	'Friends ('.$friend_lists.')';
			$this->autoRender = false;
			exit();
	}
	
	function get_friends($user_id){
			$this->loadModel('Friend');
			$this->Friend->query("UPDATE user_friends set seen=1 where to_user_id='".$user_id."'");
			
			$conditions = array(
				'OR' => array(
						array('Friend.to_user_id' => $this->Auth->User('id')),				
						array('Friend.from_user_id' => $this->Auth->User('id'))
				)				
			);
			$friend_lists = $this->Friend->find('all',array('conditions'=>$conditions,'order'=>array('Friend.status'=>'asc')));
			$this->set('friend_lists',$friend_lists);
			$this->viewPath = 'Elements';
			$this->render('get_friend');
	}
	
	function accept_request($fid){
			$this->loadModel('Friend');
			$this->Friend->query("UPDATE user_friends set status=1 where id='".$fid."'");
			echo '<a href="javascript:void(0);" onclick="return unfriend_user(\''.$fid.'\')">Unfriend</a>';
			$this->autoRender = false;
			exit();
	}
	
	function reject_request($fid)
	{
			$this->loadModel('Friend');
			$this->Friend->query("DELETE from user_friends where id='".$fid."'");
			echo 'yes';
			$this->autoRender = false;
			exit();
	}
	
	public function admin_login(){ //start of func login//
	
	  	 if ($this->request->is('Post')) {		
            App::Import('Utility', 'Validation');
            if (isset($this->data['User']['username']) && Validation::email($this->data['User']['username'])){
                $this->request->data['User']['email'] = $this->data['User']['username'];
                $this->Auth->authenticate['Form']     = array(
                    'fields' => array(
						'userModel' => 'User',
                        'username' => 'email'
                    )
                );
                $x = $this->User->find('first',array('conditions' => array('email' => $this->data['User']['username'])));
            } else {
                $this->Auth->authenticate['Form'] = array(
                    'fields' => array(
						'userModel' => 'User',
                        'username' => 'username'
                    )
                ); 
                $x = $this->User->find('first',array('conditions' => array('username' => $this->data['User']['username'])));
			}
			if(!empty($x)){
            if($x['User']['user_type'] == '1' && $x['User']['status'] == '1'){
            	if (!$this->Auth->login()) {
            		$this->Session->setFlash('Please check your password.');
            		$this->redirect(array('controller' => 'users', 'action' => 'admin_login'));
            	} else {
            		$this->Session->write('VenueUser',true);
            		$this->Session->setFlash('Successfully signed in');
            		$this->redirect(array('controller' => 'users', 'action' => 'admin_dashboard'));
            	}         
            }else{
            	$this->Session->setFlash("You don't have Administrator authorities or your account is inactive.");
            	$this->redirect(array('controller' => 'users', 'action' => 'admin_login'));
            }
			  } else {
					$this->Session->setFlash("Invalid username or password.");
					$this->redirect(array('controller' => 'users', 'action' => 'admin_login'));
			}
		}
	}//end of func login//

				  
	public function admin_dashboard(){ 
		$this->User->recursive = 0;
    	$x = $this->User->find('all',array(    				
    					"order"=>"User.id ASC"
    				));
    	$this->set("users", $x);
		$y = $this->User->read('all');
    	$this->set("use_count", $x);
		$this->loadModel("Category");
		$item= $this->Category->find("all",array("order" => "Category.id ASC"));
		$this->set("inventory_items", $item);
		$item_count = $this->Category->read('all');
		$this->set('item_count',$item);
		$this->loadModel("Blog");
		$contain= $this->Blog->find("all",array("order" => "Blog.id ASC"));
		//echo "<pre>";print_r($contain);
		$this->set("container_types", $contain);
		$contain_count = $this->Blog->read('all');
		//echo "<pre>";print_r($contain);
		$this->set('contain_count',$contain);
		$this->loadModel("Contact");
		$contact= $this->Contact->find("all",array("order" => "Contact.id ASC"));
		$this->set("contact_types", $contact);
		$contact_count = $this->Contact->read('all');
		//echo "<pre>";print_r($contact);
		$this->set('contact_count',$contact);
    	//$this->set("use_count", $xy);
		$this->set(compact('x'));
        
	} //end of func dashboard//
	

	public function admin_index() 
	{
			$this->loadModel('User');
			//$this->Customer->recursive = 0;
			$this->set('customers', $this->paginate('User'));
	}
	public function admin_logout()
    {
        $this->Auth->logout();
        $this->Session->setFlash('Logged out.');
        $this->redirect(array('controller'=>'Users','action'=>'admin_login'));
    }
	
	public function admin_changepass(){
		 if ($this->request->is('post')) {
			
			$password =AuthComponent::password($this->data['User']['opass']);
            $em= $this->Auth->user('id');
			
			$pass=$this->User->find('first',array('conditions'=>array('AND'=>array('User.id' => $em))));
			//debug($pass); exit;
			if($pass['User']['password'] == $password){
				if($this->data['User']['password'] != $this->data['User']['cpass'] ){
					$this->Session->setFlash("New password and Confirm password field do not match");
				} else {
					$this->User->data['User']['opass'] = $this->data['User']['password'];
					$this->User->id = $pass['User']['id'];
					  if($this->User->exists()){
						$pass= array('User'=>array('password'=>$this->request->data['User']['password']));
						if($this->User->save($pass)) {
							$this->Session->setFlash("Password updated successfully.");
							$this->redirect(array('controller'=>'users','action' => 'admin_profile'));
						}
					  }
				}
			} else {
				$this->Session->setFlash("Your old password did not match.");
			}        
		  }
			   
    }//end of func admin_changepass//

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
            
                //debug($this->request->data);die;
                $userdata=$this->Auth->User();
		if ($this->request->is('post')) {
			$this->request->data['User']['ip'] = $this->RequestHandler->getClientIp();
			$this->request->data['User']['status'] = '1' ;
			$this->User->create();
			if ($this->User->save($this->request->data)) {
                                $id=$this->User->getLastInsertId();
                                    $this->Session->setFlash(__('The user has been saved'));
                                    $this->redirect(array('action' => 'index'));
				
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
                
             //   $roles=$this->Role->find('all',  array('conditions'=>  array('Role.status'=>1),'fields'=>array('Role.role_name','Role.id')));
                      
              //  $this->set('roles',$roles);
                $this->set('action_type','add');
		$this->viewPath="Users";
		$this->viewPath="Users";
		$this->render('admin_edit');
	}
	
	
	public function admin_admin() {
		if ($this->request->is('post')) {
			$this->request->data['User']['type'] = 1 ;
			$this->request->data['User']['ip'] = $this->RequestHandler->getClientIp();
			$this->request->data['User']['status'] = '1' ;
			$this->User->create();
			if ($this->User->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The new Admin has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The admin could not be saved. Please, try again.'));
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
		$this->User->id = $id;
              
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
		        if ($this->User->save($this->request->data)) {
					$this->Profile->save($this->request->data);
					$this->Session->setFlash(__('The user has been saved'));
					$this->redirect(array('controller'=>'users','action' => 'index'));
				} 
				else {
					$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
                        
                        
			$this->request->data = $this->User->read(null, $id);
		}
              //  $roles=$this->Role->find('all',  array('conditions'=>  array('Role.status'=>1),'fields'=>array('Role.role_name','Role.id')));
                        
                        
             //   $this->set('roles',$roles);
                $this->set('action_type','edit');
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
		$this->loadModel('User');
		$this->User->id = $id;
		$userData = $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {			
			$this->Session->setFlash(__('User deleted successfully'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function admin_deleteall($id = null){
            
        if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
        }
		$this->loadModel('Customer');
		foreach ($this->request['data']['Customer'] as $k) {
		    $this->Customer->id = (int) $k;
			$userData = $this->Customer->find('first',array('conditions'=>array('Customer.id'=>(int) $k)));
			
            if ($this->Customer->exists()) {
				$this->Customer->deleteAll(array('Customer.id'=>$k), $cascade = true);
                //$this->Customer->deleteAll();				
            }  
		   
        }        
        $this->Session->setFlash(__('Selected Users were removed.'));
       
        $this->autoRender=false;
    }
	
	public function admin_detail($id = null){
		$this->User->id = $id;
		$this->set('detail',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
		$this->loadModel('UserEducation');
	    $x = $this->UserEducation->find('all',array('conditions'=>array('UserEducation.user_id'=>$id)));
	     $this->set('edu',$x);
		 
		$this->loadModel('UserWorkSince');
	    $x1 = $this->UserWorkSince->find('all',array('conditions'=>array('UserWorkSince.user_id'=>$id)));
	     $this->set('exp',$x1);
                    }
	
	
	public function admin_activate($id = null)
    {
        $this->User->id = $id;
        if ($this->User->exists()) {
            $x = $this->User->save(array(
                'User' => array(
                    'status' => '1'
                )
            ));
            $this->Session->setFlash("User activated successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to activate user.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }        
    }
    
    
    public function admin_block($id = null)
    {
        $this->User->id = $id;
        if ($this->User->exists()) {
            $x = $this->User->save(array(
                'User' => array(
                    'status' => '0'
                )
            ));
            $this->Session->setFlash("User blocked successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to block user.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
    }
	
	public function admin_activateall($id = null){
		if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
        }        
		
        foreach ($this->request['data']['User'] as $v) {		
			$this->User->id = $v;
			if ($this->User->exists()) {
				$x = $this->User->save(array(
					'User' => array(
						'status' => "1"
					)					
				));	        
			} 		  	          
        }
		$this->Session->setFlash(__('Selected Users Activated Successfully.', true));
		$this->autoRender = false;
    }
		
		
	public function admin_deactivateall($id = null){
            if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
                }
                
                foreach ($this->request['data']['User'] as $v) {	
                                $this->User->id = $v;
                                $x = $this->User->save(array(
                                        'User' => array(
                                                'status' => "0"
                                        )					
                                ));	          
                }
                        $this->Session->setFlash(__('Selected Users were deactivated successfully.', true));
                        $this->autoRender = false;		
            }
	
	
	public function admin_profile(){
		$id = $this->Auth->User('id');
		$this->set('profile',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
		
	}
	
	public function admin_profileedit($id=null) 
	{
		$id = $this->Auth->User('id');
		$this->set('profile',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
        $x= $this->User->find('first',array('conditions'=>array('User.id'=>$id)));
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {	
		
			
			$one = $this->request->data['User']['profile_image'];
            if($this->request->data['User']['profile_image']['name']!=""){
				$imageNAME = $x['User']['id'].$x['User']['profile_image'];
				$file = new File(WWW_ROOT . 'files/profileimage/'.$imageNAME, false, 0777);
				$file->delete();
				$this->request->data['User']['profile_image'] = $x['User']['id'].$one['name'];  
              }else{
				$this->request->data['User']['profile_image'] = $x['User']['profile_image'];
            }   
		
			if ($this->User->save($this->request->data)) {
			
			if ($one['error'] == 0) {
                    $pth = 'files' . DS . 'profileimage' . DS .$id.$one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);                   
                }
				$this->Session->setFlash(__('The Profile has been updated'));
				$this->redirect(array('action' => 'admin_profile'));
			} else {
				$this->Session->setFlash(__('The Profile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
	}
	public function admin_userprofile($id=null) {
		$this->User->id = $id;
		$this->set('profile',$this->User->find('first',array('conditions'=>array('User.id'=>$id))));
	}

		 public function admin_forget() {   
        $this->User->recursive=-1;
		if(!empty($this->data))
		{
			if(empty($this->data['User']['email']))
			{
				$this->Session->setFlash('Please Provide Your Email Address that You used to Register with Us');
			}
			else
			{
				$email=$this->data['User']['email'];
				$fu=$this->User->find('first',array('conditions'=>array('User.email'=>$email)));
				if($fu){
					if($fu['User']['status']=="1"){
						$key = Security::hash(String::uuid(),'sha512',true);
						$hash=sha1($fu['User']['username'].rand(0,100));
						$url = Router::url( array('controller'=>'Users','action'=>'reset'), true ).'/'.$key.'#'.$hash;
						$ms="<p>Hello ,<br/>".$fu['User']['name']."<br/><a href=".$url.">Click Here</a> to reset your password.</p><br /> ";
						$fu['User']['token']=$key;
						$this->User->id=$fu['User']['id'];
						if($this->User->saveField('token',$fu['User']['token'])){
							$l = new CakeEmail('smtp');
							$l->config('smtp')->emailFormat('html')->template('signup', 'fancy')->subject('Reset Your Password')->to($fu['User']['email'])->send($ms);
							$this->set('smtp_errors', "none");
							$this->Session->setFlash(__('Check Your Email To Reset your password', true));
							$this->redirect(array('controller' => 'Users','action' => 'admin_login'));
	                    }
						else{
							$this->Session->setFlash("Error Generating Reset link");
						}
					}
					else{
						$this->Session->setFlash('This Account is Blocked. Please Contact to Administrator...');
					}
				}
				else{
					$this->Session->setFlash('Email does Not Exist');
				}
			}
		}
	}
	public function admin_reset($token=null) {
		$this->User->recursive=-1;
		if(!empty($token)){
			$u=$this->User->findBytoken($token);
			if($u){
				$this->User->id=$u['User']['id'];
				if(!empty($this->data)){
					if($this->data['User']['password'] != $this->data['User']['cpassword']){
							$this->Session->setFlash("Both the passwords are not matching...");
							return;
                    }
					$this->User->data=$this->data;
					$this->User->data['User']['username']=$u['User']['username'];
					$new_hash=sha1($u['User']['username'].rand(0,100));//created token
					$this->User->data['User']['token']=$new_hash;
					if($this->User->validates(array('fieldList'=>array('password','cpassword')))){
						if($this->User->save($this->User->data))
						{
							$this->Session->setFlash('Password Has been Updated');
							$this->redirect(array('controller'=>'Users','action'=>'admin_login'));
						}
					}
					else{
					$this->set('errors',$this->User->invalidFields());
					}
				}
			}
			else
			{
			$this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.');
			}
		}
		else{
		$this->Session->setFlash('Pls try again...');
		$this->redirect(array('controller' => 'Users','action' => 'admin_login'));
		}
	}
	 public function forgot($u = null) {
       //  Configure::write('debug', 2);
		if($this->request->is('post')){
			$this->User->recursive = -1;
                $email = $this->data['username'];
                $fu = $this->User->find('first', array('conditions' => array('User.email' => $email)));
                if ($fu) {
                    if ($fu['User']['status'] == "1") {
                        $key = Security::hash(String::uuid(), 'sha512', true);
                        $hash = sha1($fu['User']['email'] . rand(0, 100));
                        $url = Router::url(array('controller' => 'Users', 'action' => 'reset'), true) . '/' . $key . '#' . $hash;
                        $ms = "<p>Hi <br/>".$fu['User']['name']."&nbsp;".$fu['User']['last_name'].",<br/><a href=".$url.">Click here</a> to reset your password.</p><br /> ";
                        $fu['User']['token'] = $key;
                        $this->User->id = $fu['User']['id'];
                        if ($this->User->saveField('token', $fu['User']['token'])) {
						   
								$l = new CakeEmail();
								$l->emailFormat('html')->template('signup', 'fancy')->subject('Reset Your Password')->from('keithmanek1988@gmail.com')->to($email)->send($ms);
								$this->Session->setFlash('Please Check Your Email To Reset your password','default',  array ('class' => 'successfully'));
								$this->redirect(array('controller'=>'users','action'=>'login'));
							
                        } else {
							$this->Session->setFlash('Please try again', 'default', array ('class' => 'errormsg'));
							$this->redirect(array('controller'=>'users','action'=>'forgot'));                         
                        }
                    } else {
							$this->Session->setFlash('Your account has been blocked by Administrator', 'default', array ('class' => 'errormsg'));
							$this->redirect(array('controller'=>'users','action'=>'forgot'));  
                       
                    }
                } else {
					//$this->Session->setFlash('You have registered successfully.', 'default', array ('class' => 'successfully'));	
					$this->Session->setFlash('Email does not exist','default',  array ('class' => 'errormsg'));
					$this->redirect(array('controller'=>'users','action'=>'forgot'));  
                    
                }
			}	
    }
	
	
	
	public function reset($token = null) {
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findBytoken($token);
            if ($u) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
					$this->request->data['User'] = $this->data;
                    if ($this->data['User']['password'] != $this->data['User']['confirm_password']) {
                        $this->Session->setFlash("Both the passwords are not matching", 'default', array ('class' => 'successfully'));
                        
                    }
                    $this->User->data = $this->data;
                    $this->User->data['User']['username'] = $u['User']['username'];
                    $new_hash = sha1($u['User']['username'] . rand(0, 100)); //created token
                    $this->User->data['User']['token'] = $new_hash;
                 
                        //	if($this->request->data['User']['password'] == $this->request->data['User']['confirm_password'] ){
                        if ($this->User->save($this->User->data)) {
							$this->Session->setFlash('Your password has been updated successfully', 'default', array ('class' => 'successfully'));
                            $this->redirect(array('controller'=>'users','action'=>'login'));
                        }
                  
                }
            } else {
			$this->Session->setFlash('Token Corrupted, Please Retry.the reset link <a style="cursor: pointer; color: rgb(0, 102, 0); text-decoration: none; background: url("http://files.adbrite.com/mb/images/green-double-underline-006600.gif") repeat-x scroll center bottom transparent; margin-bottom: -2px; padding-bottom: 2px;" name="AdBriteInlineAd_work" id="AdBriteInlineAd_work" target="_top">work</a> only for once.', 'default', array ('class' => 'errormsg'));
              
            }
        }
    }
	
	public function login() 
	{
		if($this->Session->check('Auth.User')){
				$this->Session->setFlash('You are already logged in','default',array('class'=>'successfully')); 
					$this->redirect(array('controller' => '/'));				
			}		
			if ($this->request->is('post')) 
			{
			//debug($this->data);
			App::Import('Utility', 'Validation');
			
			if(isset($this->data['User']['username']) && $this->data['User']['username']!='' && isset($this->data['User']['password']) && $this->data['User']['password'] !=''){
			if (isset($this->data['User']['username']) && Validation::email($this->data['User']['username'])){
                $this->request->data['User']['email'] = $this->data['User']['username'];
                $this->Auth->authenticate['Form']     = array(
                    'fields' => array(
						'userModel' => 'User',
                        'username' => 'email'
                    )
                );
                $x = $this->User->find('first',array('conditions' => array('email' => $this->data['User']['username'])));
            } else {
                $this->Auth->authenticate['Form'] = array(
                    'fields' => array(
						'userModel' => 'User',
                        'username' => 'username'
                    )
                ); 
             
				$x = $this->User->find('first',array('conditions' => array('username' => $this->data['User']['username'])));
				//$this->Session->setFlash("Email address not found.", 'default', array ('class' => 'errormsg'));				
            	//$this->redirect(array('controller' => 'Users', 'action' => 'login'));			
				
			}
			if(isset($x['User']['type']) && $x['User']['type'] == '0'){
						if ($this->Auth->login()) 
						{
								$this->User->query("UPDATE users set online=1, last_activity=NOW() where id ='".$this->Session->read('Auth.User.id')."'");
								$this->redirect(array('controller'=>'Users','action'=>'profile'));
								
						}
						else
						{
							$this->Session->setFlash('Invalid username or password, try again', 'default', array ('class' => 'errormsg'));
						}
				} else {
						$this->Session->setFlash("Email address not exist.", 'default', array ('class' => 'errormsg'));
						$this->redirect(array('controller' => 'Users', 'action' => 'login'));
				
				}	
				  } else {
				$this->Session->setFlash("Please enter email or password.", 'default', array ('class' => 'errormsg'));
				
            	$this->redirect(array('controller' => 'Users', 'action' => 'login'));
				
		  }		
			}
			
}

	
			/*if($this->Session->check('Auth.User')){
				$this->Session->setFlash('you are already logged in','success_msg');
            	$this->redirect(array('controller' => 'homes', 'action' => 'index'));
			}
			if ($this->request->is('post')) {
		    App::Import('Utility', 'Validation');
			
			if(isset($this->data['User']['username']) && $this->data['User']['username']!='' && isset($this->data['User']['password']) && $this->data['User']['password'] !=''){
            if (isset($this->data['User']['username']) && Validation::email($this->data['User']['username'])){
                $this->request->data['User']['email'] = $this->data['User']['username'];
                $this->Auth->authenticate['Form']     = array(
                    'fields' => array(
						'userModel' => 'User',
                        'username' => 'email'
                    )
                );
                $x = $this->User->find('first',array('conditions' => array('email' => $this->data['User']['username'])));
            } else {
                $this->Auth->authenticate['Form'] = array(
                    'fields' => array(
						'userModel' => 'User',
                        'username' => 'username'
                    )
                ); 
                $x = array();
				$this->Session->setFlash("Email address not found.",'error_msg');
            	$this->redirect(array('controller' => 'Users', 'action' => 'login'));
			}
			if(isset($x['User']['type']) && $x['User']['type'] != '1'){
            	if (!$this->Auth->login()) {
            		$this->Session->setFlash('Please check your password.','error_msg');
            		
            	} else {
            		$this->Session->setFlash('you have logged in Successfuly.','success_msg');
            		$this->redirect(array('controller' => 'homes', 'action' => 'index'));
            	}         
            } else {
            	$this->Session->setFlash("Email address not exist.",'error_msg');
            	$this->redirect(array('controller' => 'Users', 'action' => 'login'));
            }
		  } else {
				$this->Session->setFlash("Please enter email or password.",'error_msg');
            	$this->redirect(array('controller' => 'Users', 'action' => 'login'));
		  }
		 } */
	//}
	
	public function dashboard()
{
	$this->set('name',$this->Auth->User('name'));
			
}
public function profile($id=null)
{
	if(!$this->Auth->User('id') && $id==null){
			$this->redirect(array('controller'=>'/'));
	} 
	$name=$this->Auth->User('name');
	$userid = ($id==null ? $this->Auth->User('id') : $id);
	$checkUserType = ($id==null ? 'own' : 'friend');
	$getUser = $this->User->find('first',array('conditions'=>array('User.id'=>$userid)));		
	$this->set('info',$getUser);
//	$this->set('element', 'login_ajax');
	$this->set('checkUserType',$checkUserType);
	$this->set('userid',$userid);
	$friend = 'no';
	$isalreadyfriend = 'no';
	if($id != null && $id != $this->Auth->User('id')){
		$this->loadModel('Friend');
		$conditions = array(
			'OR' => array(
				array(
						array('Friend.to_user_id' => $this->Auth->User('id'),'Friend.from_user_id'=>$id)					
				),
				array(					
						array('Friend.from_user_id' => $this->Auth->User('id'),'Friend.to_user_id'=>$id)					
				)
			)
		);
		$checkUSer = $this->Friend->find('first',array('conditions'=>$conditions));
		
		if(!empty($checkUSer)){
				$friend = 'yes';	
				if($checkUSer['Friend']['status'] == (int)1){
						$isalreadyfriend = 'yes';
				}
		} 
	}
	$this->set('isfriend',$friend);
	$this->set('isalreadyfriend',$isalreadyfriend);
		if($this->request->is('post'))
		{		
				if ($this->User->save($this->request->data)) 
				{
					$this->Session->setFlash('Your information updated successfully..', 'default', array ('class' => 'successfully'));	
						$this->redirect(array('action' => 'profile'));
				} else 
				{
						$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
				}
		}
		
		
				
		
}

public function profile_image()
{
			if($this->request->is('post'))
			{				
					//debug($this->request->data['User']['id']);exit;
				
							$x = $this->User->findByid($this->request->data['User']['id']);
							$this->autoRender = false;
							$one = $this->request->data['User']['profile_image'];
								if($this->request->data['User']['profile_image']['name']!="")
								{
										$this->request->data['User']['profile_image'] = $this->request->data['User']['id'].$one['name'];  
										$file = new File(WWW_ROOT . 'files/profileimage/'. $x['User']['profile_image'], false, 0777);
										$file->delete();
										/*$dir = $this->webroot. DS .'files' . DS . 'profileimage';
										$file = new File($dir . DS . $x['User']['profile_image']);
										$file->delete();*/
								}
								else
								{
										$this->request->data['User']['profile_image'] = $x['User']['profile_image'];
									
								}   
								if ($this->User->save($this->request->data)) 
								{			
										if ($one['error'] == 0) 
										{
											$pth = 'files' . DS . 'profileimage' . DS .$this->request->data['User']['id'].$one['name'];
											move_uploaded_file($one['tmp_name'], $pth);                   
										}
									$this->Session->setFlash('The Profile has been updated','default',array('class'=>'successfully'));
									$this->redirect(array('action' => 'profile'));
								} 
								else {
									$this->Session->setFlash('The Profile could not be saved. Please, try again.','default',array('class'=>'errormsg'));
									}							
			}
	

}

/**************** Response the ajax request and handle the old password validatation ****************************/

public function getPasswordStatus(){
	if($this->request->is('Ajax')){
		$getOldPass = $_REQUEST['data']['User']['opass'];
		$password =AuthComponent::password($getOldPass);
		$em= $this->Auth->user('id');
		$pass=$this->User->find('first',array('conditions'=>array('AND'=>array('User.id' => $em))));
		if($pass['User']['password'] == $password){
			echo 'true'; 		
		}
		else{
			echo 'false'; 
		}
	}
	$this->autoRender = false;
	exit();
}

/**************** EndResponse the ajax request and handle the old password validatation ****************************/

public function changepass()
{
		$this->autoRender = false;
		if ($this->request->is('post')) 
		{
			//debug($this->data);exit();
			$password =AuthComponent::password($this->data['User']['opass']);
            $em= $this->Auth->user('id');
			
			$pass=$this->User->find('first',array('conditions'=>array('AND'=>array('User.id' => $em))));
			//debug($pass); exit;
			if($pass['User']['password'] == $password)
			{
				if($this->data['User']['password'] != $this->data['User']['cpass'] ){
					//$this->Session->setFlash("New password and Confirm password field do not match");
					$this->Session->setFlash('New password and Confirm password field do not match.', 'default', array ('class' => 'errormsg'));
				} else {
					$this->User->data['User']['opass'] = $this->data['User']['password'];
					$this->User->id = $pass['User']['id'];
					  if($this->User->exists())
					  {
						$pass= array('User'=>array('password'=>$this->request->data['User']['password']));
						if($this->User->save($pass)) {
							//$this->Session->setFlash("Password updated successfully.");
							$this->Session->setFlash('Password updated successfully..', 'default', array ('class' => 'successfully'));	
							$this->redirect(array('controller'=>'users','action' => 'profile'));
						}
					  }
				}
			} else
			{
				//$this->autoRender = false;
				$this->Session->setFlash('Your old password did not match.', 'default', array ('class' => 'errormsg'));
				$this->redirect(array('controller'=>'users','action' => 'profile'));
			}        
		  }
		
}
//$this->Session->setFlash('your blog has successfully added.', 'default', array ('class' => 'successfully'));		
//$this->redirect(array('controller'=>'blogs', 'action' => 'index'));	
	
	public function register()
	{
			$this->loadModel('Country');
			$countryList = $this->Country->find('all');
			$this->set('countryList',$countryList);
			if($this->request->is('post'))
			{
				$this->User->set($this->data);	
				if($this->User->validates())
					{	
							$this->User->create();
							if($this->User->save($this->request->data))
							{	
							$ms = "<p>Name: ".$this->request->data['name']." ".$this->request->data['last_name']. " <br/>Email: ".$this->request->data['email']."</p><br /> ";
								$l = new CakeEmail();
								$l->template('signup', 'fancy')
														->emailFormat('html')
														->subject('Signup ')
														->to($this->request->data['email'])
														->from('keithmanek1988@gmail.com')
														->send($ms);
								$this->Session->setFlash('You have registered successfully.', 'default', array ('class' => 'successfully'));								
								$this->redirect(array('controller'=>'/'));
							}else
							{
									$this->Session->setFlash(__('The user could not be created. Please, try again.'));
							}	
					}		
			}		
	}
	
	public function get_states($country_id){
			$this->loadModel('Region');
			$stateList = $this->Region->find('all',array('conditions'=>array('Region.country_id'=>$country_id),'order'=>array('Region.region'=>'asc')));
			//debug($stateList);
			foreach($stateList as $s){
				echo '<option value="'.$s['Region']['id'].'">'.$s['Region']['region'].'</option>';
			}
			$this->autoRender = false;
	}
	
	public function get_cities($state_id){
			$this->loadModel('City');
			$cityList = $this->City->find('all',array('conditions'=>array('City.region_id'=>$state_id),'order'=>array('City.city'=>'asc')));
			
			foreach($cityList as $s){
				echo '<option value="'.$s['City']['id'].'">'.$s['City']['city'].'</option>';
			}
			$this->autoRender = false;
	}
	
	public function blog()
	{
	

	}
	function checkuseralreadyexist(){
		$findUserName =  $_REQUEST['username'];
		$getUser = $this->User->find('first',array('conditions'=>array('User.username'=>$findUserName)));
		if(!empty($getUser)){
			echo 'false';
		}
		else{
			echo 'true';
		}
		$this->autoRender = false;
	}
	
	function checkemailalreadyexist()
	{
	$findUserEmail =  $_REQUEST['email'];
	$getEmail = $this->User->find('first',array('conditions'=>array('User.email'=>$findUserEmail)));
		if(!empty($getEmail)){
			echo 'false';
		}
		else{
			echo 'true';
		}
		$this->autoRender = false;
	
	}
	
	function my_account(){
		if(!empty($this->data)){
			$this->User->set($this->request->data['User']);
			$this->Profile->set($this->request->data['Profile']);
			if($this->User->validates() && $this->Profile->validates()){
				$one = $this->request->data['Profile']['profile_image'];
				
				if(isset($one['name']) && $one['name']==''){
					$getProfile = $this->Profile->findByid($this->data['Profile']['id']);
					$this->request->data['Profile']['profile_image'] = $getProfile['Profile']['profile_image'];					
				} else {
					$this->request->data['Profile']['profile_image'] = $one['name']; 
				}
				$this->User->save($this->data);
				$this->Profile->save($this->data);
				if (isset($one['error']) && $one['error'] == 0) {
                    $pth = 'files' . DS . 'userimage' . DS .$this->data['Profile']['id'].$one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);                   
                }
				$this->Session->setFlash('Your account information has been edited successfully','success_msg');
				$this->redirect(array('controller'=>'users','action'=>'my_account'));
			} else {
				$this->Session->setFlash('Please correct the following errors:','error_msg');
			}
		} else {
		$userId = $this->Session->read('Auth.User.id');
		$this->data = $this->User->find('first',array('conditions'=>array('User.id'=>$userId)));
		}
	}
	
	function change_password()
	{
		 if ($this->request->is('post')) {
		 	$this->User->set($this->request->data['User']);
			
			if($this->User->validates()){
				$id = $this->Session->read('Auth.User.id');
				$pass= array('User'=>array('id'=>$id,'password'=>$this->request->data['User']['new_password']));
					if($this->User->save($pass)) {
						$this->Session->setFlash("Your password has been updated successfully",'success_msg');
						$this->redirect(array('controller'=>'Users','action' => 'my_account'));
					}
			} else {
				$this->Session->setFlash('Please correct the following errors:','error_msg');
			}
					   
		}
	}   
  
	
	public function logout()
    {
		$this->User->query("UPDATE users set online=0 where id ='".$this->Session->read('Auth.User.id')."'");
        $this->Auth->logout();
        $this->redirect(array('controller'=>'Users','action'=>'login'));
		
    }

	
	public function donation()
    {
	
	
   
    }
public function contact()
{
		$this->loadModel('Contact');
		if($this->request->is('post'))
			{
				//$this->Contact->set($this->request->data);
				$this->request->data['Contact'] = $this->data;
				//debug($this->data);
				if($this->request->data)
				{
				$this->Contact->create();
				if($this->Contact->save($this->request->data))
				{
				 $ms = "<p>Name: ".$this->request->data['first_name']." ".$this->request->data['last_name']. " <br/>Email: ".$this->request->data['email']." <br/>Subject: ".$this->request->data['subject']."<br/>Comment: ".$this->request->data['Comment']."</p><br /> ";
						$l = new CakeEmail();
								$l->template('signup', 'fancy')
														->emailFormat('html')
														->subject('Contact enquiry  ')														
														->to('keithmanek1988@gmail.com')
														->from($this->request->data['email'])
														->send($ms);
					$this->Session->setFlash('Your request has been successfully submitted','default',  array ('class' => 'successfully'));
					$this->redirect(array('controller'=>'Users','action'=>'contact'));	
				} else {
				$this->Session->setFlash('An error occured while submitting your request','default',  array ('class' => 'errormsg'));
				 $this->redirect(array('controller'=>'Users','action'=>'contact'));
				}
				
				}
				}

			//debug( $this->data['Blog']['category_id']);die;	
}

public function admin_contactus()
{
			$this->loadModel('Contact');
		//	$contact = $this->Contact->find('all');
			//$this->set("info",$contact);
			
			//$this->Contact->recursive = 0;
			//$this->set('contact', $this->paginate());
			//$this->Customer->recursive = 0;
			$this->paginate = array(
				'order' => array('Contact.id'=>'desc'),
				'limit'=>10		
			);
			$this->set('info', $this->paginate('Contact'));
}

public function  admin_contactusedit($id=null)
{
	$this->loadModel('Contact');
	$this->Contact->id = $id;    
		if (!$this->Contact->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->Contact->exists()) 
		{
		$userData = $this->Contact->find('first',array('conditions'=>array('Contact.id'=>$id)));
		$this->set("userinfo", $userData);
		  $this->set('action_type','edit');
		  } 

	$this->loadModel('Contactreply');
	$message = $this->Contactreply->find('all',array('conditions'=>array('Contactreply.contact_id'=>$id)));
	$this->set("reply",$message);
	//debug($userData);exit;
		//$cData= $this->Contactreply->findByid($id);
		//debug($cData);exit;
		//$reply = $cData['Contactreply']['reply'];
		//debug($reply);exit;
		
		
}

public function  admin_contactdelete($id=null){
if (!$this->request->is('post')) 
{
			throw new MethodNotAllowedException();
		}
		$this->loadModel('Contact');
		$this->Contact->id = $id;
		$userData = $this->Contact->find('first',array('conditions'=>array('Contact.id'=>$id)));
		
		if (!$this->Contact->exists())
		{
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->Contact->delete()) {			
			$this->Session->setFlash(__('User deleted successfully'));
			$this->redirect(array('action' => 'contactus'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));

}

public function  admin_reply($id=null)
{
	$this->loadModel('Contact');
	$this->Contact->id = $id;
	$cData= $this->Contact->findByid($id);
	$email = $cData['Contact']['email'];
	//debug($email);exit;
	$this->loadModel('Contactreply');
	if($this->request->is('post'))
	{
	//debug($this->data);exit;
				/* $this->request->data['Contactrelpy'] = $this->data; */
				$this->request->data["Contactreply"]["reply"] = $this->request->data["Contactreply"]["reply"];
				$this->request->data["Contactreply"]["contact_id"] =$id;
				if($this->Contactreply->save($this->request->data))
				{
				//	$ms = "<p>Name: ".$this->request->data['first_name']." ".$this->request->data['last_name']. " <br/>Email: ".$this->request->data['email']." <br/>Subject: ".$this->request->data['subject']."<br/>Comment: ".$this->request->data['Comment']."</p><br /> ";
					$ms= "<p>Message: ".$this->request->data["Contactreply"]['reply']."</p></br/>";
					//debug($ms);exit;
						$l = new CakeEmail();
						$l->template('signup', 'fancy')
														->emailFormat('html')
														->subject('Contact enquiry')														
														->to($email)
														->from('keithmanek1988@gmail.com')
														->send($ms);
														
									//debug($l);exit;					
					$this->Session->setFlash('Your message has been successfully submitted','default',  array ('class' => 'successfully'));
					$this->redirect(array('controller'=>'Users','action'=>'admin_contactusedit',$this->Contact->id));		
				}
				else 
				{
				$this->Session->setFlash('An error occured while submitting your request','default',  array ('class' => 'errormsg'));
				 $this->redirect(array('controller'=>'Users','action'=>'admin_reply'));
				}
				
}

}

public function browse_video()
{
$this->loadModel('Video');
if($this->request->is('ajax'))
{
$user_id=$this->Auth->User('id');
$countVideo= $this->Video->find('count',array('conditions'=>array('Video.user_id'=>$user_id)));
if($countVideo >= 3)
{
	echo 'You cannot upload more than 3 video';
}
/* else
{
	echo 'ok';
} */

}

$this->autoRender=false;
	
}


public function upload_video()
{
ini_set("upload_max_filesize","300M");
ini_set("post_max_size","302M");
@$fileName = $_FILES["file1"]["name"]; // The file name
//echo $fileName;exit;
@$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
@$fileType = $_FILES["file1"]["type"]; // The type of file it is
@$fileSize = $_FILES["file1"]["size"]; // File size in bytes
@$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
if (!@$fileTmpLoc)
 { // if file not chosen
	echo "ERROR: Please browse for a file before clicking the upload button."; exit(); 
}
$this->loadModel('Video');
$user_id=$this->Auth->User('id');
$path=WWW_ROOT . 'files/video/';
$this->Video->create();
$this->request->data['Video']['user_id']=$user_id;
if($this->Video->save($this->request->data))
{
	$id=$this->Video->getLastInsertId();
	
	 if(move_uploaded_file(@$fileTmpLoc, $path.$id.$fileName))
	 {
			$this->Video->id=$id;
			$imageName=$id.$fileName; 
			$this->Video->saveField('video',$imageName);
		}
		
		$this->loadModel('Blog');
		$this->Blog->create();
		$this->Blog->set('type','video');
		$this->Blog->set('where',$user_id);
		$this->Blog->set('video_id',$id);
		$this->Blog->set('status',0);
		$this->Blog->set('video_status',1);
		$this->Blog->save();
	echo "true";
	//$this->Session->setFlash('Your video has been successfully uploaded','default',  array ('class' => 'successfully'));
	 } 			
$this->autoRender=false; 
		
}

public function video($id=null)
{
$this->loadModel('Video');
$videoList= $this->Video->find('first',array('conditions'=>array('Video.id'=>$id)));
$this->set('video',$videoList); 
}


public function video_comment()
{
//$videoComment_id=$video_id;
$this->loadModel('CommentVideo');
if ($this->request->is('post')) 
		{ 

		//debug($this->request->data);exit;
			$id= $this->Auth->user('id');
			$this->request->data['CommentVideo']['user_id']= $id;
            $this->request->data['CommentVideo']['status']= 1;
			$this->request->data['CommentVideo']['comment']= $_REQUEST['comment'];
             $this->request->data['CommentVideo']['video_id']= $_REQUEST['video_id'];

			$this->CommentVideo->create();
			if ($this->CommentVideo->save($this->request->data)) 
			{   
				echo 'true';
			} 
			else 
			{
				echo 'false'; exit;
			} 
						
		}

}

public function postcomment()
{
		
		$this->loadModel('CommentVideo');
		$id =  $_REQUEST['video_id'];
		$res1 = $this->CommentVideo->find('all', array('conditions' => array('CommentVideo.video_id'=>$id),'order'=>array('CommentVideo.id'=>'desc')));   
		$this->set('res1', $res1);
		$this->viewPath = 'Elements';
		$this->render('viewcomment');
}
  
	 public function video_like($id=null)
	 {
		$this->loadModel('VideoLike');
		$userid  = $this->Auth->user('id');
		$video_id=$this->data['id']; 
		$checkLike = $this->VideoLike->query("SELECT * from video_likes where user_id='" . $userid . "' AND video_id='" . $video_id . "' ");
	//	$checkLike=$this->VideoLike->query('Select * form video_likes where user_id="'.$userid.'"  AND video_id="'.$video_id.'" ');
	
		 if (empty($checkLike)) 
		 {
					$this->VideoLike->create();
					$this->VideoLike->set('video_id', $video_id);
					$this->VideoLike->set('user_id', $userid);
					$this->VideoLike->save();
		   }
			$getCounter = $this->VideoLike->find('count', array(
				'conditions' => array(
				'VideoLike.video_id' => (int) $video_id
				)
			));
			echo $getCounter;
			$this->autoRender = false;

	} 
	
	function delete_video($id=null)
	{
		$this->loadModel('Video');
		 $this->Video->id = $id;
		$video = $this->Video->find('first', array(
                'fields' => array(
                    'video'
                ),
				'conditions'=>array('Video.id'=>$id)
            ));
			
		$videoNmae = $video['Video']['video'];
		$file = new File(WWW_ROOT . 'files/video/'.$videoNmae, false, 0777);
		$file->delete();   
		$this->Video->query("DELETE from blogs where video_id='".$id."'");	
        $this->Video->delete();
		$this->Session->setFlash('Your video has been deleted successfully','default',  array ('class' => 'successfully'));
        $this->redirect(array(
            'action' => 'profile'
        ));	
          
	}
	
public function repost_video($id=null)
{
		
		$this->loadModel('Blog');
		$this->Blog->query("DELETE from blogs where video_id='".$id."'");	
		$this->Blog->create();
		$this->Blog->set('type','video');
		$this->Blog->set('where',$this->Session->read('Auth.User.id'));
		$this->Blog->set('video_id',$id);
		$this->Blog->set('status',0);
		$this->Blog->set('video_status',1);
		$this->Blog->save();
		$this->Session->setFlash('Your video has been reposted successfully','default',  array ('class' => 'successfully'));
        $this->redirect(array(
            'action' => 'profile'
        ));

}	
	
	




}