<?php
function curPageURL() {
 $pageURL = 'http';
 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

$cur = curPageURL();
?>
<section class="wrapper">
  <section class="mid-cnt"> 
    <!--  left sidebar start -->
      <!--  left sidebar start -->
    <aside class="blog-left">
<div class="post-home-box">
        <?php if($blog['Blog']['image'] != ''){ ?><div class="post-home-img"><?php echo $this->Html->image('../files/blogimages/'.$blog['Blog']['image'],array('alt'=>'blog_pic')); ?></div><?php } ?>
        <div class="post-home-content-cnt">
          <div class="post-home-heading"><?php echo $blog['Blog']['title']; ?></div>
                       <?php echo $blog['Blog']['description']; ?>
				<?php  if($blog['Blog']['tags'] != ''){ ?>	  
				
                <div class="tags-outer"><span class="tag-icon">TAGS :</span>
                <div class="tag-listing">
               <ul>
			<?php $tags = $blog['Blog']['tags']; 
			        $exp = explode(',',$tags);
					foreach($exp as $ex){
			 ?>
                <li><a href="<?php echo $base_url;?>/blogs/tag/<?php echo $ex;?>"><?php echo $ex; ?></a></li>
                <?php } ?>
                </ul>
            </div>
            </div>
			<!-- -------------------category-------------------->
			
			<div class="tags-outer" ><span class="tag-icon">Category :</span>
                <div class="tag-listing">
               <ul>
				<?php 
				$tags = $blog['BlogCategory'];
				 foreach($tags as $list)
				{ 
					?><li><?php echo $list['Category']['title']; ?></li><?php	
				} 
				?>
                </ul>
            </div>
            </div>
			
		
			<!---- ----------------cate--------------------------->
			
			
			
			<!-- ---------------------date------------------>
			
			<div class="tags-outer" ><span class="tag-icon">Date :</span>
                <div class="tag-listing">
              <?php $dateTime = $blog['Blog']['created']; 
						$dt = new DateTime($dateTime);
						$date = $dt->format('m/d/Y');
					//	$time = $dt->format('H:i:s');
						//echo $date, ' | ', $time;
						echo $date;
			  ?>
            </div>
            </div>
			
			
			<!---- ------------------------------------------->
			
			<?php } ?>
            <div class="pre-next-cnt"> 
				<?php 
					######### Link for previous blog ##################
					if(!empty($getPreviousID)){
						echo $this->Html->link('Previous',array('controller'=>'blogs','action'=>'view',$getPreviousID),array('title'=>'Previous','class'=>'pre-icon'));
					}
					######### Link for previous blog ##################
					if(!empty($getNextID)){
						echo $this->Html->link('Next',array('controller'=>'blogs','action'=>'view',$getNextID),array('title'=>'Next','class'=>'next-icon'));
					}
				?>
            </div>
        </div> 
      </div>
	  	<?php  if($blog['Blog']['blogtype_three'] == ''){?>
    <div class="written-cnt">
			<div class="writer-image">
				<?php  
				
				if (!empty($blog['User']['profile_image'])) { ?>
					<img alt="profile_pic" class="blogimage" src="<?php echo FULL_BASE_URL.$this->webroot."files".DS."profileimage"."/".@$blog['User']['profile_image'] ?>" ><?php 
				} 
				else{

				?><img alt="profile_pic"  class="blogimage" src="<?php  echo $base_url;?>/files/profileimage/user.png"><?php
				} 
				?></div>
	
        <div class="writer-content" >
			<div class="writer-heading">Written by <span><?php echo $blog['User']['name']; ?></span></div>
            <p><?php echo $blog['User']['summary']; ?></p>            
              <div class="writer-social">
				<ul>
					<li><a class="fb"  href="http://www.facebook.com/sharer.php?u=<?php echo $cur; ?>"></a></li>
					<li><a class="twitter"  href="http://twitter.com/share?text=<?php echo $blog['Blog']['title']; ?>&url=<?php echo $cur; ?>"></a></li>
					<li><a class="gplus"  href="https://plus.google.com/share?url=<?php echo $cur; ?>"></a></li>
					<!--<li><a class="youtube" href="#1"></a></li>-->
				</ul>
			</div>
        </div>
		
    </div><?php } ?>
     
     
        <div class="comment-box-outer">
        <div class="displaycomment">
          <center> <?php echo $this->Html->image('ajax-loader.gif',array('alt'=>'')); ?></center>
      </div>
            
            <section class="write-comment-cnt">
            <div class="writer-heading">Leave a comment</div>
               
          
               <?php
               if($logged_user){
			   ?> 
			          <div class="wait" align="center"></div>
			          <div class="errorMsg" align="center" style="display:none;border: 0px solid green;color: red;float: left;margin: 9px 0 5px;padding: 10px;width: 96%;">Please fill the commment</div>
			          <div class="success" align="center" style="display:none;border: 0px solid green;color: green;float: left;margin: 9px 0 5px;padding: 10px;width: 96%;"> Message Post Successfully</div>
			       <?php echo $this->Form->create('Comment',array('controller'=>'Comments','action'=>'add','id'=>'comment'),$type = 'post'); ?>    
									<div class="fullWidth">
										<textarea id="commentField" name="data[Comment][comment]" placeholder="Comment" style="color:#474245;"></textarea>
										 
									</div>
										<input type="hidden" name="data[Comment][blog_id]" value="<?php echo $blog['Blog']['id'] ?>"/>
										<input type="hidden" name="data[Comment][created]" value="<?php echo date("dd/mm/Y H:i:s"); ?>"/>
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
    </aside>
    <!--  left sidebar end -->
        <?php echo $this->Element('blog_right'); ?>
  </section>
</section>
    
<script type="text/javascript">
  function postcomment(){
         var blog_id = <?php echo $blog['Blog']['id'] ?>;
        $.get('<?php echo $base_url; ?>/Comments/postcomment',{'blog_id':blog_id},function(d){            
            d = JSON.parse(d); 
            var x = '';
			x+= ' <div class="writer-heading">'+d.length+' comments</div>';
            for(var i = 0; i < d.length;i++){
            x += '<div class="comment-box">';
            x += '<div class="comment-img">';
			if(d[i].User.profile_image){
			     x += '<img src="<?php echo $base_url; ?>/files/profileimage/'+d[i].User.profile_image+'"/>';
			}else{
                x += '<?php echo $this->Html->image('comment-person-img.jpg',array('alt'=>'')); ?>';
			}
            x += '</div>';         
            x += ' <div class="comment-content">';
            x += ' <div class="comment-heading">'+d[i].User.name+'</div>';
            x += '   <div class="comment-date">'+d[i].Comment.created+'</div>';                    
            x += '   <p>'+d[i].Comment.comment+'</p>';                                      
            x += '   </div>';                
           x += ' </div>';
            }
                $('.displaycomment').html(x); 
        });
          
    }
	
	
$(document).ready(function() {
   postcomments = setInterval('postcomment()',5000);
	/* Ajax here */
	$(".submit-btn").click(function() {
	
		var getComment = $('textarea#commentField').val();
		if(getComment==''){
			$('.errorMsg').show();
		}
		else{
			//alert(getComment );
			$.ajax({
				beforeSend: function() {
					$('.wait').html('<img src="http://www.ajaxload.info/cache/FF/FF/FF/00/00/00/1-0.gif"/>');
				},  
				type: "POST",
				url: '<?php echo $this->Html->url(array('controller' => 'Comments', 'action' => 'add'));?>',
				data: 'comment='+getComment+'&blog_id='+<?php echo $blog['Blog']['id']; ?>,
				success: function(data) {
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