$(window).on("load resize", function () {
	$('body').attr('data-mobile',
		(function(){
			var r = ($(window).width() <= 1024) ? true : false;
			return r;
		}())
	);
}).resize();


$(window).on("load resize", function () {
	$('body').attr('data-phone',
		(function(){
			var r = ($(window).width() <= 768) ? true : false;
			return r;
		}())
	);
}).resize();



/* ----------------------------------------
	GNB
---------------------------------------- */
$(window).on("load resize", function () {
	if ($('body').attr('data-mobile') == 'true'){
		$('.gnb-2dep').prev('.gnb-1dep__link').addClass('is-2depth-m').removeClass('is-2depth-d');
	}
	else {
		$('.gnb-2dep').prev('.gnb-1dep__link').addClass('is-2depth-d').removeClass('is-2depth-m');
	}
});
$(function() {
	var headerWrap = $('.header-wrap');
	var gnb = $('#gnb');
	var gnbLink = $('.gnb-1dep__link');
	var gnb1dep = $('.gnb-1dep');

	$(window).resize(function(){
		if ($('body').attr('data-mobile') == 'false'){
			$(gnb).removeClass('js-open-m').find("li").removeClass('js-open-m');
			$('.gnb-dimmed').removeClass('js-open-m');
		} else {
			$(gnb).removeClass('js-open-d').find("li").removeClass('js-open-d');
			$('.header-wrap').removeClass('js-open-d js-hover');
			$('.gnb-dimmed').removeClass('js-open-d');
		}
	});

	$(gnbLink).on("click mouseenter focus touchstart",function(e) {
		if ($('body').attr('data-mobile') == 'false') {
			$('.header-wrap').addClass('js-open-d js-hover');
			$('.gnb-dimmed').addClass('js-open-d');

			if (!$(this).parents("li").hasClass("js-open-d")) {
					$(gnb).addClass('js-open-d');
					$(this).parents("li").addClass("js-open-d").siblings("li").removeClass("js-open-d");

				if ($(this).next('ul').hasClass('gnb-2dep')) {
					$(this).addClass('is-2depth').parents("li").siblings("li").children("a").removeClass("is-2depth");
				}
				
//				if (gnbState === 0) {
//					$(this).parents("li").addClass("js-first");
//					gnbState = 1;
//				}
//			} else {
//				$(gnb).removeClass('js-open-d');
//				$(this).parents("li").removeClass("js-open-d");
//			}
//			if(e.type == "touchstart") {
//				return false;
			}
		} else {
			if(e.type == "click"){
				e.preventDefault();
				if ($(this).parents("li").hasClass("js-open-m")) {
					$(this).parents("li").removeClass("js-open-m");
				} else {
					$(this).parents("li").siblings().removeClass("js-open-m");
					$(this).parents("li").addClass("js-open-m");
				}
			}
		}
	});

	$(gnb1dep).on("mouseenter focus touchstart",function(e) {
		if ($('body').attr('data-mobile') == 'false') {

			if (!$(this).hasClass("js-open-d")) {
				$(gnb).addClass('js-open-d');
				$(this).addClass("js-open-d").siblings("li").removeClass("js-open-d");
				
			}
		} 
	});


	$(gnb).on("mouseleave",function() {
		$(headerWrap).removeClass('js-hover');
		$(headerWrap).removeClass('js-open-d');
		$('.gnb-dimmed').removeClass('js-open-d');
		$(this).removeClass('js-open-d');
		//$(gnb).find("[class$=tit]").stop().animate({height:'0'},300);
		$(this).find('li').removeClass('js-open-d js-first');
		gnbState = 0;
	});

	
	$(gnb).find("a").last().on("blur",function() {
		$(gnb).trigger("mouseleave");
	});
	$('.newAllmenu-open, .gnb-dimmed, .gnb-mbtn-close').on("click" ,function(){
		if ($('body').attr('data-mobile') == "false") return false;
		if (!$(gnb).hasClass("js-open-m")) {
			$('.gnb-dimmed').addClass('js-open-m');
			$(gnb).addClass('js-open-m');
		} else {
			$(gnb).removeClass('js-open-m');
			$('.gnb-dimmed').removeClass('js-open-m');
		}
	});

});


$(window).on('load resize scroll',function(){
	var w_top = $(window).scrollTop();
	if ( w_top > 100 ) {
		$(".header-wrap").addClass("js-fixed");
	}else {
		$(".header-wrap").removeClass("js-fixed");
	}
	
});


/* checkbox checked */
$(function(){
	$(".checkbox-label").click(function(){
		var thisCheckd = $(this).find(".checkbox-obj").is(":checked");
		if(thisCheckd){
			$(this).addClass("checkbox-on");
		}else{
			$(this).removeClass("checkbox-on");
		}
	});
});




$(function() {	
	$('.lnb-link').on("mouseenter focus",function(e) {
		if ($('body').attr('data-phone') == 'false') {
			if (!$(this).parents("li").hasClass("is-active")) {
				$(this).parents("li").addClass("is-active").siblings("li").removeClass("is-active");
			}
		}
	});
});


// Breadcrumb
$(function(){
	var crumbBtn = $(".lnb-title");
	$(crumbBtn).each(function(){
		var _this = $(this);
		_this.attr("tabindex","0");
		_this.on("click keypress",function(e){
			e.stopPropagation();
			if ((e.keyCode == 13)||(e.type == 'click')) {
				if ($(this).next().hasClass("js-active")) {
					$(this).next().removeClass("js-active");
					$(this).removeClass("js-active");
					$(this).attr("title", "메뉴 열기");
				} else {
					$(crumbBtn).next().removeClass("js-active");
					$(crumbBtn).removeClass("js-active");
					$(this).next().addClass("js-active");
					$(this).addClass("js-active");
					$(this).attr("title", "메뉴 닫기");
				}
			}
		});
	});
	$(".wrap").on("click",function(e){
		//e.stopPropagation();
		if ($(crumbBtn).next().hasClass("js-active")) $(crumbBtn).next().removeClass("js-active");
		if ($(crumbBtn).hasClass("js-active")) $(crumbBtn).removeClass("js-active").attr("title", "메뉴 열기");

	});
});



// top 버튼
$(window).on('load resize scroll',function(){
	if ($(this).scrollTop() > 100) {
		$('.footer-top').fadeIn();
	} else {
		$('.footer-top').fadeOut();
	}
	var footerPos=$("footer").position().top;

	if(footerPos<$(window).scrollTop()+$(window).height()){
		$(".footer-top").addClass("on");
	}else {
		$(".footer-top").removeClass("on");
	}
});


$(document).ready(function(){
	//말줄임
	$('.js-dot').dotdotdot({
		watch: true,
		wrap : 'letter'
	});
	$(".inquiry").addClass("inner");
	$(".footer-top").click(function() {
        $('html, body').animate({
            scrollTop : 0
        }, 400);
        return false;
    });


	$('.sub__title-text').slick({
		dots:false,
		arrows: false,
		autoplay: true,
        autoplaySpeed:3000,
		infinite: true,
		speed: 1500,
		fade: true
    });
});


$(window).on('load resize',function(){
	if ($(window).width() > 1024) {
		
			$(".newAllmenu-open").click(function() {
				if ($('body').attr('data-mobile') == "true") return false;
				$("body").addClass("js-fixed");
				//$(".top__util-inner").hide();
				$(".newAllmenu").fadeIn(300);
				$('.newAllmenu-tit').attr("tabindex","0").focus();
				
				return false;
			});	
			$(".newAllmenu-close, .newAllmenu-dimmed").click(function() {
				$("body").removeClass("js-fixed");
				//$(".top__util-inner").show();
				$(".newAllmenu").fadeOut(300);
				$(".newAllmenu-open").attr("tabindex","0").focus();
				return false;
			});
		
	} else {
		$("body").removeClass("js-fixed");
	}


});

// 높이 맞춤
$(window).on('load resize',function(){
	$('.newAllmenu-1dep').matchHeight({ 
		byRow: true, 
		property: 'height',
		//target: $('.ci__box.type1')
	});

	$('.newProduct__tab-item a').matchHeight({ 
		byRow: true, 
		property: 'height',
		//target: $('.ci__box.type1')
	});

	$('.newProduct-link .desc').matchHeight({ 
		byRow: true, 
		property: 'height',
		//target: $('.ci__box.type1')
	});

	$('.history-item .month').matchHeight({ 
		byRow: true, 
		property: 'height',
		target: $('.history-item .month').parents('.history-item .text')
	});
});


$(function(){
	$(".hac-list-top .default").click(function(){
		if($(this).parents('.hac-list-top .list').hasClass('on')) {
			$(this).parents('.hac-list-top .list').removeClass('on');
		}
		else {
			$('.hac-list-top .list').removeClass('on');
			$(this).parents('.hac-list-top .list').addClass('on');
		}
		
	});
});

// $(function(){
// 	$(".directions-tab li").click(function(){
// 		$(".directions-tab li").removeClass('on');
// 		$(this).addClass('on');
// 		$('.directions-wrap > div').removeClass('on');
// 		$(this).children('a').attr('href').addClass('on');
// 		AOS.init();
// 	});
// });

$(document).ready(function(){
	var directions_tab = $('.directions-tab li');

	$(directions_tab).on("click",function() {
		$(directions_tab).removeClass('on');
		$(this).addClass('on');
	});
	
	$(function() {
		$(directions_tab).on("click",function() {
			var directions_map_on = $(this).children('a').attr('href');

			$('html, body').animate({scrollTop : 400}, 400);

			$('.directions-wrap > div').removeClass('on');
			$(directions_map_on).addClass('on');
		});
	});
});