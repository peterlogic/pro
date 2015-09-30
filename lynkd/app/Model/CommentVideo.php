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
class CommentVideo extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	var $useTable = 'comment_videos';
	
	public $actsAs = array('Containable');
        
        
	
       
/**
 * method called beforeSave
 */	
  public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''		
                    ),
					
    
	);
	
}
?>
