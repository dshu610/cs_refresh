function sendData(){
	$.post(window.sendURL, {
		chatid : $("#form_chatid").val(),
		user : $("#form_user").val(),
		message : $("#form_message").val()},function(){
			$("#form_message").val('');
			updateChat();
		});
}

function extractTime(tstr){
	timestamp = new Date(parseInt(tstr.substring(0,8), 16)*1000);
	return timestamp.getHours() + ":" + timestamp.getMinutes();
}
function updateChat(){
	$.post(window.getURL, {
		chatid : $("#form_chatid").val(),
		time : curTime},function(data){
				var obj = data['messages'];
				for(var i=0; i<obj.length;i++){
					json = obj[i];
					oid = json['id'];
					
					var msg = $( "<div id=\"msg\"><span class=\"spanUser\">" + json['user'] + 
									"</span><span class=\"spanTime\"> [" + extractTime(oid) + "]</span> : " + json['message'] + "</div>");
					$("#messages").append(msg);
					$("#messages").animate({scrollTop: '400px'});
					curTime = (parseInt(oid.substring(0,8),16)+1).toString(16);
				}
		},"json");
}
$(document).ready(function(){
	updater = setInterval(updateChat,5000);
	// prevent enter button from submitting form
	$("#sendForm").bind('keypress', function(e) {
		if(e.keyCode == 13){
			e.preventDefault();
			sendData();
		}
	    
	});
});