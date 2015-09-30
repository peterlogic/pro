<?php echo $this->Html->script(array('tiny_mce/tiny_mce'))?>
<?php echo $this->Html->script('jqueryValidate.js'); ?>
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
<section class="wrapper">
<section class="mid-cnt"> 
    <!--  left sidebar start -->
    <?php  echo $this->Element('accountsidebar');?>
    <!--  left sidebar end -->

<section class="mid-right">
      <section class="login-outer">
        <div class="loginInner">
		<?php //echo $this->Session->flash(); ?>
			
          <div class="borderCol">
            <h1>Edit Post</h1>
          </div>
          <div class="clear"></div>
          <div class="accountInfo addPost">
		  <?php echo $this->Form->create('Blog',array('method'=>'Post', 'type'=>'file', 'id'=>'blog','enctype'=>'multipart/form-data')); ?>
            <div class="fullWidth">
			<label>Title<em class="em_color">*</em> :</label>
				<!-- <input type="text" class="titleInput"  name="data[Blog][title]"> -->
				<?php echo $this->Form->input('title', array('label'=>"",'type'=>'text','class'=>'titleInput'));?>
            </div>
              <div class="fullWidth">
              <label>Category</label>
			  <select name="data[Blog][category_id][]" class="SlectBox" multiple="multiple">
					<?php  foreach($catlist as $key=>$c){ ?>
							<option value="<?php  echo $key; ?>" <?php  if(in_array($key,$bIDs)){ echo 'selected="selected"'; } ?>><?php  echo $c; ?></option>
					<?php } ?>
			  </select>
			  
              <?php	//echo $this->Form->input('BlogCategory.category_id', array('options' => $catlist,'multiple'=>'multiple','label'=>false,'class'=>'SlectBox'));		?> 
					                    
            </div>     
            <div class="fullWidth">
			<div class="fullWidth">
				  <label>Upload Blog Image </label>
				   <div class="grid9">
					<div class="red" id="error"></div> 
					<?php if($action_type =='Edit') { 
					if( $this->data['Blog']['image'] != ''){  ?>
					<input type="file" name="data[Blog][image]" id="uploadImage"  />
					<?php
						 echo $this->Html->image('../files/blogimages/'.$this->data['Blog']['image'],array('width'=>'100','height'=>'100','alt'=>"blog_image"));
					} else {
						echo $this->Html->image('no_image.png',array('width'=>'100','height'=>'100','alt'=>"blog_image"));?>
                                                <input type="file" name="data[Blog][image]" id="uploadImage"  />
				<?php	} } else {?>
					<input type="file" name="data[Blog][image]" id="uploadImage"  />
					<?php } ?>
                    </div>
			</div>
			
					  <label>Description</label>
					 <!-- <div class="editor"> <img alt="" src="images/editordemo.jpg"> </div> -->
					<div class="editor"><?php echo $this->Form->input('description', array('label'=>false,'type'=>'textarea','id'=>'conta','class'=>'editor'));?></div>            
					</div>
			
            <div class="fullWidth">
              <label>Show in</label>
			   <?php //echo $this->Form->input('show_in', array('label'=>"",'type'=>'text','class'=>'titleInput','class'=>'commonSelectone'));?>
			  <?php echo $this->Form->input('showin_id', array('options' =>$mile,'empty'=>'Please select miles','label'=>false,'class'=>'commonSelectone')); ?>           
            </div>
               <div class="fullWidth">
				  <label>Location<em class="em_color">*</em> :</label>
				  <!-- <input type="text" class="titleInput" value="" name="data[Blog][location]">-->
				  <?php echo $this->Form->input('location', array('label'=>"",'type'=>'text','class'=>'titleInput'));?>
				</div>
		
				 <div class="fullWidth">
				  <label>Tag</label>
				  <!-- <input type="text" class="titleInput" value="" name="data[Blog][location]">-->
				  <?php echo $this->Form->input('tags', array('label'=>"",'type'=>'text','class'=>'titleInput'));?>				
				  <em style="font-size:10px;">Comma Seperate (,)</em>
				</div>
			 <div class="fullWidth">
			
					<div class="radio-input"> <input type="radio" value="Individual" <?php if($this->data['Blog']['blogtype_one']=='Individual'){ echo 'checked';} ?> name="data[Blog][blogtype_one]"> <span>Individual</span></div>
					<div class="radio-input"> <input type="radio" value="Business"<?php if($this->data['Blog']['blogtype_one']=='Business'){ echo 'checked'; }?> name="data[Blog][blogtype_one]"> <span>Business</span></div>
					<div class="radio-input"> <input type="radio" value="Both"<?php if($this->data['Blog']['blogtype_one']=='Both'){ echo 'checked';} ?> name="data[Blog][blogtype_one]"> <span>Both</span></div>

			 </div>
			 <div class="fullWidth">
			
					<div class="radio-input"> <input type="radio" value="Barter" <?php if($this->data['Blog']['blogtype_two']=='Barter'){ echo 'checked';} ?> name="data[Blog][blogtype_two]"> <span>Barter</span></div>
					<div class="radio-input"> <input type="radio" value="Transactions"<?php if($this->data['Blog']['blogtype_two']=='Transactions'){ echo 'checked'; }?> name="data[Blog][blogtype_two]"> <span>$ Transactions</span></div>
					<div class="radio-input"> <input type="radio" value="Both"<?php if($this->data['Blog']['blogtype_two']=='Both'){ echo 'checked';} ?> name="data[Blog][blogtype_two]"> <span>Both</span></div>

			 </div>
			 <div class="fullWidth">
			
					<div class="radio-input"> <input type="radio" value="Annonymous" <?php if($this->data['Blog']['blogtype_three']=='Annonymous'){ echo 'checked';} ?> name="data[Blog][blogtype_three]"> <span>Annonymous</span></div>
					
			 </div>
			 
			 <div class="fullWidth">
			<label>Meta title<em class="em_color">*</em> :</label>
				<!-- <input type="text" class="titleInput"  name="data[Blog][title]"> -->
				<?php echo $this->Form->input('meta_title', array('label'=>"",'type'=>'text','class'=>'titleInput'));?>
            </div>
			
			<div class="fullWidth">
			<label>Meta tag<em class="em_color">*</em> :</label>
				<!-- <input type="text" class="titleInput"  name="data[Blog][title]"> -->
				<?php echo $this->Form->input('meta_tag', array('label'=>"",'type'=>'text','class'=>'titleInput'));?>
            </div>
			 
			 <div class="fullWidth">
			<label>Meta description<em class="em_color">*</em> :</label>
				<!-- <input type="text" class="titleInput"  name="data[Blog][title]"> -->
				<?php echo $this->Form->input('meta_description', array('label'=>"",'type'=>'textarea','class'=>'titleInput'));?>
            </div>
			 
			<?php //echo $this->Form->input('user_id', array('type' => 'hidden', 'value'=>$user_id)); ?>
            <input type="submit" class="submitBtn" value="Update">
		
			<?php echo $this->Form->end(); ?>
          </div>
        </div>
      </section>
    </section>
		<?php echo $this->Element('friend_section'); ?>
  </section>
</section>

<script type="text/javascript">

$(document).ready(function(){
$("#blog").validate({
 errorClass:"errors",
	  rules:
	   {
      		"data[Blog][title]":{
												required:true,
													},
			
													
			
			"data[Blog][image]":{
													required:false,
													accept:'png|jpe?g|gif'	
				
														},				
			
				"data[Blog][category_id]":{
																required:true,			
				
														},
				
			"data[Blog][showin_id]":{
														required:true,
											},
			"data[Blog][meta_title]":{
												required:true,
													},
			"data[Blog][meta_tag]":{
												required:true,
													},
			"data[Blog][meta_description]":{
												required:true,
													}											
																														
            },
			
			
  messages:

	    {
			"data[Blog][title]": {
												required: "This field is required",
													},
			
			
			"data[Blog][image]":{
												accept: 'please upload only .png,.jpg,.gif file'
												},														

				"data[Blog][category_id]":{
																required: "Please select the blog category",			
				
														},
				
				"data[Blog][showin_id]":{
															required: "Please select the miles first",			
				
															},
				"data[Blog][meta_title]":{
															required: "This field is required",			
															},
				"data[Blog][meta_tag]":{
															required: "This field is required",			
															},
				"data[Blog][meta_description]":{
															required: "This field is required",			
															}													
										
	    }			
													
});    	
});
</script>