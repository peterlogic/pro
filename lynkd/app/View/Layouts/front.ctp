<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<title><?php echo (isset($page_title) ? $page_title :  'Urlynkd') ?></title>
<meta name="description" content="<?php echo (isset($page_description) ? $page_description :  'Urlynkd') ?>">
<meta name="keywords" content="<?php echo (isset($page_keyword) ? $page_keyword :  'Urlynkd') ?>">
<!-- css file -->
<?php  echo $this->Html->css(array('front/style','front/jquery.jscrollpane')); ?>
<!-- Javascript file -->
<?php echo $this->Html->script(array('front/jquery-1.11.1.min','front/hammer.min','front/html5shiv','front/sidebar')); ?>
</head>
<body>
<header>
  <section class="wrapper">
    <div class="logo pull-left"><?php echo $this->Html->link($this->Html->image('logo.png',array('alt'=>'logo')),array('controller'=>'/'),array('escape'=>false)); ?></div>
    <section class="nav-search-outer nav-search-full pull-right">
      <nav class="pull-left">
        <?php echo $this->Element('header'); ?>
      </nav>
	  <?php if($this->Session->check('Auth.User')) { ?>
		<div class="profileUser"> 
		 <?php  if (!empty($logged_user['User']['profile_image'])) { ?>
		<img alt="profile_pic" src="<?php echo FULL_BASE_URL.$this->webroot."files".DS."profileimage"."/".@$logged_user['User']['profile_image'];?>">  <?php } else{ ?>
		<img alt="profile_pic"   src="<?php  echo $base_url;?>/files/profileimage/user.png">
	<!-- 	<img alt="" src="http://dev414.trigma.us/lynkd/files/profileimage/user.png">-->
		<?php } ?>
		<a href="#" class="ckl"><?php echo $logged_user['User']['name']; ?></a>
        <div class="profile-down-window" style="display: none;">
        <ul class="dropdown-menu with-arrow">

					<li class="user"><?php echo $this->Html->link('My Profile',array('controller'=>'users','action'=>'profile'),array('class'=>'user')); ?></li>
					<li class="user"><?php echo $this->Html->link('Posts',array('controller'=>'blogs','action'=>'index'),array('class'=>'user')); ?></li>
					<li class="user"><?php echo $this->Html->link('Messages',array('controller'=>'Inboxes','action'=>'inbox'),array('class'=>'user')); ?></li>
					<li class="user"><?php echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout'),array('class'=>'user')); ?></li>	
             <!-- <li><a href="#1" class="logout"> Logout</a> </li> -->
              </ul>
          </div>
        </div>
	  <?php } ?>
	    <!--------------------------------------------------------- search blog  section start---------------------------------------------------------------------->
	   <aside class="search-box pull-left">
	  <?php echo $this->Form->create('Blog',array('url'=>array('controller'=>'Homes','action'=>'search'),'type' => 'GET')); ?>
	 <input name="tb" type="text"    placeholder="Search Blog" class="inputbox pull-left"   required ="required" />
     <input type="submit"  value="" class="search-btn pull-left" /> 
	  <?php echo $this->Form->end(); ?> 
	  </aside>
	   <!--------------------------------------------------------- search blog  section close---------------------------------------------------------------------->  
    </section>
  </section>
</header>
<!-- SIDEBAR -->
<div data-sidebar="true" class="sidebar-trigger">
    <a class="sidebar-toggle" href="#1">
        <span class="sr-only toggle-menu"></span>
 </a>
    <div class="sidebar-wrapper sidebar-default">
       <?php echo $this->Element('header'); ?>
    </div>
</div>
  <!--section here-->
  <?php echo $this->Session->flash(); ?>
  <?php echo $content_for_layout ?>
  <!--section here-->
  <!--footer here-->
  <footer>
  <?php echo $this->Element('footer'); ?>  
</footer>
<div class="donate-btn"><?php echo $this->Html->link('',array('controller'=>'users','action'=>'donation')); ?></div>
<?php echo $this->Html->script(array('front/jquery.mousewheel','front/jquery.jscrollpane.min','front/jquery.sumoselect')); ?>
<script type="text/javascript" >
			$(function()
			{
				$('.scroll-pane').jScrollPane();
			});
</script> 
<script type="text/javascript">
$(document).ready(function () {
			getFilterRecord();
            window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3 });
            window.test = $('.testsel').SumoSelect({okCancelInMulti:true });

		$(".ckl").click(function() {
			$(".profile-down-window").slideToggle();
		});
		
		$('#flashMessage').fadeOut(4000);

		$("#showcaht_btn").click(function () {
				$('.online_users').slideToggle();
		});
});

	function set_filter_country_zipcode(){
			var inputId = $("#zip").val();
			$.ajax({
				type:'get',
				url:'<?php  echo Router::url(array('controller'=>'blogs','action'=>'get_filter_result_from_zip'),true);?>/'+inputId,
				success: function(result){
						$("#bulletin-search").html(result);
						$("#filter-tt").hide();
				}
			});
			return false;
	}
	
	$("#rangeSelection").change(function(){
		var rangeSelected = $(this).val();
			$.ajax({
				type:'get',
				url:'<?php  echo Router::url(array('controller'=>'blogs','action'=>'get_filter_result_from_range'),true);?>/'+rangeSelected,
				success: function(result){
						$("#bulletin-search").html(result);
						$("#filter-tt").hide();
				}
			});
		
		return false;	
	});
	
	
	$("#catID").change(function(){
		var catSelected = $(this).val();
			$.ajax({
				type:'get',
				url:'<?php  echo Router::url(array('controller'=>'blogs','action'=>'get_filter_result_from_category'),true);?>/'+catSelected,
				success: function(result){
						$("#bulletin-search").html(result);
						$("#filter-tt").hide();
				}
			});
		
		return false;	
	});
	function getFilterRecord(){
			$.ajax({
				type:'get',
				url:'<?php  echo Router::url(array('controller'=>'blogs','action'=>'get_filter_result'),true);?>',
				success: function(result){
						$("#bulletin-search").html(result);
						$("#filter-tt").hide();
				}
			});
	}
		
	function blogType1(type){
			$.ajax({
				type:'get',
				url:'<?php  echo Router::url(array('controller'=>'blogs','action'=>'get_blog_type1'),true);?>/'+type,
				success: function(result){
						$("#bulletin-search").html(result);
						$("#filter-tt").hide();
				}
			});
	}
	
	function blogType2(type){
			$.ajax({
				type:'get',
				url:'<?php  echo Router::url(array('controller'=>'blogs','action'=>'get_blog_type2'),true);?>/'+type,
				success: function(result){
						$("#bulletin-search").html(result);
						$("#filter-tt").hide();
				}
			});
	}
	
	function blogType3(type){
			$.ajax({
				type:'get',
				url:'<?php  echo Router::url(array('controller'=>'blogs','action'=>'get_blog_type3'),true);?>/'+type,
				success: function(result){
						$("#bulletin-search").html(result);
						$("#filter-tt").hide();
				}
			});
	}

</script>   
<?php  if($this->Session->check('Auth.User')) { ?>
 <?php echo $this->Element('chat'); ?>   
 <?php } ?>
<body>
</html>