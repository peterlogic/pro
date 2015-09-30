
/**************** All jquery function here related with inbox by T:307 ***********************************/

 
/* View inbox Message with ajax */
function view_inbox(id){
	$.ajax({
		beforeSend : function(){
			$(".overlayIcon").show();
        },
		dataType: "html",
		type: "POST",
		url: base_url+'/inboxes/viewInboxMessage',
		data: 'id='+id,
		success: function (data, textStatus){
			$("#aa").hide();
			$(".overlayIcon").hide();
			$("#showMsg").show();
			$("#viewMsg").html(data);
		}
	});
} 
 
/* View outbox Message with ajax */
function view_outbox(id){
	$.ajax({
		beforeSend : function(){
			$(".overlayIcon").show();
        },
		dataType: "html",
		type: "POST",
		url: base_url+'/inboxes/viewOubboxMessage',
		data: 'id='+id,
		success: function (data, textStatus){
			$("#aa").hide();
			$(".overlayIcon").hide();
			$("#showOutboxMsg").show();
			$("#viewOutboxMsg").html(data);
		}
	});
}


/* View Inbox section */
function viewInbox(){
	$("#showOutboxMsg").hide();
	$("#showMsg").hide();
	$("#send").hide();
	$("#write").hide();
	$("#inbox").show();
	
}

/* View Outbox section */
function viewSend(){
	$("#showOutboxMsg").hide();
	$("#showMsg").hide();
	$("#inbox").hide();
	$("#write").hide();
	$("#send").show();
}

/* View Write section */
function viewWrite(){
	$("#showMsg").hide();
	$("#showOutboxMsg").hide();
	$("#aa").hide();
	//$("#inbox").hide();
	$("#write").show();
}

/* View Write section */
function sendMessageToUser()
{
//alert("hello");
	tinyMCE.triggerSave();
	var data = $('#InboxForm').serialize();
	$.ajax({
	beforeSend : function(){
			$(".overlayIcon").show();
    },
    type : 'POST',
    url : base_url+'/inboxes/sendMessageToUser',
    data : 'data='+data,
	success: function (data, textStatus){
			
			$(".overlayIcon").hide();
			$(".viewform").hide();
			$("#newMessageLebel").hide();
			$("#write").show();
			$("#showsuccessmessage").show();
			$(".viewmessage").show();
			
		}
	});
	return false;
	
}

/************ Start custom jquery ready function  **************/


jQuery(document).ready(function(){
	
	/* Find friends with autocomplete */
	
	$( "#searchFriend" ).autocomplete(
	{ 
			source: base_url+'/users/get_user_lists',
			minLength: 1,
			select: function(event, ui) {
				//assign value back to the form element
				if(ui.item){
					$(event.target).val(ui.item.value);
				}
				//submit the form
			}
	});


	/* TinyMce Editor */
	tinyMCE.init({
		selector: "textarea",
		theme: "advanced",
		plugins : "",
		theme_advanced_resizing : true,
		mode: "exact",
		elements: "conta",
		body_id: "conta",
		width:"657",
		height : "200",
		statusbar: false
	});
});