<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<?php echo $this->Html->script(array('jquery.tablednd'));?>
<script type="text/javascript">
$(function() {
	$(".tbl_repeat tbody").tableDnD({
		onDrop: function(table, row) {
			var orders = $.tableDnD.serialize();
			$.post('<?php echo Router::url(array('controller'=>'blogs','action'=>'sortRows'),true); ?>', { orders : orders });
		}
	});
});
</script>

<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-calendar"></span>Blog Management</span>
        <ul class="quickStats">
            <li>
				<?php echo $this->Html->link($this->Html->Image('../images/icons/quickstats/user.png'),'javascript:void();',array('escape'=>false,'border'=>'0','class'=>'blueImg')); ?>
                <div class="floatR"><strong class="blue"><?php echo $this->Paginator->counter('{:count}');?></strong><span>Blogs</span></div>
            </li>
        </ul>
    </div>
     <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li class="current"><a href="<?php echo $this->Html->url(array('controller'=>'blogs','action'=>'admin_index')); ?>">Blog Management</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="wrapper">
     <?php $x=$this->Session->flash(); ?>
     <?php if($x){ ?>
     <div class="nNote nSuccess" id="flash">
       <div class="alert alert-success" style="text-align:center" ><?php echo $x; ?></div>
     </div><?php } ?>            
    	<!-- Chart -->
         <div class="widget check grid6">
        <div class="whead">
        <span class="titleIcon">
        <input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox"></span>
        <h6>Blog Management</h6></div>
        <?php if(!empty($blogs)){ ?>       
        
        <div id="dyn" class="hiddenpars">
            <?php  echo $this->Form->create('Blog',array("action" => "deleteall",'id' => 'mbc')); ?>
            <table cellpadding="0" cellspacing="0" class="tDefault checkAll tMedia tbl_repeat" id="checkAll" width="100%">
            <thead>
            <tr>
            <th></th>
            <th><?php echo ('Blog name'); ?></span></th>
            <th><?php echo ('Blog image'); ?></span></th>
            <th><?php echo('Created'); ?></th>            
			<th><?php echo('Status'); ?></th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach ($blogs as $user): ?>
            <tr class="gradeX" id="order_<?php echo $user['Blog']['id']; ?>">
            <td><?php echo $this->Form->checkbox("use"+$user['Blog']['id'],array('value' => $user['Blog']['id'],'class'=>'checkAll')); ?></td>
            <td><?php echo h($user['Blog']['title']); ?></td>			
            <td><?php if($user['Blog']['image'] != ''){ echo $this->Html->image('../files/blogimages/'.$user['Blog']['image'],array('height'=>'auto','width'=>'70px')); } else {
				echo $this->Html->image('no_image.png',array('height'=>'auto','width'=>'70px'));
			}	?></td>			
            <td><?php echo date("d M y",strtotime($user['Blog']['created'])); ?></td>
            
            <td><?php if($user['Blog']['status'] == '1'){ echo "Active"; }else { echo "Inactive"; } ?></td>
			<td class="center">
             <form></form>
            
			<?php echo $this->Html->link($this->Html->image('../images/icons/admins/edit.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('action' => 'admin_edit', $user['Blog']['id']),array('class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Edit','escape'=>false)); ?>
			
            <?php echo $this->Form->postLink($this->Html->image('../images/icons/admins/delete.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('controller'=>'blogs','action'=>'delete',$user['Blog']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Delete'),__('Are you sure you want to delete #%s?', $user['Blog']['title']));?>
            <?php //echo $this->Form->postLink($this->Html->image('../images/icons/admins/options.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('controller'=>'Blogoptions','action'=>'index',$user['Blog']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Manage options'));?>    
            <?php if ($user['Blog']['status']=='0'){?>
			<?php echo $this->Form->postLink($this->Html->image('../images/icons/admins/deactivate.png',array('border'=>'0','class'=>'iconb','width'=>'17')), array('action' => 'activate', $user['Blog']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Active'),__('Are you sure you want to activate #%s?', $user['Blog']['title']));?><?php }else { ?>
			<?php echo $this->Form->postLink($this->Html->image('../images/icons/admins/activate.png',array('border'=>'0','class'=>'iconb','width'=>'17')), array('action' => 'block', $user['Blog']['id']), array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Block'),__('Are you sure you want to block #%s?', $user['Blog']['title'])); ?><?php }?>
  		
			
            </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            </table> 
            
           
            <br/><br/>
           <?php 
           echo $this->Html->link('Delete All','javascript:void(0);',array('onclick'=>'return deleteAll();','class'=>'buttonS bRed','style'=>"margin-left:20px")); ?>
				<?php echo $this->Html->link('Activate All','javascript:void(0);',array('onclick'=>'return activateAll();','class'=>'buttonS bGreen','style'=>"margin-left:40px")); ?>
				<?php echo $this->Html->link('Deactive All','javascript:void(0);',array('onclick'=>'return deactiveAll();','class'=>'buttonS bBlue','style'=>"margin-left:40px")); ?>
                        <?php  }
                        else{?>
                            
                            <div id="dyn" style="text-align:center;">
					No records found.
				</div>
                      <?php  }
                        ?>
          <div class="tPages">
              <ul class="pages">
				<li><?php echo $this->Paginator->first('First'); ?></li>
				<li><?php if($this->Paginator->hasPrev()){ echo $this->Paginator->prev(__('Previous'), array('tag' => false)); } ?></li>
                <li><?php echo @$this->Paginator->numbers(); ?></li>
				<li><?php if($this->Paginator->hasNext()){ echo $this->Paginator->next(__('Next'), array('tag' => false)); } ?></li>   
				<li><?php echo $this->Paginator->last('Last'); ?></li>	
              </ul>
            </div>
              <div style="margin-top:10px;"></div>
           </form>
             </div>  
        </div>        
    </div>
</div>
</div>

<script type="text/javascript">
function deleteAll() {
    var anyBoxesChecked = false;
	var arr = new Array();
	$('#mbc input[type="checkbox"]').each(function() {
        if ($(this).is(":checked")) {
			arr.push($(this).val());
			anyBoxesChecked = true;
        }
    });
 
    if (anyBoxesChecked == false) {
		alert('Please select at least one checkbox to delete Blog.');
		return false;
    } else {				
		if(confirm("Are you sure you want to delete seleted blogs?")){
					
					$.ajax({
						type:'POST',
						dataType: 'json',
						url:'<?php echo Router::url(array('controller'=>'blogs','action'=>'admin_deleteall')); ?>',
						 data: {'Blog':arr},
						success:function(result){
                                                        $('.checkAll').attr("checked", false);
							$('#titleCheck').attr("checked", false);
							window.location.reload();
						}
					});
					
					return false;
		}	
			return false;
	} 
}//end of func deleteAll//


function activateAll() {
    var anyBoxesChecked = false;
	var arr = new Array();
	$('#mbc input[type="checkbox"]').each(function() {
        if ($(this).is(":checked")) {
			arr.push($(this).val());
			anyBoxesChecked = true;
        }
    });
 
    if (anyBoxesChecked == false) {
		alert('Please select at least one checkbox to activate Blog.');
		return false;
    } else {
		if(confirm("Are you sure you want to activate selected blogs?")){
				$.ajax({
					type:'POST',
					dataType: 'json',
					url:'<?php echo Router::url(array('controller'=>'blogs','action'=>'admin_activateall')); ?>',
					 data: {'Blog':arr},
					success:function(result){
						$('.checkAll').attr("checked", false);
						$('#titleCheck').attr("checked", false);
						window.location.reload();
					}					
				});					
				return true;
		}	
	}	
}//end of func activateAll//

function deactiveAll() {
    var anyBoxesChecked = false;
	var arr = new Array();
	$('#mbc input[type="checkbox"]').each(function() {
        if ($(this).is(":checked")) {
			arr.push($(this).val());
			anyBoxesChecked = true;
        }
    });
 
    if (anyBoxesChecked == false) {
		alert('Please select at least one checkbox to deactivate Blog.');
		return false;
    } else {
		if(confirm("Are you sure you want to deactivate the seleted blogs?")){
			$.ajax({
				type:'POST',
				dataType: 'json',
				url:'<?php echo Router::url(array('controller'=>'blogs','action'=>'admin_deactivateall')); ?>',
				 data: {'Blog':arr},
				success:function(result){
					$('.checkAll').attr("checked", false);
					$('#titleCheck').attr("checked", false);
					window.location.reload();
				}					
			});
			return false;
		}	
		return false;
	}
}//end of func deactiveAll//
</script>