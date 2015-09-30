<?php
App::uses('AppController', 'Controller');
App::uses('File', 'Utility');

class BlogsController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'view',
            'tag',
            'changepassword',
            'get_blog_type1',
            'get_blog_type2',
            'get_blog_type3',
            'get_filter_result_from_category',
            'get_filter_result',
            'set_user_lat_long',
            'get_filter_result_from_range',
            'reset_session',
			'get_filter_result_from_zip',
			'distance',
			'friendlist'.
			'comment',
			'comment_delete',
			'admin_comment',
			'admin_commentdelete',
			'repost',
			'admin_repost'
			
        ));
    }
    
    public function index()
    {
        $userid = $this->Auth->user('id');
        if (!empty($userid)) {
            $this->Blog->recursive = 1;
            $this->paginate        = array(
                'limit' => 6,
				'order' => array('Blog.id'=>'desc')
            );
            $blogs  = $this->paginate('Blog', array(
                "Blog.user_id" => $userid
            ));
        }
        $this->set("users", $blogs);
    }
    
    public function tag($tag = null)
    {
		$lat1 = $this->Session->read('filter.latitude');
		$lon1 = $this->Session->read('filter.longitude');
		$this->Blog->recursive = 1;
		$this->paginate = array(
			'limit' => 3,
			'order' => array('Blog.id' => 'DESC')
		);
		$blogData = $this->paginate('Blog',array('Blog.tags LIKE' => "%$tag%",'Blog.status'=>1));
		foreach ($blogData as $key => $b) {
			$lat2                                       = $b['Blog']['latitude'];
			$lon2                                       = $b['Blog']['longitude'];
			if($lat2 != '' && $lon2!=''){
						$blogData[$key]['Blog']['miles_difference'] = round($this->distance($lat1, $lon1, $lat2, $lon2, $unit = ''));
				} else {
						$blogData[$key]['Blog']['miles_difference'] = 0;
				}
		}
		$userid = $this->Auth->user('id');
		$this->set('user_id',$userid);
        $this->set('blogs', $blogData);
    }
    public function view($id = null)
    {
        $this->Blog->id        = $id;
        $this->Blog->recursive = 2;
		$info = $this->Blog->find("first");
		$info1 = $this->Blog->find('first', array(
                               'order' => array('Blog.id' => 'DESC') ));
		$page_title = $info1['Blog']['meta_title'];					   
		$page_keyword = $info1['Blog']['meta_tag'];					   
		$page_description = $info1['Blog']['meta_description'];			
		
		$this->set(compact("info","info1",'page_title','page_keyword','page_description'));					   
        if (!$this->Blog->exists()) {
            throw new NotFoundException(__('Invalid Blog'));
        }
        $this->set('blog', $this->Blog->read(null, $id));
		/***************** Coded by T:307 for next and previous auto record ********************/
		#### For getting next id

		$getNextID = $this->Blog->query("SELECT id FROM blogs WHERE id > '$id' ORDER BY id LIMIT 1");
		if(!empty($getNextID)){
			$this->set('getNextID', $getNextID[0]['blogs']['id']);
		}

		#### For getting previous id
		$getPreviousID = $this->Blog->query("SELECT * FROM blogs WHERE id < '$id'  ORDER BY id DESC LIMIT 1");
		if(!empty($getPreviousID)){
			$this->set('getPreviousID', $getPreviousID[0]['blogs']['id']);
		}
		/*********** End Coded by T:307 for next and previous auto record ********************/
        $blogs = $this->Blog->find('all', array(
            'conditions' => array(
                'Blog.status' => 1
            ),
            'fields' => array(
                'title',
                'image',
                'created',
                'tags'
            )
        ));
        $this->set('blogs', $blogs);
        $types = array();
        
        foreach ($blogs as $key => $tags) {
                        
            if ($key == 0) {
                $tagings = $tags['Blog']['tags'];
            } else {
                $tagings = "," . $tags['Blog']['tags'];
            }
            $types = array_unique(array_merge($types, explode(",", $tagings)));
            $this->set('types', $types);
        }
    }
    
    public function view_more()
    {
        $blogs = $this->Blog->find('all', array(
            'conditions' => array(
                'Blog.status' => 1
            ),
            'fields' => array(
                'title',
                'image',
                'created',
                'tags'
            )
        ));
        $this->set('blogs', $blogs);
        $types = array();
        
        foreach ($blogs as $key => $tags) {
            if ($key == 0) {
                $tagings = $tags['Blog']['tags'];
            } else {
                $tagings = "," . $tags['Blog']['tags'];
            }
            
            $types = array_unique(array_merge($types, explode(",", $tagings)));            
            $this->set('types', $types);
        }
        
        
    }    
    
    public function add()
    {
        $this->loadModel('Blogcategory');
        $uid = $this->Auth->user('id');
        $this->set('user_id', $uid);
        if ($this->request->is('post')) 
		{
            
            $this->Blog->set($this->data);
            if ($this->Blog->validates()) {
                $one  = $this->data['Blog']['image'];
                $this->request->data['Blog']['image']     = $one['name'];
                $address                                  = $this->data['Blog']['location']; // Google HQ
                if($address != ''){
                $prepAddr                                 = str_replace(' ', '+', $address);
                $geocode                                  = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
                $output                                   = json_decode($geocode);
                $lat                                      = $output->results[0]->geometry->location->lat;
                $long                                     = $output->results[0]->geometry->location->lng;
				} else {
				$lat = '';
				$long = '';
				}
                $this->request->data['Blog']['latitude']  = $lat;
                $this->request->data['Blog']['longitude'] = $long;
                 
                $this->Blog->create();
				//echo "<pre>";print_r($this->request->data);
                if ($this->Blog->save($this->request->data)) {
                    
                    $blog_id     = $this->Blog->getLastInsertID();
                    $category_id = $this->data['Blog']['category_id'];
                    
                    foreach ($category_id as $cat) {
                        
                        $saveCategory['Blogcategory']['category_id'] = $cat;
                        $saveCategory['Blogcategory']['blog_id']     = $blog_id;
                        $this->Blogcategory->create();
                        $this->Blogcategory->save($saveCategory);
                    }
                    $id    = $this->Blog->getLastInsertId();
                   
                    if ($one['name'] != '') {
							$imageName = $id . $one['name'];
                            $path = WWW_ROOT . 'files/blogimages/';
                            move_uploaded_file($one['tmp_name'], $path . $imageName);                            
                            $this->Blog->id = $id;
                            $this->Blog->saveField("image", $imageName);                    
                    }
                    
                    $this->Session->setFlash('your blog has successfully added.', 'default', array(
                        'class' => 'successfully'
                    ));
                    $this->redirect(array(
                        'controller' => 'blogs',
                        'action' => 'index'
                    ));		
                }
            }
            
        }
        
        $this->loadModel('Categorie');
        $cat = $this->Categorie->find('list', array(
            'fields' => array(
                'Categorie.id',
                'Categorie.title'
            )
        ));
        $this->set('catlist', $cat);
        
        $this->loadModel('Mile');
        $miles = $this->Mile->find('list', array(
            'fields' => array(
                'Mile.id',
                'Mile.miles'
            )
        ));
        $this->set('mile', $miles);
        
    }
    
    public function edit($id = null)
    {       
        $this->Blog->id = $id;
        if (!$this->Blog->exists()) {
            throw new NotFoundException(__('Invalid blog'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
			//debug($this->data);
			//exit();
			$image = $this->Blog->find('first', array(
                'fields' => array(
                    'image'
                ),
				'conditions'=>array('Blog.id'=>$id)
            ));
            $one = $this->request->data['Blog']['image'];
            if ($one['name'] != '') {
                $this->request->data['Blog']['image'] = $one['name'];
				$imageNAME = $image['Blog']['image'];
				$file = new File(WWW_ROOT . 'files/blogimages/'.$imageNAME, false, 0777);
				$file->delete();
            } else {
                $this->request->data['Blog']['image'] = $image['Blog']['image'];
            }
				$address                                  = $this->data['Blog']['location']; // Google HQ
				if($address != ''){
                $prepAddr                                 = str_replace(' ', '+', $address);
                $geocode                                  = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
                $output                                   = json_decode($geocode);
                $lat                                      = $output->results[0]->geometry->location->lat;
                $long                                     = $output->results[0]->geometry->location->lng;
				} else {
				$lat = '';
				$long = '';
				}
                $this->request->data['Blog']['latitude']  = $lat;
                $this->request->data['Blog']['longitude'] = $long;
			if ($this->Blog->save($this->request->data)) {
                if ($one['error'] == 0) {
                    $pth = 'files' . DS . 'blogimages' . DS . $id . $one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);
                    $this->Blog->saveField("image", $id . $one['name']);
                }
				$this->Blog->query("DELETE from blogcategories where blog_id='".$id."' ");
				$category_id = $this->data['Blog']['category_id'];
                    $this->loadModel('Blogcategory');
                    foreach ($category_id as $cat) {                        
                        $this->Blogcategory->create();
                        $this->Blogcategory->set('category_id',$cat);
                        $this->Blogcategory->set('blog_id',$id);
                        $this->Blogcategory->save();
                    }
				$this->Session->setFlash('The blog has been updated successfully', 'default', array(
                    'class' => 'successfully'
                ));
                $this->redirect(array(
                    'controller' => 'blogs',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__('The blog could not be updated. Please, try again.','default',array('class'=>'errormsg')));
				$this->redirect(array(
                    'controller' => 'blogs',
                    'action' => 'edit',$id
                ));
            }
        } 
		
        $this->loadModel('Categorie');
        $cat         = $this->Categorie->find('list', array(
            'fields' => array(
                'Categorie.id',
                'Categorie.title'
            )
        ));
        $this->loadModel('Blogcategory');
		$this->data = $this->Blog->findByid($id);
		$bIDs = array();
		foreach($this->data['BlogCategory']  as $bc){
				$bIDs[] = $bc['category_id'];
		}
        $this->set('bIDs', $bIDs);
        $this->set('catlist', $cat);
        $this->set('action_type', 'Edit');
        $this->viewPath = 'Blogs';
        $this->loadModel('Mile');
        $miles = $this->Mile->find('list', array(
            'fields' => array(
                'Mile.id',
                'Mile.miles'
            )
        ));
        $this->set('mile', $miles);
        
    }
    
    public function changepassword()
    {
         
    }
    
    public function delete($id = null)
    {
        $this->Blog->id = $id;
		$image = $this->Blog->find('first', array(
                'fields' => array(
                    'image'
                ),
				'conditions'=>array('Blog.id'=>$id)
            ));
          
		$imageNAME = $image['Blog']['image'];
		$file = new File(WWW_ROOT . 'files/blogimages/'.$imageNAME, false, 0777);
		$file->delete();
        $this->Blog->query("DELETE from blogcategories where blog_id='".$id."' "); 
        $this->Blog->delete();
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    
    public function admin_index()
    {
		 $this->loadModel("Blog");
		 $blogs = $this->Blog->find("all");
		// echo "<pre>";print_r($blogs);
      //  $this->Blog->recursive = 0;
        $this->set('blogs', $this->paginate());
        
    }
    
    public function admin_view($id = null)
    {
        $this->Sitesetting->id = $id;
        if (!$this->Sitesetting->exists()) {
            throw new NotFoundException(__('Invalid sitesetting'));
        }
        $this->set('sitesetting', $this->Sitesetting->read(null, $id));
    }
    
    public function admin_add()
    {
       
		$this->loadModel('Blogcategory');
        $uid = $this->Auth->user('id');
        $this->set('user_id', $uid);
        if ($this->request->is('post')) {
            
            $this->Blog->set($this->data);
            if ($this->Blog->validates()) {
                $one                                      = $this->data['Blog']['image'];
                $this->request->data['Blog']['image']     = $one['name'];
                $address                                  = $this->data['Blog']['location']; // Google HQ
                if($address != ''){
                $prepAddr                                 = str_replace(' ', '+', $address);
                $geocode                                  = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
                $output                                   = json_decode($geocode);
                $lat                                      = $output->results[0]->geometry->location->lat;
                $long                                     = $output->results[0]->geometry->location->lng;
				} else {
				$lat = '';
				$long = '';
				}
                $this->request->data['Blog']['latitude']  = $lat;
                $this->request->data['Blog']['longitude'] = $long;
                 
                $this->Blog->create();				
                if ($this->Blog->save($this->request->data)) {
                    
                    $blog_id     = $this->Blog->getLastInsertID();
                    $category_id = $this->data['Blog']['category_id'];
                    
                    foreach ($category_id as $cat) {
                        
                        $saveCategory['Blogcategory']['category_id'] = $cat;
                        $saveCategory['Blogcategory']['blog_id']     = $blog_id;
                        $this->Blogcategory->create();
                        $this->Blogcategory->save($saveCategory);
                    }
                    $id    = $this->Blog->getLastInsertId();
                   
                    if ($one['name'] != '') {
							$imageName = $id . $one['name'];
                            $path = WWW_ROOT . 'files/blogimages/';
                            move_uploaded_file($one['tmp_name'], $path . $imageName);                            
                            $this->Blog->id = $id;
                            $this->Blog->saveField("image", $imageName);                    
                    }
                    
                    $this->Session->setFlash('your blog has successfully added.');
                    $this->redirect(array(
                        'controller' => 'blogs',
                        'action' => 'index'
                    ));		
                }
            }
            
        }
        
        $this->loadModel('Categorie');
        $cat = $this->Categorie->find('list', array(
            'fields' => array(
                'Categorie.id',
                'Categorie.title'
            )
        ));
        $this->set('catlist', $cat);
        
        $this->loadModel('Mile');
        $miles = $this->Mile->find('list', array(
            'fields' => array(
                'Mile.id',
                'Mile.miles'
            )
        ));
        $this->set('mile', $miles);
        
        $this->set('action_type', 'Add New');
        $this->viewPath = "Blogs";
        $this->render('admin_add');
    }
    
    public function admin_edit($id = null)
    {
       
		 $this->Blog->id = $id;
        if (!$this->Blog->exists()) {
            throw new NotFoundException(__('Invalid blog'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
		
			$image = $this->Blog->find('first', array(
                'fields' => array(
                    'image'
                ),
				'conditions'=>array('Blog.id'=>$id)
            ));
            $one = $this->request->data['Blog']['image'];
            if ($one['name'] != '') {
                $this->request->data['Blog']['image'] = $one['name'];
				$imageNAME = $image['Blog']['image'];
				$file = new File(WWW_ROOT . 'files/blogimages/'.$imageNAME, false, 0777);
				$file->delete();
            } else {
                $this->request->data['Blog']['image'] = $image['Blog']['image'];
            }
				$address                                  = $this->data['Blog']['location']; // Google HQ
				if($address != ''){
                $prepAddr                                 = str_replace(' ', '+', $address);
                $geocode                                  = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
                $output                                   = json_decode($geocode);
                $lat                                      = $output->results[0]->geometry->location->lat;
                $long                                     = $output->results[0]->geometry->location->lng;
				} else {
				$lat = '';
				$long = '';
				}
                $this->request->data['Blog']['latitude']  = $lat;
                $this->request->data['Blog']['longitude'] = $long;
			if ($this->Blog->save($this->request->data)) {
                if ($one['error'] == 0) {
                    $pth = 'files' . DS . 'blogimages' . DS . $id . $one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);
                    $this->Blog->saveField("image", $id . $one['name']);
                }
				$this->Blog->query("DELETE from blogcategories where blog_id='".$id."' ");
				$category_id = $this->data['Blog']['category_id'];
                    $this->loadModel('Blogcategory');
                    foreach ($category_id as $cat) {                        
                        $this->Blogcategory->create();
                        $this->Blogcategory->set('category_id',$cat);
                        $this->Blogcategory->set('blog_id',$id);
                        $this->Blogcategory->save();
                    }
				$this->Session->setFlash('The blog has been updated successfully');
                $this->redirect(array(
                    'controller' => 'blogs',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash('The blog could not be updated. Please, try again.');
				$this->redirect(array(
                    'controller' => 'blogs',
                    'action' => 'edit',$id
                ));
            }
        } 
		
        $this->loadModel('Categorie');
        $cat         = $this->Categorie->find('list', array(
            'fields' => array(
                'Categorie.id',
                'Categorie.title'
            )
        ));
        $this->loadModel('Blogcategory');
		$this->data = $this->Blog->findByid($id);
		$bIDs = array();
		foreach($this->data['BlogCategory']  as $bc){
				$bIDs[] = $bc['category_id'];
		}
        $this->set('bIDs', $bIDs);
        $this->set('catlist', $cat);
        $this->set('action_type', 'Edit');
        $this->viewPath = 'Blogs';
        $this->loadModel('Mile');
        $miles = $this->Mile->find('list', array(
            'fields' => array(
                'Mile.id',
                'Mile.miles'
            )
        ));
        $this->set('mile', $miles);
        $this->set('action_type', 'Edit');
        $this->viewPath = 'Blogs';  
		
    }
    
    public function admin_delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Blog->id = $id;
        if (!$this->Blog->exists()) {
            throw new NotFoundException(__('Invalid blog'));
        }
        if ($this->Blog->delete()) {
            $this->Session->setFlash(__('Blog deleted'));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->Session->setFlash(__('Blog was not deleted'));
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    
    
    
    
    public function admin_deleteall($id = null)
    {
        if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
        }
        
        foreach ($this->request['data']['Blog'] as $k) {
            $this->Blog->id = (int) $k;
            if ($this->Blog->exists()) {
                $this->Blog->delete();
            }
        }
        $this->Session->setFlash(__('Selected Blogs were removed.'));
        
        $this->autoRender = false;
    }
    
    public function admin_activate($id = null)
    {
        $this->Blog->id = $id;
        if ($this->Blog->exists()) {
            $x = $this->Blog->save(array(
                'Blog' => array(
                    'status' => '1'
                )
            ));
            $this->Session->setFlash("Blog activated successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to activate Blog.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    
    public function activate($id = null)
    {
        $this->Blog->id = $id;
        if ($this->Blog->exists()) {
            $x = $this->Blog->save(array(
                'Blog' => array(
                    'status' => '1'
                )
            ));
            
            $this->Session->setFlash('Blog activated successfully', 'default', array(
                'class' => 'successfully'
            ));
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to activate Blog.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    
    
    public function admin_block($id = null)
    {
        $this->Blog->id = $id;
        if ($this->Blog->exists()) {
            $x = $this->Blog->save(array(
                'Blog' => array(
                    'status' => '0'
                )
            ));
            $this->Session->setFlash("Blog blocked successfully.");
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to block Blog.");
            $this->redirect(array(
                'action' => 'index'
            ));
        }        
    }    
    
    public function block($id = null)
    {
        $this->Blog->id = $id;
        if ($this->Blog->exists()) {
            $x = $this->Blog->save(array(
                'Blog' => array(
                    'status' => '0'
                )
            ));
            
            $this->Session->setFlash('Blog blocked successfully', 'default', array(
                'class' => 'successfully'
            ));
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            $this->Session->setFlash("Unable to block Blog.",'default',array('class'=>'errormsg'));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        
    }
    
    
    public function admin_activateall($id = null)
    {
        if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
        }
        
        foreach ($this->request['data']['Blog'] as $v) {
            $this->Blog->id = $v;
            if ($this->Blog->exists()) {
                $x = $this->Blog->save(array(
                    'Blog' => array(
                        'status' => "1"
                    )
                ));
            }
        }
        $this->Session->setFlash(__('Selected Blogs Activated Successfully.', true));
        $this->autoRender = false;
    }
    
    
    public function admin_deactivateall($id = null)
    {
        if (!$this->request->is('Ajax')) {
            throw new MethodNotAllowedException();
        }
        
        foreach ($this->request['data']['Blog'] as $v) {
            $this->Blog->id = $v;
            $x              = $this->Blog->save(array(
                'Blog' => array(
                    'status' => "0"
                )
            ));
        }
        $this->Session->setFlash(__('Selected Blogs were deactivated successfully.', true));
        $this->autoRender = false;
    }
    
    public function like($id = null)
    {
        $this->loadModel('Like');
        $userid    = $this->Auth->user('id');
        $blog_id   = $this->data['id'];
        $checkLike = $this->Like->query("SELECT * from likes where user_id='" . $userid . "' AND blog_id='" . $blog_id . "' ");
        if (empty($checkLike)) {
            $this->Like->create();
            $this->Like->set('blog_id', $blog_id);
            $this->Like->set('user_id', $userid);
            $this->Like->save();
        }
        $getCounter = $this->Like->find('count', array(
            'conditions' => array(
                'Like.blog_id' => (int) $blog_id
            )
        ));
        echo $getCounter;
        $this->autoRender = false;
    }
	
	public function friendlist()
	{ 
		Configure::write('debug',2);
		$this->loadModel('Like');
		$getBlogID = $this->data['id'];
		$getLike = $this->Like->find('all', array('conditions' => array('Like.blog_id'=>$getBlogID)));
		if(!empty($getLike)){
			?>
			<?php
			echo '<div class="smalHead">People Who Like This</div>';
			echo '<div class="folowing-box-popup"><ul>';
			foreach($getLike as $key => $allLike)
			{
					echo '<li>';
					if($allLike['user']['profile_image']!='')
					{
						echo '<a href="'.FULL_BASE_URL.$this->webroot.'users/profile/'.$allLike['user']['id'].'"><div class="likeUsersImage" ><img  src="'.FULL_BASE_URL.$this->webroot.'files'.DS.'profileimage'.'/'.$allLike['user']['profile_image'].'"></div></a>';
					}
					else
					{
						echo '<a href="'.$base_url.'users/profile/'.$allLike['user']['id'].'"><div class="likeUsersImage"><img src=" '.FULL_BASE_URL.$this->webroot.'/files/profileimage/user.png"></div></a>';
					}
					echo '<div class="likeUsers">'.ucfirst($allLike['user']['name']).'</div>';
					echo '</li>';
			}
			echo '</ul></div>';
		}
		$this->autoRender = false;
	
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
			/*$geocode                           = file_get_contents('http://maps.googleapis.com/maps/api/distancematrix/json?origins='.$lat1.'%20-'.$lon1.'&destinations='.$lat2.'%20-'.$lon2.'&mode=driving&units=imperial&sensor=false');
			$output                                = json_decode($geocode);
			debug($output);
			$miles                                      = str_replace(' mi','',$output->rows[0]->elements[0]->distance->text);
			return trim($miles);
			//$long                                   = $output->results[0]->geometry->location->lng;
			//$this->autoRender = false;*/
    }
    
    public function get_blog_type1($type)
    {
        $this->Session->write(array(
            'filter.blogType1' => $type
        ));
        $this->get_filter_result();
    }
    
    public function get_blog_type2($type)
    {
        $this->Session->write(array(
            'filter.blogType2' => $type
        ));
        $this->get_filter_result();
    }
    
    public function get_blog_type3($type)
    {
        $this->Session->write(array(
            'filter.blogType3' => $type
        ));
        $this->get_filter_result();
    }
    
    public function get_filter_result_from_category($catIDs)
    {
        $catiDS = ($catIDs != '' ? $catIDs : '');
        $this->Session->write(array(
            'filter.category' => $catiDS
        ));
        $this->get_filter_result();
    }
    
    public function get_filter_result_from_range($rangeIDs)
    {
        $t        = explode(',', $rangeIDs);
        $r        = max($t);
        $rangeiDS = ($r != 'null' ? $r : '');
        $this->Session->write(array(
            'filter.range' => $rangeiDS
        ));
        $this->get_filter_result();
    }
	
	public function get_filter_result_from_zip($inputId)
	{
		$t        = ($inputId!='zip code, city, state, country.' ? $inputId: '');
        $this->Session->write(array(
            'filter.zip' => $t
        ));
        $this->get_filter_result();
	}
    
    public function set_user_lat_long($lat, $long)
    {
        $this->Session->write(array(
           'filter.latitude' => $lat
        ));
        $this->Session->write(array(
            'filter.longitude' => $long
        ));
        $this->autoRender = false;
    }
    
    public function reset_session()
    {
        $this->Session->delete('filter.blogType1');
        $this->Session->delete('filter.blogType2');
        $this->Session->delete('filter.blogType3');
        $this->Session->delete('filter.category');
        $this->Session->delete('filter.range');
        $this->Session->delete('filter.zip');
        $this->redirect(array(
            'controller' => '/'
        ));
    }
    
    public function get_filter_result()
    {
        $lat1 = $this->Session->read('filter.latitude');
        $lon1 = $this->Session->read('filter.longitude');
        $blogType1   = ($this->Session->check('filter.blogType1') ? $this->Session->read('filter.blogType1') : 'b');
		$blogType2   = ($this->Session->check('filter.blogType2') ? $this->Session->read('filter.blogType2') : 'b');
		$blogType3   = ($this->Session->check('filter.blogType3') ? $this->Session->read('filter.blogType3') : 'b');
		$category_id = ($this->Session->check('filter.category') ? $this->Session->read('filter.category') : '0');
		$a           = ($blogType1 != ' ' ? "'Blog.blogtype_one' => " . "'" . $blogType1 . "'" : ' ');
		 if($this->Session->check('filter.blogType1') || $this->Session->check('filter.blogType2') || $this->Session->check('filter.blogType3') || $this->Session->check('filter.category')){
		 $conditions  = array(
                'OR' => array(
                    array(
                        'Blog.blogtype_one' => $blogType1
                    ),
                    array(
                        'Blog.blogtype_two' => $blogType2
                    ),
                    array(
                        'Blog.blogtype_three' => $blogType3
                    ),
                    array(
                        'Blogcategory.category_id IN (' . $category_id . ')'
                    )
                    
                ),
                'AND' => array(
                    'Blog.status' => (int) 1
                )
            );
			} else {
			$conditions  = array(                
                'AND' => array(
                    'Blog.status' => (int) 1
                )
            );
			}
            $join        = array(
                array(
                    'alias' => 'Blogcategory',
                    'table' => 'blogcategories',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Blogcategory.blog_id = Blog.id'
                    )
                )
            );			
		
        if (!$this->Session->check('filter.zip') && !$this->Session->check('filter.blogType1') && !$this->Session->check('filter.blogType2') && !$this->Session->check('filter.blogType3') && !$this->Session->check('filter.category')) {
		    $blogData = $this->Blog->find('all', array(
                'limit' => '500',
                'order' => array(
                    'Blog.id' => 'desc'
                ),
                'group' => 'Blog.id'
            ));
        } else if(!$this->Session->check('filter.zip') || @$this->Session->read('filter.zip') == ''){
          
            $blogData    = $this->Blog->find('all', array(
                'conditions' => $conditions,
                'joins' => $join,
                'order' => array(
                    'Blog.id' => 'desc'
                ),
                'group' => 'Blog.id'
            ));
            
        } else if($this->Session->check('filter.zip') && $this->Session->read('filter.zip') !=''){
	
			$zip = ($this->Session->check('filter.zip') ? $this->Session->read('filter.zip') : ' ');
			$prepAddr                          = str_replace(',', '+', $zip);
			$geocode                           = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
			$output                                = json_decode($geocode);
			$lat                                      = $output->results[0]->geometry->location->lat;
			$long                                   = $output->results[0]->geometry->location->lng;
           
            $blogD    = $this->Blog->find('all', array(
                'conditions' => $conditions,
                'joins' => $join,
                'order' => array(
                    'Blog.id' => 'desc'
                ),
                'group' => 'Blog.id'
            ));
			$blogData = array();
			$i = 0;
			foreach ($blogD as $key => $b) {
				$lat2                                       = $b['Blog']['latitude'];
				$lon2                                       = $b['Blog']['longitude'];
				if($lat2 != '' && $lon2!=''){
				$distance = round($this->distance($lat, $long, $lat2, $lon2, $unit = ''));
				} else {
				$distance = 0;
				}
				$distance_difference = (($this->Session->check('filter.range') && $this->Session->read('filter.range') !='') ? $this->Session->read('filter.range') : 100);
				 
				if($distance <= $distance_difference && $i <= 200){
					if($lat2 != '' && $lon2!=''){
						$blogD[$key]['Blog']['miles_difference'] = round($this->distance($lat1, $lon1, $lat2, $lon2, $unit = ''));
					} else {
							$blogD[$key]['Blog']['miles_difference'] = 0;
					}					
					$blogData[] = $blogD[$key];
					$i++;
				}
				
			}
		}
        foreach ($blogData as $key => $b) {
            $lat2                                       = $b['Blog']['latitude'];
            $lon2                                       = $b['Blog']['longitude'];
            if($lat2 != '' && $lon2!=''){
						$blogData[$key]['Blog']['miles_difference'] = round($this->distance($lat1, $lon1, $lat2, $lon2, $unit = ''));
				} else {
						$blogData[$key]['Blog']['miles_difference'] = 0;
				}
        }
        $type = (($this->Session->check('filter.zip') && $this->Session->read('filter.zip') !='') ? 'zip' : 'simple');
		$this->set('type',$type);
        $this->set('blogData', $blogData);
        $this->viewPath = 'Elements';
        $this->render('bulletin_record');
    }
	
	public function admin_view_blog($id = null)
	{
	         $this->loadModel("Blog");
			 $this->Blog->id = $id;
			 $info = $this->Blog->find("first",array("conditions" =>array("Blog.id" =>$id)));
			$this->set("info",$info);
	}
	
	public function comment($id=null)
	{
		$this->loadModel('Comment');
		$this->Comment->recursive = 1;
			$this->paginate = array(
				'limit' => 2,
				'order' => array('Comment.id' => 'DESC')
			);
			$blogComment = $this->paginate('Comment',array('Comment.blog_id'=>$id));
			$this->set("comment",$blogComment);
		//$this->Comment->id = $id;
		//$blogComment = $this->Comment->find('all',array('conditions'=>array('Comment.blog_id'=>$id)));
		//debug($blogComment);exit;
		//$this->set("comment",$blogComment);
	
		
	}
	
	public function comment_delete($id=null,$getID = null)
	{
		$this->loadModel('Comment');
		$this->Comment->id = $id;
        $this->Comment->query("DELETE from comments where id='".$id."' "); 
        $this->Comment->delete($id);
       $this->Session->setFlash('Comment remove successfully..', 'default', array ('class' => 'successfully'));	
		$this->redirect(array('controller'=>'blogs','action' => 'comment/'.$getID));
	}
	
	
	public function admin_comment($id=null)
	{
	//debug($id);exit;
		$this->loadModel('Comment');
		$this->Comment->recursive = 1;
			$this->paginate = array(
				'limit' => 2,
				'order' => array('Comment.id' => 'DESC')
			);
			$blogComment = $this->paginate('Comment',array('Comment.blog_id'=>$id));
			$this->set("comment",$blogComment);
	
	}
	
public function admin_commentdelete($id=null,$getID = null)	
{
//debug($id);exit;
		$this->loadModel('Comment');
		$this->Comment->id = $id;
        $this->Comment->query("DELETE from comments where id='".$id."' "); 
        $this->Comment->delete($id);
		//$this->Session->setFlash('Comment remove successfully..', 'default', array ('class' => 'successfully'));	
		 $this->Session->setFlash('your comment  has  remove successfully .');
		$this->redirect(array('controller'=>'blogs','action' => 'admin_comment/'.$getID));

}

public function repost($id = null)
{
//debug($this->request->data);exit;
		 $this->Blog->id = $id;
        if (!$this->Blog->exists()) {
            throw new NotFoundException(__('Invalid blog'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
		
			$image = $this->Blog->find('first', array(
                'fields' => array(
                    'image'
                ),
				'conditions'=>array('Blog.id'=>$id)
            ));
            $one = $this->request->data['Blog']['image'];
            if ($one['name'] != '') {
                $this->request->data['Blog']['image'] = $one['name'];
				$imageNAME = $image['Blog']['image'];
				$file = new File(WWW_ROOT . 'files/blogimages/'.$imageNAME, false, 0777);
				$file->delete();
            } else {
                $this->request->data['Blog']['image'] = $image['Blog']['image'];
            }
				$address                                  = $this->data['Blog']['location']; // Google HQ
				if($address != ''){
                $prepAddr                                 = str_replace(' ', '+', $address);
                $geocode                                  = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
                $output                                   = json_decode($geocode);
                $lat                                      = $output->results[0]->geometry->location->lat;
                $long                                     = $output->results[0]->geometry->location->lng;
				} else {
				$lat = '';
				$long = '';
				}
                $this->request->data['Blog']['latitude']  = $lat;
                $this->request->data['Blog']['longitude'] = $long;
				$userid = $this->Auth->user('id');
				$this->request->data['Blog']['user_id']=$userid;
				$this->Blog->create();
			if ($this->Blog->save($this->request->data)) 
			{
                if ($one['error'] == 0) {
                    $pth = 'files' . DS . 'blogimages' . DS . $id . $one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);
                    $this->Blog->saveField("image", $id . $one['name']);
					
                }
				$this->Blog->query("DELETE from blogcategories where blog_id='".$id."' ");
				$category_id = $this->data['Blog']['category_id'];
			//debug($category_id);exit;
                $this->loadModel('Blogcategory');
                    foreach ($category_id as $cat) {                        
                        $this->Blogcategory->create();
                        $this->Blogcategory->set('category_id',$cat);
                        $this->Blogcategory->set('blog_id',$id);
                        $this->Blogcategory->save();
                    }
				//$this->Session->setFlash('The blog has been Repost successfully');
				 $this->Session->setFlash('The blog has been Repost successfully..', 'default', array ('class' => 'successfully'));	
                $this->redirect(array(
                    'controller' => 'blogs',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash('The blog could not be updated. Please, try again.');
				$this->redirect(array(
                    'controller' => 'blogs',
                    'action' => 'edit',$id
                ));
            }
        } 
		
        $this->loadModel('Categorie');
        $cat         = $this->Categorie->find('list', array(
            'fields' => array(
                'Categorie.id',
                'Categorie.title'
            )
        ));
        $this->loadModel('Blogcategory');
		$this->data = $this->Blog->findByid($id);
		$bIDs = array();
		foreach($this->data['BlogCategory']  as $bc){
		$bIDs[] = $bc['category_id'];
		}
        $this->set('bIDs', $bIDs);
        $this->set('catlist', $cat);
        $this->set('action_type', 'Edit');
        $this->viewPath = 'Blogs';
        $this->loadModel('Mile');
        $miles = $this->Mile->find('list', array(
            'fields' => array(
                'Mile.id',
                'Mile.miles'
            )
        ));
        $this->set('mile', $miles);
        $this->set('action_type', 'Edit');
        $this->viewPath = 'Blogs';  

}

public function admin_repost($id=null)
{
	$this->Blog->id = $id;
     if (!$this->Blog->exists()) {
    throw new NotFoundException(__('Invalid blog'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
		
			$image = $this->Blog->find('first', array(
                'fields' => array(
                    'image'
                ),
				'conditions'=>array('Blog.id'=>$id)
            ));
            $one = $this->request->data['Blog']['image'];
            if ($one['name'] != '') {
                $this->request->data['Blog']['image'] = $one['name'];
				$imageNAME = $image['Blog']['image'];
				$file = new File(WWW_ROOT . 'files/blogimages/'.$imageNAME, false, 0777);
				$file->delete();
            } else {
                $this->request->data['Blog']['image'] = $image['Blog']['image'];
            }
				$address                                  = $this->data['Blog']['location']; // Google HQ
				if($address != ''){
                $prepAddr                                 = str_replace(' ', '+', $address);
                $geocode                                  = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
                $output                                   = json_decode($geocode);
                $lat                                      = $output->results[0]->geometry->location->lat;
                $long                                     = $output->results[0]->geometry->location->lng;
				} else {
				$lat = '';
				$long = '';
				}
                $this->request->data['Blog']['latitude']  = $lat;
                $this->request->data['Blog']['longitude'] = $long;
			$this->Blog->create();	
			if ($this->Blog->save($this->request->data)) 
			{
                if ($one['error'] == 0) {
                    $pth = 'files' . DS . 'blogimages' . DS . $id . $one['name'];
                    move_uploaded_file($one['tmp_name'], $pth);
                    $this->Blog->saveField("image", $id . $one['name']);
                }
				$this->Blog->query("DELETE from blogcategories where blog_id='".$id."' ");
				$category_id = $this->data['Blog']['category_id'];
                    $this->loadModel('Blogcategory');
                    foreach ($category_id as $cat) 
					{                        
                        $this->Blogcategory->create();
                        $this->Blogcategory->set('category_id',$cat);
                        $this->Blogcategory->set('blog_id',$id);
                        $this->Blogcategory->save();
                    }
				$this->Session->setFlash('The blog has been updated successfully');
                $this->redirect(array(
                    'controller' => 'blogs',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash('The blog could not be updated. Please, try again.');
				$this->redirect(array(
                    'controller' => 'blogs',
                    'action' => 'edit',$id
                ));
            }
        } 
		
        $this->loadModel('Categorie');
        $cat         = $this->Categorie->find('list', array(
            'fields' => array(
                'Categorie.id',
                'Categorie.title'
            )
        ));
        $this->loadModel('Blogcategory');
		$this->data = $this->Blog->findByid($id);
		$bIDs = array();
		foreach($this->data['BlogCategory']  as $bc){
				$bIDs[] = $bc['category_id'];
		}
		//debug($this->data);
        $this->set('bIDs', $bIDs);
        $this->set('catlist', $cat);
        $this->set('action_type', 'Edit');
        $this->viewPath = 'Blogs';
        $this->loadModel('Mile');
        $miles = $this->Mile->find('list', array(
            'fields' => array(
                'Mile.id',
                'Mile.miles'
            )
        ));
        $this->set('mile', $miles);
        $this->set('action_type', 'Edit');
        $this->viewPath = 'Blogs';  
		
    }    
}
?>