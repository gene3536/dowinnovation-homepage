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





$(function(){
	// Select
	var base_select = $("select.base-select");

	$(window).on('scroll',function(){
		$(base_select).prev().removeClass("js-active");
		$(base_select).removeClass("js-active");
	});

	base_select.on("click keypress",function(e){
		e.stopPropagation();
		if ((e.keyCode == 13)||(e.type == 'click')) {
			if ($(this).prev().hasClass("js-active")) {
				$(this).prev().removeClass("js-active");
				$(this).removeClass("js-active");
			} else {
				$(this).prev().addClass("js-active");
				$(this).addClass("js-active");
			}
		}
	});

	$(".wrap, #wrapper").on("click",function(e){
		//e.stopPropagation();
		if ($(base_select).prev().hasClass("js-active")) $(base_select).prev().removeClass("js-active");
		if ($(base_select).hasClass("js-active")) $(base_select).removeClass("js-active");

	});

	base_select.change(function(){
		var base_select_name = $(this).children("option:selected").text();
		$(this).siblings("label").text(base_select_name).addClass('is-selected');
	});

});


$(function(){
	
	// fileUploader
	var fileTarget = $('.base__fileup-file');

	fileTarget.on('change', function() {
		if (window.FileReader) {
			// 파일명 추출
			var filename = $(this)[0].files[0].name;
		} else {
			// Old IE 파일명 추출
			var filename = $(this).val().split('/').pop().split('\\').pop();
		};

		$(this).parent().siblings('.base__fileup-name').val(filename).addClass('is-active');
		$('.base__fileup-del').addClass('is-active');
	});

	$('.base__fileup-del').on('click', function(e){
		var aaa = $(this).siblings().children('.base__fileup-file');
		$(this).removeClass('is-active');
		$(this).siblings('.base__fileup-name').removeClass('is-active');
		resetFormElement(aaa);
		return false;
	});

});


/*썸네일게시판 높이 맞춤*/
$(window).on('load resize',function(){
	$('.board_thumbnail-item').matchHeight({ 
		byRow: true, 
		property: 'height',
		//target: $('.ci__box.type1')
	});
});
