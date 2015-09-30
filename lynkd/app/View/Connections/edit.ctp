<div class="connections form">
<?php echo $this->Form->create('Connection'); ?>
	<fieldset>
		<legend><?php echo __('Edit Connection'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('connectedwith');
		echo $this->Form->input('notes');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Connection.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Connection.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Connections'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
