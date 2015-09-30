<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<?php echo $this->Html->script(array('tiny_mce/tiny_mce'))?>
<script type="text/javascript">
jQuery(document).ready(function(){
tinyMCE.init({
theme: "advanced",
plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
// Theme options
theme_advanced_buttons1 : ",justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2 : "cut,copy,paste|,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,backcolor",
theme_advanced_buttons3 : "tablecontrols,|sub,sup,|,charmap,emotions,iespell,media,advhr,|,fullscreen",
theme_advanced_buttons4 : "bold,italic,underline,strikethrough,|styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,|,insertimage",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,
mode: "exact",
elements: "conta",
body_id: "conta"
});
});

        
        </script>
<!--------------------------->

<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-calendar"></span>Blog Management</span>
    </div>

     <!-- Breadcrumbs line -->

    <div class="breadLine">

        <div class="bc">

            <ul id="breadcrumbs" class="breadcrumbs">

                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>

                <li><a href="<?php echo $this->Html->url(array('controller'=>'Blogs','action'=>'admin_index')); ?>">Blog Management</a></li>

                 <li class="current"><a href="javascript:void:(0)"><?php echo $action_type.' Blog'; ?></a></li>

            </ul>

        </div>

    </div>

    

    <!-- Main content -->

    <div class="wrapper">

         <div class="widget fluid">

        <div class="whead"><h6><?php echo $action_type.' Blog'; ?></h6></div>

        <div id="dyn" class="hiddenpars">

             <?php echo $this->Form->create('Blog',array('method'=>'Post','type'=>'file','id'=>'validate')); ?>

                <div class="formRow">

                    <div class="grid3"><label>Blog title:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('title', array('label'=>"",'type'=>'text','required'=>true));?>

                    </div>

                </div>
				
				<div class="formRow">

                    <div class="grid3"><label>Category:<span class="red">*</span></label></div>
					
					 <div class="grid9">

							<select name="data[Blog][category_id][]" class="SlectBox" multiple="multiple">
					<?php  foreach($catlist as $key=>$c){ ?>
							<option value="<?php  echo $key; ?>" <?php  if(in_array($key,$bIDs)){ echo 'selected="selected"'; } ?>><?php  echo $c; ?></option>
					<?php } ?>
			  </select>     
			    </div>
		</div>

                <div class="formRow">
                    <div class="grid3"><label>Upload Blog Image:<span class="red">*</span></label></div>
                    <div class="grid9">
					
					<div class="red" id="error"></div>
                    
					<?php if($action_type =='Edit') { 
					if( $this->data['Blog']['image'] != ''){  ?>
					<input type="file" name="data[Blog][image]" id="uploadImage" accept="image/gif, image/jpeg, image/png"  />
					<?php
						 echo $this->Html->image('../files/blogimages/'.$this->data['Blog']['image'],array('width'=>'100','height'=>'100'));
					} else {
						echo $this->Html->image('no_image.png',array('width'=>'100','height'=>'100'));?>
                                                <input type="file" name="data[Blog][image]" id="uploadImage" accept="image/gif, image/jpeg, image/png"  />
				<?php	} } else {?>
					<input type="file" name="data[Blog][image]" id="uploadImage" accept="image/gif, image/jpeg, image/png"  />
					<?php } ?>
					
                    </div>
                </div>
               
                  <div class="formRow">

                    <div class="grid3"><label>Description:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('description', array('label'=>"",'type'=>'textarea','id'=>'conta','style'=>'height:450px;width:100%;'));?>

                    </div>

                </div>
				
				 <div class="formRow">

                    <div class="grid3"><label>Show in:<span class="red">*</span></label></div>

                    <div class="grid9">
					<?php   echo $this->Form->input('showin_id', array('options' => $mile,'empty'=>'Please select miles','label'=>false,'required'=>true)); ?>	
                    <?php //echo $this->Form->input('within', array('label'=>"",'type'=>'number'));?>
                      
                    </div>
                </div>
				
				<div class="formRow">

                    <div class="grid3"><label>Location:</label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('location', array('label'=>"",'type'=>'text'));?>
                      
                    </div>

                </div>
				
				
			<div class="formRow">

                    <div class="grid3"><label>Tag:</label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('tags', array('label'=>"",'type'=>'text'));?>
					<em style="font-size:10px;">Comma Seperate (,)</em>
                      
                    </div>
                </div> 				
				   <?php echo $this->Form->input('user_id', array('label'=>"",'type'=>'hidden','value'=>$this->Session->read('Auth.User.id')));?>
				
				 <div class="formRow">
			
					<div class="radio-input"> <input type="radio" value="Individual" <?php if($this->data['Blog']['blogtype_one']=='Individual'){ echo 'checked';} ?> name="data[Blog][blogtype_one]"> <span>Individual</span></div>
					<div class="radio-input"> <input type="radio" value="Business"<?php if($this->data['Blog']['blogtype_one']=='Business'){ echo 'checked'; }?> name="data[Blog][blogtype_one]"> <span>Business</span></div>
					<div class="radio-input"> <input type="radio" value="Both"<?php if($this->data['Blog']['blogtype_one']=='Both'){ echo 'checked';} ?> name="data[Blog][blogtype_one]"> <span>Both</span></div>

			 </div>
			 <div class="formRow">
			
					<div class="radio-input"> <input type="radio" value="Barter" <?php if($this->data['Blog']['blogtype_two']=='Barter'){ echo 'checked';} ?> name="data[Blog][blogtype_two]"> <span>Barter</span></div>
					<div class="radio-input"> <input type="radio" value="Transactions"<?php if($this->data['Blog']['blogtype_two']=='Transactions'){ echo 'checked'; }?> name="data[Blog][blogtype_two]"> <span>$ Transactions</span></div>
					<div class="radio-input"> <input type="radio" value="Both"<?php if($this->data['Blog']['blogtype_two']=='Both'){ echo 'checked';} ?> name="data[Blog][blogtype_two]"> <span>Both</span></div>

			 </div>
			 <div class="formRow">
			
					<div class="radio-input"> <input type="radio" value="Annonymous" <?php if($this->data['Blog']['blogtype_three']=='Annonymous'){ echo 'checked';} ?> name="data[Blog][blogtype_three]"> <span>Annonymous</span></div>
					
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