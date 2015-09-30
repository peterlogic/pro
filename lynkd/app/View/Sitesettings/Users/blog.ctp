<!-- Main content -->

    <div class="wrapper">

         <div class="widget fluid">

        <div class="whead"><h6><?php echo $action_type.' Blog'; ?></h6></div>

        <div id="dyn" class="hiddenpars">

             <?php echo $this->Form->create('Blog',array('method'=>'Post','type'=>'file','id'=>'validate')); ?>

                <div class="formRow">

                    <div class="grid3"><label>Blog title:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('title', array('label'=>"",'type'=>'text'));?>

                    </div>

                </div>
				
				<div class="formRow">

                    <div class="grid3"><label>Categorie:<span class="red">*</span></label></div>
					
					 <div class="grid9">

							<?php		//foreach ($catlist  as $key => $val) 
								
										//debug($val);
									//	echo $this->Form->input('category_id', array('options' => $catlist,'empty'=>'Please select category','label'=>false));
										?>
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

                    <div class="grid3"><label>Only visible to users in area (Ex. 50 miles):<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('within', array('label'=>"",'type'=>'number'));?>
                      
                    </div>

                </div>
				
				<div class="formRow">

                    <div class="grid3"><label>Location with in want to show post:<span class="red">*</span></label></div>

                    <div class="grid9">

                    <?php echo $this->Form->input('where', array('label'=>"",'type'=>'text'));?>
                      
                    </div>

                </div>
				
				<div class="formRow">

                    <div class="grid3"><label>Publish Type:<span class="red">*</span></label></div>

                    <div class="grid9">
                             <select name="data[Blog][type]">
							   <option>--Select--</option>
							      <option value="Anonymously">Anonymously</option>
								   <option value="Publically">Publically</option>
							 </select>
                      
                      
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