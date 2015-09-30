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
        <span class="pageTitle"><span class="icon-calendar"></span>Contact us Management</span>
       
    </div>
     <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li class="current"><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_contactus')); ?>">Contact us Management</a></li>
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
        <span class="titleIcon"><h6>Contactus</h6> </span> </div>
        <!-- <input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox">-->
        

        <?php if(!empty($info)){ 
		//debug($contact);exit;
		?>     
		
        
        <div id="dyn" class="hiddenpars">
            <?php  echo $this->Form->create('Contact',array("action" => "deleteall",'id' => 'mbc')); ?>
            <table cellpadding="0" cellspacing="0" class="tDefault checkAll tMedia tbl_repeat" id="checkAll" width="100%">
            <thead>
            <tr>
            <th></th>
            <th><?php echo (' Name'); ?></span></th>
            <th><?php echo ('Subject'); ?></span></th>
            <th><?php echo('Created'); ?></th>            
			<!-- <th><?php //echo('Status'); ?></th> -->
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
			<?php   foreach ($info as $user): 
			?>
            <tr class="gradeX" id="order_<?php echo $user['Contact']['id']; ?>">
            <td><?php //echo $this->Form->checkbox("use"+$user['Contact']['id'],array('value' => $user['Contact']['id'],'class'=>'checkAll')); ?></td>
            <td><?php echo h($user['Contact']['first_name']); ?></td>		
			<td><?php echo h($user['Contact']['subject']); ?></td>							
            <td><?php echo date("d M y",strtotime($user['Contact']['created'])); ?></td>
            
            <!-- <td><?php// if($user['Blog']['status'] == '1'){ echo "Active"; }else { echo "Inactive"; } ?></td> -->
			<td class="center">
             <form></form>
			<?php echo $this->Html->link($this->Html->image('../images/icons/admins/view.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('action' => 'admin_contactusedit', $user['Contact']['id']),array('class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'view','escape'=>false)); ?>
			
            <?php echo $this->Form->postLink($this->Html->image('../images/icons/admins/delete.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('controller'=>'Users','action'=>'contactdelete',$user['Contact']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Delete'),__('Are you sure you want to delete ?'));?>
			
            <?php //echo $this->Form->postLink($this->Html->image('../images/icons/admins/options.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('controller'=>'Blogoptions','action'=>'index',$user['Blog']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Manage options'));?>    
            </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            </table> 
            <br/><br/>
           <?php 
          // echo //$this->Html->link('Delete All','javascript:void(0);',array('onclick'=>'return deleteAll();','class'=>'buttonS bRed','style'=>"margin-left:20px")); ?>
				<?php //echo $this->Html->link('Activate All','javascript:void(0);',array('onclick'=>'return activateAll();','class'=>'buttonS bGreen','style'=>"margin-left:40px")); ?>
				<?php //echo $this->Html->link('Deactive All','javascript:void(0);',array('onclick'=>'return deactiveAll();','class'=>'buttonS bBlue','style'=>"margin-left:40px")); ?>
                        <?php // }
                        //else//{?>
                            
                            <!-- <div id="dyn" style="text-align:center;"> 
					No records found.
				</div> -->
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