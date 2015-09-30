<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<!--------------------------->
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-calendar"></span>Category Management</span>
    </div>
     <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Categories','action'=>'admin_index')); ?>">Category Management</a></li>
                 <li class="current"><a href="javascript:void:(0)"><?php echo $action_type.' Category'; ?></a></li>
            </ul>
        </div>
    </div>
    <!-- Main content -->
    <div class="wrapper">
         <div class="widget fluid">
        <div class="whead"><h6><?php echo $action_type.' Category'; ?></h6></div>
        <div id="dyn" class="hiddenpars">
             <?php echo $this->Form->create('Category',array('method'=>'Post','type'=>'file','id'=>'validate')); ?>
                <div class="formRow">
                    <div class="grid3"><label>Category title:<span class="red">*</span></label></div>
                    <div class="grid9">
                    <?php echo $this->Form->input('title', array('label'=>"",'type'=>'text','required'));?>
                    </div>
                </div>
                

			<?php if(isset($this->data['Category']['id'])){
				$userID = $this->data['Category']['id'];
			} else {
				$userID = '';
			}	 ?>				

			<?php echo $this->Form->input('Category.id', array('label'=>"",'type'=>'hidden','value'=>$userID));?>

                <div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="grid9">
                    <button type="submit" name="Save" id="update" class="buttonS bLightBlue" >Save</button>
                    </div>
                </div>
           </form>     
        </div> 
        </div>
    </div>
</div>