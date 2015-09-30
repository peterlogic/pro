<?php echo $this->Html->css('front/jquery-ui.css'); ?>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<div class="friend-search-main">
<div class="friend-search">
<?php echo $this->Form->create('User',array('controller'=>'users','action'=>'get_profile_link'));  ?>
<?php echo $this->Form->input('friends',array('label'=>false,'placeholder'=>'Find friends','id'=>'tt','div'=>false)); ?>
<button style="display:none;" data-bhw="LocationBarFindDeals" type="submit"></button>
<?php echo $this->Form->end(); ?>
</div>

</div>
<script type="text/javascript">
$(function() {
$( "#tt" ).autocomplete(
	{
			source:'<?php echo Router::url(array('controller'=>'users','action'=>'get_user_lists'),true); ?>',
			minLength: 1,
			select: function(event, ui) {
				//assign value back to the form element
				if(ui.item){
					$(event.target).val(ui.item.value);
				}
				//submit the form
				$(event.target.form).submit();
			}
	});
});
</script>