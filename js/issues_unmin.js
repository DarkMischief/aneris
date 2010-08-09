var asyncRequest;
var asyncID;

function viewIssue(id){
	document.location.href = "view.php?id="+id;
}

function dealWithIssue(command,id){
	try{
		asyncRequest=getHTTPObject();
		if(command=="delete"){
			asyncRequest.onreadystatechange=deleteStateChange;
			asyncRequest.open("GET","update.php?delete="+id,true);
			asyncRequest.send(null);
		}
		else if(command=="pending"){
			asyncRequest.onreadystatechange=pendingStateChange;
			asyncRequest.open("GET","update.php?pending="+id,true);
			asyncRequest.send(null);
		}
		else if(command=="incomplete"){
			asyncRequest.onreadystatechange=incompleteStateChange;
			asyncRequest.open("GET","update.php?incomplete="+id,true);
			asyncRequest.send(null);
		}
		else if(command=="complete"){
			asyncRequest.onreadystatechange=completeStateChange;
			asyncRequest.open("GET","update.php?complete="+id,true);
			asyncRequest.send(null);
		}
	}
	catch(exception){
		alert("Request failed: "+exception.message);
	}
}

function getHTTPObject(){
	if(window.ActiveXObject){
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if(window.XMLHttpRequest){
		return new XMLHttpRequest();
	}
	else{
		alert("Your browser does not support AJAX.");
		return null;
	}
}

function deleteStateChange(){
	if(asyncRequest.readyState==4&&asyncRequest.status==200){
		asyncID=parseInt(asyncRequest.responseText);
		
		if(asyncID!="no"){
			$("#issue"+asyncID).fadeOut("slow").removeClass('hoverable');
			
			var i=0;
			$(".hoverable").each(function(){
				if((i%2)==0){
					$(this).css({'background-color':'#d2b48c'});
				}
				else{
					$(this).css({'background-color':'#ffffff'});
				}
				
				i++;
			});
			
			$("#message-box").css({'background-color':'#00cd66'}).html("<p>Issue deleted.</p>").fadeIn().oneTime(2000,function(){
				$(this).fadeOut();
			});
		}
		else{
			$("#message-box").css({'background-color':'#f08080'}).html("<p>Issue not deleted.</p>").fadeIn().oneTime(2000,function(){
				$(this).fadeOut();
			});
		}
	}
}

function pendingStateChange(){
	if(asyncRequest.readyState==4&&asyncRequest.status==200){
		asyncID=parseInt(asyncRequest.responseText);
		
		if(asyncID!="no"){
			var issueID="#issue"+asyncID+"-status";
			var cellID=".issue"+asyncID+"-status-cell";
			$(cellID).css({'background-color':'#ffc125'});
			$(issueID).html("pending");
			$("#message-box").css({'background-color':'#00cd66'}).html("<p>Issue status updated.</p>").fadeIn().oneTime(2000,function(){
				$(this).fadeOut();
			});
		}
		else{
			$("#message-box").css({'background-color':'#f08080'}).html("<p>Issue status not updated.</p>").fadeIn().oneTime(2000,function(){
				$(this).fadeOut();
			});
		}
	}
}

function incompleteStateChange(){
	if(asyncRequest.readyState==4&&asyncRequest.status==200){
		asyncID=parseInt(asyncRequest.responseText);
		
		if(asyncID!="no"){
			var issueID="#issue"+asyncID+"-status";
			var cellID=".issue"+asyncID+"-status-cell";
			$(cellID).css({'background-color':'#f5782a'});
			$(issueID).html("incomplete");
			$("#message-box").css({'background-color':'#00cd66'}).html("<p>Issue status updated.</p>").fadeIn().oneTime(2000,function(){
				$(this).fadeOut();
			});
		}
		else{
			$("#message-box").css({'background-color':'#f08080'}).html("<p>Issue status not updated.</p>").fadeIn().oneTime(2000,function(){
				$(this).fadeOut();
			});
		}
	}
}

function completeStateChange(){
	if(asyncRequest.readyState==4&&asyncRequest.status==200){
		asyncID=parseInt(asyncRequest.responseText);
		
		if(asyncID!="no"){
			var issueID="#issue"+asyncID+"-status";
			var cellID=".issue"+asyncID+"-status-cell";
			$(cellID).css({'background-color':'#00cd66'});
			$(issueID).html("complete");
			$("#message-box").css({'background-color':'#00cd66'}).html("<p>Issue completed.</p>").fadeIn().oneTime(2000,function(){
				$(this).fadeOut();
			});
		}
		else{
			$("#message-box").css({'background-color':'#f08080'}).html("<p>Issue status not set to complete.</p>").fadeIn().oneTime(2000,function(){
				$(this).fadeOut();
			});
		}
	}
}