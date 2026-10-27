function myScrap(query,dir)
{
	$.get('/base/php/cmn.ajax.php?action=myScrap&dir='+dir+'&'+query,function(data){ 
		var res = parseInt(data);
		if(res == -1) alert('로그인 후 이용하세요.');
	});
}

function _logout(rt)
{
	$.get('/base/php/cmn.ajax.php?action=logout',function(){ 
		location.href = (rt)? rt : '/home';
	});
}

function shareSNS(f,url,tt)
{ 

	var titl = tt;
	titl = titl.replace('"', '&quot;');
	titl = titl.replace('"', '&quot;');
	titl = titl.replace('&gt;','>');
	titl = encodeURIComponent(titl);
	var link = encodeURIComponent(url);	
	
	if(f=="fb"){
		if(url!=""){
			document.getElementById("fbOgURL").value = link;
		}else{
			document.getElementById("fbOgURL").value = strFbOgURL;
			//window.open("http://www.facebook.com/sharer/sharer.php?u="+url);
		}
		window.open("http://www.facebook.com/sharer/sharer.php?u=" + link + "&amp;t=" + titl);

	}
	else if(f == "tw"){
		window.open("http://twitter.com/intent/tweet?text="+titl+"&url="+link);
	}
}


function back_player(server_num, service_id){
	$("#videoMovie"+server_num+"").html("<iframe id='ifrm' name='ifrm' src='/wenMedia/player.php?type=aod&id="+service_id+"&autoStart=Y&aodType=M&controlbarYn=Y&width=150&height=50' frameborder='0' allowfullscreen=true style='position:absolute;top:0px;left:0px;width:150px; height:50px;>'></iframe>");

}

$(document).ready(function(){
	$("a.submitBtn").click(function(){
		$(this).parents().find(".ASubmitForm").submit();
	});

    $("#pass").keydown(function (key) { 
        if(key.keyCode == 13){//키가 13이면 실행 (엔터는 13)
            $("a.submitBtn").trigger("click");
			return false;
        } 
    });

});