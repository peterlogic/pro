<?php
App::uses('AppModel', 'Model');

class Category extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	var $useTable = 'categories';
	
	public $actsAs = array('Containable');
        
        var $validate = array(
		'title' => array(
			'rule'=>'notEmpty',
			'message'=>'Please enter the title'
		),
		'image' => array(
				'rule' => array(
					'extension',
					array('gif', 'jpeg', 'png', 'jpg')
				),
				'message' => 'Please supply a valid image.'
			)              
                
	);
	
	
	
 
      

}
?>