		var bStartPc = bStartMob = false;

		$(window).resize(function(){ 
			if($('.visual_w_pc').css("display") != "none") start_visual_rolling();
			if($('.visual_w_tm').css("display") != "none") start_m_visual_rolling();
		});
		
		$(window).load(function() { 
			//비주얼
			if($('.visual_w_tm').css("display") != "none"){ //모바일일때
				start_m_visual_rolling();
			}else{ //pc일때
				start_visual_rolling();
			}

			if($("#visualAreaA").length > 0){
			}
		});

		function start_visual_rolling()
		{ 
			if(!bStartPc){ 
				$('#visualArea').bjqs({
					'height'          : 214,
					'width'           : $(window).width(),
					//'postion'		  : 'absolute',
					//'automatic'       : false,
					'animspeed'       : 8000,
					'animduration'    : 1000,
					'existcontrols'   : true,
					'showcontrols'    : true,
					'showmarkers'     : true,
					'existmarkers'    : true,
					'keyboardnav'     : false,
					'hoverpause'	  : false,
					'responsive'      : true
				});	
				bStartPc = true;
			}
			
		}

		function start_m_visual_rolling()
		{
			if(!bStartMob){ 
				$('#visualAreaTM').bjqs({
					'height'          : $("#visualAreaTM div.bjqs img").outerHeight(),
					'width'           : $(window).width(),
					//'animtype'        : 'slide',
					//'automatic'       : false,
					'animspeed'       : 4000,
					'animduration'    : 900,
					'showcontrols'    : true,
					'showmarkers'     : true,
					'existmarkers'    : true,
					'existcontrols'   : true,
					'keyboardnav'     : false,
					'hoverpause'	  : false,
					'responsive'      : true
				});
				bStartMob = true;
			}			
		}