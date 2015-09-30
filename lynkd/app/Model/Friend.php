<?php
App::uses('AppModel', 'Model');

class Friend extends AppModel {
		
		var $useTable = 'user_friends';
		var $primaryKey = 'id';
		
		var $belongsTo = array(			
			'User' => array(
				'className' => 'User',
				'foreignKey' => 'to_user_id'
			),
			'FromUser' => array(
				'className' => 'User',
				'foreignKey' => 'from_user_id'
			)
		);
}
?>