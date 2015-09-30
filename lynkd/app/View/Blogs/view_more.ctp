
<section class="wrapper">
  <section class="mid-cnt"> 
    <!--  left sidebar start -->
      <!--  left sidebar start -->
    <aside class="blog-left">
<div class="post-home-box">
        <div class="post-home-img"></div>
        <div class="post-home-content-cnt">
				<h2>Tags</h2>
				<div class="tag-listing marginTop10">
				
					<ul>
					<?php     foreach($types as $key=>$val)
						{  if($val != "")
							{ ?>
						<li><a href="<?php echo $base_url;?>/blogs/tag/<?php echo $val;?>"><?php echo $val; ?></a></li>
					<?php } 
						} ?>
						</ul>
			  </div>
        </div>
    

    
    
      </div>
    
            
     
     
        <!-- <div class="comment-box-outer">
        
            
           
            
        </div> -->
        
        
        
    </aside>
    <!--  left sidebar end -->
        <?php echo $this->Element('blog_right'); ?>

  </section>
</section>
<div class="donate-btn"><a href="#"></a></div>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script> 
<!-- the jScrollPane script --> 
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
<script src="js/jquery.sumoselect.js"></script>
<script type="text/javascript" >
			$(function()
			{
				$('.scroll-pane').jScrollPane();
			});
</script> 
<script type="text/javascript">
        $(document).ready(function () {
            window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
            window.test = $('.testsel').SumoSelect({okCancelInMulti:true });
        });
</script>
    
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
	$(".ckl").click(function() {
		$(".profile-down-window").slideToggle("fast");
	});	
	$(".profile-down-window").hide("fast");   
	
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