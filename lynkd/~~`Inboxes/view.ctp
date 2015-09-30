<div class="inboxes view">
<h2><?php  echo __('Inbox'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($inbox['Inbox']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('To'); ?></dt>
		<dd>
			<?php echo h($inbox['Inbox']['to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($inbox['User']['email'], array('controller' => 'users', 'action' => 'view', $inbox['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subject'); ?></dt>
		<dd>
			<?php echo h($inbox['Inbox']['subject']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Message'); ?></dt>
		<dd>
			<?php echo h($inbox['Inbox']['message']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($inbox['Inbox']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($inbox['Inbox']['date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Inbox'), array('action' => 'edit', $inbox['Inbox']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Inbox'), array('action' => 'delete', $inbox['Inbox']['id']), null, __('Are you sure you want to delete # %s?', $inbox['Inbox']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Inboxes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inbox'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
