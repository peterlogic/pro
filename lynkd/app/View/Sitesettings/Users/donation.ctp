 <?php echo $this->Html->script(array('jqueryValidate.js')); ?> 
<section class="wrapper">
  <section class="mid-cnt"> 
 <!--  left sidebar start -->
    <?php  echo $this->Element('left_sidebar');?>
<!--  left sidebar end -->
<section class="mid-right">	 	
 <div class="blueHeading">Donation </div>
<section class="login-outer">
        <div class="loginInner">
          <div class="clear"></div>
          <div class="accountInfo addPost">
  <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" id="donation" name="donation" method="post" class="form-center" >
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
<input type="hidden" name="business" value="pramodsingh302-facilitator@gmail.com">
<input type="hidden" name="cmd" value="_donations" />
 <input type="hidden" name="no_note" value="0">
<input type="hidden" name="note" value="this is testing">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="item_name" value="lynkd Donation">
<input type="hidden" name="cancel_return" value="http://dev414.trigma.us/lynkd?status=ERROR">
<input type="hidden" name="return" value="http://dev414.trigma.us/lynkd?status=SUCCESS">
<input type="hidden" name="bn" value="
        PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest" />
<input type="hidden" name="handling" value="0">
<!--hidden field close -->
<div class="fullWidth">
              <label>Payment Method</label>
			  <img src="<?php echo $this->webroot; ?>files/paypal/paypalmeth.png" /> 
			  <?php //echo $this->Form->input('Comment', array('label'=>"",'Placeholder'=>'comment','type'=>'textarea','class'=>'titleInput'));?>
            </div> 
              <div class="fullWidth">
              <label>Donation Amount<em style="color:red;">*</em></label>
		<input id="amount" class="titleInput" type="text" placeholder="Amount" name="amount">
            </div>
           <input type="submit" value="Donate" class="submitBtn" name="Update">
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
	$("#donation").validate({
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
	"amount":{

												
															 required:true,
														number:true
													}
},																							

	   messages:

	    {
													
		"first_name": {
													required: "This field is required",
													maxlength: "This field contain max 50 character"
													},
													
		"last_name": {
													required: "This field is required",
													maxlength: "This field contain max 50 character"
													},

				"email": {
													required: "This field is required",
													email: "Please enter a valid email address"
													
													},
																				
			"amount": {
													required: "This field is required",
													number:"Enter valid amount "
													
													}		
				
	    }
	});         
});
</script>

