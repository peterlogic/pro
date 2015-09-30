<div class="inboxes index">
	<h2><?php echo __('Inboxes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('to'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('subject'); ?></th>
			<th><?php echo $this->Paginator->sort('message'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($inboxes as $inbox): ?>
	<tr>
		<td><?php echo h($inbox['Inbox']['id']); ?>&nbsp;</td>
		<td><?php echo h($inbox['Inbox']['to']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($inbox['User']['email'], array('controller' => 'users', 'action' => 'view', $inbox['User']['id'])); ?>
		</td>
		<td><?php echo h($inbox['Inbox']['subject']); ?>&nbsp;</td>
		<td><?php echo h($inbox['Inbox']['message']); ?>&nbsp;</td>
		<td><?php echo h($inbox['Inbox']['status']); ?>&nbsp;</td>
		<td><?php echo h($inbox['Inbox']['date']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $inbox['Inbox']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $inbox['Inbox']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $inbox['Inbox']['id']), null, __('Are you sure you want to delete # %s?', $inbox['Inbox']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Inbox'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
