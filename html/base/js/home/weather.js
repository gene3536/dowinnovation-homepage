$(document).ready(function(){
	var iniDay = $(".w_date");
	var iniSky = $(".w_icon");
	var iniTemp = $(".w_temp");

	// &amp; 반환
	function returnToDay(){ 
		var currentDate = new Date();
		var week = ['일','월','화','수','목','금','토'];
		return week[currentDate.getDay()];
	} 

	// 현재 시간
	function returnToTime(){
		var currentDate = new Date();
		var hour = currentDate.getHours();
		return hour;
	}

	$.get('http://www.kma.go.kr/wid/queryDFS.jsp?gridx=74&gridy=97',function(data){ 
		var dataMap = data.responseText;
			dataMap = $.parseXML(dataMap); 
		var dataBody = $(dataMap).find("data");
		var month = Number($(dataMap).find("tm").text().substr(4,2))+"월";
		var day = Number($(dataMap).find("tm").text().substr(6,2))+"일";

		var skyNumber = dataBody.first().find("sky").text();
		var skyAlt = dataBody.first().find("wfKor").text();
		var rainNumber = dataBody.first().find("pty").text();
		var temp = Math.round(dataBody.first().find("temp").text())+"℃";
		skyNumber = (parseInt(rainNumber) >0) ? "2"+rainNumber : "1"+skyNumber;

		iniDay.html(month+" "+day+" "+returnToDay()+"요일");		
		iniTemp.html(temp);
		//iniSky.html('<img src="/img/kr/common2/icon_nalsi0'+skyNumber+'.jpg" alt="'+skyAlt+'"/>');
		iniSky.find("img").first().attr({
			'src'  : '/home/images/layout/w_cr'+skyNumber+'.png' ,
			'alt'  : skyAlt
		}); 
	},'xml');

	/*$.ajax({
		url       : 'http://www.kma.go.kr/wid/queryDFS.jsp?gridx=74&gridy=97',
		method    : 'get',
		dataType  : 'xml',
		success   : function(data){ 
			var dataMap = data.responseText;
				dataMap = $.parseXML(dataMap); 
			var dataBody = $(dataMap).find("data");
			var month = Number($(dataMap).find("tm").text().substr(4,2))+"월";
			var day = Number($(dataMap).find("tm").text().substr(6,2))+"일";

			var skyNumber = dataBody.first().find("sky").text();
			var skyAlt = dataBody.first().find("wfKor").text();
			var rainNumber = dataBody.first().find("pty").text();
			var temp = Math.round(dataBody.first().find("temp").text())+"℃";
			skyNumber = (parseInt(rainNumber) >0) ? "2"+rainNumber : "1"+skyNumber;

			iniDay.html(month+" "+day+" "+returnToDay()+"요일");		
			iniTemp.html(temp);
			//iniSky.html('<img src="/img/kr/common2/icon_nalsi0'+skyNumber+'.jpg" alt="'+skyAlt+'"/>');
			iniSky.find("img").first().attr({
				'src'  : '/home/images/layout/w_cr'+skyNumber+'.png' ,
				'alt'  : skyAlt
			}); 
		},  
        error:function(e){  
            //alert("11>"+e.responseText);  
        }  	
	});*/

});

function layout(param,btn,l_wrap,r_wrap){
    var param = $(param);
    var btn = $(btn);
    
    var leftWrap = $(l_wrap);
    var rightWrap = $(r_wrap);

    var lw = $("#mainWrap").outerWidth();
    var lh = $("#mainWrap").outerHeight();

    var scrw = $(window).width();
    var scrh = $(".expansion").outerHeight();
    var du = 600;

    rightWrap.css({"position":"absolute","top":"0","right":"0","width":"0","height":lh,"overflow":"hidden","z-index":"10000"});
    $(".expansion").css({"opacity":"0","width":"950px","margin":"0 auto"});

    function getWidth(){
        /*
        if(scrw<1280){
            $(".expansion").css({"width":"950px","margin":"0 auto"});

        }
     
        if(scrw>1280){
            $(".expansion").css({"width":"auto"});
        }

        if(scrw>1800){
            $(".expansion").css({"width":"1700px","margin":"0 auto"});
        }
        */

        

        scrh = $(".expansion").outerHeight();
        scrh = scrh+200;


        rightWrap.stop(true,false).animate({"width":lw},{duration:du,easing:"easeOutCubic"});
        $(".expansion").stop(true,false).animate({"opacity":"1"},{duration:du*2,easing:"easeOutCubic"});

        if(scrh>lh){
            rightWrap.css({"height":scrh});
        }else{
            rightWrap.css({"height":lh});
        }
    }

    btn.click(function(){
        lw = $("#mainWrap").outerWidth();
        lh = $("#mainWrap").outerHeight();
        //scrw = $(window).width();
        getWidth();
        return false;
    });

    $("#return1, #return2").click(function(){
        rightWrap.stop(true,false).animate({"width":"0"},{duration:du,easing:"easeOutCubic"});
        $(".expansion").stop(true,false).animate({"opacity":"0"},{duration:du/2,easing:"easeOutCubic"});
        return false;
    });


    $(window).resize(function(){
        if(rightWrap.width() > 1){
            du = 0;
            lw = $("#mainWrap").outerWidth();
            lh = $("#mainWrap").outerHeight();
            //scrw = $(window).width();
            getWidth();
            du = 600;
        }
    });
}