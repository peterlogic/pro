<div class="inboxes form">
<?php echo $this->Form->create('Inbox'); ?>
	<fieldset>
		<legend><?php echo __('Edit Inbox'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('to');
		echo $this->Form->input('user_id');
		echo $this->Form->input('subject');
		echo $this->Form->input('message');
		echo $this->Form->input('status');
		echo $this->Form->input('date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Inbox.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Inbox.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Inboxes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
