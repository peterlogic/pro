<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 

<!--------------------------->
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Administrator Profile</span>
      
    </div>
     <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_profile')); ?>">Administrator Profile</a></li>
                 <li class="current"><a href="javascript:void:(0)">Edit Administrator Profile</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="wrapper">
    <?php $x=$this->Session->flash();if($x){ ?>
    <div class="nNote nSuccess" id="flash">
       <div class="alert alert-success" style="text-align:center" ><?php echo $x; ?></div>
     </div><?php } ?>
    	<!-- Chart -->
     <div class="widget fluid">
        <div class="whead"><h6>Edit</h6></div>
        <div id="dyn" class="hiddenpars">
             <?php echo $this->Form->create('User',array('action'=>'admin_profileedit','type'=>'file')); ?>
                <div class="formRow">
                    <div class="grid3"><label>Username:<span class="red">*</span></label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('username', array('label'=>"",'type'=>'text','value'=>$profile['User']['username'],'required'=>true));?>
                    </div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>First Name:<span class="red">*</span></label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('User.name', array('label'=>"",'type'=>'text','required'=>true));?>
                    </div>
                </div>
		
                        
                <div class="formRow">
                    <div class="grid3"><label>Email:<span class="red">*</span></label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('User.email', array('label'=>"",'type'=>'email','value'=>$profile['User']['email'],'required'=>true));?>
                    </div>
                </div>                
                   
                <div class="formRow">
                    <div class="grid3"><label>Profile Image:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('User.profile_image', array('label'=>"",'type'=>'file')); ?>
					<?php 
                    if($profile['User']['profile_image']== NULL || $profile['User']['profile_image']==''){
                       echo $this->Html->image('admin.png',array('height'=>'auto','width'=>'100px'));
                     }else{ echo $this->Html->image('/files/profileimage/'.$profile['User']['id'].$profile['User']['profile_image'],array('height'=>'auto','width'=>'100px'));} ?>
                    </div>
                </div> 
			
                <div class="formRow">
                    <div class="grid3"><label>Contact No:</label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('User.phone', array('label'=>"",'type'=>'text'));?>
                    </div>
                </div>
                
                <div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="grid9">
                    <button type="submit" name="Save" id="update" class="buttonS bLightBlue" >Save</button>
                    </div>
                </div>
           </form>
        </div>  
        </div>        
    </div>
</div>