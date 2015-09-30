 <?php echo $this->Html->script(array('jqueryValidate.js')); ?> 
<section class="wrapper">
  <section class="mid-cnt"> 
  <?php  echo $this->Session->flash();?>
 <!--  left sidebar start -->
    <?php  echo $this->Element('left_sidebar');?>
<!--  left sidebar end -->
<section class="mid-right">	 	
 <div class="blueHeading">Contact Us   </div>
<section class="login-outer">
        <div class="loginInner">
          <div class="clear"></div>
          <div class="accountInfo addPost">
		  <?php echo $this->Form->create('Contact',array('method'=>'Post', 'type'=>'file', 'id'=>'contact')); ?>
            <div class="fullWidth">
            <label>First Name<em style="color:red;">*</em></label>
		<input id="first_name" class="titleInput" type="text" placeholder="First Name" name="first_name">
            </div>
             <div class="fullWidth">
              <label>Last Name<em style="color:red;">*</em></label>
			<input id="last_name" class="titleInput" type="text" placeholder="Last Name" name="last_name">
            </div>
              <div class="fullWidth">
              <label>E-mail<em style="color:red;">*</em></label>
		<input id="email" class="titleInput" type="text" placeholder="Email" name="email">
            </div>
<!--hidden field start -->
<!--hidden field close -->
<div class="fullWidth">
              <label>Subject<em style="color:red;">*</em></label>
			<input id="sub" class="titleInput" type="text" placeholder="subject" name="subject">
			  <?php //echo $this->Form->input('Comment', array('label'=>"",'Placeholder'=>'comment','type'=>'textarea','class'=>'titleInput'));?>
            </div> 
              <div class="fullWidth">
              <label>Comment<em style="color:red;">*</em></label>
			    <textarea id="comment" class="comment" name="Comment" id="comment" placeholder="Comment"></textarea>
            </div>
           <input type="submit" value="Submit" class="submitBtn" name="Submit">
		     <?php echo $this->Form->end(); ?> 
          </div>
        </div>
      </section>
  </section>
	</section>
	</section>
<script type="text/javascript">
$(document).ready(function(){
$.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Alphabets allowed only"); 
	$("#contact").validate({
	 errorClass:"errors",
	  rules:
	   {
      		"first_name":{
												required:true,
												maxlength:50,
												lettersonly: true
											},
		"last_name":{
													required:true, 
													maxlength:50,
													lettersonly: true								
											},
													
	"email":{

											 required:true,
											email: true          

													},		
	"subject":{
	
												 required:true,
																	
													},
													
		"Comment":{
	
												 required:true,
																	
													}											
},																							

      		

	   messages:

	    {
													
		"first_name": {
													required: "This field is required",
													//maxlength: "This field contain max 50 character",
													alphanumeric: "Only Alphabets Number Allowed Only"
													},
													
		"last_name": {
													required: "This field is required",
													//maxlength: "This field contain max 50 character"
													alphanumeric: "Only Alphabets Number Allowed Only"
													},

				"email": {
													required: "This field is required",
													email: "Please enter a valid email address"
													
													},
																				
			"subject": {
													required: "This field is required",
												
													
													},	

	"Comment":{
	
												required: "This field is required",
																	
													}	
													
				
	    }
	});         
});
</script>

