<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	var $components = array('Session','Auth','RequestHandler');
	var $helpers = array('Html','Form','Session');
	public function beforeFilter() 
	{
	//debug(HTTP_ROOT);exit;
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
			 $this->layout = 'admin';		
	    } else 
		{
			 $this->layout = 'front';
		}	
		 if(isset($this->request->params['admin']))
		 {
			$this->Auth->loginAction = array('controller' =>'users','action' => 'admin_login');
			}
		else{
			$this->Auth->loginAction = array('controller' =>'users','action' => 'login');
		}	
		
		$this->loadModel('Sitesetting');
		$this->loadModel('Friend');
		$this->set('Site',$this->Sitesetting->find('first'));
		
		$this->loadModel('Staticpage');
		$this->set('Staticpages',$this->Staticpage->find('all'));

		$this->loadModel('User');
		$logged_user = $this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->User('id'))));
		$this->set('logged_user',$logged_user);
		//debug($logged_user);
		if($this->Auth->User('id')){
			/*$address = $logged_user['City']['city'].', '.$logged_user['State']['region'].', '.$logged_user['Country']['country'];
			$prepAddr = str_replace(' ','+',$address);		 
			$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');		 
			$output= json_decode($geocode);		 
			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;*/	
			//echo $address.'<br>Lat: '.$lat.'<br>Long: '.$long;
		}
		//$this->set('friend_lists',$this->Friend->find('all',array('conditions'=>array('Friend.from_user_id'=>$this->Auth->User('id'),'Friend.status'=>(int)1))));
		
		$conditions = array(
			'OR' => array(				
						array('Friend.to_user_id' => $this->Auth->User('id')),
						array('Friend.from_user_id' => $this->Auth->User('id'))
					),
			'AND' => array('Friend.status'=>(int)1)		
		);
		$this->set('friend_lists',$this->Friend->find('all',
		array('conditions'=>$conditions,'order'=>array('Friend.status'=>'asc'))
		));
		
		
		

	   $url = "http://dev414.trigma.us/lynkd";
	   $this->set('base_url',$url);
   
/*--------------------------------------------------*/
		$log_id = $this->Auth->User('id');
        $pop_open = $this->User->query("select * from `chat_open` where `user_id`='$log_id'");
        $this->set('pop_open', $pop_open);
		$this->loadModel('Multichat');
        $this->set('multichat', $this->Multichat->find("all"), array("conditions" => array("Multichat.user_id" => $this->Auth->User('id'))));
        $onlinechats = $this->Multichat->find("all", array('conditions' => array('Multichat.user_id' => $this->Auth->User("id"))));
         $this->set("onlinechats", $onlinechats);
       $onuser = array();
        foreach ($onlinechats as $onli) {
			$us = $this->User->find("first", array("conditions" => array("User.id" => $onli['Multichat']['to_user_id'])));
			$onuser[] = array('id'=>$us['User']['id'],'name'=>$us['User']['name']); ;
        }
        $this->set('onl', @$onuser);
        $this->loadModel('Friend');
        $date = date("Y-m-d H:i:s");
       // $onlineusers = $this->User->query("SELECT * FROM users WHERE DATE_ADD(last_activity, INTERVAL 2 MINUTE) >='$date' and `online`=1");
		$onlineusers = $this->User->find("all",array('conditions'=>array('User.online'=>1)));
        foreach ($onlineusers as $user) {
            if ($user['User']['id'] != $this->Auth->user('id')) {
			$conditions = array(
				'OR' => array(				
							array('Friend.to_user_id' => $this->Auth->User('id'),'Friend.from_user_id' => $user['User']['id']),
							array('Friend.from_user_id' => $this->Auth->User('id') ,'Friend.to_user_id' => $user['User']['id'])
						),
				'AND' => array('Friend.status'=>(int)1)		
			);
                $friend = $this->Friend->find('first', array('conditions' => $conditions));
				//debug($friend);
                if ($friend) {
                    $user['User']['friend'] = '1';
                    $userlist[] = $user;
                }
            }
        }

        $this->set('findfriends', @$userlist);
		$this->loadModel('Chat');
        $this->set('chat_view', $this->Chat->find('all', array('conditions' => array('AND' => array('Chat.to_user_id' => $this->Auth->User('id'), 'Chat.recd' => 0)))));
		
/*---------------------------------------------------*/
		$this->loadModel('Category');
		$blogCategoryList = $this->Category->find('all',array('conditions'=>array('Category.status'=>(int)1),'order'=>array('Category.title'=>'asc')));
		$this->set('blogCategoryList', $blogCategoryList);
		
		$this->loadModel('Mile');
		$milesList = $this->Mile->find('all',array('order'=>array('Mile.id'=>'asc')));
		$this->set('milesList', $milesList);
		
	}
}