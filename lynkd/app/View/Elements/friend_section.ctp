<div class="followingColOuter">
    <div class="footer-heading smallheading">Friends</div>
    <div class="folowing-box followingCol">
        
      <ul>
		<?php if(!empty($friend_lists)){ 
			foreach($friend_lists as $fl){?>
				 <?php if($fl['Friend']['from_user_id'] == $this->Session->read('Auth.User.id')){  ?>
						<li><?php  echo $this->Html->link($this->Html->image('/files/profileimage/'.($fl['User']['profile_image']!=''?$fl['User']['profile_image']:'user.png'),array('height'=>'72','width'=>'72','alt'=>"profile_pic")),array('controller'=>'users','action'=>'profile',$fl['User']['id']),array('escape'=>false) );?></li>
				 <?php  } else { ?>
						<li><?php  echo $this->Html->link($this->Html->image('/files/profileimage/'.($fl['FromUser']['profile_image']!=''?$fl['FromUser']['profile_image']:'user.png'),array('height'=>'72','width'=>'72','alt'=>"profile_pic")),array('controller'=>'users','action'=>'profile',$fl['FromUser']['id']),array('escape'=>false) );?></li>
				 <?php } ?>
		<?php } }  else { ?>
		<li style="color:#777170;">No friend added so far</li>
		<?php } ?>
        
      </ul>
    </div>
  </div>
  