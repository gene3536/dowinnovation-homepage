/** 로컬메뉴 타입1 - 140618 */
$(function(){
	$.fn.navigation = function(rootkey, chk) {
		// 마우스 오버,아웃
		$('#top1menu').find('.top2hover').hover(function() {
			$("#mainWrapper").addClass("lnb_bar");
			$('#top1menu').find('.top2hover').find('div').hide();
			$(this).find('div').show();
		}, function() {
			$("#mainWrapper").removeClass("lnb_bar");
			$(this).find('div').hide();
			$.fn.currentShow();
		});
		
		// 키보드 포커스인
		$('#top1menu').find('.top2hover > a').focusin(function() {
			$("#mainWrapper").addClass("lnb_bar");
			$('#top1menu').find('.top2hover').find('.top2m').hide();
			$(this).parent().find('.top2m').show();
		});

		// 키보드 포커스아웃
		$('#top1menu').find('.top2hover').focusout(function() {
			if($(".top2hover > div").find("*").is(':focus') == false) {
				$("#mainWrapper").removeClass("lnb_bar");
				$('#top1menu').find('.top2hover').find('.top2m').hide();
				$.fn.currentShow();
			}
		});
		
		// 현재메뉴 출력
		$.fn.currentShow = function() {
			if(rootkey > 0) {
				if(chk == true) {
					$('#top1menu').find('.top2hover').find('a').removeClass('on');
					$('#top1m' + rootkey).addClass('on');
					$('#top2m' + rootkey).show();
				}
			}
		};
		
		$.fn.currentShow();
	};
});