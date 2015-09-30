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
		<?php echo $this->Session->flash(); ?>
          <div class="borderCol">
            <h1>Add a new post</h1>
			
          </div>
          <div class="clear"></div>
          <div class="accountInfo addPost">
		  <?php echo $this->Form->create('Blog',array('method'=>'Post', 'type'=>'file', 'id'=>'blog','enctype'=>'multipart/form-data')); ?>
            <div class="fullWidth">
				<label>Title<em class="em_color">*</em></label>
				<input type="text" class="titleInput" value="" name="data[Blog][title]">
            </div>
              
               <div class="fullWidth">
              <label>Category</label>
          
              <?php
									echo $this->Form->input('category_id', array('options' => $catlist,'multiple'=>'multiple','label'=>false,'class'=>'SlectBox'));
										?>                       
            </div>
              
            <div class="fullWidth">
			
			<div class="fullWidth">
				  <label>Upload Blog Image </label>
				  <?php echo $this->Form->input('image', array('type' => 'file','label'=>false)); ?>
			</div>
			
			
			
			
					  <label>Description</label>
					 <!-- <div class="editor"> <img alt="" src="images/editordemo.jpg"> </div> -->
					<div class="editor"><?php echo $this->Form->input('description', array('label'=>false,'type'=>'textarea','id'=>'conta','class'=>'editor'));?></div>            
					</div>
			
            <div class="fullWidth">
              <label>Show in<em class="em_color">*</em></label>			  
			<?php   echo $this->Form->input('showin_id', array('options' => $mile,'empty'=>'Please select miles','label'=>false,'class'=>'commonSelectone')); ?>			                 
            </div>
			
			
              
               <div class="fullWidth">
				  <label>Location</label>
				  <input type="text" class="titleInput" value="" name="data[Blog][location]">
				</div>
				
				
				 <div class="fullWidth">
				  <label>Tag</label>
				  <input type="text" class="titleInput" value="" name="data[Blog][tags]">
				  <em style="font-size:10px;">Comma Seperate (,)</em>
				</div>
              
            
			
			 <div class="fullWidth">
					<div class="radio-input"> <input type="radio" value="Individual" name="data[Blog][blogtype_one]"> <span>Individual</span></div>
					<div class="radio-input"> <input type="radio" value="Business" name="data[Blog][blogtype_one]"> <span>Business</span></div>
					<div class="radio-input"> <input type="radio" value="Both" name="data[Blog][blogtype_one]"> <span>Both</span></div>
					
			 </div>
			 
			 <div class="fullWidth">
					<div class="radio-input"> <input type="radio" value="Barter" name="data[Blog][blogtype_two]"> <span>Barter</span></div>
					<div class="radio-input"> <input type="radio" value="Transactions" name="data[Blog][blogtype_two]"> <span>$ Transactions</span></div>
					<div class="radio-input"> <input type="radio" value="Both" name="data[Blog][blogtype_two]"><span>Both</span></div>
					
			 </div>
			 
			 <div class="fullWidth">
					<div class="radio-input"> <input type="radio" value="Annonymous"  name="data[Blog][blogtype_three]"> <span>Annonymous</span></div>
					
			 </div>
			  	
			 <div class="fullWidth">
				  <label>Meta title<em class="em_color">*</em></label>
				  <input type="text" class="titleInput" value="" name="data[Blog][meta_title]">
			</div>
			
			<div class="fullWidth">
				  <label>Meta tag<em class="em_color">*</em></label>
				  <input type="text" class="titleInput" value="" name="data[Blog][meta_tag]">
				  <em style="font-size:10px;">Comma Seperate (,)</em>
			</div>
			 <div class="fullWidth">
				  <label>Meta description<em class="em_color">*</em></label>
				  <textarea id="comment" class="titleInput" name="data[Blog][meta_description]" ></textarea>
				 <!-- <input type="textarea" class="titleInput" value="" name="data[Blog][meta_description]"> -->
			</div>
			 
			  <div class="fullWidth">
					 <p>  <input type="checkbox" name="policy"  value=""  checked='checked' />
              I agree to the Lynkd 	<?php echo $this->Html->link('User Agreement',array('controller'=>'staticpages','action'=>'view',6), array('target' => '_blank')); ?> and <?php echo $this->Html->link('Privacy policy',array('controller'=>'staticpages','action'=>'view',3), array('target' => '_blank')); ?>.</p>
			 </div>
			 
			<?php echo $this->Form->input('user_id', array('type' => 'hidden', 'value'=>$user_id)); ?>
            <input type="submit" class="submitBtn" value="Submit">
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
			/*"data[Blog][location]":{
												required:true,												
													},	*/
				"data[Blog][image]":{				
																required:false,	
																accept:'png|jpe?g|gif'	
				
														}, 
			
				"data[Blog][category_id]":{
																required:true,			
				
														},
/* 				"data[Blog][tags]":{
													required:true,
													}, */
			"data[Blog][showin_id]":{
														required:true,
											},
			"policy":{
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
			
			/*"data[Blog][location]": {
												required: "This field is required",								
													},	*/	
				"data[Blog][image]":{
														accept: 'please upload only .png,.jpg,.gif file'
															},

				"data[Blog][category_id]":{
																required: "Please select the blog category",			
				
														},
				/* "data[Blog][tags]":{
														required: "This field is required",	
													}, */
				"data[Blog][showin_id]":{
															required: "Please select the miles first",			
				
															},
				"policy":{
														required: "Please agree to our User Agreemen and  Privacy policy!",
												},
												
				"data[Blog][meta_title]": {
												required: "This field is required",
													},
				"data[Blog][meta_tag]": {
												required: "This field is required",
													},
					"data[Blog][meta_description]": {
												required: "This field is required",
													},										
													
				
	    }			
});    	

});	
</script>