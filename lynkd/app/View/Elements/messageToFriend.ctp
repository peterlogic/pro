<?php echo $this->Html->script(array('tiny_mce/tiny_mce'))?>
<?php echo $this->Html->css('front/jquery-ui.css'); ?>
<?php //echo $this->Html->script('jqueryValidate.js'); ?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 
<div class="blueHeading" id="newMessageLebel">New Message </div>
<div class="blueHeading" id="showsuccessmessage" style="display:none">Message submitted successfully</div>
<div class="messageInfo newmessage">
	<div class="viewform">
	<?php $getCurrentDate = date('Y-m-d H:i:s'); ?>
	<?php echo $this->Form->create('Inbox',array('controller'=>'Inbox','action'=>''));  ?>
	<?php echo $this->Form->input('to',array('label'=>false, 'class'=>'msgInput', 'placeholder'=>'To', 'id'=>'searchFriend', 'div'=>false,'required'=>true)); ?>
	<?php echo $this->Form->input('subject',array('label'=>false, 'class'=>'msgInput', 'placeholder'=>'Subject', 'id'=>'subject', 'div'=>false,'required'=>true)); ?>
	<?php echo $this->Form->hidden('from',array('value'=>$user_email)); ?>
	<?php echo $this->Form->hidden('status',array('value'=>'Unread')); ?>
	<?php echo $this->Form->hidden('date',array('value'=>$getCurrentDate)); ?>
	<?php echo $this->Form->input('message', array('label'=>false,'type'=>'textarea','id'=>'conta','class'=>'msgInput'));?>
	<?php echo $this->Form->button('Submit', array('id'=>'sendMsg','class'=>'sendBtn','onclick'=>'return sendMessageToUser()')); ?>
	 <?php //echo $this->Form->submit(__('Submit',true), array('id'=>'sendMsg','class'=>'sendBtn','onclick'=>'return sendMessageToUser()'));  ?>
	<?php echo $this->Form->end(); ?> 
	</div>
	<div class="viewmessage" style="display:none;">
	<p>Thank you! Your message has been successfully sent. Wait for user response, it can be taken some time!</p>
	</div>
</div> 





