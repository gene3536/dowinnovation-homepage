//메인페이지 관광지 
var mc09_list = new Array();
mc09_list[0] = "sub.php?menukey=399#m_allWrap#sc51_list_no1"; //영국사
mc09_list[1] = "sub.php?menukey=399#m_allWrap#sc51_list_no5"; //함벽정
mc09_list[2] = "sub.php?menukey=399#m_allWrap#sc51_list_no2"; //강선대
mc09_list[3] = "sub.php?menukey=399#m_allWrap#sc51_list_no6"; //여의정
mc09_list[4] = "sub.php?menukey=399#m_allWrap#sc51_list_no3"; //비봉산
mc09_list[5] = "sub.php?menukey=399#m_allWrap#sc51_list_no7"; //자풍서당
mc09_list[6] = "sub.php?menukey=399#m_allWrap#sc51_list_no4"; //봉황대
mc09_list[7] = "sub.php?menukey=399#m_allWrap#sc51_list_no8"; //용암


$(document).ready(function(){

	//피씨메뉴
	var menuObj  = $("#menu_wrap ul");
	var menuObj2 = menuObj.find(".menu2ndPC");
	var headerH  = ($(window).width() >= 990)? 120 : $("#head").height() ;
	
	$("#head_w").append('<div id="headerBg" style="position:absolute; width:100%; height:'+headerH+'px; top:0px; left:0px; z-index:991;"></div>');
	if($(window).width() >= 990) $("#headerBg").show();
	else $("#headerBg").hide();
	
	menuObj.find(">li >div").hide();
	/*menuObj.find(">li").hover(function(){ 
		menuShow(); 
	});

	$("#m_con_w, .s_con_w, #footer_w, .m_archive_w, .head_w, #head_w, #headerBg").hover(function(){
		menuHide(); 
	});*/		
	
	menuObj.find(">li").on({
		mouseover : function(){
			menuShow(); 
		},
		focusin : function(){
			menuShow(); 
		}
	});		

	$("#m_con_w, .s_con_w, #footer_w, .m_archive_w, .head_w, #head_w, #headerBg").hover(function(){
		menuHide(); 
	});	
	$("#m_con_w, .s_con_w, #footer_w, .m_archive_w, #headerBg").focusin(function(){
		menuHide(); 
	});
	
	function menuHide(){
		if(menuObj2.css("display") != "none") {
			setTimeout(function(){menuObj2.hide(120);} ,50);
		}
	}
	
	function menuShow(){ 
		if(menuObj2.css("display") == "none") {
			setTimeout(function(){menuObj2.show(200);} ,50);
		}
	}		
	
	$(".vis_w .vis01, .vis_w .vis02").on({
		mouseover : function(){
			$(this).find("div").first().attr("class",$(this).find("div").first().attr("class").replace("_on","_off"));
		},
		mouseleave : function(){
			$(this).find("div").first().attr("class",$(this).find("div").first().attr("class").replace("_off","_on"));
		},
		focusin : function(){
			$(this).find("div").first().attr("class",$(this).find("div").first().attr("class").replace("_on","_off"));
		},
		focusout : function(){
			$(this).find("div").first().attr("class",$(this).find("div").first().attr("class").replace("_off","_on"));
		}
	});			
	
	menuObj.find(">li").on({
		mouseover : function(){
			menuShow(); 
		},
		focusin : function(){
			menuShow(); 
		}
	});	


	var popupIMG = menuObj.find(">li").children().find(".sm li").find("._onoff");
	
	//탑메뉴 새창 이미지 온오프
	if(popupIMG.length>0){	
		popupIMG.parent().on("hover",function(){ 
			$(this).find("img").attr("src", $(this).find("img").attr("src").replace("off.png","on.png"));
		});
		popupIMG.parent().on("mouseout",function(){ 
			$(this).find("img").attr("src", $(this).find("img").attr("src").replace("on.png","off.png"));
		});
	}

	function open_div(id){ //모바일일때 검색 영역
		if(id == "srarch_div"){
			document.getElementById("srarch_div").style.display="block";//보이기
		}
	}
	function close_div(id){
		if(id == "srarch_div"){
			document.getElementById("srarch_div").style.display="none";//안보이기
		}	
	}

	//tm 메뉴 
	var menuTM1 = $(".menuTM1dep");	
	var menuTM2 = $(".menuTM2dep");	
	var menuTM3 = $(".menuTM3dep");	

	menuTM3.hide();
	menuTM2.find(".sm_2d_on").find(".menuTM3dep").show();

	menuTM1.find(".menuTM1depChd").on("click","a",function(e){ 
		e.preventDefault();
		var spd = ($(this).parent().find(".menuTM2depChd").length) * 20;
		if($(this).parent().find(".menuTM2dep").length > 0){	
			if($(this).parent().hasClass("on")){
				menuTMHide($(this).parent(),2,spd);
				_scrollTop($("#head_w"));
			}else{ 
				menuTMShow($(this).parent(),2,spd);
				if((menuTM1.height()+100) > $(window).height()){
					_scrollTop($(this));
				}
			}
			return false; 	
		}else {
			location.href = this.href;
		}
	});

	menuTM2.find(".menuTM2depChd").on("click","a",function(e){ 
		e.preventDefault();
		var spd = ($(this).parent().find(".menuTM3depChd").length) * 50;
		if($(this).parent().find(".menuTM3dep").length > 0){ 
			if($(this).parent().find(".menuTM3dep").css("display") == "block"){
				menuTMHide($(this).parent(),3,spd);
			}else{ 
				menuTMShow($(this).parent(),3,spd);				
			}
			return false; 
		}else {
			location.href = this.href;
		}
	});

	function menuTMHide(obj,dep,spd)
	{
		obj.find(".menuTM"+dep+"dep").slideUp(spd,function(){
			obj.find(".menuTM"+dep+"dep").hide();	
			if(dep == 2){
				obj.removeClass("on");
				obj.addClass("off");
			}else{
				obj.removeClass("sm_"+dep+"d_on");
				obj.addClass("sm_"+dep+"d_off");
			}
		});	
	}

	function menuTMShow(obj,dep,spd)
	{ 
		obj.find(".menuTM"+dep+"dep").hide();
		if(dep == 2){
			obj.removeClass("off");
			obj.addClass("on");
		}else{
			obj.removeClass("sm_"+dep+"d_off");
			obj.addClass("sm_"+dep+"d_on");
		}
		obj.find(".menuTM"+dep+"dep").slideDown(spd);
	}

	//태블릿,모바일 위치 초기화
	$("#head_w #head").css({'position':'absolute','left':0,'top':0});
	$("#head_w .tm_menu").css({'top':0 ,'left':-220});
	$("#m_con_w, .s_con_w, #s_con_w").css({'position':'relative','left':0});
	$("#footer_w, #s_footer_w").css({'left':0});
	$("button.tm_menu_btn").css("zIndex",'99999');

	//태블릿,모바일메뉴
	$("button.tm_menu_btn").bind("click",function(){ 
		if(parseInt($("#head_w .tm_menu").css("left")) == -220) show_tm_menu(); 
		else hide_tm_menu(); 
	});

	function show_tm_menu()
	{ 
		$("#head_w .tm_menu").animate({left:0},300);
		$("#head_w #head, #m_con_w, .s_con_w, #s_con_w, .m_archive_w, #footer_w, #s_footer_w").animate({left:220},300);
	}

	function hide_tm_menu()
	{
		//$("#head_w #head, #m_con_w, .s_con_w, #footer_w, #s_footer_w").animate({left:-30},200,function(){$(this).animate({left:0},400);});
		//$("#head_w .tm_menu").animate({left:-300},200,function(){$(this).animate({left:-220},400);}); 
		$("#head_w #head, #m_con_w, .s_con_w, #s_con_w, .m_archive_w, #footer_w, #s_footer_w").animate({left:0},200);
		$("#head_w .tm_menu").animate({left:-220},150); 
	}



	$(".openSearch").click(function(){
		$(".tm_sear .ts_off").hide(200,function(){
			$(".tm_sear .ts_on").show(300);
		});		
	});

	$(".closeSearch").click(function(){
		$(".tm_sear .ts_on").hide(200,function(){
			$(".tm_sear .ts_off").show(300);
		});		
	});

	$(".openLang").click(function(){
		if($(this).parent().parent().find("dd").css("display") == "none"){
			$(this).parent().parent().find("dd").show(200);
		}else{
			$(this).parent().parent().find("dd").hide(200);
		}
	});

	$(".openLangTM").click(function(){
		if($(this).parent().find("div").css("display") == "none"){
			$(this).parent().find("div").show(200);
		}else{
			$(this).parent().find("div").hide(200);
		}
	});
	
	//플레이스홀더 
	$("input, textarea").placeholder();

	// 페이징 이미지 온오프
	if($(".sb_page .bnt a img").length > 0){
		$(".sb_page .bnt a img").bind("mouseover",function(){
			$(this).attr("src",$(this).attr("src").replace("off.gif","on.gif")); 
		});
		$(".sb_page .bnt a img").bind("mouseout",function(){
			$(this).attr("src",$(this).attr("src").replace("on.gif","off.gif")); 
		});
	}

	//메인 비주얼
	if($("#m_con_w").length > 0){		
		//즐겨찾는 메뉴 
		$(".favo_box ul li").each(function(){
			$(this).css({
				"position"   : "relative",
				"opacity"    : 0,
				"left"       : -($(this).find("img").outerWidth())
			});
		});

		if($("#bannerArea").css("display") != "none"){
			mainBanner({
				'id'       : "#bannerArea",
				'min'      : 2,
				'elemt'    : 'li'
			});
		}

		//게시판 스크립트
		$(".notice .list_w >li >a").on("click",function(){
			$(".notice .list_w .list").hide();
			$(".notice .list_w").children().removeClass("on");			
			$(".notice .list_w").children().addClass("off");
			$(this).parent().find("ul.list").show();
			$(this).parent().removeClass("off");			
			$(this).parent().addClass("on");
		});

		$("#middleVisualArea").bjqs({
			'height'          : 260,
			'width'           : 400,
			'animtype'        : 'slide',
			//'postion'		  : 'absolute',
			//'automatic'       : false,
			'animspeed'       : 4000,
			'animduration'    : 1000,
			'existcontrols'   : true,
			'showcontrols'    : true,
			'showmarkers'     : true,
			'existmarkers'    : true,
			'keyboardnav'     : false,
			'hoverpause'	  : false,
			'responsive'      : true,
			'objelement'      : 'li',
			'objwindowwidth'  : false
		});

		//하단 주요관광지 
		$('#tourArea').bjqs({
			'height'          : 125,
			'width'           : 154,
			//'postion'		  : 'absolute',
			'automatic'       : false,
			'animspeed'       : 4000,
			'animduration'    : 500,
			//'existcontrols'   : true,
			'showcontrols'    : false,
			//'showmarkers'     : false,
			'existmarkers'    : true,
			'keyboardnav'     : false,
			'hoverpause'	  : false,
			'responsive'      : true,
			'objelement'      : 'li',
			'objwindowwidth'  : false
		});	

	}else{

		movingQuick({
			'name'                : ".quick_w",
			'menu_top_limit'      : 160,
			'menu_top_margin'     : 0,
			'menu_shift_duration' : 300,
			'menuYloc'			  : null
		});	

	}

	//상단 이동 버튼 
	$(".moveScrolltop").on("click",function(e){
		e.preventDefault();
		var obj = $(this).attr("href").split("#")[1];
			if($("#m_allWrap").length > 0){
				obj = $("#m_allWrap"); 
			}else{
				obj = ($("#"+obj).length > 0)? $("#"+obj) : $("."+obj); 
			}

			_scrollTop(obj);
	});

	var siteParent  = $(".familySiteArea");
	var siteChild   = $(".familySiteArea").find("li"); 
	var spNewHeight = -( (siteChild.height()*siteChild.length) + 12 );
	
	siteParent.css({
		"top"     : spNewHeight+"px",
		"height"  : "0px",
		"opacity" : 0,
		"display" :"none"
	});

	$(".familySiteBtn").on("click","a",function(e){
		e.preventDefault(); 
		if(siteParent.css("opacity")!=0){	
			siteParent.stop(true).animate({
				top      : 0,
				height   : 0,
				opacity  : 0
			},300,function(){siteParent.css({"top":spNewHeight+"px","display":"none"});});
		}else{ 
			siteParent.css({"top":"0px","display":"block"});
			siteParent.stop(true).animate({
				top      : spNewHeight,
				height   : (siteChild.height()*siteChild.length),
				opacity  : 1
			},350);
		}
	});

});

window.onload = function(){
	//해시태그 있으면 화면스크롤 이동 (모바일일 경우, 반드시 첫번째 해시태그는 m_allWrap 여야함)
	if(window.location.hash){
		var thisHash = window.location.hash.split("#")[2]; 
		var ele = $("#"+thisHash); 
		if(ele.length >0){ 
			_scrollTop(ele);
		}
	}

	if($("#m_con_w").length > 0){
		//즐겨찾는 아이콘
		$(".favo_box ul li").eq(0).animate({opacity:1,left:0},500);
		setTimeout(function(){	$(".favo_box ul li").eq(1).animate({opacity:1,left:0},500); },400);
		setTimeout(function(){	$(".favo_box ul li").eq(2).animate({opacity:1,left:0},500); },800);
		setTimeout(function(){	$(".favo_box ul li").eq(3).animate({opacity:1,left:0},500); },1200);
		setTimeout(function(){	$(".favo_box ul li").eq(4).animate({opacity:1,left:0},500); },1600);
		setTimeout(function(){	$(".favo_box ul li").eq(5).animate({opacity:1,left:0},500); },2000);
		setTimeout(function(){	$(".favo_box ul li").eq(6).animate({opacity:1,left:0},500); },2400);
	}


}

$(window).resize(function(){
	if($(window).width() > 989){
		$("#head_w #head, #m_con_w, .s_con_w, #s_con_w, #footer_w, #s_footer_w").stop().animate({left:0},300);
		$("#head_w .tm_menu").stop().animate({left:-220},300);
		$("#headerBg").show();
	}else 
		$("#headerBg").hide();
});


function movingQuick(settings){ 

	$(window).scroll(function() 
	{ 
		// Calculate the top offset, adding a limit
		offset = settings.menuYloc + $(document).scrollTop() + settings.menu_top_margin;

		// Limit the offset to 241 pixels...
		// This keeps the menu out of our header area:
		if(offset < settings.menu_top_limit)
			offset = settings.menu_top_limit;

		// Give it the PX for pixels:
		offset += "px";

		// Animate:
		$(settings.name).animate({top:offset},{duration:settings.menu_shift_duration,queue:false});
	});

}

function _scrollTop(obj)
{
	$('html,body').animate({scrollTop: obj.offset().top }, 700, 'swing');
	obj.focus();
}

