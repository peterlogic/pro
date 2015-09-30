<?php

App::uses('AppController', 'Controller');

/**
 * Chats Controller
 *
 * @property Chat $Chat
 */
class ChatsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array("chat", 'getchat'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Chat->recursive = 0;
        $this->set('chats', $this->paginate());
    }

    public function message1() {
        $this->layout = "ajax";
        $res1 = $this->Chat->find('all', array('conditions' => array('AND' => array('Chat.to_user_id' => $this->Auth->User('id'), 'Chat.recd' => 0))));
        $this->set('response', $res1);
        $this->render('ajax', 'ajax');
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Chat->exists($id)) {
            throw new NotFoundException(__('Invalid chat'));
        }
        $options = array('conditions' => array('Chat.' . $this->Chat->primaryKey => $id));
        $this->set('chat', $this->Chat->find('first', $options));
    }

    public function chat() {
        if ($this->request->is('post')) {
            // //debug($this->request->data);exit;
            $this->loadModel('Chat');
            $res1 = $this->Chat->find('all', array("conditions" => array("AND" => array("Chat.user_id" => $this->request->data['user_id'], "Chat.to_user_id" => $this->request->data['to_user_id'])), "order" => array("Chat.id ASC")));
            //$res2 = $this->Chat->find('all',array("conditions"=>array("AND"=>array("Chat.to_user_id"=>$this->request->data['user_id'],"Chat.user_id"=>$this->request->data['to_user_id'])),"limit"=>"15","order"=>array("Chat.id DESC")));
            //$res = array_merge($res1,$res2);
            $this->set('response', $res1);
            $this->render('ajax', 'ajax');
        }
    }

//         public function chat(){
//             $this->loadModel('Chat');      
//             $res1 = $this->Chat->find('all',array("limit"=>"15","order"=>array("Chat.id DESC")));
//             $this->set('response',$res1);
//              $this->render('ajax', 'ajax');
//         }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layout = "ajax";
        if ($this->request->is('post')) {
            $user_id = $this->request->data['Chat']['user_id'];
            $to_user_id = $this->request->data['Chat']['to_user_id'];
            $message = $this->request->data['Chat']['message'];
            $sender = $this->request->data['Chat']['sender_name'];
            $arr1 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`,`recd`) values('','$user_id','$to_user_id','$sender','$message','1')");
            $arr2 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`,`recd`) values('','$to_user_id','$user_id','$sender','$message','1')");
//			$this->Chat->create();
//			if ($this->Chat->save($this->request->data)) {
//                                $response['error'] = '0';
//				$response['message'] = 'Sent Successfully.';				
//				$this->set('response',$response);                                
//			} else {
//				$response['error'] = '1';
//                                $response['message'] = 'Somethings went wrong.Please try again';
//                                $this->set('response',$response);				
//			}
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
        if (!$this->Chat->exists($id)) {
            throw new NotFoundException(__('Invalid chat'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Chat->save($this->request->data)) {
                $this->Session->setFlash(__('The chat has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The chat could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Chat.' . $this->Chat->primaryKey => $id));
            $this->request->data = $this->Chat->find('first', $options);
        }
        $users = $this->Chat->User->find('list');
        $toUsers = $this->Chat->ToUser->find('list');
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
        $this->Chat->id = $id;
        if (!$this->Chat->exists()) {
            throw new NotFoundException(__('Invalid chat'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Chat->delete()) {
            $this->Session->setFlash(__('Chat deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Chat was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function send_message() {
        if ($this->request->is('post')) {
            $user_id = $this->request->data['Chat']['user_id'];
            $to_user_id = $this->request->data['Chat']['to_user_id'];
            $message = $this->request->data['Chat']['message'];
            $sender = $this->request->data['Chat']['sender_name'];
            $arr1 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`) values('','$user_id','$to_user_id','$sender','$message')");
            $arr2 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`,`recd`) values('','$to_user_id','$user_id','$sender','$message','1')");
            $this->Session->setFlash(__('Message send successfully'));
            $this->redirect(array('controller' => 'users', 'action' => 'view', $to_user_id));
        }
    }

    public function home_send_message() {
        if ($this->request->is('post')) {
            $user_id = $this->request->data['Chat']['user_id'];
            $to_user_id = $this->request->data['Chat']['to_user_id'];
            $message = $this->request->data['Chat']['message'];
            $sender = $this->request->data['Chat']['sender_name'];
            $arr1 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`) values('','$user_id','$to_user_id','$sender','$message')");
            $arr2 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`,`recd`) values('','$to_user_id','$user_id','$sender','$message','1')");
            $this->Session->setFlash(__('Message send successfully'));
            $this->redirect("/");
        }
    }

    public function message($id=null) {
        $this->loadModel('User');
        $user_id = $this->User->find('all', array('fields' => 'id'));
        foreach ($user_id as $user_id1) {
            if ($this->Auth->User('id') == $user_id1['User']['id']) {
                $chat = $this->Chat->find('all', array('conditions' => array('AND' => array('Chat.to_user_id' => $this->Auth->User('id'),
                            'Chat.user_id' => $id))));
                $chat1[] = $chat;
            }
        }
        $this->set('chat', $chat);
        $auth_id = $this->Auth->User('id');
        $aa = $this->User->find('first', array('conditions' => array('User.id' => $id), "fields" => array("id")));

        $this->set('us_id', $aa);
        $this->Chat->query("UPDATE `chats` SET `recd`='1' where `user_id`=$id AND `to_user_id`=$auth_id");
        // $this->Chat->query("update `chats` set `recd`=1 where `user_id`=$auth_id AND `to_user_id`=$id");
    }

    public function send_mychat() {
        $user_id = $this->request->data['Chat']['user_id'];
        $to_user_id = $this->request->data['Chat']['to_user_id'];
        $message = $this->request->data['Chat']['message'];
        $sender = $this->request->data['Chat']['sender_name'];
        $arr1 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`) 
                    values('','$user_id','$to_user_id','$sender','$message')");
        $arr2 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`) 
                    values('','$to_user_id','$user_id','$sender','$message')");
        $this->Session->setFlash(__('Message send successfully'));
        $this->redirect(array('controller' => 'chats', 'action' => 'message', $to_user_id));
    }

    public function getchat() {
        $this->layout = 'ajax';
        $user = $this->request->data['user_id'];
        $loguser = $this->Auth->user('id');
        $this->Chat->recursive = -1;
        $chat = $this->Chat->query("SELECT * FROM `chats` WHERE `to_user_id`=" . $user . " AND `user_id`=" . $loguser . " ");
        $this->set('response', $chat);
    }

    public function addchat() {
        $this->layout = "ajax";
       // configure::write('debug', 2);

        if ($this->request->is('post')) {
            //debug($this->request->data);
            $user_id = $this->Auth->user('id');
            $to_user_id = $this->request->data['user_id'];
            $message = $this->request->data['msg'];
            $sender = $this->request->data['user_name'];
            $message = preg_replace('/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/i', '<a href="$1" target="_blank">$1</a>', $message);
            $arr1 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`,`recd`) values('','$user_id','$to_user_id','$sender','$message','0')");
            $arr2 = $this->Chat->query("insert into `chats` (`id`,`user_id`,`to_user_id`,`sender_name`,`message`,`recd`) values('','$to_user_id','$user_id','$sender','$message','1')");
			$response = array(
                'error' => '1'
            );
            $this->set('response', $response);
        }
    }

    public function chatopen() {
        $this->layout = "ajax";
        configure::write('debug', 2);
        //debug($this->request->data);
        $user_id = $this->Auth->user('id');
        $to_user_id = $this->request->data['user_id'];
        //$message = $this->request->data['msg'];
        $sender = $this->request->data['sender'];

        $arr1 = $this->Chat->query("insert into `chat_open` (`id`,`user_id`,`pop_open`,`sendername`,`status`) values('','$user_id','$to_user_id','$sender','1')");
		$this->set('response', 1);       
    }

    public function chatclose() {
        $this->layout = "ajax";
        configure::write('debug', 0);
        debug($this->request->data);
        $user_id = $this->Auth->user('id');
        $to_user_id = $this->request->data['user_id'];
        //$message = $this->request->data['msg'];
        //$qry=$this->Multichat->query("DELETE FROM `multichats` where `user_id`='$user_id' AND `to_user_id`='$to_user_id'");
        $arr1 = $this->Chat->query("DELETE FROM `chat_open` where `user_id`='$user_id' AND `pop_open`='$to_user_id'");
        if ($arr1) {
            $this->set('response', 1);
        }
    }

    public function chatseen() {
        $this->layout = "ajax";
        configure::write('debug', 0);
        if ($this->request->is(post)) {
            $user_id = $this->Auth->user('id');
            $to_user_id = $this->request->data['user_id'];
            $arr1 = $this->Chat->query("UPDATE `chats` SET `recd`='1' where `user_id`=$user_id AND `to_user_id`=$to_user_id");
            $arr2 = $this->Chat->query("UPDATE `chats` SET `recd`='1' where `user_id`=$to_user_id AND `to_user_id`=$user_id");
            if ($arr1) {
                $this->set('response', 1);
            }
        }
    }
    
     public function chatnoti() {
        $this->layout = "ajax";
        configure::write('debug', 0);
        if ($this->request->is(post)) {
            $user_id = $this->Auth->user('id');
            $to_user_id = $this->request->data['user_id'];
            $arr1 = $this->Chat->query("UPDATE `chats` SET `notification_seen`='1' where `user_id`=$user_id AND `to_user_id`=$to_user_id");
            $arr2 = $this->Chat->query("UPDATE `chats` SET `notification_seen`='1' where `user_id`=$to_user_id AND `to_user_id`=$user_id");
            if ($arr1) {
                $this->set('response', 1);
            }
        }
    }

    public function updateactivity() {
        $this->loadModel('User');
        $this->layout = "ajax";
        configure::write('debug', 2);
        if ($this->request->is('post')) {
            $u_i = $this->request->data['user_id'];
            $date = date("Y-m-d H:i:s");
            $arr1 = $this->User->query("UPDATE `users` SET `last_activity`='$date' where `id`='$u_i'");
           
            $this->set('response', 'success');
           
        }
    }

    public function getonlineuser() {
        $this->layout = "ajax";
        configure::write('debug', 2);
        $this->loadModel('User');
        $this->loadModel('Friend');
        $date = date("Y-m-d H:i:s");
		//echo "SELECT id,name,last_name,profile_image FROM users WHERE `online`=1";
        $users = $this->User->query("SELECT id,name,last_name,profile_image FROM users WHERE  `online`=1" );
   //     debug($users);
        if ($users) {

            foreach ($users as $user) {
                if ($user['users']['id'] != $this->Auth->user('id')) {
				$conditions = array(
				'OR' => array(				
							array('Friend.to_user_id' => $this->Auth->User('id'),'Friend.from_user_id' => $user['users']['id']),
							array('Friend.from_user_id' => $this->Auth->User('id') ,'Friend.to_user_id' => $user['users']['id'])
						),
				'AND' => array('Friend.status'=>(int)1)		
			);
                $friend = $this->Friend->find('first', array('conditions' => $conditions));

                    if ($friend) {
                        $user['users']['friend'] = '1';
                        if( $user['users']['profile_image']){
                            $user['users']['profile_image']=FULL_BASE_URL.$this->webroot.'files/profileimage/'. $user['users']['profile_image'];
                        }
                        else{
                              $user['users']['profile_image']=FULL_BASE_URL.$this->webroot.'files/profileimage/user.png';
                        }
                        $userlist[] = $user;
                    }
                }
            }
            if(@$userlist){
            $response['error']='0';
            $response['list']=@$userlist;
          $this->set('response',$response);  }
          else{
                   $response['error']='1';
         
            $this->set('response',$response);
          }
        }
        else{
             $response['error']='1';
         
            $this->set('response',$response);
        }
    }
    public function new_friend_request(){
            $this->loadModel('Myfriend');
            $this->layout="ajax";
            configure::write('debug',2);
            $new_friend_request=$this->Myfriend->find('all',array('conditions'=>array('AND'=>array('Myfriend.to_user_id'=>$this->Auth->User('id'),'Myfriend.status'=>0))));
            $this->set('response',$new_friend_request);
        }

}