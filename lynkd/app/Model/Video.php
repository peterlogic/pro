<?php
App::uses('AppModel', 'Model');

class Video extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	var $useTable = 'videos';
	
	public $actsAs = array('Containable');
        
      
	
	
  public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''		
                    )
											
	);

  public $hasMany = array(
		'CommentVideo' => array(
		'className' => 'CommentVideo',
		'foreignKey' => 'video_id',
		'conditions' => '',
		'fields' => '',
		'order' => '',	
		'dependent'=> true
            ),
		'VideoLike' => array(
		'className' => 'VideoLike',
		'foreignKey' => 'video_id',
		'conditions' => '',
		'fields' => '',
		'order' => '',	
		'dependent'=> true
            )	
			
	);

      

}
?>
