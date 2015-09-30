<?php $_SESSION['username'] = @$logged_user['User']['username']; ?>
        <?php //echo $this->fetch('content'); ?>		
        <?php
        if (@$logged_user['User']['id']) {
            $i = 0;
            foreach ($onlinechats as $onlinechat){ ?>     
                <!--<div  id="draggable_<?php echo $onlinechat['Multichat']['to_user_id']; ?>" style="bottom: 0px; right: 200px; display: block;position: fixed; width: 225px;z-index: 5000;">
                    <div style=" background-color: #2670C4;border-left: 1px solid #F99D39;border-right: 1px solid #F99D39;color: #FFFFFF;
                         padding-bottom: 22px;padding-left: 5px;padding-right: 7px;padding-top: 0px;">
                        <div style="float: left">
                            <a href="<?php echo $this->Html->url(array('controller' => 'User', 'action' => 'view',$onl['id'])); ?>" style="color: #FFFFFF;">
                                  <?php echo $onl['name']; ?>
                            </a>
                        </div>
                        <div style="float: right">              
                            <a class="close" href="javascript:void(0)" rel="<?php echo $onlinechat['Multichat']['to_user_id']; ?>">X</a>
                        </div>
                    </div>
                    <div style=" background-color: #FFFFFF;border-bottom: 1px solid #EEEEEE;border-left: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;
                         color: #333333;font-family: arial,sans-serif;font-size: 13px;height: 200px;line-height: 1.3em;overflow: auto;padding: 7px;width: 100%;"
                         class="chatting_<?php echo $onlinechat['Multichat']['to_user_id']; ?>">            
                    </div>
                    <div style="background-color: #FFFFFF; border-bottom: 1px solid #CCCCCC;border-left: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;
                         padding: 5px;">
                        <center><span class="load_img"></span></center>
                        <?php echo $this->Form->create('Chat', array("controller" => "Chats", "action" => "add", "id" => "chat" . $onlinechat['Multichat']['to_user_id'])); ?>   
                            <input type="hidden" name="data[Chat][user_id]" value="<?php echo $logged_user['User']['id']; ?>"/>
                            <input type="hidden" name="data[Chat][to_user_id]" value="<?php echo $onlinechat['Multichat']['to_user_id']; ?>"/>         
                            <input type="hidden" name="data[Chat][sender_name]" value="<?php echo $onlinechat['User']['name']; ?>"/>         
                            <input type="text" style="border: 1px solid #EEEEEE;height: 44px;margin: 1px;overflow: hidden;padding: 3px 0 3px 3px;width: 206px;"
                                   name="data[Chat][message]" class="editor10 chatboxtextarea"   autocomplete="off" 
                                   onkeydown="javascript:return checkChatBoxInputKey(event,this,'<?php echo $onlinechat['User']['name']; ?>');" />
                            <input type="submit" hidefocus="true" style="height: 0px; width: 0px; border: none; padding: 0px;" />
                        </form>
                    </div>      
                </div>
                <style type="text/css">
                    #draggable { width: 150px; height: 150px; padding: 0.5em; }
                </style>
            <script type="text/javascript">
                function chat_<?php echo $onlinechat['Multichat']['to_user_id']; ?>(){
                    var user_id = <?php echo $onlinechat['Multichat']['user_id']; ?>;
                    var to_user_id = <?php echo $onlinechat['Multichat']['to_user_id']; ?>;
                    $.post("<?php echo $this->webroot; ?>Chats/chat",{'user_id':user_id,'to_user_id':to_user_id},function(d){                   
                        d = JSON.parse(d);
                        var x = '';
                        for(var i = 0; i < d.length;i++){              
                            x +=  '<span><b>'+d[i].Chat.sender_name+':</b>&nbsp;'+d[i].Chat.message+'<br/>' ;
                        }
                        $('.chatting_<?php echo $onlinechat['Multichat']['to_user_id']; ?>').html(x);
                    });
                }
                $(document).ready(function(){  
                    $("#draggable_<?php echo $onlinechat['Multichat']['to_user_id']; ?>" ).draggable();
                    var state = true;
                    $( "#mini_<?php echo $onlinechat['Multichat']['to_user_id']; ?>" ).click(function() {
                        if ( state ) {
                            $( "#draggable_<?php echo $onlinechat['Multichat']['to_user_id']; ?>" ).animate({                 
                                height:500
                            }, 1000 );
                        } else {
                            $( "#draggable_<?php echo $onlinechat['Multichat']['to_user_id']; ?>").animate({                  
                                height:20
                            }, 1000 );
                        }
                        state = !state;
                    });
                    $('#chat<?php echo $onlinechat['Multichat']['to_user_id']; ?>').ajaxForm({   
                        //$('.load_img').html('<img src="/fbook/img/facebook-loader.gif"/>');
                        beforeSend: function(){
                            $('.load_img').html('<img src="<?php echo $this->webroot; ?>img/facebook-loader.gif"/>');
                        },
                        success: function(data){
                            $('.load_img').html('');
                            $('.chatboxtextarea').val('');
                            $('.chatboxtextarea').focus();
                            return false;
                        }
                    });
                    chat_<?php echo $onlinechat['Multichat']['to_user_id']; ?>();                     
                    featuresmonth = setInterval('chat_<?php echo $onlinechat['Multichat']['to_user_id']; ?>()',1000);                                    
                }); 
            </script>
            <?php
            $i++;
?> -->
<?php
        }
}
       ?>
<?php if (@$logged_user['User']['id']) { ?> 
        <table class="chat_sidebar" style="border:1px solid #E2E2E1; float: right;position:fixed;right:0px;bottom:0px;background: white; z-index: 50000 !important;">
            <!------------------------CHATBOX TD---------------------------------------------->
            <tr style="float:left;z-index: 5000 !important;" id="chatbox_1" class="chat_box_tr"></tr>
            <!------------------------CHATBOX TD---------------------------------------------->
            <!-------------------------ONLINE USER LIST--------------------------------------->
            <tr style="float: left;background: white;" class="chat_tr">
                <td class="chat_td " id="online_user"  rel="" style="cursor:pointer;width:200px;">
                    <div id="showcaht_btn" class="online_top_title">Online Users</div>
					<?php  //debug($findfriends); ?>
                    <div class="online_users" id="online_userbox" > <?php if($findfriends){ foreach ($findfriends as $online) { ?>
                         <div class="clickforchat2"  onclick="javascript:clickonchat(<?php echo $online['User']['id'] ?>);" user_id="chatUs_<?php echo $online['User']['id']; ?>"  id="chatUs_<?php echo $online['User']['id']; ?>" username="<?php echo $online['User']['name']; ?>" > 
						 <div class="profile_chat_img">
						 <?php
                              if ($online['User']['profile_image']) {
                                   echo $this->Html->image("../files/profileimage/" . $online['User']['profile_image'], array("style" => "height:30px;width:30px;padding:5px;"));
                              } else {
                                   echo $this->Html->image('../files/profileimage/user.png',array('alt'=>$online['User']['name'],'style' => 'height:30px;width:30px; padding:5px;'));
                              } ?>
							  </div>
							   <div class="profile_chat_name"><span><?php echo ucfirst($online['User']['name'])." ".$online['User']['last_name']; ?><span class="chat_status"><?php echo $this->Html->image('status-online.png');?></span></span></div>
                              
                         </div>
                         <?php }}else{?>
                                No user
                         <?php } ?>
                    </div>
                </td>
            </tr>
          <!-------------------------ONLINE USER LIST--------------------------------------->
        </table>
<?php } ?> 
    <script type="text/javascript">
        $(function(){
            $(".clickforchat").click(function(){
                $(".wait").html("<img src='http://assets2.sendgrid.com/mkt/assets/ajax-loader-e6c3a0b324539c02fd9259fe24fbcfcd.gif'/>")
                var online_user = $(this).attr('rel');  
                var user_id = <?php echo $logged_user['User']['id']; ?>;
                $.post('<?php echo $this->Html->url(array("controller" => "Multichats", "action" => "add")); ?>',{'user_id':user_id,'to_user_id':online_user});
                //location.reload().delay( 8000 );
                setTimeout(function () {
                    location.reload(); 
                }, 1000);
            }); 
            /*$(".close").live("click",function(){
                var to_user_id = $(this).attr('rel');
                var user_id = <?php echo $logged_user['User']['id']; ?>;
                $("#draggable_"+to_user_id).hide();
                $.post('<?php echo $this->webroot; ?>Multichats/del',{'user_id':user_id,'to_user_id':to_user_id});
            });*/
        });
    </script>
            <?php if (@$logged_user['User']['id']) { ?>
        <div class="footer_main">
<?php } else { ?>
            <div class="footer_main" style="margin-top:-50px">
<?php } ?>
<?php echo $this->Html->script(array('jquery.form')); ?>
        <script type="text/javascript">
        
               
        </script>
        <script>
            var chatuser=[];
            $(document).ready(function() {
                $('.nav-toggle').click(function(){
                    //get collapse content selector
                    var collapse_content_selector = $(this).attr('href');		
                    //make the collapse content to be shown or hide
                    var toggle_switch = $(this);
                    $(collapse_content_selector).toggle(function(){
                        if($(this).css('display')=='none'){
                            //change the button label to be 'Show'
                            toggle_switch.html('<span style="color:white">Show Chat Box</span>');
                        }else{
                            //change the button label to be 'Hide'
                            toggle_switch.html('<span style="color:white">Close Chat Box</span>');
                        }
                    });
                });
            });	
        </script>
<?php echo $this->Html->css(array('chat')); ?>
<?php echo $this->element('chatscript'); ?> 