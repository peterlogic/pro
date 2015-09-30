<?php 
echo $this->element('logged_in_header') ; ?>
<div class="main_con">
    <div class="wrapp">
    	<div class="con">
            <div class="span12" id="flash">
                    <?php $x=$this->Session->flash(); ?>
                    <?php if($x){ ?>
                     <div class="alert alert-block" style="margin-left:45px; margin-top:5px; width:88%;background-color:#3B80D0;color:white;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>                
                    <strong><center><?php echo $x; ?></center></strong>
                   </div>
                   <?php }?> 
            </div>
            <?php echo $this->element('myprofile_leftsection'); ?>            
            <div class="con_med_main">
                <div style="width:100%;height: 850px;overflow: scroll">
                    <?php foreach($chat as $chats){?>
                        <div style="padding:0px 0px 0px 10px">
                            <div>
                                    <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'view',$chats['User']['id'])) ?>">
                                        <?php 
//                                        if($chats['User']['profile_image']){
//                                            echo $this->Html->image('../files/profile_image/'.$chats['User']['id'].$chats['User']['profile_image'],
//                                                    array('height'=>'40','width'=>'40','style'=>'padding:5px'));
//                                        }?>
                                        <b><?php echo $chats['Chat']['sender_name'] ; ?></b>
                                    </a>
                            </div>
                            <br/>
                            <div style="padding:10px 0 0 0px;margin-top: -15px">
                                <?php echo $chats['Chat']['message'];?>
                            </div>    
                       </div>
                        <hr/>
                 
                    <?php } ?>
                         </div>
                    <div style="height: 200px;width: 100%;margin-top: 10px;float: left;">
                        <?php echo $this->Form->create('Chat',array('action'=>'send_mychat','method'=>'post'));?>
                            <input type="text" name="data[Chat][message]" style="width:100%;height: 30px;border: 2px #E2E2E1 solid;"
                                   placeholder="Enter Your Message Here"/>
                            <input type="hidden" name="data[Chat][to_user_id]" value="<?php echo $us_id['User']['id'];?>"/>
                            <input type="hidden" name="data[Chat][user_id]" value="<?php echo $loggedin_userid?>"/>
                            <input type="hidden" name="data[Chat][sender_name]" value="<?php echo $loggedinuserdata['User']['firstname']." ".
                                 $loggedinuserdata['User']['lastname'];?>"/>
                            
                            <input type="submit" hidefocus="true" style="height: 0px; width: 0px; border: none; padding: 0px;" />
                    </form>
                    </div> 
               
            </div>
               
            <?php echo $this->element('myprofile_rightsection'); ?>
            </div>
     </div>
</div>


<!----------------------------con------------------------------------>
<?php echo $this->element('footer') ; ?>
