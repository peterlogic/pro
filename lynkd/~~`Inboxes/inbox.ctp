<?php echo $this->element('top-header'); ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<style type="text/css">
    .message{text-decoration:none;color:#333333;}
    .message:hover{text-decoration:none;color:#333333;}
</style>
<div class="row-fluid" style="padding-top:5px;">  
    
       <div class="span12" style="width:100%;margin: 20px;">
       <div class="span8">
         <div class="top">                
                    <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="span12">
                     <div class="alert alert-block" style="margin-left:10px; margin-top:5px; width:88%;background-color:#5DA150;color:white;">
<button type="button" class="close" data-dismiss="alert">&times;</button>                
                    <strong><?php echo $x; ?></strong>
                   </div>                
                    </div>
                        <?php }?>
             <div style="margin-left:7%;padding:5px;margin-top:0px;width:88%;margin-bottom:100px;">
                     <ul class="nav nav-tabs">
                        <li><a href="#home" data-toggle="tab">Inbox</a></li>
                        <li><a href="#profile" data-toggle="tab">Outbox</a></li>
                        <li><a href="#messages" data-toggle="tab">Compose</a></li>    
<!--                        <li><a href="#trash" data-toggle="tab">Trash</a></li>    -->
                    </ul>
                 <div class="tab-content">
                    <div class="tab-pane active" id="home">
       <!-------------------------------------------------unread------------------------------------------------------------------------>
                      <h5>  <i class="icon-star"></i>Inbox</h5>                      
                        <table class="table" id="checkAll">
                            <?php  echo $this->Form->create('Inbox',array("action" => "deleteall",'id' => 'mbc')); ?>
                                <tr>
                                    <th> <input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox"></th>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Time</th>
                                 <th>Action</th>
                                </tr>
                                <?php  if(count($unread)==0){  ?>
                                <tr><td colspan="5">There is no received Message to read.</td></tr>
                                <?php }else{ ?>
                                <?php foreach($unread as $in){ if(($in['Inbox']['to']==$from)&&($in['Inbox']['status']=='Sent')){ ?>
                                
                                <tr>
                                    <td><?php echo $this->Form->checkbox("inb"+$in['Inbox']['id'],array('value' => $in['Inbox']['id'],'class'=>'checkAll')); ?></td>
                                    <td>
                                        <a href="#un_<?php echo $in['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal" title="View">
                                        <?php echo $in['Inbox']['to']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#un_<?php echo $in['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal" title="View">
                                        <?php echo $in['Inbox']['subject']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#un_<?php echo $in['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal" title="View">
                                        <?php echo substr($in['Inbox']['message'],0,100)."..."; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $this->Time->timeAgoInWords($in['Inbox']['date']); ?></td>
                                    <td>
<!--                                        <a href="#un_<?php echo $in['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal" title="View"><i class="icon-eye-open"></i></a>-->
                                        <form></form>      
 <?php echo $this->Form->postLink('<span class="icon-trash" data-icon="&#xe136;"></span>',array('controller'=>'Inboxes','action'=>'trash',$in['Inbox']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS ','title'=>'Move to Trash'));?>    
                                       
                                    </td> 
                                </tr>

                           
                                                               
                                <!--------------unread view-------->
                                    <div class="modal  fade" id="un_<?php echo $in['Inbox']['id']; ?>">
                                        <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       <h3>View Mail</h3>
                                       </div>
                                       <div class="modal-body">
                                           <p><b>From:</b><?php echo $in['Inbox']['from']; ?></p>
                                           <p><b>TO:</b><?php echo $in['Inbox']['to']; ?></p>
                                           <p><b>Date:</b><?php echo $in['Inbox']['date']; ?></p>
                                           <p><b>Subject:</b><?php echo $in['Inbox']['subject']; ?></p>
                                           <p><b>Message:</b><?php echo $in['Inbox']['message']; ?></p>
                                       </div>
                                       <div class="modal-footer">
                                           <a href="#in_<?php echo $in['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal" title="View" onclick="javascript:$('#un_<?php echo $in['Inbox']['id']; ?>').modal('hide');"><button class="btn btn-primary">Reply</button></a>                              
                                       <a href="#" class="btn" onclick="javascript:$('#un_<?php echo $in['Inbox']['id']; ?>').modal('hide');">Close</a>   
                                       
                                       </div>
                                       </div>
                              
                                <!--------------unread reply------------->                                  
                                    <div class="modal  fade" id="in_<?php echo $in['Inbox']['id']; ?>">
                                           <?php echo $this->Form->create('Inbox',array('controller'=>'inboxes','action'=>'add'));  ?>
                                        <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       <h3>Reply Mail</h3>
                                       </div>
                                       <div class="modal-body">
                                           <div class="row-fluid">
                                               <div class="span4">To</div>
                                               <div class="span4"><?php echo $this->Form->input('from',array('label'=>"",'div'=>"",'value'=>$in['Inbox']['from'])); ?></div>
                                           </div>
                                           <div class="row-fluid">
                                               <div class="span4">From</div>
                                               <div class="span4"><?php echo $this->Form->input('to',array('label'=>"",'div'=>"",'value'=>$in['Inbox']['to'])); ?></div>
                                           </div>
                                           
                                           <div class="row-fluid">
                                               <div class="span4">Subject</div>
                                               <div class="span4"><?php echo $this->Form->input('from',array('label'=>"",'div'=>"",'value'=>$in['Inbox']['subject'])); ?></div>
                                           </div>
                                            <div class="row-fluid"> 
                                                <div class="span4">Message</div>                                                                                          
                                               <div class="span4"><textarea name="data[Inbox][message]" rows="5" width="200px" id="unread_<?php echo $in['Inbox']['id']; ?>"><?php echo $in['Inbox']['message']; ?></textarea></div>
                                           </div>
                                          <input type="hidden" value="<?php echo date('d/m/Y'); ?>" name="data[Inbox][date]"/>
                                           <input type="hidden" value="Sent" name="data[Inbox][status]"/>
                                       </div>
                                       <div class="modal-footer">
                                           <button class="btn btn-primary" type="submit">Reply</button>
                                           <a href="#" class="btn" onclick="javascript:$('#in_<?php echo $in['Inbox']['id']; ?>').modal('hide');">Close</a>   
                                        
                                       </div>
                                    </form>
                                       </div>
                                           </tr>
<script type="text/javascript">
jQuery(document).ready(function(){
tinyMCE.init({
theme: "advanced",
plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,|,insertimage",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,
mode: "exact",
elements: "unread_<?php echo $in['Inbox']['id']; ?>",
body_id: "unread_<?php echo $in['Inbox']['id']; ?>"
});
});
</script>                     
                                <!--------------------------->
                                 <?php  } } ?>      
                                <?php } ?>
                <button onclick="$('#mbc').submit();" value="Delete" class="btn btn-mini" style="margin-left:20px"> Delete All</button>                 
                        </form>
                            </table>
                    </div>
                    <div class="tab-pane" id="profile">
      <!------------------------------------------------------outbox------------------------------------------------------------->
       <?php  echo $this->Form->create('Inbox',array("action" => "deleteall",'id' => 'mbc1')); ?>
                            <table class="table" id="checkAll">
                                <tr>
                                    <th><input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox"></th> 
                                <th>To</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Time</th>
                                <th>Action</th>
                                </tr>
                                <?php  if(count($outbox)==0){  ?>
                                <tr><td colspan="5">There is no sent Message.</td></tr>
                                <?php }else{ ?>
                                <?php foreach($outbox as $out){ if($out['Inbox']['from']==$from){ ?>
                               
                                <tr>
                                    <td><?php echo $this->Form->checkbox("inb"+$out['Inbox']['id'],array('value' => $out['Inbox']['id'],'class'=>'checkAll')); ?></td>
                                    <td>
                                        <a href="#out_<?php echo $out['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal" title="View">
                                           <?php echo $out['Inbox']['to']; ?>
                                        </a>
                                    </td>
                                    <td>   
                                        <a href="#out_<?php echo $out['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal" title="View">
                                            <?php echo $out['Inbox']['subject']; ?>
                                        </a>
                                    </td>
                                    <td>
                                           <a href="#out_<?php echo $out['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal" title="View">
                                        <?php echo substr($out['Inbox']['message'],0,100)."..."; ?>
                                           </a>
                                    </td>
                                    <td><?php echo $this->Time->timeAgoInWords($out['Inbox']['date']); ?></td>
                                    <td>
                       <form></form> 
  <a href="#out_<?php echo $out['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal" title="View"><i class="icon-eye-open"></i></a>
                                      
 <?php echo $this->Form->postLink('<span class="icon-trash" data-icon="&#xe136;"></span>',array('controller'=>'Inboxes','action'=>'delete',$out['Inbox']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS ','title'=>'Delete'));?>     
                                    <!---------------------view outbox--------->
                                    <div class="modal  fade" id="out_<?php echo $out['Inbox']['id']; ?>">
                                        <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       <h3>View Mail</h3>
                                       </div>
                                       <div class="modal-body">
                                           <p><b>To:</b><?php echo $out['Inbox']['to']; ?></p>
                                           <p><b>From:</b><?php echo $out['Inbox']['from']; ?></p>                                           
                                           <p><b>Date:</b><?php echo $out['Inbox']['date']; ?></p>
                                           <p><b>Subject:</b><?php echo $out['Inbox']['subject']; ?></p>
                                           <p><b>Message:</b><?php echo $out['Inbox']['message']; ?></p>
                                       </div>
                                       <div class="modal-footer">
                                            <a href="#ob_<?php echo $out['Inbox']['id']; ?>" class="message btn btn-primary" role="button" data-toggle="modal" onclick="javascript:$('#out_<?php echo $out['Inbox']['id']; ?>').modal('hide');">Reply</a>
                                       <a href="#" class="btn" onclick="javascript:$('#out_<?php echo $out['Inbox']['id']; ?>').modal('hide');">Close</a>   
                                        
                                       </div>
                                       </div>
                
                                       <!--------------reply outbox------------------------------->
                             
                                    <div class="modal  fade" id="ob_<?php echo $out['Inbox']['id']; ?>">
                                           <?php echo $this->Form->create('Inbox',array('controller'=>'inboxes','action'=>'add'));  ?>
                                        <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       <h3>Reply Mail</h3>
                                       </div>
                                       <div class="modal-body">
                                           <div class="row-fluid">
                                               <div class="span4">To</div>
                                               <div class="span4"><?php echo $this->Form->input('to',array('label'=>"",'div'=>"",'value'=>$out['Inbox']['to'],'readonly')); ?></div>
                                           </div>
                                           <div class="row-fluid">
                                               <div class="span4">From</div>
                                               <div class="span4"><?php echo $this->Form->input('from',array('label'=>"",'div'=>"",'value'=>$out['Inbox']['from'],'readonly')); ?></div>
                                           </div>
                                           
                                           <div class="row-fluid">
                                               <div class="span4">Subject</div>
                                               <div class="span4"><?php echo $this->Form->input('subject',array('label'=>"",'div'=>"",'value'=>"Reply-".$out['Inbox']['subject'])); ?></div>
                                           </div>
                                            <div class="row-fluid"> 
                                                <div class="span4">Message</div> 
                                            </div>
                                           <div class="row-fluid"> 
                                               <div class="span8"><textarea name="data[Inbox][message]" rows="5" width="150px" id="outbox_<?php echo $out['Inbox']['id']; ?>"><?php echo $out['Inbox']['message']; ?></textarea></div>
                                           </div>
                                          <input type="hidden" value="<?php echo date('d/m/Y'); ?>" name="data[Inbox][date]"/>
                                           <input type="hidden" value="Sent" name="data[Inbox][status]"/>
                                       </div>
                                       <div class="modal-footer">
                                           <button class="btn btn-primary" type="submit">Reply</button>
                                   <a href="#" class="btn" onclick="javascript:$('#ob_<?php echo $out['Inbox']['id']; ?>').modal('hide');">Close</a>          
                                        
                                       </div>
                                    </form>
                                       </div>
                                <!--------------------------->
                                    </td>
                                </tr>
<script type="text/javascript">
jQuery(document).ready(function(){
tinyMCE.init({
theme: "advanced",
plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,|,insertimage",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,
mode: "exact",
elements: "outbox_<?php echo $out['Inbox']['id']; ?>",
body_id: "outbox_<?php echo $out['Inbox']['id']; ?>"
});
});
</script>
                                <?php } } ?>
        <button onclick="$('#mbc1').submit();" value="Delete" class="btn btn-mini" style="margin-left:20px"> Delete All</button>        
                               
                             <?php   }  ?>
                            </table>
                    </form>
                    </div>
           <!------------------------------------------------------compose------------------------------------->          
                    <div class="tab-pane" id="messages" style="padding:50px;">
                        <?php echo $this->Form->create('Inbox',array('controller'=>'inboxes','action'=>'add'));  ?>
                        <div class="row-fluid">
                            <div class="span4">From</div>
                            <div class="span4"><?php echo $this->Form->input('from',array('label'=>"",'div'=>"",'value'=>$from,'readonly')); ?></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span4">To</div>
                            <div class="span4"><?php echo $this->Form->input('to',array('label'=>"",'div'=>"")); ?></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span4">Subject</div>
                            <div class="span4"><?php echo $this->Form->input('subject',array('label'=>"",'div'=>"")); ?></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span4">Message</div>
                            <div class="span4"><textarea name="data[Inbox][message]" rows="3" width="250px" id="compose"></textarea></div>
                            <input type="hidden" name="data[Inbox][status]" value="Sent" />
                             <input type="hidden" name="data[Inbox][date]" value="<?php echo date('d/m/Y'); ?>" />
                        </div>
                        <div class="row-fluid">
                            <div class="span4"></div>
                            <div class="span4"><button type="submit" class="btn btn-primary">Send</button></div>
                        </div>
                    </form>
                    </div>
           <!--------------------------------trash---------------------------------------------------------------------------------------->
                     <div class="tab-pane" id="trash">
                         <table class="table" id="checkAll">
                       <?php  echo $this->Form->create('Inbox',array("action" => "deleteall",'id' => 'mbc')); ?>      
                                <tr>
                                    <th><input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox"></th> 
                                <th>To</th>
                                 <th>From</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Time</th>
                                  <th>Action</th>
                                </tr>
                                <?php if(empty($trash)){  ?>
                                <tr><td colspan="5">There is no trashed Message.</td></tr>
                                <?php }else{ ?>
                                <?php foreach($trash as $tr){ if(($tr['Inbox']['to']==$from)||($tr['Inbox']['from']==$from)){ ?>
                               
                                <tr>
                                    <td><?php echo $this->Form->checkbox("inb"+$tr['Inbox']['id'],array('value' => $tr['Inbox']['id'],'class'=>'checkAll')); ?></td>
                                    <td><?php if($tr['Inbox']['to']==$from){echo "me";}else{echo $tr['Inbox']['to'];} ?></td>
                                     <td><?php if($tr['Inbox']['from']==$from){echo "me";}else{echo $tr['Inbox']['from'];} ?></td>
                                    <td><?php echo $tr['Inbox']['subject']; ?></td>
                                    <td><?php echo substr($tr['Inbox']['message'],0,100)."..."; ?></td>
                                    <td><?php echo $this->Time->timeAgoInWords($tr['Inbox']['date']); ?></td>
                                    <td>
                                        <a href="#out_<?php echo $tr['Inbox']['id']; ?>" class="message" role="button" data-toggle="modal"><i class="icon-eye-open"></i></a>
<?php echo $this->Form->postLink('<span class="icon-inbox" data-icon="&#xe136;"></span>',array('controller'=>'Inboxes','action'=>'restore',$tr['Inbox']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS ','title'=>'Restore'));?>                                            
 <?php //echo $this->Form->postLink('<span class="icon-trash" data-icon="&#xe136;"></span>',array('controller'=>'Inboxes','action'=>'delete',$tr['Inbox']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault tipS ','title'=>'Move to Trash'));?>     
                                          <!--------------------------------------view trash----------->
                                    <div class="modal hide fade" id="out_<?php echo $tr['Inbox']['id']; ?>">
                                        <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       <h3>View Mail</h3>
                                       </div>
                                       <div class="modal-body">
                                           <p><b>From:</b><?php echo $tr['Inbox']['from']; ?></p>       
                                           <p><b>To:</b><?php echo $tr['Inbox']['to']; ?></p>                                           
                                           <p><b>Date:</b><?php echo $tr['Inbox']['date']; ?></p>
                                           <p><b>Subject:</b><?php echo $tr['Inbox']['subject']; ?></p>
                                           <p><b>Message:</b><?php echo $tr['Inbox']['message']; ?></p>
                                       </div>
                                       <div class="modal-footer">                                                                                      
                                           <a href="#" class="btn" onclick="javascript:$('#out_<?php echo $tr['Inbox']['id']; ?>').modal('hide');">Close</a>   
                                        
                                       </div>
                                       </div>

                                
                                    </td>
                                </tr>
                                   
                             <?php }  } ?>
             <button onclick="$('#mbc').submit();" value="Delete" class="btn btn-mini" style="margin-left:20px"> Delete All</button>                   
                         <?php    }  ?>
                         </form>
                            </table>
                     </div>
                  </div>

                    <script>
                    $(function () {                        
                       $('#myTab a').click(function (e) {
                       e.preventDefault();
                       $(this).tab('show');
                    })
                    $('#myTab a:last').tab('show');
                    })
                    </script>
             </div>
         </div>
       </div>
     
     </div>  
</div>
<?php echo $this->Html->script(array('tiny_mce/tiny_mce'))?>
<script type="text/javascript">    
jQuery(document).ready(function(){
tinyMCE.init({
theme: "advanced",
plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,|,insertimage",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,
mode: "exact",
elements: "compose",
body_id: "compose"
});
news_updates();
  newsupdtes = setInterval('news_updates()',20000);
});

    </script>       