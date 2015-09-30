<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
      var chatuser=[];
    //updateactivity();
    $(document).ready(function(){
         setInterval(function() {
            autochat();
        }, 1000); 
        setInterval(function() {
            updateactivity();
        }, 100000); 
        setInterval(function() {
            getonlineuser();
        }, 10000);  
//         $("#showcaht_btn").click(function(){
//            $('#online_userbox').toggle();
//        });
  //adverts_show();
        //eventss = setInterval('adverts_show()',30000);
    })
    
    /*-----------------------------------------------GET ONLINE USER--------------------------------------------------------*/
     function getonlineuser(){
        //  $('.chatuser').remove();
        $.post('<?php echo $base_url; ?>/Chats/getonlineuser',{},function(onlineuser){
			//alert(onlineuser);
            data=JSON.parse(onlineuser);
            console.log(data.list);
            var use='';
            //var use='<div class="chatuser">';
            if(data.error=='0'){
            $.each(data.list,function(as,value){
                 
                
                //var use='';
                use+='<div onclick="javascript:clickonchat('+value.users.id+');"  style="margin: 2px;" username="'+value.users.name+'" user_id="'+value.users.id+'" id="chatUs_'+value.users.id+'" class="clickforchat2">';
                use+='<div class="profile_chat_img"><img style="height:30px;width:30px;padding:5px;" alt="upinder" src="'+value.users.profile_image+'"></div>';
                use+='<div class="profile_chat_name"><span >'+value.users.name+' '+value.users.last_name;
                use+='<span class="chat_status"><?php echo $this->Html->image('status-online.png');?></span></span></div></div>';
                            
                // $('.chatuser').append(use);   
            })
            }else{
            use +='No User';
            }
           // use +='</div>'
            $('#online_userbox').html(use);
        })
    }
       /*-----------------------------------------------GET ONLINE USER--------------------------------------------------------*/
       /*--------------------------------------------------Chat open on click  -------------------------------------------------*/
        function clickonchat(chat_id){
			var username=$('#chatUs_'+chat_id).attr('username');
			
        var token=0;
        // var username=chat_user;
        var userid=chat_id;
                
                
                
        for(var i=0;i<chatuser.length;i++){
            if(chatuser[i]==userid){
                token=1; 
            }
        }
        if(token==0){
            chatuser.push(userid);
            $.post('<?php echo $base_url;?>/Chats/chatopen',{'user_id':userid,'sender':username},function(openchat){
                console.log(openchat); 
            })
            if(chatuser.length>4){
                var offchat='user_'+chatuser[0];
                $('#'+offchat).remove();
                var indexToRemove = 0;
                var numberToRemove = 1;
                      
                      
                chatuser.splice(indexToRemove, numberToRemove);
            }
            open_chat(userid);
            $.post('<?php echo $base_url ; ?>/Chats/getchat',{'user_id':userid},function(chat){
                var chatu=JSON.parse(chat);
                //console.log(chatu);
                $.each(chatu,function(j,val){
                    //console.log(val.chats.id);
                    var t='';
                    t +='<div class="chat_fix"><span><b>'+val.chats.sender_name+':</b></span><span style="word-wrap:break-word;">'+val.chats.message+'</span></div>'
                    $('#chat_'+userid).append(t);
                               
                })
                $("#chat_"+userid).scrollTop($("#chat_"+userid)[0].scrollHeight);
            })
        }
                 
     }
       /*----------------------------------------------------------chat open on click---------------------------------------------*/
       /*--------------------------------------------------------------chat box html-------------------------------------------------------------*/
        function open_chat(userid){
        var username=$('#chatUs_'+userid).attr('username');
        
        var y = '';
        y += ' <td id="user_'+userid+'" style="z-index:5000  !important;margin-top:-173px;float:left;"> <div style="bottom:5px;  display: block;float:left; width: 225px;z-index: 5000;border:1px solid #E2E2E1;">';
        y +='<div class="usre-heading" ><span >'+username+'</span>';
        y +='<span style="float: right;  margin-top: 0;  position: absolute;  right: 0;  top: 7px;  width: 10%;"><img src="<?php echo $this->webroot; ?>img/cross.png" cursor:pointer;margin-left:-7px;margin-top:-2px;" id="cross" onClick=" javascript:$(this).parent().parent().parent().remove(); closechat('+userid+');"></i></span>';
        y +='</div>';
                
        y +='<div id="chat_'+userid+'"" style="background: none repeat scroll 0 0 white;  border: medium none;  box-sizing: border-box;  height: 240px;  overflow-y: scroll;  padding-left: 4px;  width: 100%;"></div>';
        y +='<textarea  onClick="javascript:seen('+userid+');" user_id="'+userid+'" username="'+username+'" class="chat_input" onkeypress="javascript:chatsent()" rows=1 style="resize:none;width:100%;border:0px;"></textarea>';
        y +='  </div></td>'
        // var chatboxtitle='michle';
        // y +='<div><div class="chatboxhead" style=" right: 200px;float:left;"><div class="chatboxtitle">'+chatboxtitle+'</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">-</a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown=""></textarea></div></div></>';

        $('#chatbox_1').append(y);  
    }
       /*----------------------------------------------------------------chat box html--------------------------------------------------------------*/
       
       /*------------------------------------------------------------------------close chat----------------------------------------------------------*/
       
                 var newchat=[];
    function closechat (til){
        //alert(til);

        var newchat=[];

        for(var i=0;i<chatuser.length;i++){
            var frt=chatuser[i];
            if(frt!=til){
                //alert(frt);
                newchat.push(frt);
       
            }
            $.post('<?php echo $base_url ; ?>/Chats/chatclose',{'user_id':til},function(openchat){
                console.log(openchat); 
            })
        }
        console.log(newchat)   // var chatuser=[];
        chatuser=newchat;
   


    }
    console.log(chatuser);
       /*------------------------------------------------------------------------close chat----------------------------------------------------------*/
       
       /*---------------------------------------------------------------------------------------------------------------------------------------------*/
         var token_ms=0;
    function chatsent (){
    
        $('.chat_input').keypress(function(e){
            if(e.which==13 && token_ms==0){
                var msg= $(this).val();
                var user_id=$(this).attr('user_id');
                var user_name=$(this).attr('username');
                $(this).val('');
                token_ms=1;
                $.post('<?php echo $base_url; ?>/Chats/addchat',{'user_id':user_id,'user_name':'<?php echo $logged_user['User']['name']
?>','msg':msg},function(d){
                    token_ms=0;
                    $.post('<?php echo $base_url; ?>/Chats/getchat',{'user_id':user_id},function(chat){
                        $('#chat_'+user_id).find('.chat_fix').remove();
                        var chatu=JSON.parse(chat);
                        //console.log(chatu);
                        $.each(chatu,function(j,val){
                            //console.log(val.chats.id);
                            var t='';
                            t +='<div class="chat_fix" ><span><b>'+val.chats.sender_name+':</b></span><span class="chat_conversation">'+val.chats.message+'</span></div>'
                            $('#chat_'+user_id).append(t);
                               
                        })
                    })
                    $("#chat_"+user_id).scrollTop($("#chat_"+user_id)[0].scrollHeight);
                    //groupcomments(loder);
                })
            }
        })
    }
    
       /*---------------------------------------------------------------------------------------------------------------------------------------------*/
       
       /*---------------------------------------------------------------------------------------------------------*/
        var asd=0;
    function auto(){
        //alert('fgdfg');
      
        if(asd<chatuser.length){
          
           
            var chatid=chatuser[asd];
            // alert(chatid);
            asd++;
            $.post('<?php echo $base_url; ?>/Chats/getchat',{'user_id':chatid},function(chaton){
                //console.log('#chat_'+chatid);
                $('#chat_'+chatid).find('.chat_fix').remove();
                var chatus=JSON.parse(chaton);
                // console.log(chatus);
                $.each(chatus,function(js,valu){
                    //console.log(val.chats.id);
                    var ts='';
                    ts +='<div class="chat_fix" ><span><b>'+valu.chats.sender_name+':</b></span><span class="chat_conversation">'+valu.chats.message+'</span></div>'
                    $('#chat_'+chatid).append(ts);
                            
                })
                //$("#chat_"+chatid).scrollTop($("#chat_"+chatid)[0].scrollHeight);
                console.log(chatid+'dsfsdf');
                auto();
                // var chatid='';
            }) 
        }
        else{
            asd=0;
          
        }
    }
    function autochat(){
        var fot=1;
        var asd=0;
      
        if(chatuser.length>0){
            auto();
    
        }
    }
    
    
               
    
       /*----------------------------------------------------------------------------------------------------------*/
       
       /*------------------------------------------------------------------------------------------------------------------*/
       function seen(ping){
        //alert(ping);
        $('#msg_ping').hide();
        $.post('<?php echo $base_url; ?>/Chats/chatseen',{'user_id':ping},function(o){
            console.log(o); 
        })
    }
    function updateactivity(){
        $.post('<?php echo $base_url; ?>/Chats/updateactivity',{'user_id':'<?php echo $logged_user['User']['id']; ?>'},function(o){
            console.log(o); 
            //updateactivity();
        })
    }
       /*------------------------------------------------------------------------------------------------------------------*/
  
    jQuery(document).ready(function(){        
        jQuery('#flash').fadeOut(5000); 
            
     
   }); 
  
</script>
<?php if ($pop_open) {

    foreach ($pop_open as $pop) { ?>
        <script type="text/javascript">
            var qwe=<?php echo $pop['chat_open']['pop_open']; ?>;
            $('.clickforchat2').show();
            var y = '';
            y += ' <td id="user_<?php echo $pop['chat_open']['pop_open']; ?>" style="z-index:5000 !important;margin-top:-173px;float:left;"> <div style="bottom:5px;  display: block;float:left; width: 225px;z-index: 5000;border:1px solid #E2E2E1;">';
            y +='<div class="usre-heading" ><span ><?php echo $pop['chat_open']['sendername']; ?></span>';
            y +='<span style="float: right;  margin-top: 0;  position: absolute;  right: 0;  top: 7px;  width: 10%;"><img src="<?php echo $this->webroot; ?>img/cross.png" style="cursor:pointer;margin-left:-7px;margin-top:-2px;" id="cross" onClick=" javascript:$(this).parent().parent().parent().remove(); closechat('+qwe+');"></i></span>';
            y +='</div>';
                                
            y +='<div id="chat_<?php echo $pop['chat_open']['pop_open']; ?>" style="background: none repeat scroll 0 0 white;  border: medium none;  box-sizing: border-box;  height: 240px;  overflow-y: scroll;  padding-left: 4px;  width: 100%;"></div>';
            y +='<textarea onClick="javascript:seen('+qwe+');" user_id="<?php echo $pop['chat_open']['pop_open']; ?>" username="<?php echo $pop['chat_open']['sendername']; ?>" class="chat_input" onkeypress="javascript:chatsent()" rows=1 style="resize:none;width:100%;border:0px;"></textarea>';
            y +='  </div></td>';

            $('#chatbox_1').append(y);  
            chatuser.push(qwe);
        </script>
    <?php }
} ?>