/** 로컬메뉴 타입2 - 140618 */
$(function(){
	$.fn.navigation = function(rootkey, chk) {
		// 마우스 오버,아웃
		$('#top1menu').find('.top2hover').hover(function() {
			$("#mainWrapper").addClass("lnb_bar");
			$('#top1menu').find('.top2hover').find('div').hide();
			if(rootkey > 0 && rootkey < 7) {
				$('#top1m' + rootkey).find('.menu1th').attr('src', $('#top1m' + rootkey).find('.menu1th').attr('src').replace('on', 'off'));
			}

			$(this).find('div').show();
			$(this).find('.menu1th').attr('src', $(this).find('.menu1th').attr('src').replace('off', 'on'));
		}, function() {
			$("#mainWrapper").removeClass("lnb_bar");
			$(this).find('div').hide();
			$(this).find('.menu1th').attr('src', $(this).find('.menu1th').attr('src').replace('on', 'off'));
			$.fn.currentShow();
		});
		
		// 키보드 포커스인
		$('#top1menu').find('.top2hover > a').focusin(function() {
			$("#mainWrapper").addClass("lnb_bar");
			$('#top1menu').find('.top2hover').find('.top2m').hide();
			if(rootkey > 0 && rootkey < 7) {
				$('#top1m' + rootkey).find('.menu1th').attr('src', $('#top1m' + rootkey).find('.menu1th').attr('src').replace('on', 'off'));
			}
			$(this).parent().find('div').show();
			$(this).find('.menu1th').attr('src', $(this).find('.menu1th').attr('src').replace('off', 'on'));
		});

		// 키보드 포커스아웃
		$('#top1menu').find('.top2hover').focusout(function() {
			if($(".top2hover > div").find("*").is(':focus') == false) {
				$("#mainWrapper").removeClass("lnb_bar");
				$('#top1menu').find('.top2hover').find('.top2m').hide();
				$(this).find('.menu1th').attr('src', $(this).find('.menu1th').attr('src').replace('on', 'off'));
				$.fn.currentShow();
			}
		});
		
		// 현재메뉴 출력
		$.fn.currentShow = function() {
			if(rootkey > 0 && rootkey < 7) {
				$('#top1m' + rootkey).find('.menu1th').attr('src', $('#top1m' + rootkey).find('.menu1th').attr('src').replace('off', 'on'));
				if(chk == true) $('#top2m' + rootkey).show();
			}
		};
		
		$.fn.currentShow();
	};
});