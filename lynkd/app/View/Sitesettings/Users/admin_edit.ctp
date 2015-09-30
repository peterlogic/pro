<?php echo $this->element("admin_header"); ?>

<?php echo $this->element("admin_topright"); ?>

<?php echo $this->element("admin_nav"); ?>

<?php echo $this->element("admin_sidebar"); ?> 

<!--------------------------->

<div id="content">

    <div class="contentTop">

        <span class="pageTitle"><span class="icon-screen"></span>User Management</span>

        

    </div>

     <!-- Breadcrumbs line -->

    <div class="breadLine">

        <div class="bc">

            <ul id="breadcrumbs" class="breadcrumbs">

                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>

                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_index')); ?>">User Management</a></li>

                 <li class="current"><a href="javascript:void:(0)"><?php if(!empty($this->data)){ ?>Edit User <?php } else { ?> Add User<?php } ?></a></li>

            </ul>

        </div>

    </div>

    

    <!-- Main content -->

    <div class="wrapper">

         <div class="widget fluid">

        <div class="whead"><h6><?php if($action_type=='edit'){ $r = 'readonly'; ?>Edit User <?php } else { $r = '';?> Add User<?php } ?></h6></div>

        <div id="dyn" class="hiddenpars">

             <?php echo $this->Form->create('User'); ?>

                <div class="formRow">

                    <div class="grid3"><label>Username:</label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('username', array('label'=>"",'type'=>'text',$r));?>

                    </div>

                </div>

                  <div class="formRow">

                    <div class="grid3"><label>Full Name:</label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('name', array('label'=>"",'type'=>'text'));?>

                    </div>

                </div>      

                <div class="formRow">

                    <div class="grid3"><label>Email:</label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('email', array('label'=>"",'type'=>'email'));?>

                    </div>

                </div>

              <div class="formRow">

                    <div class="grid3"><label>User Type:</label></div>

                    <div class="grid9">
                              <select name="data[User][user_type]">
							      <option>--Select--</option>
								  <option value="1">Admin</option>
								    <option value="2">User</option>
							  </select>
                   

                    </div>

                </div>    
              

                <div class="formRow">

                    <div class="grid3"><label>Password:</label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('password', array('label'=>"",'type'=>'password'));?>

                    </div>

                </div>     

             		
                		
				<div class="formRow">

                    <div class="grid3"><label>Profession:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('profession', array('label'=>"",'type'=>'text','required'));?>
                      
                    </div>

                </div>
				
				
				
					
				<div class="formRow">

                    <div class="grid3"><label>Skills:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('skills', array('label'=>"",'type'=>'text','required'));?>
                      
                    </div>

                </div>
				
				
				
					
				<div class="formRow">

                    <div class="grid3"><label>Interests:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('interests', array('label'=>"",'type'=>'text','required'));?>
                      
                    </div>

                </div>
				
				
				
					
				<div class="formRow">

                    <div class="grid3"><label>Sex:<span class="red">*</span></label></div>

                    <div class="grid9">

                 <select name="data[Blog][sex]">
							   <option>--Select--</option>
							      <option value="Male">Male</option>
								   <option value="Female">Female</option>
							 </select>
                      
                    </div>

                </div>
				
				
				
					
				<div class="formRow">

                    <div class="grid3"><label>D.O.B:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('dob', array('label'=>"",'type'=>'text','required'));?>
                      
                    </div>

                </div>
				
				
				
					
				<div class="formRow">

                    <div class="grid3"><label>Address:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('address', array('label'=>"",'type'=>'textarea','required'));?>
                      
                    </div>

                </div>

                
				
				<div class="formRow">

                    <div class="grid3"><label>Zipcode:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('zipcode', array('label'=>"",'type'=>'text','required'));?>
                      
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

<script>
(function($) {
    $.fn.extend( {
        limiter: function(limit, elem) {
            $(this).on("keyup focus", function() {
                setCount(this, elem);
            });
            function setCount(src, elem) {
                var chars = src.value.length;
                if (chars > limit) {
                    src.value = src.value.substr(0, limit);
                    chars = limit;
                }
                elem.html( limit - chars );
            }
            setCount($(this)[0], elem);
        }
    });
})(jQuery);

var elem = $("#chars");
$("#profile_desc").limiter(500, elem);
</script> 

      