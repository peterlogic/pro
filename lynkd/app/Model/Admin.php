<?php
App::uses('AppModel', 'Model');

class Admin extends AppModel {
	var $useTable = 'admins';	
	public $actsAs = array('Containable');     
}
?>