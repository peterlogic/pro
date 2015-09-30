<script>
	$(document).ready(function(){
		getLocation();	
	});
	function getLocation()
	{
	  if (navigator.geolocation)
		{
		navigator.geolocation.getCurrentPosition(showPosition);
		}
	}
	function showPosition(position)
	{
		$.ajax({
			type:'get',
			url:'<?php  echo Router::url(array('controller'=>'blogs','action'=>'set_user_lat_long'),true);?>/'+position.coords.latitude+'/'+position.coords.longitude,
			success: function(result){
					//x.innerHTML="Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
			}
		});    
	}
</script>
<?php //debug($_SERVER); ?>
	<aside class="mid-left">
        
        <!-- filter start -->
             <div class="search-filter-cnt">
                 <div class="mid-left-heading2">Search filter <span><a href="<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'reset_session')); ?>">Clear</a></span></div>
                 
        <div class="width_100">
            <div class="search-outer">
                <input type="text" id="zip" value="<?php if($this->Session->check('filter.zip') && $this->Session->read('filter.zip') != ''){ echo $this->Session->read('filter.zip');} else { echo 'zip code, city, state, country.';} ?>" onfocus="if (this.value=='zip code, city, state, country.') this.value = ''" onblur="if (this.value=='') this.value = 'zip code, city, state, country.'" class="search-filter">
                <input type="button" class="filter-search-btn" value="Search" onclick="return set_filter_country_zipcode();"/>
            </div>
            </div>
                 
                 
                <div class="width_100">
				 <?php $rSelected = ($this->Session->check('filter.range') ? explode(',',$this->Session->read('filter.range')) : array() ); ?>
                     <label>Show in (miles)</label>
					<select multiple="multiple" placeholder="Select Range" class="SlectBox" id="rangeSelection">					
						<?php  foreach($milesList as $mile){ ?>
							<option  value="<?php  echo $mile['Mile']['to']; ?>" <?php echo (in_array($mile['Mile']['to'],$rSelected) ? "selected='selected'" : '') ?>><?php  echo $mile['Mile']['miles'];?></option>
						<?php } ?>
					</select>             
                </div>
				<div class="width100">
				<?php $cSelected = ($this->Session->check('filter.category') ? explode(',',$this->Session->read('filter.category')) : array() ); ?>
                     <label>Category</label>
                        <select multiple="multiple" placeholder="Select category" class="SlectBox" id="catID" >                       				
                        <?php foreach($blogCategoryList as $bc){ ?>
							<option value="<?php echo $bc['Category']['id']; ?>" onchange="return tt();" <?php echo (in_array($bc['Category']['id'],$cSelected) ? "selected='selected'" : '') ?>> <?php echo ucfirst($bc['Category']['title']); ?></option>
                        <?php } ?>
                         </select>
                </div>
                 
                 <div class="width100">
				  
						<label class="radio-input-div"> <input type="radio" onclick="return blogType1('Business');" value="Business" name="myradio1" <?php if($this->Session->check('filter.blogType1') && $this->Session->read('filter.blogType1') == 'Business'){ echo "checked='checked'";} ?> /> <span>Business</span></label>
						<label class="radio-input-div"> <input type="radio" onclick="return blogType1('Individual');" value="Individual" name="myradio1" <?php if($this->Session->check('filter.blogType1') && $this->Session->read('filter.blogType1') == 'Individual'){ echo "checked='checked'";} ?> /> <span>Individual</span></label>
						<label class="radio-input-div"> <input type="radio" onclick="return blogType1('Both');" value="Both" name="myradio1" <?php if($this->Session->check('filter.blogType1') && $this->Session->read('filter.blogType1') == 'Both'){ echo "checked='checked'";} ?> /> <span>Both</span></label>
                 </div>                 
                 <div class="width100">
						<label class="radio-input-div"> <input type="radio" onclick="return blogType2('Barter');" value="Barter" name="myradio2" <?php if($this->Session->check('filter.blogType2') && $this->Session->read('filter.blogType2') == 'Barter'){ echo "checked='checked'";} ?> /> <span>Barter</span></label>
						<label class="radio-input-div"> <input type="radio" onclick="return blogType2('Transactions');" value="Transactions" name="myradio2" <?php if($this->Session->check('filter.blogType2') && $this->Session->read('filter.blogType2') == 'Transactions'){ echo "checked='checked'"; } ?> /> <span>$ Transactions</span></label>
						<label class="radio-input-div"> <input type="radio"  onclick="return blogType2('Both');"  value="Both" name="myradio2" <?php if($this->Session->check('filter.blogType2') && $this->Session->read('filter.blogType2') == 'Both'){ echo "checked='checked'"; } ?> /> <span>Both</span></label>
                 </div>
                 <div class="width_100">
						<label class="radio-input-div"> <input type="radio" onclick="return blogType3('Annonymous');" value="Annonymous" name="myradio3" <?php if($this->Session->check('filter.blogType3') && $this->Session->read('filter.blogType3') == 'Annonymous'){ echo "checked='checked'"; } ?> /> <span>Annonymous</span></label>
                 </div> 
        
        </div>
        <!-- filter end -->
        
      <div id="bulletin-search">
	  <div id="fade" class="black_overlay"></div>
	  </div>
      <div class="mid-left-heading">Following</div>
      <div class="folowing-box">
	 
        <ul>
          <li><a href=""><?php echo $this->Html->image('following-pic-01.jpg',array('alt'=>'')); ?></a></li>
          <li><a href=""><?php echo $this->Html->image('following-pic-02.jpg',array('alt'=>'')); ?></a></li>
          <li><a href=""><?php echo $this->Html->image('following-pic-03.jpg',array('alt'=>'')); ?></a></li>
          <li><a href=""><?php echo $this->Html->image('following-pic-04.jpg',array('alt'=>'')); ?></a></li>
          <li><a href=""><?php echo $this->Html->image('following-pic-05.jpg',array('alt'=>'')); ?></a></li>
          <li><a href=""><?php echo $this->Html->image('following-pic-06.jpg',array('alt'=>'')); ?></a></li>
          <li><a href=""><?php echo $this->Html->image('following-pic-07.jpg',array('alt'=>'')); ?></a></li>
          <li><a href=""><?php echo $this->Html->image('following-pic-08.jpg',array('alt'=>'')); ?></a></li>
          <li><a href=""><?php echo $this->Html->image('following-pic-09.jpg',array('alt'=>'')); ?></a></li>        
        </ul>
      </div>
	  
	<!-- <div class="ad-img" ><?php //echo $this->Html->image('ad-img.jpg'); ?></div>  -->
	     <!--div class="ad-img" ><?php //echo $Site['Sitesetting']['adsense']; ?></div--> 
    </aside>