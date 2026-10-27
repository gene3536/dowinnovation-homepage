
$(document).ready(function(){

	// 탭 이미지
	if($("#Tabmn01").length > 0){
		$("ul.tab_list >li >a").on("click",function(e){
			e.preventDefault();
			var idx = $(this).parent().index(); 
			
			$("ul.tab_list li").removeClass("on");
			$("ul.tab_list li").addClass("off");
			$(this).parent().removeClass("off");
			$(this).parent().addClass("on");

			$("#Tabmn01,#Tabmn02,#Tabmn03,#Tabmn04,#Tabmn05").fadeOut(80);
			$("#Tabmn0"+(idx+1)).fadeIn(150);

		});
	}

});

