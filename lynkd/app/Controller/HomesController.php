<?php
class HomesController extends AppController
{
		var $name= 'Homes';
		var $layout = 'front';
		 public function beforeFilter(){
		            parent::beforeFilter();
                     $this->Auth->allow('index','search');    
	     }
		public function index()
		{
			$lat1 = $this->Session->read('filter.latitude');
			$lon1 = $this->Session->read('filter.longitude');
		
			if(isset($this->request->query['status']) && $this->request->query['status']=='SUCCESS'){
				$this->Session->setFlash('Thanks for your donation to lynkd','default',array('class'=>'successfully'));
			} else if(isset($this->request->query['status']) && $this->request->query['status']=='ERROR'){
				$this->Session->setFlash('An error occured while processing your transaction','default',array('class'=>'errormsg'));
			}
			$this->loadModel('Blog');
			$this->loadModel('Like');
			$userid = $this->Auth->user('id');
			$this->set('user_id',$userid);
			$this->Blog->recursive = 1;
			$this->paginate = array(
				'limit' => 3,
				'order' => array('Blog.id' => 'DESC')
			);
			$blogData = $this->paginate('Blog',array('Blog.status'=>1));
			foreach ($blogData as $key => $b) {
			
				$lat2                                       = $b['Blog']['latitude'];
				$lon2                                       = $b['Blog']['longitude'];
				if($lat2 != '' && $lon2!=''){
						$blogData[$key]['Blog']['miles_difference'] = round($this->distance($lat1, $lon1, $lat2, $lon2, $unit = ''));
				} else {
						$blogData[$key]['Blog']['miles_difference'] = 0;
				}
			}
			$this->set('blogs',$blogData );
				
		}
		
	public function distance($lat1, $lon1, $lat2, $lon2, $unit = '')
    {
        $theta = $lon1 - $lon2;
        $dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist  = acos($dist);
        $dist  = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit  = strtoupper($unit);
        
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
	
public function search()
{
		$lat1 = $this->Session->read('filter.latitude');
		$lon1 = $this->Session->read('filter.longitude');
		$this->loadModel('Blog');
		if($this->request->is('post') || $this->request->is('get') )
		{
			$blogname = $this->params->query['tb'];
				if(!empty($blogname))
				{
					 $this->Blog->recursive = 1;
					 $this->paginate = array(
						'limit' => 3,
						'order' => array('Blog.id' => 'DESC')
					);
					$blogData = $this->paginate('Blog',array('OR'=>array(array('Blog.title LIKE' => "%$blogname%"),array('Blog.tags LIKE' => "%$blogname%")),'AND'=>array('Blog.status'=>1)));
					foreach ($blogData as $key => $b) {
						$lat2                                       = $b['Blog']['latitude'];
						$lon2                                       = $b['Blog']['longitude'];
						if($lat2 != '' && $lon2!=''){
						$blogData[$key]['Blog']['miles_difference'] = round($this->distance($lat1, $lon1, $lat2, $lon2, $unit = ''));
						} else {
								$blogData[$key]['Blog']['miles_difference'] = 0;
						}
					}
				}
				$this->set("blog_list",$blogData);	
	}
}
				
}
?>