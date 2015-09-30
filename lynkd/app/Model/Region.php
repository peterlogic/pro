<?php
App::uses('AppModel', 'Model');
class Region extends AppModel {

	var $useTable = 'regions';
	public $actsAs = array('Containable');	
	
}
?>