<section class="wrapper">
  <section class="mid-cnt"> 
    <!--  left sidebar start -->
    <?php  echo $this->Element('left_sidebar'); ?>
	<?php echo $this->Html->script(array('jqueryValidate.js')); ?>
    <!--  left sidebar end -->
	    
    <section class="mid-right mob-marginTB0">
      <section class="login-outer">
        <div class="loginInner">
          <div class="borderCol">
            <h1>Register</h1>
          </div>
          <div class="clear"></div>
<?php echo $this->Session->flash(); ?>
          <div class="accountInfo">
  <?php echo $this->Form->create('User',array('method'=>'Post', 'type'=>'file', 'id'=>'validate')); ?>


            <div class="input-outer"> <span class="user-icon"></span>
			
			<?php //echo $this->Form->input('name', array('type' => 'text',  'label' => false, 'required'=>false,'style' => 'width:200px')); ?>
			
			   <input type="text" name='name'  id= "name" class="login-input"  placeholder="First name / Buisness name" /> 
            </div>
			
            <div class="input-outer"> <span class="user-icon"></span>			
			   <input type="text" name='last_name' class="login-input"  placeholder="Last name" />
            </div>
			
            <div class="input-outer"> <span class="lock-icon"></span>
			   <input type="text"  name='email' class="login-input"  placeholder="Email"/>
            </div>
            <div class="input-outer"> <span class="user-icon"></span>
			   <input type="text" name='username' class="login-input"  placeholder="Username" />
            </div>
            <div class="input-outer"> <span class="lock-icon"></span>
		   <input type="password" name='password'  id="password" class="login-input"  placeholder="Password"/>
            </div>
            <div class="input-outer"> <span class="lock-icon"></span>
			   <input type="password" name='confirm_password' class="login-input" placeholder="Confirm password" />
            </div>
			<?php  //debug($countryList);?>
			<div class="input-outer"> <span class="country-icon"></span>
			   <select  placeholder="Select Country" class="commonSelect"  id="country" name='country'>
						<option value='' >Select Country</option>
						<?php  foreach($countryList as $c){ ?>
								<option value='<?php echo $c['Country']['id']; ?>' ><?php  echo $c['Country']['country']; ?></option>
						<?php  } ?>
                </select>
				</div>
				 <div class="input-outer"> <span class="state-icon"></span>
				<select  placeholder="Select State" class="commonSelect" id="region"  name='state' >
						<option value='' >Select State</option>
                </select>
				</div>
				<div class="input-outer"> <span class="city-icon"></span>
				<select  placeholder="Select City" class="commonSelect_one"  id="city" name='city' >
						<option value='' >Select City</option>
                </select>
				</div>
				
			 	<div class="input-outer"> <span class="city-icon"></span>
				<select  placeholder="Select user" class="commonSelect_one"  id="city" name='account_type' >
						 <option value="">Select user type</option>	
						 <option value="Business">Business</option>
						<option value="Individual">Individual</option>
                </select>
				</div> 				
			
            <div class="input-outer"> <span class="zip-icon"></span>
			   <input type="text"  name='zipcode' class="login-input"  placeholder="Zip code"/>
            </div>

            <div class="agreeHead">
            <p>  <input type="checkbox" name="policy" value=""  checked='checked'/>
              I agree to the Lynkd <?php echo $this->Html->link('User Agreement',array('controller'=>'staticpages','action'=>'view',6), array('target' => '_blank')); ?> and <?php echo $this->Html->link('Privacy policy',array('controller'=>'staticpages','action'=>'view',3), array('target' => '_blank')); ?>.</p>
			  
			  </div>
            <input type="submit" class="submitBtn" value="Submit" />
			
			</form>
          </div>
        </div>
      </section>
    </section>
  </section>
</section>


<script type="text/javascript">
$( "#country" ).change(function() {
    	var country = $( "#country" ).val();
    	$("#country option[value='0']").remove();

       	$.ajax({ url: "<?php echo Router::url(array('controller'=>'users','action'=>'get_states'),true); ?>/"+country,        
         type: 'get',
         async: false,
         success:
         function(msg) {
         	$('#region').html(msg);
       	 }
        });
    	$('#city').find('option').remove().end();
    	$('#city').append('<option value="0">Please choose a Region/State</option>');

	});
	
	$( "#region" ).change(function() {
    	var region = $( "#region" ).val();
        $.ajax({ url: "<?php echo Router::url(array('controller'=>'users','action'=>'get_cities'),true); ?>/"+region,  
         data: {region_id: region},
         type: 'get',
         async: false,
         success:
         function(msg) {
         	$('#city').html(msg);
       	 }
        });
	});
	
$(document).ready(function(){
$.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Alphabets allowed only"); 
$("#validate").validate({
	  rules:
	   {
      		"name":{
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
												email: true,
												remote:'checkemailalreadyexist'
													},	
				"username":{
												required:true,
												remote: "checkuseralreadyexist"
											
									},		
										
					"password":{
												required:true,
												 minlength: 5
									 },	

				"confirm_password":{
													required: true,
													minlength: 5,
													equalTo: "#password"
									 },

				"city":{
													required: true
													
							},
								
				"state":{
													required: true
													
							},		

				"zipcode" :{
													required:true,
													minlength: 5,
													digits: true,
													maxlength:6	
													
							},
							
					"country" :{
													required: true
													
							},

						"policy" :{
													required: true
													
									},
					"account_type" :{
													required: true
													
									}				
													
            },
			
			
  messages:

	    {
			"name": {
												required: "This field is required",
												maxlength: "This field contain max 50 character"
													},
			
		
			"last_name": {
												required: "This field is required",
												maxlength: "This field contain max 50 character"
											
													},
			"email": {
												required: "This field is required",
												email: "Please enter a valid email address",
												remote: jQuery.format("{0} is already in use")
												
											
													},	
				"username": {
											required: "This field is required",
											remote: jQuery.format("{0} is already in use")
											
											
													},
														
				"password": {
											required: "This field is required",
											minlength: "password contain atleast 5 character"
											
									},

														
				"confirm_password": {
											   required: "This field is required",
											   minlength: "password contain atleast 5 character",
											   equalTo: "Passwords do not match"
											
									},
										
				"city": {
											required: "This field is required",
											
											
							},	

					"state": {
											required: "This field is required",
											
											
							},

					"state": {
											required: "This field is required",
											
											
							},	

					"zipcode": {
											required: "This field is required",
											minlength: "This field must contain at least 5 digit",
											digits: "This field can only contain digits",
											maxlength:"This field onlty contain 6 digit "
											
											
							},		

						"country": {
											required: "This field is required",
													
							},

						"policy": {
											required: "Please agree to our User Agreemen and  Privacy policy!",
													
							},
							
					"account_type" :{
													required: "Please select the account type",
													
									}			
							
	    }	
});    	

});
</script>