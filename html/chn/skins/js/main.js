$(document).ready(function() {

		/*===== main-visual START =====*/
		function video_resize(){
			var target = $(".main__visual-video");
			var window_w = $(window).width();
			var window_h = $(window).height();
			var video_ratio = 16 / 9;
			var window_ratio = window_w / window_h;

			if(window_ratio < video_ratio){
				target.height(window_h);
				target.width(window_h * video_ratio);
			}else{
				target.width(window_w);
				target.height(window_w / video_ratio);
			}
		}video_resize();

		$(window).resize(function(){
			video_resize();
		})



	// 메인 비주얼
    $('.main__visual-wrap').on('init', function(e, slick) {
		
		var $firstAnimatingElements = $('div.main__visual-item:first-child').find('[data-animation]');
        doAnimations($firstAnimatingElements);    
		$('.slick-active > .bg .main__visual-img').addClass('is-scale');
		$('.slick-active .main__visual-border').addClass('is-active');
		
		
    });
    $('.main__visual-wrap').on('beforeChange', function(e, slick, currentSlide, nextSlide) {

		var $animatingElements = $('div.main__visual-item[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
		doAnimations($animatingElements);
		$('.slick-slide .main__visual-img').removeClass('is-scale');
		$('.main__visual-border').removeClass('is-active');
    });
	$('.main__visual-wrap').on('afterChange', function(e, slick, currentSlide, nextSlide){
		$('.slick-active .main__visual-border').addClass('is-active');
        $('.slick-active > .bg .main__visual-img').addClass('is-scale');
    });

	$('.main__visual-wrap').slick({
		dots:true,
		//dotsClass:'main__visual-dots',
		appendDots: $(".main__visual-dots"),
		//lazyLoad: 'ondemand', //or progressive
		arrows: false,
		prevArrow: $('.main__visual-arrow.prev'),
		nextArrow: $('.main__visual-arrow.next'),
		autoplay: true,
        autoplaySpeed:10000,
		infinite: true,
		speed: 1500,
		fade: true,
		pauseOnFocus: false,
		pauseOnHover: false,
		customPaging: function (slider, i) {
			var title = $(slider.$slides[i]).data('title');
			return '<button><span>' + title + '</span></button>';
		}
		
    });

    function doAnimations(elements) {
        var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        elements.each(function() {
            var $this = $(this);
            var $animationDelay = $this.data('delay');
            var $animationType = 'animated ' + $this.data('animation');
			var $animationDuration = $this.data('dura');
            $this.css({
                'animation-delay': $animationDelay,
                '-webkit-animation-delay': $animationDelay,
				'animation-duration' : $animationDuration
            });
            $this.addClass($animationType).one(animationEndEvents, function() {
                $this.removeClass($animationType);
            });
        });
	}

	var visualBtn = $(".main__visual-control .play");
    $(visualBtn).on("click",function() {
		if ($(this).hasClass('paused')) {
			$(this).removeClass('paused').text('일시정지');
			$('.main__visual-wrap').slick('slickPlay');
		} else {
			$(this).addClass('paused').text('재생');
			$('.main__visual-wrap').slick('slickPause');
		}
	});




	$('.main__case-list').slick({
		dots:false,
		//appendDots: $(".main__news-dots"),
		arrows: true,
		autoplay: true,
		autoplaySpeed: 5000,
		infinite: true,
		speed: 1000,
		focusOnSelect: true,
		//fade: true,
		//cssEase: 'linear',
		prevArrow: $('.main__case-prev'),
		nextArrow: $('.main__case-next'),
		centerMode: true,
		//centerPadding: '10px',
		variableWidth: true,

		
	});

});



$(document).ready(function() {
	/* 스크롤이동 */
	$(".scroll-btn").click(function(event){
		$('html,body').animate({scrollTop:$(this.hash).offset().top}, 500);
		event.preventDefault();
	});


/*
	$('.main__case-item').on("mouseenter focus touchstart",function(e) {
		$(this).addClass('slick-current');
		$(this).siblings().removeClass('slick-current');
	});
*/
	
});



$(window).on("load resize", function () {
	var boxW = $('.main__smart-item').width();
	$('.main__smart-item').css({
		'height'	:	boxW + 'px',
		'line-height' : boxW + 'px'
	});

	var sotryIcon = $('.main__story-item .ico').width();
	$('.main__story-item .ico').css({
		'height'	:	sotryIcon + 'px'
	});

	var mainCustomer = $('.main__customer li').width();
	$('.main__customer li').css({
		'height'	:	mainCustomer  + 'px'
	});


	// 높이 맞추기
	$('.main__product-item a').matchHeight({ 
		byRow: true, 
		property: 'height',
		//target: $('.main__info-item:nth-child(2)')
	});

	$('.main__product-link .text').matchHeight({ 
		byRow: true, 
		property: 'height',
		//target: $('.main__info-item:nth-child(2)')
	});

	$('.main__story-item a').matchHeight({ 
		byRow: true, 
		property: 'height',
		//target: $('.main__info-item:nth-child(2)')
	});

	$('.main__case-item a').matchHeight({ 
		byRow: true, 
		property: 'height',
		//target: $('.main__info-item:nth-child(2)')
	});

	

	

	
});

