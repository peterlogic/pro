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
class VideoLike extends AppModel {

	var $useTable = 'video_likes';
	public $actsAs = array('Containable');
	var $belongsTo = array
	(
			'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
		);

 
	
}
?>
