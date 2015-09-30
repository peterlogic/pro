<div class="connections view">
<h2><?php  echo __('Connection'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($connection['Connection']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($connection['User']['email'], array('controller' => 'users', 'action' => 'view', $connection['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Connectedwith'); ?></dt>
		<dd>
			<?php echo h($connection['Connection']['connectedwith']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($connection['Connection']['notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($connection['Connection']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Connection'), array('action' => 'edit', $connection['Connection']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Connection'), array('action' => 'delete', $connection['Connection']['id']), null, __('Are you sure you want to delete # %s?', $connection['Connection']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Connections'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Connection'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
