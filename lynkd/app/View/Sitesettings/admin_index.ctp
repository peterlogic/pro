<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 

<!--------------------------->
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Site Settings Management</span>
    </div>
     <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li class="current"><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_index')); ?>">Site Setting Management</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="wrapper">
    <?php $x=$this->Session->flash(); ?>
         <?php if($x){ ?>
        <div class="nNote nSuccess" id="flash">
         <div class="alert alert-success" style="text-align:center" ><?php echo $x; ?></div> 
         </div>                
        <?php } ?>
         <div class="widget check grid6">
        <div class="whead"><h6>Site Setting Management</h6></div>
        <div id="dyn" class="hiddenpars">
            <!--<a class="tOptions"><img src="../images/icons/options" alt="" /></a>-->
             <?php  echo $this->Form->create('Sitesetting',array("action" => "",'id' => 'mbc')); ?>
            <table cellpadding="0" cellspacing="0" class="tDefault checkAll tMedia" id="checkAll" width="100%">
            <thead>
            <tr>
           <th><?php echo 'Title'; ?></th>
			<th><?php echo 'Web_URL'; ?></th>
			<th><?php echo 'Web_logo'; ?></th>
			<th><?php echo 'Keywords'; ?></th>
			<th><?php echo 'Site_Email'; ?></th>
			<th><?php echo 'Facebook_URL'; ?></th>
			<th><?php echo 'Twitter_URL'; ?></th>
			<th><?php echo 'Google URL'; ?></th>
			<th><?php echo 'ADSENSE'; ?></th>
			 <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
	foreach ($sitesettings as $sitesetting):?>
            <tr class="gradeX">
        <td><?php echo h($sitesetting['Sitesetting']['title']); ?>&nbsp;</td>
		<td><?php echo h($sitesetting['Sitesetting']['web_url']); ?>&nbsp;</td>
                <td><img src="<?php echo FULL_BASE_URL.$this->webroot.'files/'; ?><?php echo h($sitesetting['Sitesetting']['web_logo']); ?>" style="height: 100px;width: 100px;"/> &nbsp;</td>
		<td><?php echo h($sitesetting['Sitesetting']['keywords']); ?>&nbsp;</td>
		<td><?php echo h($sitesetting['Sitesetting']['site_email']); ?>&nbsp;</td>
		<td><?php echo h($sitesetting['Sitesetting']['facebook_url']); ?>&nbsp;</td>
		<td><?php echo h($sitesetting['Sitesetting']['twitter_url']); ?>&nbsp;</td>
		
		<td><?php echo h($sitesetting['Sitesetting']['googleplus']); ?>&nbsp;</td>
		<td><?php echo h($sitesetting['Sitesetting']['adsense']); ?>&nbsp;</td>
		 <td class="center">
           <?php echo $this->Html->link($this->Html->image('../images/icons/admins/edit.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('action' => 'admin_edit', $sitesetting['Sitesetting']['id']),array('class'=>'tablectrl_small bDefault tipS tool-tip','title'=>'Edit','escape'=>false)); ?>
            
                       </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
            </table> 

           </form>
     
        </div>  
          
        </div>        
    </div>
</div>

      