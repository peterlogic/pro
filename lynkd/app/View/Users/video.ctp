<section class="wrapper">
  <section class="mid-cnt"> 
  	<?php echo $this->Session->flash(); ?>
	<?php  echo $this->Element('video_sidebar');?>


   <section class="mid-right"> 
				<div style="display: none;" class="overlayIcon"></div>
				<div id="inbox" style="display: block;">
					<div class="rightCol">
					
				
				
				<div class="blueHeading">Video  <div class="vedioside"><?php if($this->Session->check('Auth.User.id')) { ?>
				<div class="likes pull-left">
				<?php
					/********* Returning the ajax response  *******/
					 $user_id = $this->Session->read('Auth.User.id');
					$video_id = $video['Video']['id'];
						 if(!empty($video['VideoLike']))
						 {
								$a = 'no';
								
								foreach($video['VideoLike'] as $val)
								{	
									if($val['video_id']==$video_id && $val['user_id'] == $user_id)
									{
										$a = 'yes';
									}
								}  
								if($a=='yes')
								{ 
									?><a class="afterlike"  id ="<?php echo $video['Video']['id'];?>"></a> <?php
								} 
								else 
								{ 
									?><a class="afterlike"   id="tfterlike_<?php echo $video['Video']['id'];?>" style="display:none;" id ="<?php echo $video['Video']['id'];?>">
									<a onclick="get_like(<?php echo $video['Video']['id'];?>)" class="like"   id ="like_<?php echo $video['Video']['id'];?>"></a><?php
								}
							} 
				
				else{
								?><a class="afterlike"   id="tfterlike_<?php echo $video['Video']['id'];?>" style="display:none;" id ="<?php echo $video['Video']['id'];?>">
								<a  onclick="get_like(<?php echo $video['Video']['id'];?>)" class="like"   id ="like_<?php echo $video['Video']['id'];?>"></a><?php
							}	
							?>	
				
				
				<span id="output">
					<!---------------------------------- blog like users  popup start ------------------------------------------------------>
					<?php 
					if(count($video['VideoLike'])!=0) 
					{
						?><a  onclick = "getblog_id(<?php echo $video['Video']['id']; ?>)"  class="before_like_<?php echo $video['Video']['id']; ?>" href="javascript:void(0);" ><?php echo count($video['VideoLike']); ?></a><?php
					}
					else
					{
						?><a  href = "javascript:void(0)"  class="before_like_<?php echo $video['Video']['id']; ?>" href="javascript:void(0);" ><?php echo count($video['VideoLike']); ?></a><?php
					}
					?>
					
					
					<!------------------------------------ blog like users  popup  close---------------------------------------------------------------------------------->				
					<a onclick = "getblog_id(<?php echo $video['Video']['id']; ?>)" class="after_like_<?php echo $video['Video']['id']; ?>" href="javascript:void(0);" ></a>
				</span>
			</div> <?php 
			} 
			
			else {?>
			<!-- --------------------------------- --------------------------------------without login message popup start  ------------------------------------------------------------------>
					 <div class="likes pull-left">
					 <a class="like"  id ="<?php echo $video['Video']['id'];?>" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block' " ></a>
					 <span id="output">
					 <a  <?php if(count($video['VideoLike']) > 0){ ?>onclick = "getblog_id(<?php echo $video['Video']['id']; ?>)" <?php } ?>  href="javascript:void(0);" ><?php echo count($video['VideoLike']); ?></a>
					 
					</span></div>  
					 
			   <div id="light" class="white_content2"><div class="faurate">Please Login first to like this blog.. !! <?php echo $this->Html->link('Login',array('controller'=>'users','action'=>'login'),array('class'=>'login')); ?>  <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" class="change-image-close"  >Close</a></div></div>
				<div id="fade" class="black_overlay"></div>
	<!-- ------------------------------------------------------------------------------------------- without login message popup start  ------------------------------------------------------------------>
			<?php } ?></div> </div>
					<!---- ------------------------------------------------- like section  start ------------------------------------ -------------------------------------------------------------------->		
			
			
			
			
						
			<!---- ------------------------------------------------- like section  close ------------------------------------ -------------------------------------------------------------------->	
					
					
					
						<div class="messageInfo">
						<video width="100%"   controls>
						<source src=" <?php  echo FULL_BASE_URL . $this->webroot.'files'.DS.'video'.'/'. $video['Video']['video']; ?>" type="video/mp4">			
						</video>
						
							
		
		 
		<div class="comment-box-outer">
        <div class="displaycomment">
          <center> <?php echo $this->Html->image('ajax-loader.gif',array('alt'=>'')); ?></center>
      </div>
            
            <section class="write-comment-cnt">
            <div class="writer-heading">Leave a comment</div>
               
               <?php
               if($logged_user)
			   {
			   ?> 
			          <div class="wait" align="center"></div>
			          <div class="errorMsg" align="center" style="display:none;border: 0px solid green;color: red;float: left;margin: 9px 0 5px;padding: 10px;width: 96%;">Please fill the commment</div>
			          <div class="success" align="center" style="display:none;border: 0px solid green;color: green;float: left;margin: 9px 0 5px;padding: 10px;width: 96%;"> Message Post Successfully</div>
			       <?php echo $this->Form->create('CommentVideo',array('controller'=>'Users','action'=>'video_comment','id'=>'comment'),$type = 'post'); ?>    
									<div class="fullWidth">
										<textarea id="commentField" name="data[CommentVideo][comment]" placeholder="Comment" style="color:#474245;"></textarea>
										 
									</div>
										<input type="hidden" name="data[CommentVideo][video_id]" value="<?php echo $video['Video']['id'] ?>"/>
										<input type="hidden" name="data[CommentVideo][created]" value="<?php echo date("dd/mm/Y H:i:s"); ?>"/>
									<div class="fullWidth1">
									     <input type="button" value="Submit" class="submit-btn" />
										
									</div>
				  </form>
                <?php }else{ ?>
				 <div class="fullWidth1">
                <a href="<?php echo $base_url; ?>/users/login" class="submit-btn" style="text-decoration:none;" />Please login for comment </a>
                </div>
				<?php } ?>
            </section>
        </div>
			</div>
			</div>
			</div>
				
            </section>
				<?php echo $this->Element('friend_section'); ?>
  </section>
</section>

  
<script type="text/javascript">

function get_like(id)
{
		$( ".like" ).prop( "disabled", true );
		var $user = '<?php echo $this->Session->read('Auth.User.id') ?>';
		 if( $user !='')
		 {
				$.ajax({
									type:'POST',
									url:'<?php echo $this->Html->url(array('controller'=>'Users','action' => 'video_like')); ?>',
									data:{id :id},
									success:function(data)
									{										
											$("#like_"+id).hide();											
											$("#tfterlike_"+id).show();											
											$("#alreadylike_"+id).show();											
											$(".before_like_"+id).hide();											
											$(".after_like_"+id).html(data);
											$(".after_like_"+id).show();									
									}
						});			
				
		}
}

   function postcomment()
   {
	    var video_id = <?php echo $video['Video']['id']?>;
		  
			
			$.ajax({
				type: "POST",
				url: '<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'postcomment'));?>',
				data: 'video_id='+video_id,
				success: function(data) 
				{
					$('.displaycomment').html(data);
				}
			});
    }
	
	
$(document).ready(function() {
   postcomments = setInterval('postcomment()',5000);
   

	$(".submit-btn").click(function() {
	
		var getComment = $('textarea#commentField').val();
		if(getComment==''){
			$('.errorMsg').show();
		}
		else{
			$.ajax({
				beforeSend: function() {
					$('.wait').html('<img src="http://www.ajaxload.info/cache/FF/FF/FF/00/00/00/1-0.gif"/>');
				},  
				type: "POST",
				url: '<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'video_comment'));?>',
				data: 'comment='+getComment+'&video_id='+<?php echo $video['Video']['id'] ?>,
				success: function(data) 
				{
					$('.errorMsg').hide();
					$(".success").show(function(){setInterval($(".success").hide(),20000);});
					$('.wait').hide();
					$('#commentField').val('');					
				}
			});
		}
		
	});
	
});
</script>    