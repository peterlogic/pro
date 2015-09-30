<div class="writer-heading"><?php  echo count($res1)." "."Comment" ;?></div>
<?php
if(!empty($res1))
{ 
foreach($res1 as $comment)
{
?>

<div class="comment-box">

<?php if(!empty($comment['User']['profile_image'])) {?>

<div class="comment-img">
<img src="<?php echo FULL_BASE_URL.$this->webroot."files".DS."profileimage"."/".$comment['User']['profile_image'];?>">
</div> 
<?php }  else {?>
<div class="comment-img">
<img alt=""   src="<?php  echo $base_url;?>/files/profileimage/user.png">
</div> 
<?php } ?>
<div class="comment-content"> 
<div class="comment-heading"><?php echo $comment['User']['name'];  ?></div>  
<div class="comment-date"><?php echo $comment['User']['created'];  ?></div> 

<p><?php echo $comment['CommentVideo']['comment']; ?></p>  
 </div>
 </div>
 
<?php } } ?>