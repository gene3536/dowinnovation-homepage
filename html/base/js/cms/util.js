

	$(document).ready(function(){
		$(".tabBtn").click(function(){
			var _parent = $(this).parent().parent().parent();
			var _tabBtn = $(this).parent().parent().find('.tabBtn');
			var _currentBtn = $(this).parent().find('.tabBtn');

			$(_parent).find(".tabContent").hide();
			$(_parent).find(".tabContent").eq($(this).parent().index()).fadeIn();
			$(_parent).find(".tabMore").hide();
			$(_parent).find(".tabMore").eq($(this).parent().index()).fadeIn();
			
			if($(_tabBtn).find('img').length) {
				$(_tabBtn).each(function(){
					$(this).find('img').attr({src:$(this).find('img').attr('src').replace('on','off')});
				});
				$(_currentBtn).find('img').attr('src', $(_currentBtn).find('img').attr('src').replace('off','on'));
			} else {
				$(this).parent().parent().find("li").removeClass("on");
				$(this).parent().addClass("on");
			}
		});
		
		// 셀렉트유형 버튼
		$(".selectBtn").toggle(function(){
			$(this).parent().parent().find(" > dd").fadeIn();
		}, function() {
			$(this).parent().parent().find(" > dd").fadeOut();
		});
		
		// 카피라이터 수정
		$(".copyBtn").click(function(){
			window.open($(".copyBtn").attr("href"), 'copyrightEditor', 'width=800, height=320, resizable=no, scrollbars=yes, status=no');
		});
		// 사이트정보 수정
		$(".siteBtn").click(function(){
			window.open($(".siteBtn").attr("href"), 'siteManager', 'width=800, height=600, resizable=no, scrollbars=yes, status=no');
		});
		
		// 달력설정
		if ( $(".cal").length > 0 ) {
			$.datepicker.setDefaults({
			    monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
			    dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			    showMonthAfterYear:true,
			    dateFormat: 'yy-mm-dd',
			    buttonImageOnly: true,
			    buttonText: "달력",
			    buttonImage: "/base/imgs/btn/btn_calendar.gif"
			});
		    $(".cal").datepicker({
		    	defaultDate: new Date(),
			    showOn: "both", // focus, button, both
			    showAnim: "blind", // blind, clip, drop, explode, fold, puff, slide, scale, size, pulsate, bounce, highlight, shake, transfer
			    showOptions: {direction: 'horizontal'},
			    duration: 200
		    });
		};
	
		//밸리데이터 정규식 추가 
		$.validator.addMethod("regex",function(value, element, regexp){
			var re = new RegExp(regexp);
			return this.optional(element) || re.test(value);
		});
		
		//밸리데이터 경고창 출력 
		$.validator.setDefaults({
			onkeyup : false,
			onclick : false,
			onfocusout : false,
			showErrors:function(errorMap, errorList){
				if(errorList.length < 1) return;
				alert(errorList[0].message);
			}
		});
	});

jQuery(function($){
	// 게시판유형 폼 체크 - 140617
	$.brdValidation = function() {
		if($('#brdata_subject').is(this) && $.trim($('#brdata_subject').val()) == '') {
			alert("제목을 입력하세요.");
			$('#brdata_subject').focus();
			return false;
		} else if($('#brdata_name').is(this) && $.trim($('#brdata_name').val()) == '') {
			alert("이름을 입력하세요.");
			$('#brdata_name').focus();
			return false;
		} else if($('#spamKey').is(this) && $.trim($('#spamKey').val()) == '') {
			alert("인증번호를 입력하세요.");
			$('#spamKey').focus();
			return false;
		} else if($('#brdata_wd').is(this) && $.trim($('#brdata_wd').val()) == '') {
			alert("비밀번호를 입력하세요.");
			$('#brdata_wd').focus();
			return false;
		} else {
			$.submitContent();
		}
	};

	// addFavorite
	$('.addFavorite').click(function() {
		var title = document.title;
		var url = location.href;
		if(window.sidebar && window.sidebar.addPanel){
			window.sidebar.addPanel(title, url,"");
		} else if(window.opera && window.print) {
			var elem = document.createElement('a'); 
			elem.setAttribute('href',url); 
			elem.setAttribute('title',title); 
			elem.setAttribute('rel','sidebar'); 
			elem.click();
		} else if(document.all) {
			window.external.AddFavorite( url, title);
		} else {
			alert("해당브라우저는 즐겨찾기 추가기능이 지원되지 않습니다.");
			return true;
		}
	});
	
	// 확대/축소/출력 스크립트
	var current_zoom = 100;
	var zoomIn = function() {
		/*
		if($.browser.msie){ // IE
			if($.browser.version >= 8) {
				current_zoom += 10;
				$("body").children().css("zoom", current_zoom + "%");
			} else {
				current_zoom += 2;
				$("body *").css("zoom", current_zoom + "%");
				$('div[class$="_left"]').parent().css('width','auto');
			}
			return;
		}
		*/
		alert("표준 브라우저에서의 확대/축소는 브라우저의 기능을 이용합니다.\n\n화면 확대: 키보드의 control키와 '+'를 동시에 누릅니다.\n화면 축소: 키보드의 control키와 '-'를 동시에 누릅니다.\n화면 초기화: 키보드의 control키와 '0'을 동시에 누릅니다.");
	};
	var zoomReset = function() {
		/*
		if($.browser.msie){ // IE
			current_zoom = 100;
			if($.browser.version >= 8) {
				$("body").children().css("zoom", "100%");
			} else {
				$("body *").css("zoom", "100%");
			}
			return;
		}
		*/
		alert("표준 브라우저에서의 확대/축소는 브라우저의 기능을 이용합니다.\n\n화면 확대: 키보드의 control키와 '+'를 동시에 누릅니다.\n화면 축소: 키보드의 control키와 '-'를 동시에 누릅니다.\n화면 초기화: 키보드의 control키와 '0'을 동시에 누릅니다.");
	};
	var zoomOut = function() {
		/*
		if($.browser.msie ){ // IE
			if($.browser.version >= 8) {
				current_zoom -= 10;
				$("body").children().css("zoom", current_zoom + "%");
			} else {
				current_zoom -= 2;
				$("body *").css("zoom", current_zoom + "%");
			}
			return;
		}
		*/
		alert("표준 브라우저에서의 확대/축소는 브라우저의 기능을 이용합니다.\n\n화면 확대: 키보드의 control키와 '+'를 동시에 누릅니다.\n화면 축소: 키보드의 control키와 '-'를 동시에 누릅니다.\n화면 초기화: 키보드의 control키와 '0'을 동시에 누릅니다.");
	};
	$(".zoomIn").click(zoomIn);
	$(".zoomOut").click(zoomOut);
	$(".zoomReset").click(zoomReset);
});