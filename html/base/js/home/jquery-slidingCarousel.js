/*
coverflow
make :pjc
version :0.1
e-mail:mobileitlab@gmail.com
*/
(function($) {
	$.fn.slidingCarousel = function (options) {
		options = $.extend({}, $.fn.slidingCarousel.defaults, options || {});

		var pluginData = {
			container: $(this),
			sinus:   [0],
			images:  null,
			mIndex:  null
		};

		var preload = function(callback) {
			var images = pluginData.container.find('.slide img'),
				total  = images.length,
				shift  = total % 2,
				middle = total < 3 ? total : ~~(total / 2) + shift,
				result = [],
				loaded = 0;

			images.each(function (index, element) {

				var img = new Image();

				$(img).bind('load error', function () {
					loaded++;


					result[(index+middle- 1 ) % total] = element;


					element.ratio = this.width / this.height;
					element.origH = this.height;

					element.idx   = index;


					if (loaded == total) {
						pluginData.mIndex = middle;
						pluginData.sinsum = 0;
						pluginData.images = result;


						for (var n=1, freq=0; n<total; n++) {
							pluginData.sinus[n] = (n<=middle) ? Math.sin(freq+=(1.2/middle)) : pluginData.sinus[total-n];


							if (n < middle)
								pluginData.sinsum += pluginData.sinus[n]*options.squeeze;
						}

						callback(pluginData.images);
					}
				});
				img.src = element.src;
			});
		};

		var setupCarousel = function() { 
			preload(doLayout);
			var list = setupEvents();
			if (options.active){
				active_l();
			}
		};

		var setupEvents = function() {
			var list =pluginData.container.parent().parent().find('.cover_list li');
				$(list).click(function(e) {

					var idx = $(list).index( this ),
						arr = pluginData.images;

					while (arr[pluginData.mIndex-1].idx != idx ) {
						arr.push(arr.shift());

					}
					active_l(100,idx);
					aligns(arr);
					doLayout(arr, true);
				});
				pluginData.container.find('.navigate-left').click(function() {
					var images = pluginData.images;

					images.splice(0,0,images.pop());
					active_l(-1,-1);
					aligns(images);
					doLayout(images, true);
				});
				pluginData.container.find('.navigate-right').click(function() {
					var images = pluginData.images;

					images.push(images.shift());
					active_l(+1,+1);
					aligns(images);
					doLayout(images, true);
				});
				return list;
		};
		var jdx = (function (){
			var idx = 0;
			var imgleng =  pluginData.container.find('.slide img').length -1;

			function sm(arg){
				if(idx == imgleng){
					up(0);
				}else{
				idx += arg;
				}
			}
			function mis(arg){
				if(idx <= -1){
					up(imgleng - 1);
				}else{
				idx += arg;
				}
			}
			function up(arg){

				idx = arg;
			}
		return {
			p : function(arg,idx){

				switch (arg) {
			  case 1    : sm(idx);
			               break;
			  case -1   : mis(idx);
			               break;
			  case 100  : up(idx);
			               break;
			  default   : sm(0);
			               break;
			}
			},
			m : function(arg){
					mis(arg);
			},
			val : function(){
				return idx;
			}
		};
		})();
		var active_l = function(arg,idx){

			jdx.p(arg,idx);


			var list =pluginData.container.parent().parent().find('.cover_list li');
			var txt = pluginData.container.parent().parent().find('.txt_wrap .list_box');

			if($(list).hasClass('active')){

				$(list).removeClass('active');
			}
			$(list).eq(jdx.val()).addClass('active');
			if($(txt).hasClass('active')){

				$(txt).removeClass('active');
				$(txt).stop(true).animate({opacity:'0'},250);
			}
			$(txt).eq(jdx.val()).addClass('active');

			$(txt).eq(jdx.val()).stop(true).animate({ opacity:'1'},250);
		};

		var aligns = function(images, animate) {

			var mid  = pluginData.mIndex;

			$.each(images, function(i, img) {

				idx = Math.abs(i+1-mid);

				var el = $(img).closest('.slide');

					el.css({
						zIndex   : mid-idx
					});

					el.attr('z-index', mid-idx);


			});

		};
		var movelay = function(images, animate) {

			var mid  = pluginData.mIndex,
				sin  = pluginData.sinus,
				posx = 0,
				diff = 0,
				width  = images[mid-1].origH * images[mid-1].ratio,
				middle = (pluginData.container.width() - width)/2,
				offset = middle - pluginData.sinsum,
				height = images[mid-1].origH, top, left, idx, j=1;


			pluginData.container.find('span').hide().css('opacity', 0);

			$.each(images, function(i, img) {
				idx = Math.abs(i+1-mid);
				top = idx * 15;

				img.cWidth = (height-(top*2)) * img.ratio;

				diff = sin[i] * options.squeeze;
				left = posx += (i < mid) ? diff : images[i-1].cWidth + diff - img.cWidth;

				var el = $(img).closest('.slide'),
					fn = function() {
						if (i === mid-1) {

							el.find('span').show().animate({opacity: 1});

						}
					};

				if (animate) {

					el.css({	top : top * 2,	left     : left+offset,	height   : height - (top* 4), opacity:0.5});
					el.stop(true).animate({
						opacity  : 1
					},800,'', fn);
				}
				else
				{
					el.css({
						zIndex   : mid-idx,
						height   : height - (top*4),
						top      : top *2,
						left     : left+offset,
						opacity  : 1
					}).show().animate({opacity: 1}, fn);

					if (options.shadow) {

						el.addClass('shadow');
					}
				}
			});

			if (!animate) {

			}
		};

		var doLayout = function(images, animate) {

			var mid  = pluginData.mIndex,
				sin  = pluginData.sinus,
				posx = 0,
				diff = 0,
				width  = images[mid-1].origH * images[mid-1].ratio,
				middle = (pluginData.container.width() - width)/2,
				offset = middle - pluginData.sinsum,
				height = pluginData.container.parent().height()
				, top, left, idx, j=1;
	

			pluginData.container.find('span').hide().css('opacity', 0);

			$.each(images, function(i, img) {
				idx = Math.abs(i+1-mid);
				top = idx * 15;

				img.cWidth = (height-(top*2)) * img.ratio;

				diff = sin[i] * options.squeeze;
				left = posx += (i < mid) ? diff : images[i-1].cWidth + diff - img.cWidth;
				if(i < mid){

				$(images).eq(i -1).css({ 'transform': 'matrix3d(1,0,0.00,0.0005,0.00,0.85,0.00,0,0,0,1,0,0,0,0,1)','transition':'400ms' });
				}if(i > mid){
					$(images).eq(i -1).css({ 'transform': 'matrix3d(1,0,0.00,-0.0005,0.00,0.9,0.00,0,0,0,1,0,0,0,0,1)','transition':'400ms'});
				}if(i === mid){
						$(images).eq(mid -1).css({ 'transform': 'matrix3d(1,0,0.00,0,0.00,1,0.00,0,0,0,1,0,0,0,0,1)','transition':'400ms'});
				}
				var el = $(img).closest('.slide'),
					fn = function() {
						if (i === mid-1) {

							el.find('span').show().animate({opacity: 1});

						}
					};

				if (animate) {

					el.css({});
					el.stop(true).animate({
						top      : top * 2.5,
						height   : height - (top* 4),
						left     : left + offset,
						opacity  : 1
					}, options.animate,'', fn);
				}
				else
				{
					el.css({
						zIndex   : mid-idx,
						height   : height - (top*4),
						top      : top *2.5,
						left     : left+offset,
						opacity  : 1
					}).show().stop(true).animate({opacity: 1}, fn);

					if (options.shadow) {

						el.addClass('shadow');
					}
				}
			});

			if (!animate) {


			}
		};

		this.initialize = function () {
			setupCarousel();
		};

		return this.initialize();

	};

	$.fn.slidingCarousel.defaults = {
		shadow: false,
		squeeze: 254,
		animate: 300,
		active :true,
		idx: 0
	};

})(jQuery);