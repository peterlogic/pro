<?php
App::uses('AppModel', 'Model');
class City extends AppModel {

	var $useTable = 'cities';
	public $actsAs = array('Containable');	
	
}
?>