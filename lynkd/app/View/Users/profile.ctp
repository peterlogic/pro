<?php  echo $this->Html->script('bootstrap-fileupload.min.js'); ?>
<?php echo $this->Html->script('front/jquery_003'); ?>
<?php echo $this->Html->script(array('jqueryValidate.js')); ?>

<section class="wrapper">
<section class="mid-cnt">

<?php  echo $this->Element('friend_search'); ?>
<?php echo $this->Session->flash(); ?>
	<div class="successfully" id="flashMessage" style="display:none;"></div>
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
            <p>First Name/Buisness Name</p>
			
			<?php echo $this->Form->input('name',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'name','value'=>$info['User']['name'],'class'=>'edit-input')); ?>
          </div>
		  <div class="pop-outer rig">
            <p>Last Name</p>
        
			<?php echo $this->Form->input('last_name',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Last Name','value'=>$info['User']['last_name'],'class'=>'edit-input')); ?>
          </div>
          
          <div class="pop-outer lef">
            <p>Skills</p>
			<?php echo $this->Form->input('skills',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Skills','value'=>$info['User']['skills'],'class'=>'edit-input')); ?>
           
          </div>
		  <div class="pop-outer rig">
            <p>Profession</p>
			<?php echo $this->Form->input('profession',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Profession','value'=>$info['User']['profession'],'class'=>'edit-input')); ?>
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
			<?php echo $this->Form->input('interests',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Interests','value'=>$info['User']['interests'],'class'=>'edit-input')); ?>           
          </div>
          
          <div class="pop-outer left phone">
            <p>phone</p>
            
			<?php echo $this->Form->input('phone',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Phone','value'=>($info['User']['phone'] ==0 ?' ' :$info['User']['phone']),'class'=>'edit-input','size'=>'12')); ?> 
          </div>
		  <div class="pop-outer rig">
            <p>D.O.B.</p>
			<?php echo $this->Form->input('dob',array('type'=>'text','label'=>false,'div'=>false,'placeholder'=>'DOB','value'=>$info['User']['dob'],'class'=>'edit-input')); ?>        
          </div>
          
			<div class="pop-outer lef ">
				<p>Address</p>
				<textarea name="data[User][address]"><?php echo $info['User']['address'];?></textarea>

			</div>
            <div class="pop-outer rig ">
                      <p>Summary</p>
                     <textarea  name="data[User][summary]"><?php echo $info['User']['summary'];?></textarea>
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
            <div class="profileUser"><img src="<?php echo FULL_BASE_URL.$this->webroot."files".DS."profileimage"."/".$info['User']['profile_image'];?>" alt=""></div><?php }  else { ?>
			
			  <div class="profileUser"><img alt="" src="<?php  echo $base_url;?>/files/profileimage/user.png"></div>
			
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
          <div class="labelInfo"><?php echo ($info['User']['interests']!='' ? $info['User']['interests']: 'Not Mnetioned'); ?></div>
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
			   <?php echo $this->Form->input('opass', array('label'=>"",'type'=>'text','Placeholder'=>'Old Password...','type'=>'password','class'=>'titleInput'));?>
            </div>
       
              
             <div class="fullWidth">
              <label>New Password:<span class="red">*</span></label>
			  <?php echo $this->Form->input('password', array('label'=>"",'Placeholder'=>'New Password...','type'=>'password','id'=>'password','class'=>'titleInput','minlength'=>'3','maxlength'=>'50'));?>
            </div>
              
              <div class="fullWidth">
              <label>Confirm Password:<span class="red">*</span></label>
 			  <?php echo $this->Form->input('cpass', array('label'=>"",'Placeholder'=>'Confirm Password...','type'=>'password','class'=>'titleInput','minlength'=>'3','maxlength'=>'50'));?>
            </div>
			<input type="submit" value="Update" class="submitBtn" name="Update">
		     <?php echo $this->Form->end(); ?> 
          </div>
        </div>
      </section>
	  
		
		 </div>
	</div>
	
<!-----------------   change password tab close------------------------->

<!-------------------------- ---    video upload tab start ----------------------------------------------->
		
<div style="display: none;" id="upload"><div class="rightCol" > 
 <div class="blueHeading">upload video	 
</div>
<section class="login-outer">

        <div class="loginInner">
         <div class="clear"></div>
          <div class="accountInfo addPost">

		  
		<form id="upload_form" enctype="multipart/form-data" method="post"> 
		<?php //echo $this->Form->create('User',array('url'=>array('controller'=>'Users','action'=>'upload_video','id'=>'upload_form'),'type' => 'file')); ?>
        <input type="file" name="file1" id="file1">
        <br>
        <input type="button" value="Upload File" onclick="uploadFile()"  id="upload_button" >
        <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
        <h3 id="status"></h3>
        <p id="loaded_n_total" style="display:none;"></p>
		 <?php //echo $this->Form->end(); ?> 
	
            <p>  <input type="checkbox" id="terms_check" name="policy" value=""/>
              I agree to the Lynkd <?php echo $this->Html->link('User Agreement',array('controller'=>'staticpages','action'=>'view',6), array('target' => '_blank')); ?> and <?php echo $this->Html->link('Privacy policy',array('controller'=>'staticpages','action'=>'view',3), array('target' => '_blank')); ?>.</p>
			
		</form> 
		
		 
		
		
		
		
		
	<?php  if(!empty($info['Video'])){ ?>
	<table id="viewinbox" class="table">
				<tbody>
						<tr>
										<th align="center">S.No</th>
										<th align="center">Video title</th>
										<th align="center">Action</th>
						</tr>
								
									<?php $sno=1;?>
									<?php foreach($info['Video'] as $value) {?>
												<tr>												
													<td align="center"><?php echo $sno; ?> </td>  
													<td align="center"><?php echo ucfirst($value['video']); ?></td>		
													<td class="center" align="center">
             <form></form>
          
			 
			 <?php echo $this->Html->link($this->Html->image('../images/icons/admins/view.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('action' => 'video', $value['id']),array('class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Video','escape'=>false)); ?>
			 
			 
			 <?php echo $this->Html->link($this->Html->image('../images/icons/admins/repost.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('action' => 'repost_video', $value['id']),array('class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Repost_video','escape'=>false)); ?>
			 
			 
			 <?php echo $this->Form->postLink($this->Html->image('../images/icons/admins/delete.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('controller'=>'Users','action'=>'delete_video',$value['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Delete'),__('Are you sure you want to delete #%s?'));?>
			 
			 
			 
			 
			 

					</td>												
													
																	
					</tr>	
			<?php $sno++ ?>
		<?php } } else { ?>
		
				<tr>												
					<td colspan="4" align="center">No video found</td>
				</tr>											
		<?php } ?>								
	</tbody>
	</table> 
	
	
<!-- <form id="upload_form" enctype="multipart/form-data" method="post"> -->
       
	
          </div>
        </div>
      </section>
</div>
</div>
	
<!-------------------------- ---    video upload tab close ----------------------------------------------->



	
	
	</div>


</section>

<script type="text/javascript">
function get_friends(){
	var user_id = '<?php echo $this->Session->read('Auth.User.id'); ?>';
	$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'get_friends')); ?>/'+user_id,
			success:function(result){
						//alert(result);
						$("#viewinbox").html(result);
					}
		});
		return false;
}


function get_friend_notification(){
		var user_id = '<?php echo $this->Session->read('Auth.User.id'); ?>';
		$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'get_friend_notifications')); ?>/'+user_id,
			success:function(result){
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
		$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'users','action'=>'get_friend_count')); ?>/'+user_id,
			success:function(result){					
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




$('input[type=file]').change(function(){
 var file = this.files[0];
$.ajax({
									/* beforeSend: function(){
										$('.overlayIcon').show();
									}, */
									type:'POST',
									url:'<?php echo $this->Html->url(array('controller'=>'Users','action' => 'browse_video')); ?>',
									success:function(data)
									{
										if(data=='You cannot upload more than 3 video')
										{
										alert(data);
										$("#file1").val("");
										//location.reload();
										$("#upload_button").hide();
										$("#loaded_n_total").hide();
										
										}			
									}
						});			
    var file = this.files[0];
    name = file.name;
    size = file.size;
    type = file.type;
	//alert(size);
	fileSize = size / 1048576; //size in mb 
	//alert("Uploaded File Size is " + fileSize + "MB");
	
	if(type!='video/mp4')
	{
		alert("The file extension is not valid");
		$("#file1").val("");
		//location.reload();
	}
	 if(fileSize >80)
	{
		alert("video size must be smaller than 200mb");
		$("#file1").val("");
		//location.reload();
		//$("#file1").val("");
	} 

});

//$(".successfully").delay(4000).hide();

 setInterval(function () {
        $(".successfully").hide();
    }, 10 * 1000);

});
	
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

////////////////////////////////upload video js start////////////////////////////////
	
        /* Script written by Adam Khoury @ DevelopPHP.com */ /* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
        function _(el) {
            return document.getElementById(el);
        }

        function uploadFile() {

			
            var file = _("file1").files[0]; // alert(file.name+" | "+file.size+" | "+file.type);
			var fileLength = document.getElementById("file1").files.length;
			if(fileLength>0){
				if($("#terms_check").is(':checked')){
				//if($("#").prop('checked') == true){
						var formdata = new FormData();
						formdata.append("file1", file);
						var ajax = new XMLHttpRequest();
						ajax.addEventListener("load", completeHandler, false);
						ajax.addEventListener("error", errorHandler, false);
						ajax.addEventListener("abort", abortHandler, false);
						ajax.upload.addEventListener("progress", progressHandler, false);
						ajax.open("POST", "<?php echo $this->Html->url(array('controller'=>'Users','action' => 'upload_video')); ?>");
						//url:'<?php echo $this->Html->url(array('controller'=>'Users','action' => 'upload_video')); ?>',
						ajax.send(formdata);
				} else {
					alert("Please agree to our User Agreemen and  Privacy policy first!");
				}		
			}
			else{
				alert("Please choose any file");
			}
			
        }

        function progressHandler(event) 
		{
            _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBar").value = Math.round(percent);
            _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
			
			$("#file1").val("");
			$("#loaded_n_total").hide();

        }

        function completeHandler(event) {
            _("status").innerHTML = event.target.responseText;
            _("progressBar").value = 0;
			$("h3#status").hide();
			$(".successfully").show();
			$(".successfully").html('Video uploaded successfully...');
			location.reload();
        }

        function errorHandler(event) {
            _("status").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
            _("status").innerHTML = "Upload Aborted";
        }
   
</script>						
	
  <?php echo $this->Element('friend_section'); ?>
</section>
</section>



