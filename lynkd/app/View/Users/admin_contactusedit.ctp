<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar"); ?> 
<?php echo $this->Html->script(array('tiny_mce/tiny_mce'))?>
<script type="text/javascript">
jQuery(document).ready(function(){
tinyMCE.init({
theme: "advanced",
plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
// Theme options
theme_advanced_buttons1 : ",justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
theme_advanced_buttons2 : "cut,copy,paste|,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,backcolor",
theme_advanced_buttons3 : "tablecontrols,|sub,sup,|,charmap,emotions,iespell,media,advhr,|,fullscreen",
theme_advanced_buttons4 : "bold,italic,underline,strikethrough,|styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,|,insertimage",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,
mode: "exact",
elements: "conta",
body_id: "conta"
});
});

        
        </script>
<!--------------------------->

<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-calendar"></span>Contact us Management</span>
    </div>

     <!-- Breadcrumbs line -->
	<?php echo $this->Session->flash(); ?>
    <div class="breadLine">

        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                 <li class="current"><a href="javascript:void:(0)"><?php echo 'Contact us'; ?></a></li>
            </ul>
        </div>
    </div>


    <?php //debug($reply);exit ?>
    <!-- Main content -->

    <div class="wrapper">
         <div class="widget fluid">
        <div class="whead"><h6><?php echo ' Contact us'; ?></h6></div>
        <div id="dyn" class="hiddenpars">
            <?php //echo $this->Form->create('Contact',array('method'=>'Post','type'=>'file','id'=>'validate')); ?>
                <div class="formRow">
                    <div class="grid3"><label>First name:</label></div>
                    <div class="grid9">
					<?php echo $userinfo['Contact']['first_name']; ?>
                 
                    </div>
                </div>
				
				<div class="formRow">
                    <div class="grid3"><label>Last name:</label></div>
                    <div class="grid9">
                  <?php echo $userinfo['Contact']['last_name']; ?>
                    </div>
                </div>
				
				<div class="formRow">
                    <div class="grid3"><label>Email:</label></div>
                    <div class="grid9">
                    <?php echo $userinfo['Contact']['email']; ?>
                    </div>
                </div>
				
				<div class="formRow">
                    <div class="grid3"><label>subject:</label></div>
                    <div class="grid9">
                   <?php echo $userinfo['Contact']['subject']; ?>
                    </div>
                </div>
				
				<div class="formRow">
                    <div class="grid3"><label>Comment:</label></div>
                    <div class="grid9">
                     <?php echo $userinfo['Contact']['Comment']; ?>
                    </div>
                </div>
				
				<?php  $count = '1';  foreach($reply as  $message){ ?>
				<div class="formRow">
                    <div class="grid3"><label>Reply message(<?php echo $count; ?>):</label></div>
                    <div class="grid9">
                     <?php echo $message['Contactreply']['reply']; ?><br/>
                    </div>
                </div>
				
				 <?php $count++; } ?>
								
					<div class="formRow">
                    <div class="grid3"><label></label></div>
                    <div class="grid9">
					
                  <?php echo $this->Html->link('Reply',array('controller'=>'users','action'=>'admin_reply',  $userinfo['Contact']['id'] )); ?>
                    </div>
                </div> 

           </form>     
        </div> 
        </div>
    </div>
</div>

