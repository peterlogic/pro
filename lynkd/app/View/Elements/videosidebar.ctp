<aside class="mid-left">
    <section class="leftCol">
      <div class="profileThumbCol">
	  	<?php  if (!empty($info['User']['profile_image'])) { ?>
      <div class="profileThumb"><img src="<?php echo FULL_BASE_URL.$this->webroot."files".DS."profileimage"."/".$info['User']['profile_image'];?>" alt=""></div>
	  <?php }  else { ?>
		<div class="profileThumb"><img alt="" src="<?php  echo $base_url;?>/files/profileimage/user.png"></div>
	  <?php } ?>
      <div class="thumbEdit">
        <ul>
          <!-------------------------- change image popup start---------------------------------->
		  <?php if($checkUserType == 'own'){ ?>
          <li><a href = "javascript:void(0)" onclick = "document.getElementById('lightone').style.display='block';document.getElementById('fade').style.display='block'" >Change</a></li>
		 
          <div id="lightone" class="white_content">
            <div class="change-image-popup"> <a class="change-image-close" href = "javascript:void(0)" onclick = "document.getElementById('lightone').style.display='none';document.getElementById('fade').style.display='none'">Close</a>
              <div data-provides="fileupload" class="fileupload fileupload-new">
			<?php  if (!empty($info['User']['profile_image'])) { ?>
                <div  class="fileupload-preview thumbnail">
                  <div class="profileThumb"><img src="<?php echo FULL_BASE_URL.$this->webroot."files".DS."profileimage"."/".$info['User']['profile_image'];?>" alt=""></div>
                </div><?php } else {?>
				
					<div  class="fileupload-preview thumbnail">
                  <div class="profileThumb"><img alt=""   src="<?php  echo $base_url;?>/files/profileimage/user.png"></div>
                </div>
				
		
			<?php	}?>
                <?php echo $this->Form->create('User',array('url'=>array('controller'=>'Users','action'=>'profile_image'),'type' => 'file')); ?>
				<!-- <?php $edit_id = $info['User']['id']; ?> -->
                <div>
				<span class="btn btn-file"> <span class="fileupload-new"></span> <span class="fileupload-exists"></span>
                  <label for="PostJobLogo"></label>
                 <input type="file" id="PostJobLogo" name="data[User][profile_image]">
                  </span>
                 <!-- <div class="remove"><a data-dismiss="fileupload" class="btn fileupload-exists submitBtn" href="#">Remove</a></div>-->
                  <div class="update">
				    <?php echo $this->Form->input('id', array('type' => 'hidden', 'value'=>$edit_id )); ?>
                    <input type="submit" name="submit" class="submitBtn" value="update" />
                  </div>
                </div>
                <?php echo $this->Form->end(); ?> 
				</div>
            </div>
          </div>
		   <?php  } ?>

          <!-------------------------- change image popup close---------------------------------->
        </ul>
        <div class="clear"></div>
       </div>
	   
      <div class="profileThumbInfo">
        <div class="profileName"><?php echo $info['User']['name'].' '.$info['User']['last_name'];?></div>
      </div>	 

      <div class="Tagline"><?php echo $info['User']['account_type'];?></div>
	  
      <ul class="leftListing" id="usual1">
        <li class="selected" ><a href="#inbox">Profile</a></li>
		<?php  if($checkUserType == 'own'){ ?>
        <li class=""  ><a id="ffcount"href="#send" onclick="return get_friends();">Friends (<?php  echo count($friend_lists);?>)</a><span id="fcount"></span></li>
      
		<li class="" ><a href="#change">Change Password</a></li>
		<li class="" ><a href="#upload">Upload video</a></li>
		<?php } ?>
		
      </ul>
	  <?php if(isset($checkUserType) && $checkUserType != 'own' && $this->Session->check('Auth.User') && $isfriend=='no' && $isalreadyfriend=='no'){ ?>
<div class="add-friend" id="friend"><?php  echo $this->Html->link('Send Friend Request','javascript:void(0);',array('onclick'=>'return send_friend_request(\''.$userid.'\');','id'=>'fr')); ?></div>
<?php } elseif(isset($checkUserType) && $checkUserType != 'own' && $this->Session->check('Auth.User') && $isfriend=='yes' && $isalreadyfriend=='no' ){ ?>
<div class="add-friend" id="friend">Friend request sent</div>
<?php } elseif(isset($checkUserType) && $checkUserType != 'own' && $this->Session->check('Auth.User') && $isfriend=='yes' && $isalreadyfriend=='yes' ){ ?>
<div class="add-friend" id="friend">Already added in your friend list</div>
<?php } ?>
    </section>
  </aside>