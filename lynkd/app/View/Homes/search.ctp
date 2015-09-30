<section class="wrapper">
 <div class="clear"></div>

  <section class="mid-cnt"> 
  <?php echo $this->Session->flash(); ?>
    <!--  left sidebar start -->
    <?php echo $this->Element('left_sidebar'); ?>
    <!--  left sidebar end -->
    <section class="mid-right"> 
	<?php if(!empty($blog_list)) { ?>
	<?php  foreach($blog_list as $blog){
	?>
      <div class="post-home-box">
	  
        <?php if($blog['Blog']['image'] != ''){ ?> <div class="post-home-img"><?php echo $this->Html->image('../files/blogimages/'.$blog['Blog']['image'],array('alt'=>'blog_image')); ?></div><?php } ?>
        <div class="post-home-content-cnt">
          <div class="post-home-heading"><?php echo $this->Html->link($blog['Blog']['title'],array('controller'=>'blogs','action'=>'view',$blog['Blog']['id'])); ?></div>
          <p><?php echo (strlen(strip_tags($blog['Blog']['description']))>600 ? substr(strip_tags($blog['Blog']['description']),0,600).'...' : strip_tags($blog['Blog']['description'])); ?></p>
          <div class="post-home-bottom">
            <div class="post-home-bottom-left"> <?php echo $this->Html->link('Read more..',array('controller'=>'blogs','action'=>'view',$blog['Blog']['id'])); ?>
              <div class="time-txt"><?php echo $this->Time->timeAgoInWords($blog['Blog']['created']); ?></div>
			   <?php  if($blog['Blog']['miles_difference'] !=0 ) {?><div class="time-txt"><?php echo $blog['Blog']['miles_difference'].' miles'; ?></div><?php } ?>
            </div> 
            <div class="post-home-bottom-right">
			<?php if($this->Session->check('Auth.User.id')) { ?>
			<div class="likes pull-left">
					<?php
					/********* Returning the ajax response  *******/
					//echo '<a class="alreadylike" id="alreadylike_'.$blog['Blog']['id'].'" style="display:none;"></a>';
						$Blog_id = $blog['Blog']['id'];
						 if(!empty($blog['Like'])){
							$a = 'no';
							foreach($blog['Like'] as $val){
								//debug($val);exit;							
								if($val['blog_id']==$Blog_id && @$val['user_id'] == @$this->Session->read('Auth.User.id')){
									$a = 'yes';
								}
							}   if($a=='yes'){ ?><a class="afterlike"    id ="<?php echo $blog['Blog']['id'];?>"></a> <?php } else { ?>
							<a class="afterlike"   id="tfterlike_<?php echo $blog['Blog']['id'];?>" style="display:none;" id ="<?php echo $blog['Blog']['id'];?>">
							<a onclick="get_like(<?php echo $blog['Blog']['id'];?>)" class="like"   id ="like_<?php echo $blog['Blog']['id'];?>"></a>
						<?php } } else{
							
							?>
							<a class="afterlike"   id="tfterlike_<?php echo $blog['Blog']['id'];?>" style="display:none;" id ="<?php echo $blog['Blog']['id'];?>">
							<a  onclick="get_like(<?php echo $blog['Blog']['id'];?>)" class="like"   id ="like_<?php echo $blog['Blog']['id'];?>"></a>
						<?php	}	?>	
				<span id="output">
				<a class="before_like_<?php echo $blog['Blog']['id']; ?>" href="javascript:void(0);" ><?php echo count($blog['Like']); ?></a>		
				<a class="after_like_<?php echo $blog['Blog']['id']; ?>" href="javascript:void(0);" ></a>					
				</span>
			</div> 
		
			<?php } else {?>
			<!-- --------------------------------- --------------------------------------without login message popup start  ------------------------------------------------------------------>
					 <div class="likes pull-left"><a class="like"  id ="<?php echo $blog['Blog']['id'];?>" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'" ></a><span id="output"><a href="javascript:void(0);" ><?php echo count($blog['Like']); ?></a></span></div>  
					 
			   <div id="light" class="white_content2"><div class="faurate">Please Login first to like this blog.. !! <?php echo $this->Html->link('Login',array('controller'=>'users','action'=>'login'),array('class'=>'login')); ?>  <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" class="change-image-close"  >Close</a></div></div>
				<div id="fade" class="black_overlay"></div>
				
	<!-- ------------------------------------------------------------------------------------------- without login message popup start  ------------------------------------------------------------------>
			<?php } ?>
              <div class="comment pull-left"><a class="comment" href="<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'view',$blog['Blog']['id'])); ?>"></a><span><a href="javascript:void(0);"><?php echo count($blog['Comment']); ?></a></span></div>
            </div>
          </div>
        </div>
      </div>

	  <?php  } ?>
	  <div class="pagination">

	<?php  if($this->Paginator->hasPrev()){
	echo $this->Paginator->prev('&laquo;', array( 'tag' => 'false', 'escape' => false), null, array('class' => 'prev disabled prv' ,'tag' => 'false', 'escape' => false));
	}
    echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'false' ,'currentClass' => 'active', 'currentTag' => 'a' , 'escape' => false));
	if($this->Paginator->hasNext()){
    echo $this->Paginator->next('&raquo;', array( 'tag' => 'false', 'escape' => false), null, array('class' => 'next disabled nxt' ,'tag' => 'false', 'escape' => false)); 
	}
	?>
      </div>
	<?php   } else { ?>
	 <div class="post-home-box">
        <div class="post-home-img" ><?php echo "No blog found for this search.."; }?></div>
        <div class="post-home-content-cnt">
	  </div>
</div>      
	  
    </section>
  </section>
</section>

<script type="text/javascript">
function get_like(id){
		//$('.likes a').css('background-image','../.../img/heart.png');
		//$(this).attr("src","img/heart.png");
		$( ".like" ).prop( "disabled", true );
		var $user = '<?php echo $this->Session->read('Auth.User.id') ?>';
		 if( $user !='')
		 {
				$.ajax({
									type:'POST',
									url:'<?php echo $this->Html->url(array('controller'=>'Blogs','action' => 'like')); ?>',
									data:{id :id},
									success:function(data)
									{
											//alert(data);
											//$(".afterlike").hide();											
											$("#like_"+id).hide();											
											$("#tfterlike_"+id).show();											
											$("#alreadylike_"+id).show();											
											$(".before_like_"+id).hide();											
											$(".after_like_"+id).html(data);
											$(".after_like_"+id).show();
											//$('.like a').css({backgroundImage: "url("+none+")"});										
									}
						});			
				
		}
}
</script>