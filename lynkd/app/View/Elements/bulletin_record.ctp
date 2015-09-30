<div class="mid-left-heading">Bulletin</div>
<div class="filter-main-div">
<div class="overly" id="filter-tt">
<div class="loader"></div>
</div>

<section class="news-feed-listing scroll-pane">

<ul>
<?php  //debug($blogData); ?>
<?php if($type == 'simple'){ ?>
<?php if(!empty($blogData)){ ?>
	<?php $i = 0; foreach($blogData as $bd){ 
		
		
		if($this->Session->check('filter.range') && ($bd['Blog']['miles_difference']  <= $this->Session->read('filter.range') )){ 
		$i=$i+1; 	
		//echo $i;
		?>
			<li>
				<a href="<?php echo ($bd['Blog']['user_id'] != 0?$this->Html->url(array('controller'=>'blogs','action'=>'view',$bd['Blog']['id'])): $this->Html->url(array('controller'=>'users','action'=>'video',$bd['Blog']['video_id']))); ?>">
						<?php if($bd['Blog']['user_id'] == 0){  ?><div class="listing-image"><?php echo $this->Html->image('video-icon.png',array('alt'=>'video')); ?></div><?php } 
						else if($bd['Blog']['image'] != ''){?><div class="listing-image"><?php echo $this->Html->image('/files/blogimages/'.$bd['Blog']['image'],array('alt'=>$bd['Blog']['title'])); ?></div><?php } 
						else { ?><div class="listing-image"></div><?php } ?>
						<div class="news-feed-content">
								<div class="news-feed-description"><?php echo ($bd['Blog']['user_id'] != 0 ?$bd['Blog']['title']: ucfirst($bd['WhereUser']['name']).' '.ucfirst($bd['WhereUser']['last_name']).' has uploaded a video in his profile'); ?></div>
								<div class="news-feed-time"><?php echo $this->Time->timeAgoInWords($bd['Blog']['created']); ?></div>
								<?php  if($bd['Blog']['miles_difference'] !=0 ) {?><div class="news-feed-time"><?php echo $bd['Blog']['miles_difference'].' miles'; ?></div><?php } ?>
						</div>
				</a>
			</li>	
		<?php }  else if(!$this->Session->check('filter.range') && ($bd['Blog']['miles_difference'] <= $bd['Mile']['to'] )){ $i=$i+1;		?>
		<li>
				<a href="<?php echo ($bd['Blog']['user_id'] != 0?$this->Html->url(array('controller'=>'blogs','action'=>'view',$bd['Blog']['id'])): $this->Html->url(array('controller'=>'users','action'=>'video',$bd['Blog']['video_id']))); ?>">
						<?php if($bd['Blog']['user_id'] == 0){  ?><div class="listing-image"><?php echo $this->Html->image('video-icon.png',array('alt'=>'video')); ?></div><?php } 
						else if($bd['Blog']['image'] != ''){?><div class="listing-image"><?php echo $this->Html->image('/files/blogimages/'.$bd['Blog']['image'],array('alt'=>$bd['Blog']['title'])); ?></div><?php } 
						else { ?><div class="listing-image"></div><?php } ?>
						<div class="news-feed-content">
								<div class="news-feed-description"><?php echo ($bd['Blog']['user_id'] != 0 ?$bd['Blog']['title']: ucfirst($bd['WhereUser']['name']).' '.ucfirst($bd['WhereUser']['last_name']).' has uploaded a video in his profile'); ?></div>
								<div class="news-feed-time"><?php echo $this->Time->timeAgoInWords($bd['Blog']['created']); ?></div>
								<?php  if($bd['Blog']['miles_difference'] !=0 ) {?><div class="news-feed-time"><?php echo $bd['Blog']['miles_difference'].' miles'; ?></div><?php } ?>
						</div>
				</a>
		</li>
		
		<?php  } }  ?>  
		<?php if($i == 0){
		?>
				<li>No records found</li>
		<?php } ?>
		<?php }  else { ?>	
		<li>No records found</li>
	<?php  } ?>	
	<?php } else { ?>
		<?php if(!empty($blogData)){ ?>
	<?php $i = 0; foreach($blogData as $bd){ 
		
		?>
			<li>
				<a href="<?php echo ($bd['Blog']['user_id'] != 0?$this->Html->url(array('controller'=>'blogs','action'=>'view',$bd['Blog']['id'])): $this->Html->url(array('controller'=>'users','action'=>'video',$bd['Blog']['video_id']))); ?>">
						<?php if($bd['Blog']['user_id'] == 0){  ?><div class="listing-image"><?php echo $this->Html->image('video-icon.png',array('alt'=>'video')); ?></div><?php } 
						else if($bd['Blog']['image'] != ''){?><div class="listing-image"><?php echo $this->Html->image('/files/blogimages/'.$bd['Blog']['image'],array('alt'=>$bd['Blog']['title'])); ?></div><?php } 
						else { ?><div class="listing-image"></div><?php } ?>
						<div class="news-feed-content">
								<div class="news-feed-description"><?php echo ($bd['Blog']['user_id'] != 0 ?$bd['Blog']['title']: ucfirst($bd['WhereUser']['name']).' '.ucfirst($bd['WhereUser']['last_name']).' has uploaded a video in his profile'); ?></div>
								<div class="news-feed-time"><?php echo $this->Time->timeAgoInWords($bd['Blog']['created']); ?></div>
								<?php  if($bd['Blog']['miles_difference'] !=0 ) {?><div class="news-feed-time"><?php echo $bd['Blog']['miles_difference'].' miles'; ?></div><?php } ?>
						</div>
				</a>
			</li>	
		
		
		<?php }  ?>  
		
		<?php }  else { ?>	
		<li>No records found</li>
	<?php  } ?>
	<?php } ?>
</ul>
</section>
</div>
