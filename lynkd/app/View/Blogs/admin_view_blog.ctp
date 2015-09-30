<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 

<!--------------------------->
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Blog View Details</span>
    </div>
     <!-- Breadcrumbs line -->
      <div class="breadLine">

        <div class="bc">

            <ul id="breadcrumbs" class="breadcrumbs">

                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>

                <li><a href="<?php echo $this->Html->url(array('controller'=>'Blogs','action'=>'admin_index')); ?>">Blog Management</a></li>

                 <li class="current"><a href="javascript:void:(0)">Blog View Details</a></li>

            </ul>

        </div>

    </div>
    
    <!-- Main content -->
    <div class="wrapper">
    <?php $x=$this->Session->flash(); ?>
                  <?php if($x){ ?>
                   <div class="nNote nSuccess" id="flash">
                   <div class="alert alert-success" style="text-align:center">                
                   <?php echo $x; ?>
                   </div></div>
                   <?php } ?>
          
         <div class="widget fluid">
        <div class="whead"><h6>Blog View Details</h6></div>
        <div id="dyn" class="hiddenpars">
            <div class="formRow">
               
                </div>
                <div class="formRow">
                    <div class="grid3"><label><b>Blog Name:</b></label></div>
                    <div class="grid9">
                    <?php echo $info['Blog']['title'];?>
                    </div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label><b>Blog Image:</b></label></div>
                    <div class="grid9">
                       <?php if($info['Blog']['image'] != ''){ echo $this->Html->image('../files/blogimages/'.$info['Blog']['image'],array('height'=>'auto','width'=>'70px')); } else {
				echo $this->Html->image('no_image.png',array('height'=>'auto','width'=>'70px'));
			}	?>
                    
                    </div>
                </div>
				  <div class="formRow">
                    <div class="grid3"><label><b>Created By :</b></label></div>
                    <div class="grid9">
                         <?php echo $info['User']['name'].'  '.$info["User"]["last_name"]; ?>
                    
                    </div>
                </div>
				<div class="formRow">
                    <div class="grid3"><label><b>User Email :</b></label></div>
                    <div class="grid9">
                         <?php echo $info['User']['email']; ?>
                    
                    </div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label><b>Created:</b></label></div>
                    <div class="grid9">
                    <?php echo date("d M y",strtotime($info['Blog']['created'])); ?>
                    </div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label><b>Description :</b></label></div>
                    <div class="grid9">
                      <?php echo $this->Text->truncate(addslashes($info['Blog']['description']),150,array('ending'=>'...','exact'=>false));?>
                    </div>
                </div>     

				<div class="formRow">
                    <div class="grid3"><label><b>Location :</b></label></div>
                    <div class="grid9">
					<?php if(!empty($info["Blog"]["location"])) { ?>
                      <?php echo $info['Blog']['location']; ?>
					  <?php } else {?>
					    <?php echo "Not Mention"; ?>
					  <?php } ?>
                    </div>
                </div>    				
				
                <div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="grid9">                   
                    </div>
                </div>      
                
        </div>  
          
        </div>        
    </div>
</div>