function mainBanner(settings)
{ 
	var this_id   = $(settings.id), content = $(settings.id).children();
	var elmt	  = settings.elemt;
	var width     = (settings.width)? settings.width : this_id.children().outerWidth();
	var height    = (settings.height)? settings.height : this_id.children().outerHeight();
	
	var prevBnt   = (this_id.parent().find(".btn-prev").length>0)? this_id.parent().find(".btn-prev") : this_id.parent().parent().find(".btn-prev");
	var nextBnt   = (this_id.parent().find(".btn-next").length>0)? this_id.parent().find(".btn-next") : this_id.parent().parent().find(".btn-next");
	var pauseBnt  = (this_id.parent().find(".btn-pause").length>0)? this_id.parent().find(".btn-pause") : this_id.parent().parent().find(".btn-pause");
	//var playBnt   = (this_id.parent().find(".btn-play").length>0)? this_id.parent().find(".btn-play") : this_id.parent().parent().find(".btn-play");
	if(settings.indicator){
		var indicator = (this_id.parent().find(".indicator").length>0)? this_id.parent().find(".indicator") : this_id.parent().parent().find(".indicator");
	}

	var timeout   = false, timeout2 = false, term = (settings.term)? settings.term : 5000;
	var minSize   = settings.min, maxSize = this_id.children().length;
	var thisIDX   = newIDX = 0;

	function setLayout()
	{ 
		this_id.css({
			"height"   : height,
			"overflow" : "hidden"
		});		
	}

	function setIDX()
	{
		this_id.children().each(function(i){
			$(this).attr("rel",i);
		});
	}

	function doorMove(){ 

		setLayout();
		setIDX();

		if(maxSize > minSize) moveStart();
	}

	function setThisIDX()
	{
		if(thisIDX >= (maxSize-1)){
			thisIDX = 0;
		}else{
			thisIDX  = thisIDX + 1;
		}
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
	

	function move()
	{
		if(maxSize > minSize){
			//if(!this_id.hasClass('stop')){
				if(!this_id.hasClass('stop')) moveStop(); 

				newIDX  = thisIDX+1;
				newIDX  = (newIDX >= maxSize)? 0 : newIDX ;

				var last_li = this_id.find(elmt+"[rel='"+thisIDX+"']").clone();	
				this_id.find(elmt+"[rel='"+thisIDX+"']").remove();				

				for(var i=newIDX; i<maxSize; i++){
					var next = this_id.find(elmt+"[rel='"+i+"']").clone();	
					this_id.find(elmt+"[rel='"+i+"']").remove();
					this_id.append(next);
				}
				for(var i=0; i<(newIDX-1); i++){
					var next2 = this_id.find(elmt+"[rel='"+i+"']").clone();	
					this_id.find(elmt+"[rel='"+i+"']").remove();
					this_id.append(next2);
				}

				this_id.append(last_li);
				setThisIDX();

				if(settings.indicator){					
					setOnOff();
				}

				if(!this_id.hasClass('stop')) moveStart();	
			}
		//}
	}

	function setOnOff(){ 
		indicator.children().each(function(){			
			$(this).find("img").each(function(){
				$(this).attr("src",$(this).attr("src").replace("on","off"));
			});			
		});
		var obj = indicator.children().eq(thisIDX).find("img").eq(0);
		obj.attr("src",obj.attr("src").replace("off","on"));
	}
	
	if(settings.indicator){
		indicator.children().on('click',function(){				
			thisIDX = $(this).index() -1; 
			move();
		});
	}

	pauseBnt.on('click',function(){ 
		if(this_id.hasClass("stop")){
			moveStart();
			this_id.removeClass("stop");
			pauseBnt.find("img").remove();
			pauseBnt.append('<img src="images/main/bann_btn02.gif" alt="일시정지">');
		}else{
			moveStop();
			this_id.addClass("stop");
			pauseBnt.find("img").remove();
			pauseBnt.append('<img src="images/main/bann_btn04.gif" alt="재생">');
		}
	});

	/*playBnt.on('click',function(){ 
		moveStart();
		this_id.removeClass("stop");
		pauseBnt.parent().show();
		playBnt.parent().hide();
	});*/

	prevBnt.on('click',function(){ 
		thisIDX = ((thisIDX-1) < 0)? maxSize -2 : (thisIDX-1)-1;
		move();
	});

	nextBnt.on('click',function(){  
		thisIDX = (thisIDX > (maxSize-1))? 0 : (thisIDX-1)+1;
		move();
	});

	$(window).on("resize", function() {
		height = this_id.children().height();
		if(height <= 0){
			timeout2 = setInterval(getHeight, 10); 
		}else{
			clearInterval(timeout2);  
		}
		
		moveStop();
		moveStart();
	});

	doorMove();

	function getHeight()
	{
		height = this_id.children().height();
	}

}