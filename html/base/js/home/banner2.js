function slideBanner(settings)
{ 
	var this_id   = jQuery(settings.id), content = jQuery(settings.id).children();
	var elmt	  = (settings.elmt)? settings.elmt : "div";
	var width     = (settings.width)? settings.width : this_id.children().outerWidth();
	var height    = (settings.height)? settings.height : this_id.children().outerHeight();
	
	var prevBnt   = (this_id.parent().find(".btn-prev").length>0)? this_id.parent().find(".btn-prev") : this_id.parent().parent().find(".btn-prev");
	var nextBnt   = (this_id.parent().find(".btn-next").length>0)? this_id.parent().find(".btn-next") : this_id.parent().parent().find(".btn-next");
	var indicator = (this_id.parent().find(".indicator").length>0)? this_id.parent().find(".indicator") : this_id.parent().parent().find(".indicator");

	var timeout   = false, term = (settings.term)? settings.term : 5000;
	var minSize   = (settings.min)? settings.min : 5, maxSize = this_id.children().length;
	var thisIDX   = 1, lastIDX = 8;

	function setLayout()
	{ 
		this_id.css({
			"width"    : width+"px",
			"height"   : height+"px",
			"overflow" : "hidden"
		});		
	}

	function setIDX()
	{
		this_id.children().each(function(i){
			jQuery(this).attr("rel",i);
		});
	}

	function doorMove(){ 

		setLayout();
		setIDX();

		if(maxSize > minSize){
			this_id.addClass("next");
			moveStart();
		}
	}

	function setClass()
	{
		this_id.children().each(function(i){
			jQuery(this).removeClass("on");
			jQuery(this).addClass("off");
		});	
		this_id.find(elmt+"[rel='"+thisIDX+"']").removeClass("off");
		this_id.find(elmt+"[rel='"+thisIDX+"']").addClass("on");
	}

	function moveStart(){   
		if(	timeout == false && maxSize > minSize){ 
			timeout = setInterval(move, term); 
		}
		 
	}

	function moveStop(){ 
		if(timeout != false && maxSize > minSize){  			 
			clearInterval(timeout);    
			timeout=false;
		}
	}

	function chgBG()
	{
		var canvas = this_id.parent().parent().find(".canvasArea img");
		var imgIDX = thisIDX + 1;
		imgIDX = (imgIDX < 10)? '0'+imgIDX : imgIDX ; 
		canvas.fadeOut(200,function(){
			this_id.parent().parent().find(".canvasArea img").attr("src","../home/images/main/bg"+imgIDX+".jpg");
			jQuery(this).fadeIn(300);
		});
	}

	function slide()
	{ 
		var direction = this_id.hasClass("prev")? "+=" : "-="; 
		var delElmt   = this_id.hasClass("prev")? ":last-child" : ":first-child";

		var last_li = this_id.find(elmt+delElmt).clone();	
		
		if(this_id.hasClass("prev")){ 
			this_id.prepend(function(){
				return last_li.click(function(){
					thisIDX = parseInt(jQuery(this).attr("rel"));		
					move();
				});
			});
		}else{
			this_id.append(function(){
				return last_li.click(function(){
					thisIDX = parseInt(jQuery(this).attr("rel"));		
					move();
				});
			});
		}

		this_id.stop(true).animate({
			'left':direction+"111"
		},300,function(){ 
			this_id.find(elmt+delElmt).remove();
			if(this_id.hasClass("prev")) this_id.removeClass("prev");			
		}); 
	}

	function setThisIDX()
	{
		if(this_id.hasClass("prev")) {
		}else{
			if(thisIDX >= (maxSize-1)){
				thisIDX = 0;
				lastIDX = parseInt(this_id.find(elmt).eq(minSize+1).attr("rel"));	
			}else{
				thisIDX = thisIDX + 1;
			}
		}
	}	

	function move()
	{
		if(maxSize > minSize){ 	
			if(!this_id.hasClass('stop')) moveStop();
			
			if(this_id.hasClass("prev")){ 
				slide();
			}else{			
				if(thisIDX == lastIDX){ 
					slide();		
					lastIDX = lastIDX +1;
				}				
			}

			chgBG();
			setClass();			
			setThisIDX();

			if(!this_id.hasClass('stop')) moveStart();	
		}
	}
	
	indicator.children().bind("click",function(){
		thisIDX = parseInt(jQuery(this).attr("rel"));		
		move();
	});

	prevBnt.click(function(){ 	
		lastIDX = ((thisIDX-1) < 0)? 0 : thisIDX-1;
		thisIDX = ((thisIDX-2) < 0)? maxSize -1 : thisIDX-1; 
		this_id.removeClass("next");
		this_id.addClass("prev");
		move();
	});

	nextBnt.click(function(){  
		thisIDX = lastIDX;
		this_id.removeClass("prev");
		this_id.addClass("next");
		move();
	});

	doorMove();

}