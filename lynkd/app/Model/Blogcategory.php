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
class Blogcategory extends AppModel {

/**
 * Display field
 *
 * @var string
 */
       
	var $useTable = 'blogcategories';
	
	public $actsAs = array('Containable');
        
   	
       
/**
 * method called beforeSave
 */	
 
	var $belongsTo = array(
		'Blog' => array(
		'className' => 'Blog',
		'foreignKey' => 'blog_id'
		),
		
		'Category' => array(
	'className' => 'Category',
	'foreignKey' => 'category_id',
	'conditions' => '',
	'fields' => '',
	'order' => ''
		)
		
	);
	

 

   
	
      

}
?>
