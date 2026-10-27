
$(document).ready(function(){

	//피씨메뉴
	var menuObj  = $("#menu_wrap ul");
	var menuObj2 = menuObj.find(".menu2ndPC");
	
	menuObj.find(">li >div").hide();
	menuObj.find(">li").hover(function(){ 
		menuShow(); 
	});

	$("#m_con_w, #s_con_w, #footer_w, .head_w, #head_w").hover(function(){
		menuHide(); 
	});		
	
	menuObj.find(">li").on({
		mouseover : function(){
			menuShow(); 
		},
		focusin : function(){
			menuShow(); 
		}
	});		

	$("#m_con_w, #s_con_w, #footer_w, .head_w, #head_w").hover(function(){
		menuHide(); 
	});	
	$("#m_con_w, #s_con_w, #footer_w").focusin(function(){
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
	
	menuObj.find(">li").on({
		mouseover : function(){
			menuShow(); 
		},
		focusin : function(){
			menuShow(); 
		}
	});	

	//tm 메뉴 
	var menuTM1 = $(".menuTM1dep");	
	var menuTM2 = $(".menuTM2dep");	
	var menuTM3 = $(".menuTM3dep");	

	menuTM2.find(".sm_2d_on").find(".menuTM3dep").show();

	menuTM1.find(".menuTM1depChd").on("click","a",function(e){ 
		e.preventDefault();
		var spd = ($(this).parent().find(".menuTM2depChd").length) * 20;
		if($(this).parent().find(".menuTM2dep").children().length > 0){	
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
			if(this.target == "_blank")	window.open(this.href);
			else location.href = this.href;
		}
	});

	menuTM2.find(".menuTM2depChd").on("click","a",function(e){ 
		e.preventDefault();
		var spd = ($(this).parent().find(".menuTM3depChd").length) * 50;
		if($(this).parent().find(".menuTM3dep").children().length > 0){ 
			if($(this).parent().find(".menuTM3dep").css("display") == "block"){
				menuTMHide($(this).parent(),3,spd);
			}else{ 
				menuTMShow($(this).parent(),3,spd);				
			}
			return false; 
		}else {
			if(this.target == "_blank")	window.open(this.href);
			else location.href = this.href;
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
	$("button.tm_menu_btn, .openSearch").css("zIndex",'99999');
	$(".tm_sear .ts_on").hide();

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

	$(".openSearch").bind("click",function(){
		$(".tm_sear .ts_off").hide(30,function(){
			$(".tm_sear .ts_on").show(180);
		});	
	});

	$(".closeSearch").bind("click",function(){ 
		$(".tm_sear .ts_on").hide(180,function(){
			$(".tm_sear .ts_off").show();
		});	
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

		//게시판 스크립트
		$(".notice .list_w >li >a").on("click",function(){
			$(".notice .list_w .list").hide();
			$(".notice .list_w").children().removeClass("on");			
			$(".notice .list_w").children().addClass("off");
			$(this).parent().find("ul.list").show();
			$(this).parent().removeClass("off");			
			$(this).parent().addClass("on");
		});

		$("#boardArea").css({"height":"98px"});
		$("#boardArea").children().css({"height":"98px","width":$("#boardArea").outerWidth()+"px"});

		var slider = $("#boardArea").bxSlider({
			mode:'horizontal',
			speed:1000,
			pause:7000,
			slideMargin: 0,
			//pager: false,
			controls :false,
			//nextSelector: "#slider_next",
			//prevSelector: "#slider_prev",
			//nextText: '',
			//prevText: '',
			pagerCustom: '.slider-pager',
			auto : true,
			stopAutoOnClick: true,
			autoDelay: 80,
			onSliderLoad : function(){ 
				$("#boardArea").parent().css({
					"height"    : "98px",
					"top"       : "85px"
				});
				$("#boardArea").children().children().css({
					"position"    : "relative",
					"top"         : "0px"
				});
				$("#boardViewBtn").prop("href",$("#boardArea").children().eq(0).find("dl dt a").attr("href"));
			}, 
			onSlideBefore : function(elm,o,n){	
				$(".slider-pager").find("li").each(function(i){
					$(this).find("img").attr("src",$(this).find("img").attr("src").replace("on","off"));
				});
				$(".slider-pager").find("li").eq(n).find("img").attr("src",$(".slider-pager").find("li").eq(n).find("img").attr("src").replace("off","on"));
				$("#boardViewBtn").prop("href",elm.find("dl dt a").attr("href"));
			}, 
			onSlideAfter : function(){
				slider.startAuto();			
			}
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

	if($("#m_con_w").length > 0){	
		$("#visual_w").bjqs({
			'height'          : $("#visual_w .bjqs").children().outerHeight(),
			'width'           : $(window).width(),
			'animtype'        : 'slide',
			//'postion'		  : 'absolute',
			//'automatic'       : false,
			'animspeed'       : 8000,
			'animduration'    : 1000,
			'showcontrols'    : false,
			'showmarkers'     : true,
			'existmarkers'    : true,
			'keyboardnav'     : false,
			'hoverpause'	  : false,
			'responsive'      : true
		});
	}

}

$(window).resize(function(){
	if($(window).width() > 989){
		$("#head_w #head, #m_con_w, #s_con_w, #s_con_w, .m_archive_w, #footer_w, #s_footer_w").stop().animate({left:0},300);
		$("#head_w .tm_menu").stop().animate({left:-220},300);
		if($(".tm_sear .ts_on").css("display") != "none"){
			$(".tm_sear .ts_on").hide(180,function(){
				$(".tm_sear .ts_off").show();
			});	
		}
	}
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

