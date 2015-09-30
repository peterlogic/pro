<?php
App::uses('AppModel', 'Model');

class Blog extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	var $useTable = 'blogs';
	
	public $actsAs = array('Containable');
        
        var $validate = array(
		'title' => array(
			'rule'=>'notEmpty',
			'message'=>'Please enter the title'
		)
                
	);
	
	
	
	


  public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''		
                    ),
		'WhereUser' => array(
			'className' => 'User',
			'foreignKey' => 'where',
			'conditions' => '',
			'fields' => '',
			'order' => ''		
                    ),		
		'Mile' => array(
			'className' => 'Mile',
			'foreignKey' => 'showin_id'	
		)			
					
		
									
	);

  public $hasMany = array(
		'Comment' => array(
		'className' => 'Comment',
		'foreignKey' => 'blog_id',
		'conditions' => '',
		'fields' => '',
		'order' => '',	
		'dependent'=> true
            ),
			
		'BlogCategory' => array(
			'className' => 'Blogcategory',
			'foreignKey' => 'blog_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
            	'dependent'=> true
        ),
		
		
		'Comment' => array(
		'className' => 'Comment',
		'foreignKey' => 'blog_id',
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'dependent'=> true	
                 ),


		'Like' => array(
		'className' => 'Like',
		'foreignKey' => 'blog_id',
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'dependent'=> true	
             )						

			
				
			
	);

      

}
?>
