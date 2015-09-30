    <div>    <?php echo $this->Form->create('Paypal',array('controllers'=>'Users','action'=>'donation','id'=>'changepass','name'=>'changepass')); ?>
          <h3>Basic Information</h3>
          <label>
          <p>First Name <span>*</span> </p>
          <?php echo $this->Form->input('name', array('label'=>"",'type'=>'text','Placeholder'=>'name...','type'=>'text','class'=>'titleInput'));?>
          </label>
          <label>
          <p>Last Name <span>*</span></p>
         <?php echo $this->Form->input('lastname', array('label'=>"",'type'=>'text','Placeholder'=>'lastname...','type'=>'text','class'=>'titleInput'));?>
          </label>
         
          <label>
          <p>Donation Amount <span>*</span> </p>
       <?php echo $this->Form->input('amount', array('label'=>"",'type'=>'text','Placeholder'=>'amount...','type'=>'text','class'=>'titleInput'));?>
          
          </label>

          <label>
          <div class="submit">
            <input type="submit" value=" Donate " id="donate">
          </div>
          </label>

		<?php echo $this->Form->end(); ?> 
		</div>
