<?php
echo $this->element('top-header');
?>
<div style="padding: 10px;">
    <div>
        <div>
            <div class="row-fluid">
                <div class="span6">
                    <div class="well-small well">
                         <h5>Posts you may be Interested in</h5>
                        <div id="postumayknow">

                        </div>
                    </div>
                    <div class="well-small well">
                        <h5>Grants you may be Interested in</h5>
                        <div id="grantumayknow">

                        </div>
                    </div>
                   <div class="well-small well">
                        <h5>Feature of the month</h5>
                        <div id="Featuresmonth">

                        </div>
                    </div>
                </div>
                <div class="span6 well-small well">
                    <h4>Recent News</h4>
                    <div>
                        <div id="newsfeed"></div>
                             <?php  foreach($news as $new){   ?>
                   <div style="min-height:65px;" class="well well-small tio_news">
                   <a href="/NewsArticles/view/<?php echo $new['NewsArticle']['id']; ?>"><?php echo $new['NewsArticle']['title']; ?></a><br />
                   <p><?php echo substr($new['NewsArticle']['description'],100,300); ?></p>
                   </div>  
                         <?php    } ?>
                        <?php  foreach($twittersfeed->channel->item as $twit){   ?>
                   <div style="min-height:65px;" class="well well-small">
                    <a href="<?php echo (string)$twit->link ; ?>"><?php echo (string)$twit->title;?></a><br />
                      <p><?php echo (string)$twit->pubDate ; ?></p>
                   <p><?php echo (string)$twit->description ; ?></p>
                   </div>
                         <?php    } ?>
                    </div>                      
                </div>
            </div>
        </div>
    </div>



</div>

<!-- Modal Start ---->
<div id="connect" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
<form action="/connections/add" controller="connections" id="ConnectionAddForm" method="post" accept-charset="utf-8"><div style="display:none;"><input name="_method" value="POST" type="hidden"></div><div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3 id="myModalLabel">&nbsp;&nbsp;<img src="/img/msg.png" alt="">Invite to connect on Academatch</h3>
</div>
<div class="modal-body">
<input name="data[Connection][user_id]" value="<?php echo $userid; ?>" type="hidden">
<input name="data[Connection][connectedwith]" value="" id="cnw" type="hidden">
<input name="data[Connection][status]" value="1" type="hidden">
        <div class="row-fluid">
            <div class="span4">How do you know him?</div>
            <div class="span4">
            <table>
            <tbody><tr><td><input name="data[Connection][relation]" value="Colleague" type="radio"></td><td width="200">Colleague</td></tr>
             <tr><td><input name="data[Connection][relation]" value="Classmate" type="radio"></td><td width="200">Classmate</td></tr>
              <tr><td><input name="data[Connection][relation]" value="We've done business together" type="radio"></td><td width="200">We've done business together</td></tr>
               <tr><td><input name="data[Connection][relation]" value="Friend" type="radio"></td><td width="200">Friend</td></tr>
                <tr><td><input name="data[Connection][relation]" value="Other" type="radio"></td><td width="200"> Other</td></tr>
                 <tr><td><input name="data[Connection][relation]" value=" I don't know ashish" type="radio"></td><td width="200"> I don't know him</td></tr>
            </tbody></table></div>
        </div>
        <div class="row-fluid">
        <div class="span4">Include a personal note: (optional)</div>    
           <div class="span4">           
             <textarea name="data[Connection][notes]" rows="5" cols="10"></textarea>
           </div>
        </div>
       <span style="color:maroon;margin-left:75px;">Important:</span> Only invite people you know well and who know you. 
        
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
<button class="btn btn-primary" type="submit">Save changes</button>
</div>
</form>
</div>
<!-- Modal Over ---->
<?php echo $this->element('footer'); ?>
<script type="text/javascript">
   /*
    function pplumk(){
        $.get('/Home/pplumayknow',function(d){
            $('#pplumayknow').children('div').slideUp();
            $('#pplumayknow').html('');
            d = JSON.parse(d);
            var x = '';
            for(i = 0; i<d.length;i++){
                x += '<div style="min-height:65px;" class="well well-small">';
                x += '<img style="height:60px; width:60px" src="/files/profileimage/'+d[i].User.profile_image+'" align="left" hspace="5" />'
                x += '<a href="/users/profile_view/'+d[i].User.id+'">'+d[i].User.first_name + ' '+d[i].User.last_name+'</a><br />' ;
                if(d[i].UserWorkSince.length > 0){
                    x += '<p>'+d[i].UserWorkSince[d[i].UserWorkSince.length - 1].exp_title+ ' at ' + d[i].UserWorkSince[d[i].UserWorkSince.length - 1].exp_company_name +'</p>';
                }else if(d[i].UserEducation.length > 0){
                    x += '<p>'+d[i].UserEducation[d[i].UserEducation.length - 1].edu_degree + '('+d[i].UserEducation[d[i].UserEducation.length - 1].edu_fieldofstudy+')'+ ' from ' + d[i].UserEducation[d[i].UserEducation.length - 1].edu_school +'</p>';
                }
                x +='<a href="#connect" role="button" data-toggle="modal" onClick="javascript: $(\'#cnw\').val('+d[i].User.id+')" class="btn btn-small pull-right" style="margin-top:-15px;"><i class="icon-plus"></i> Connect</a>'
                x += '</div>';
            }
            $('#pplumayknow').html(x);
        });
        
    }
    function cmpnyumk(){
        $.get('/Home/cmpnumayknow',function(d){
            $('#cmpnyumayknow').children('div').slideUp();
            $('#cmpnyumayknow').html('');
            d = JSON.parse(d);
            var x = '';
            for(i = 0; i<d.length;i++){
                x += '<div style="min-height:65px;" class="well well-small">';
                x += '<img style="height:60px; width:60px" src="/files/companyimg/'+d[i].Company.logo+'" align="left" hspace="5" />'
                x += '<a href="/companies/view/'+d[i].Company.company_name+'">'+d[i].Company.company_name+'</a><br />' ;
                x += '<p><b>'+d[i].Company.company_size +'</b></p>';
                x += '</div>';
            }
            $('#cmpnyumayknow').html(x);
        });
        
    } */
    function news_updates(){
         $.post('/Home/newsfeeds',function(d){
             //$('#newsfeed').children('div').slideUp();
           // $('#newsfeed').html('');
            d = JSON.parse(d);
            var x = '';            
            for(i = 0; i<d.length;i++){
                if(d[i].Company){
                    x += '<div style="min-height:65px;" class="well well-small tio_news">';
                    x += '<img style="height:60px; width:60px;margin:15px;" src="/files/companyimg/'+d[i].Company.logo+'" align="left" hspace="10"/>'
                    x += '<a href="/companies/view/'+d[i].Company.company_name+'">'+d[i].Company.company_name+'</a><br />' ;
                    x += '<p><b>'+d[i].Companyupdate.title +'</b></p>';
                    x += '<p>'+d[i].Companyupdate.description.substring(100,300) +'</p>';
                    x += '</div>';
                }else{
                    x += '<div style="min-height:65px;" class="well well-small tio_news">';
                    x += '<img style="height:60px; width:60px;margin:15px;" src="/files/grouplogo/'+d[i].UserGroup.logo+'" align="left" hspace="10"/>'
                    x += '<a href="/UserGroups/home_group/'+d[i].UserGroup.group_name+'">'+d[i].UserGroup.group_name+'</a><br />' ;
                    x += '<p><b>'+d[i].Groupupdate.title +'</b></p>';
                    x += '<p>'+d[i].Groupupdate.description.substring(100,300) +'</p>';
                    x += '</div>';
                }
                
            }
            $('#newsfeed').html(x);
            //$('.tio_news:first').before(x);
            //$('.tio_news:last').remove();
        });
    }
  /*  function connections(){
        $.post('/Home/connections',function(d){
            d = JSON.parse(d);
            if(d.count > 0){
                $('#connectionscnt b').html(d.count + ' Connections');
                x = '';
                for(i = 0; i<d.count; i++){
                    x += '<div style="height:45px;">';
                    x += '<img style="height:40px; width:40px;margin:15px;" src="/files/profileimage/'+d.data[i].User.profile_image+'" align="absmiddle" hspace="5" />';
                    x += '<a href="/users/profile_view/'+d.data[i].User.id+'" >'+d.data[i].User.first_name+ ' ' +d.data[i].User.last_name + '</a>';
                    x += '</div>';
                }
                $('#yourconnections').html(x);
            }
        });
    }*/
    function pstumayknow(){
        $.get('/Home/postumayknow',function(d){
            $('#postumayknow').children('div').slideUp();
            $('#postumayknow').html('');
            d = JSON.parse(d);
            var x = '';
            for(var i = 0; i < d.length;i++){
                x += '<div style="min-height:65px;" class="well well-small">';
                x += '<a href="/PostJobs/view/'+d[i].PostJob.id+'"><img style="height:70px; width:60px;margin-right:15px;margin-top:5px;" src="/files/postlogo/'+d[i].PostJob.id+d[i].PostJob.logo+'" align="left" hspace="5" />'
                x +=  d[i].PostJob.job_title+'<br />' ;
                x +=  d[i].PostJob.company+'</a><br />' ;
                x += '<p><b>Posted on :</b>'+d[i].PostJob.date +'</p>';
                x += '</div>';
            }
            //console.log(x);
                $('#postumayknow').html(x);
        });
        
    }
    
    function grantumayknow(){
        $.get('/Home/grantumayknow',function(d){
            $('#grantumayknow').children('div').slideUp();
            $('#grantumayknow').html('');
            d = JSON.parse(d);
            var x = '';
            for(var i = 0; i < d.length;i++){
                x += '<div style="min-height:65px;" class="well well-small">';
                x += '<a href="/Grants/view/'+d[i].Grant.id+'"><img style="height:60px; width:60px;margin:15px;" src="/files/grantlogo/'+d[i].Grant.id+d[i].Grant.logo+'" align="left" hspace="5" />'
                x +=  d[i].Grant.title+'<br />' ;
                x +=  '<p><b>Department:</b>'+d[i].Grant.department+'</a><br />' ;
                x += '<p><b>Posted on :</b>'+d[i].Grant.posted_date +'</p>';
                x += '</div>';
            }
                $('#grantumayknow').html(x);
        });
        
    }
    
     function Featuresmonth(){
        $.get('/Features/Featuresmonth',function(d){
            $('#Featuresmonth').children('div').slideUp();
            $('#Featuresmonth').html('');
            d = JSON.parse(d);
            var x = '';
            for(var i = 0; i < d.length;i++){
                x += '<div style="min-height:65px;" class="well well-small">';
               // x += '<a href="/Features/view/'+d[i].Feature.id+'">'
                x +=  '<b>'+d[i].Feature.title+'</b><br />' ;
               // x +=  '<p>Expire on:</b>'+d[i].Feature.date_expiry+'<br />' ;
                x += '<p>'+d[i].Feature.description.substring(100,300) +'</p>';
                x += '<p><a href="/Features/view/'+d[i].Feature.id+'">Read More...&raquo;</a></p>';
                x += '</div>';
            }
            //console.log(x);
                $('#Featuresmonth').html(x);
        });
        
    }
    
    
    
     $(document).ready(function(){
        //pplumk();
       // cmpnyumk();
        Featuresmonth();
        //connections();
        pstumayknow();
        grantumayknow();
        news_updates();
       // pplumayknow = setInterval('pplumk()',5000);
       // cmpnymk = setInterval('cmpnyumk()',6000);
        featuresmonth = setInterval('Featuresmonth()',20000);
        newsupdtes = setInterval('news_updates()',20000);
        postumayknow = setInterval('pstumayknow()',20000);
        grant_umayknow = setInterval('grantumayknow()',20000);
    });
</script>   

