<?php
App::uses('AppModel', 'Model');
class Country extends AppModel {

	var $useTable = 'countries';
	public $actsAs = array('Containable');	
	
}
?>