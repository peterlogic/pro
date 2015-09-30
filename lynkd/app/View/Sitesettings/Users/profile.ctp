<?php  echo $this->Html->script('bootstrap-fileupload.min.js'); ?>
<?php echo $this->Html->script('front/jquery_003'); ?>
<?php echo $this->Html->script(array('jqueryValidate.js','jquery.tooltipster.min.js')); ?>
<?php echo $this->Html->css(array('tooltipster.css'));?>
<section class="wrapper">
<section class="mid-cnt">
<?php  echo $this->Element('friend_search'); ?>
<?php echo $this->Session->flash(); ?>
  <aside class="mid-left">
    <section class="leftCol">
      <div class="profileThumbCol">
	  	<?php  if (!empty($info['User']['profile_image'])) { ?>
      <div class="profileThumb"><img src="<?php echo FULL_BASE_URL.$this->webroot."files".DS."profileimage"."/".$info['User']['profile_image'];?>" alt="profile_pic"></div>
	  <?php }  else { ?>
		<div class="profileThumb"><img alt="profile_pic" src="<?php  echo $base_url;?>/files/profileimage/user.png"></div>
	  <?php } ?>
      <div class="thumbEdit">
        <ul>
          <!-------------------------- change image popup start---------------------------------->
		  <?php if($checkUserType == 'own'){ ?>
          <li><a href = "javascript:void(0)" onclick = "document.getElementById('lightone').style.display='block';document.getElementById('fade').style.display='block'"  title="Click here to change your profile picture" class="tooltip">Change</a></li>
          <div id="lightone" class="white_content">
            <div class="change-image-popup"> <a class="change-image-close" href = "javascript:void(0)" onclick = "document.getElementById('lightone').style.display='none';document.getElementById('fade').style.display='none'">Close</a>
           <div data-provides="fileupload" class="fileupload fileupload-new">
			<?php  if (!empty($info['User']['profile_image'])) { ?>
                <div style="width: 200px; height: 150px;" class="fileupload-preview thumbnail">
                  <div class="profileThumb"><img src="<?php echo FULL_BASE_URL.$this->webroot."files".DS."profileimage"."/".$info['User']['profile_image'];?>" alt=""></div>
                </div><?php } else {?>
					<div style="width: 200px; height: 150px;" class="fileupload-preview thumbnail">
                  <div class="profileThumb"><img alt="profile_pic"   src="<?php  echo $base_url;?>/files/profileimage/user.png"></div>
                </div>
			<?php	}?>
                <?php echo $this->Form->create('User',array('url'=>array('controller'=>'Users','action'=>'profile_image'),'type' => 'file')); ?>
				<!-- <?php $edit_id = $info['User']['id']; ?> -->
                <div> <span class="btn btn-file"> <span class="fileupload-new"></span> <span class="fileupload-exists"></span>
                  <label for="PostJobLogo"></label>
                 <input type="file" id="PostJobLogo" name="data[User][profile_image]">
                  </span>
                 <!-- <div class="remove"><a data-dismiss="fileupload" class="btn fileupload-exists submitBtn" href="#">Remove</a></div>-->
                  <div class="update">
				    <?php echo $this->Form->input('id', array('type' => 'hidden', 'value'=>$edit_id )); ?>
                    <input type="submit" name="submit" class="submitBtn" value="update" />
                  </div>
                </div>
                <?php echo $this->Form->end(); ?> </div>
            </div>
          </div>
		   <?php  } ?>
	<!-- 	<li><a href="<?php //echo $this->Html->url(array('controller'=>'/','action'=>'javascript:void(0);')); ?>">Remove</a></li>-->
          <!--<li><a href="#">Remove</a></li> -->
          <!-------------------------- change image popup close---------------------------------->
        </ul>
        <div class="clear"></div>
       </div>
	   
      <div class="profileThumbInfo">
        <div class="profileName"><?php echo $info['User']['name'].' '.$info['User']['last_name'];?></div>
      </div>
	 
      <!-- <div class="Tagline"><?php //echo ($info['User']['skills'] !='' ? $info['User']['skills']: 'N/A').'/'.($info['User']['interests']!=''?$info['User']['interests']:'N/A');?></div> -->
      <div class="Tagline"><?php echo $info['User']['account_type'];?></div>
	  
      <ul class="leftListing" id="usual1">
        <li class="selected" ><a href="#inbox">Profile</a></li>
		<?php  if($checkUserType == 'own'){ ?>
        <li class=""  ><a id="ffcount"href="#send" onclick="return get_friends();">Friends (<?php  echo count($friend_lists);?>)</a><span id="fcount"></span></li>
        <!-- <li class="" ><a href="#deleted">Option Three <span>5</span></a></li>-->
		<li class="" ><a href="#change">Change Password</a></li>
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
  <!--  left sidebar end -->
  
  <section class="mid-right">
      <div style="display: block;" id="inbox"><div class="rightCol"> 
      <!-- --------------------------------------edit profile popup start-------------------------------------------------------->
      <div class="blueHeading">Personal Information 
			<?php  if($checkUserType == 'own'){ ?>
				<a href="javascript:void(0)"   class="editIcon"  onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'" ></a> 
			<?php } ?>	
	  </div>
	  <?php  if($checkUserType == 'own'){ ?>
      <div id="light" class="white_content2">
        <div class="editaccountInfo">
        <a class="change-image-close" href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">Close</a>
          <div class="smalHead">Personal information </div>
          <?php $edit_id = $info['User']['id']; ?>
          <?php echo $this->Form->create('User',array('method'=>'Post', 'id'=>'loginform')); ?>
          <div class="pop-outer lef">
            <p>First Name</p>
			<?php  echo $this->Form->input('name',array('label'=>false,'type'=>'text','value'=>$info['User']['name'],'class'=>'edit-input','div'=>false));?>
          
          </div>
		  <div class="pop-outer rig">
            <p>Last Name</p>
			<?php  echo $this->Form->input('last_name',array('label'=>false,'type'=>'text','value'=>$info['User']['last_name'],'class'=>'edit-input','div'=>false));?>
            
          </div>
		   <div class="pop-outer lef">
            <p>Skills</p>
			<?php  echo $this->Form->input('skills',array('label'=>false,'type'=>'text','value'=>$info['User']['skills'],'class'=>'edit-input','div'=>false));?>
          </div>
          <div class="pop-outer rig">
            <p>Profession</p>
			<?php  echo $this->Form->input('profession',array('label'=>false,'type'=>'text','value'=>$info['User']['profession'],'class'=>'edit-input','div'=>false));?>
          
          </div>
         <div class="pop-outer lef">
            <p>Gender</p>
            <div class="gender">
              <select name="data[User][sex]">
					<option value="male"<?php if($info['User']['sex']=='male'){echo 'selected';}?>>Male</option>
					<option value="female"<?php if($info['User']['sex']=='female'){echo 'selected';}?>>female</option>
              </select>
            </div>
</div>
          <div class="pop-outer rig">
            <p>Interests</p>
			<?php  echo $this->Form->input('interests',array('label'=>false,'type'=>'text','value'=>$info['User']['interests'],'class'=>'edit-input','div'=>false));?>
          </div>
           <div class="pop-outer left phone">
            <p>phone</p>
          
				<?php  echo $this->Form->input('phone',array('label'=>false,'type'=>'text','value'=>$info['User']['phone'],'class'=>'edit-input','div'=>false));?>
          </div>
          <div class="pop-outer rig">
            <p>D.O.B.</p>
            
			<?php  echo $this->Form->input('dob',array('label'=>false,'type'=>'text','value'=>$info['User']['dob'],'class'=>'edit-input','div'=>false));?>
          </div>
         <div class="pop-outer lef ">
				<p>Address</p>
				<?php  echo $this->Form->input('address',array('label'=>false,'type'=>'textarea','value'=>$info['User']['address'],'class'=>'edit-input','div'=>false,'rows'=>'3','cols'=>'3'));?>	
        </div>
          
            <div class="pop-outer rig ">
                      <p>Summary</p>
                     
       <?php  echo $this->Form->input('summary',array('label'=>false,'type'=>'textarea','value'=>$info['User']['summary'],'class'=>'edit-input','div'=>false,'rows'=>'3','cols'=>'3' ));?>	
                   </div>
            
          
          <?php echo $this->Form->input('id', array('type' => 'hidden', 'value'=>$edit_id )); ?>
         <div class="submit"> <input type="submit" name="submit" class="submitBtn" value="update" /></div>
          <?php echo $this->Session->flash();?> <?php echo $this->Form->end(); ?> </div>
		

      </div>
		<?php } ?>  
      <!-- --------------------------------------edit profile popup close-------------------------------------------------------->
      <div id="fade" class="black_overlay"></div>
      <div id="fade" class="black_overlay"></div>
      <div class="messageInfo">
        <div class="fullWidth">
          <label>Name</label>
          <div class="labelInfo">
		  	<?php  if (!empty($info['User']['profile_image'])) { ?>
            <div class="profileUser"><img src="<?php echo FULL_BASE_URL.$this->webroot."files".DS."profileimage"."/".$info['User']['profile_image'];?>" alt="profile_pic"></div><?php }  else { ?>
			
			  <div class="profileUser"><img alt="profile_pic" src="<?php  echo $base_url;?>/files/profileimage/user.png"></div>
			
			<?php } ?>
			
            <div class="userName"><?php echo $info['User']['name'].' '.$info['User']['last_name'];  ?></div>
          </div>
        </div>
        <div class="fullWidth">
          <label>Profession</label>
          <div class="labelInfo">
           
            <div class="userName"><?php echo ($info['User']['profession']!='' ?$info['User']['profession']: 'Not Mentioned');?></div>
          </div>
        </div>
        <div class="fullWidth">
          <label>Skills</label>
          <div class="labelInfo"><?php echo  ($info['User']['skills']!=''?$info['User']['skills']:'Not Mentioned'); ?></div>
        </div>
        <div class="fullWidth">
          <label>Interests</label>
          <div class="labelInfo"><?php echo ($info['User']['interests']!='' ? $info['User']['interests']: 'Not Mentioned'); ?></div>
        </div>
        <div class="fullWidth">
          <label>Gender</label>
          <div class="labelInfo"><?php echo ($info['User']['sex']!='' ? $info['User']['sex'] : 'Not Mentioned');?></div>
        </div>
        <div class="fullWidth">
          <label>D.O.B.</label>
          <div class="labelInfo"> <?php echo ($info['User']['dob']!='' ? $info['User']['dob'] : 'Not Mentioned'); ?></div>
        </div>
        
        <div class="fullWidth">
          <label>Contact number</label>
          <div class="labelInfo"><?php echo ($info['User']['phone']!='0' ? $info['User']['phone'] : 'Not Mentioned'); ?></div>
        </div>
        
		<div class="fullWidth">
          <label>Country</label>
          <div class="labelInfo"><?php echo ($info['Country']['country']!='' ? $info['Country']['country'] : 'Not Mentioned'); ?></div>
        </div>
		
		<div class="fullWidth">
          <label>State</label>
          <div class="labelInfo"><?php echo ($info['State']['region']!='' ? $info['State']['region'] : 'Not Mentioned'); ?></div>
        </div>
		
		<div class="fullWidth">
          <label>City</label>
          <div class="labelInfo"><?php echo ($info['City']['city']!='' ? $info['City']['city'] : 'Not Mentioned'); ?></div>
        </div>
		
		 <div class="fullWidth">
          <label>Summary</label>
          <div class="labelInfo"><?php echo ($info['User']['summary'] !='' ? $info['User']['summary'] : 'Not Mentioned'); ?></div>
        </div>
		<div class="fullWidth">
          <label>Address</label>
          <div class="labelInfo"><?php echo ($info['User']['address']!='' ? $info['User']['address'] : 'Not Mentioned'); ?></div>
        </div>
		
      </div>
    </div></div>
<!-----------------   second following tab start------------------------->
	    <div style="display: none;" id="send">
			<div class="rightCol" > 
				<div class="blueHeading">Friend</div>
					<div class="messageInfo">
						
							<table id="viewinbox" class="table">
									<tbody>
											<tr>												
												<td colspan="4" align="center">Please wait Loading...</td>
											</tr>											
									</tbody>
							</table> 										
					</div>
			</div>
		</div>
<!-----------------   second following tab close------------------------->
<!-----------------   third following tab start------------------------->
	   <div style="display: none;" id="deleted"><div class="rightCol" > 
	     <div class="blueHeading">Option three 5 <a href="javascript:void(0)"   class="editIcon"  onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'" ></a>

		 </div>
	
	</div></div>
<!-----------------   third following tab close------------------------->	
<!-----------------   change password tab start------------------------->
	   <div style="display: none;" id="change"><div class="rightCol" > 
	     <div class="blueHeading">Change Password<a href="javascript:void(0)"   class="editIcon"  onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'" ></a> 
		 
        </div>
		
		
<section class="login-outer">

        <div class="loginInner">
          <div class="clear"></div>
          <div class="accountInfo addPost">
		  <?php echo $this->Form->create('User',array('controllers'=>'Users','action'=>'changepass','id'=>'changepass','name'=>'changepass')); ?>
            <div class="fullWidth">
            <label>Old Password:<span class="red">*</span></label>
              <!-- <input type="text" value="" class="titleInput"> -->
			   <?php echo $this->Form->input('opass', array('label'=>"",'type'=>'text','Placeholder'=>'Old Password...','type'=>'password','class'=>'titleInput'));?>
            </div>
       
              
             <div class="fullWidth">
              <label>New Password:<span class="red">*</span></label>
              <!-- <input type="text" value="" class="titleInput"> -->
			  <?php echo $this->Form->input('password', array('label'=>"",'Placeholder'=>'New Password...','type'=>'password','id'=>'password','class'=>'titleInput','minlength'=>'3','maxlength'=>'50'));?>
            </div>
              
              <div class="fullWidth">
              <label>Confirm Password:<span class="red">*</span></label>
              <!-- <input type="text" value="" class="titleInput"> -->
			  <?php echo $this->Form->input('cpass', array('label'=>"",'Placeholder'=>'Confirm Password...','type'=>'password','class'=>'titleInput','minlength'=>'3','maxlength'=>'50'));?>
            </div>
			
			<!-- <button type="submit" name="Save" id="update" class="submitBtn" >Save</button>-->
           <input type="submit" value="Update" class="submitBtn" name="Update">
		     <?php echo $this->Form->end(); ?> 
          </div>
        </div>
      </section>
	  
		
		 </div>
	</div>
	</div>
<!-----------------   change password tab close------------------------->

</section>

<script type="text/javascript">
function get_friends(){
	var user_id = '<?php echo $this->Session->read('Auth.User.id'); ?>';
	$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'get_friends')); ?>/'+user_id,
			success:function(result){
						$("#viewinbox").html(result);
					}
		});
		return false;
}


function get_friend_notification(){
		var user_id = '<?php echo $this->Session->read('Auth.User.id'); ?>';
		//alert(user_id);
		$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'get_friend_notifications')); ?>/'+user_id,
			success:function(result){
						//alert(result);
						if(result != 0){
								$("#fcount").css('display','block').html(result);
						} else {
								$("#fcount").css('display','none');
						}
					}
		});
		return false;
}

function get_friends_count(){
		var user_id = '<?php echo $this->Session->read('Auth.User.id'); ?>';
		//alert(user_id);
		$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'get_friend_count')); ?>/'+user_id,
			success:function(result){
						//alert(result);
						$("#ffcount").text(result);						
					}
		});
		return false;
}
$(document).ready(function(){
get_friend_notification();
setInterval(function () { get_friend_notification(); get_friends_count(); }, 5000);
});

function send_friend_request(userid){	
	$.ajax({
			type:'post',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'send_friend_request')); ?>',
			data:{'id':userid},
			success:function(result){
					if(result == 'SUCCESS'){
						$("#friend").html('Friend request sent');
					}
			}
	});
	return false;
}

$(document).ready(function(){
$("#usual1").idTabs();
$("#changepass").validate({
errorClass: "authError",

	  rules:
	   {
      		"data[User][opass]":{
												required:true,
												remote:'getPasswordStatus'
												
													},
													
		"data[User][password]":{
												required:true,
												 minlength: 5
									 },		

		"data[User][cpass]":{
													required: true,
													minlength: 5,
													equalTo: "#password"
									 }								
            },
			
			
  messages:

	    {
			"data[User][opass]": {
												required: "This field is required",
												remote: "The old password is not correct"
											
													},
													
			"data[User][password]": {
											required: "This field is required",
											minlength: "password contain atleast 5 character"
											
									},

														
		"data[User][cpass]": {
											   required: "This field is required",
											   minlength: "password contain atleast 5 character",
											   equalTo: " Passwords do not match"
											
									}
	    }			
});    	
$('.tooltip').tooltipster({
			contentAsHTML: true,
				position: 'bottom',				 
		});
});
	

</script>	
<script type="text/javascript">

function accept_request(fid){
	$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'accept_request')); ?>/'+fid,
			success:function(result){
						$("#"+fid+"b").html(result);
					}
		});
	return false;
}


function reject_request(fid){
	$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'reject_request')); ?>/'+fid,
			success:function(result){
						$("#"+fid+"a").remove();
					}
		});
	return false;
}

function unfriend_user(fid){
	$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'reject_request')); ?>/'+fid,
			success:function(result){
						$("#"+fid+"a").remove();
					}
		});
	return false;
}
</script>		
				
	
  <?php echo $this->Element('friend_section'); ?>
</section>
</section>