function sendData(chatid,user,message,txtInput){
	$.post(window.sendURL, {
		chatid : chatid,
		user : user,
		message : message},function(){
			$("#" + txtInput).val('');
			updateChat(chatid,$(".chat_messages"));
		});
}

function extractTime(tstr){
	timestamp = new Date(parseInt(tstr.substring(0,8), 16)*1000);
	return timestamp.getHours() + ":" + timestamp.getMinutes();
}
function updateChat(chatid){
	$.post(window.getURL, {
		chatid : chatid,
		time : curTime},function(data){
				var obj = data['messages'];
				for(var i=0; i<obj.length;i++){
					json = obj[i];
					oid = json['id'];
					
					var msg = $( "<div class=\"chat_msg\"><span class=\"chat_spanUser\">" + json['user'] + 
									"</span><span class=\"chat_spanTime\"> [" + extractTime(oid) + "]</span> : " + json['message'] + "</div>");
					$(".chat_messages").append(msg);
					$(".chat_messages").animate({scrollTop: $(".chat_messages").height()});
					curTime = (parseInt(oid.substring(0,8),16)+1).toString(16);
				}
		},"json");
}
