<?php
App::uses('AppModel', 'Model');
/**
 * Comment Model
 *
 * @property AccessToken $AccessToken
 * @property AuthCode $AuthCode
 * @property Client $Client
 * @property RefreshToken $RefreshToken
 */
class Like extends AppModel {

	var $useTable = 'likes';
	public $actsAs = array('Containable');
				
	var $belongsTo = array(
			'user' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
		);

 
	
}
?>
