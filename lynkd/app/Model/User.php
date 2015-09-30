<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property AccessToken $AccessToken
 * @property AuthCode $AuthCode
 * @property Client $Client
 * @property RefreshToken $RefreshToken
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
        public function beforeSave($options = array()){
		if(isset($this->data[$this->alias]['password'])){
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}
	var $useTable = 'users';
	
	public $actsAs = array('Containable');
        
   	
       
/**
 * method called beforeSave
 */	
 var $validate = array(
		'username'=>array(
			'NotEmpty'=>array(
				'rule'=>'notEmpty',
				'message'=>'Please enter user name.'
			),
			'IsUnique'=>array(
				'rule'=>'isUnique',
				'message'=>'User name is already exist.'
			)
		)
	);

   public $hasMany = array(
		'Blog' => array(
			'className' => 'Blog',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''		
                    ),
		'Friend' => array(
			'className' => 'Friend',
			'foreignKey' => 'from_user_id'
		),
		'ToFriend' => array(
			'className' => 'Friend',
			'foreignKey' => 'to_user_id'
		),
		'Video' => array(
		'className' => 'Video',
		'foreignKey' => 'user_id'
		)
		
			
	);
	
	var $belongsTo = array(
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country'
		),
		'State' => array(
			'className' => 'Region',
			'foreignKey' => 'state'
		),
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'city'
		)
	);
      

}
?>
