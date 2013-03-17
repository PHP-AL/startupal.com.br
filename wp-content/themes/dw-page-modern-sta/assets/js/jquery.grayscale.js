/**
 * Jquery Grayscale v1.0 by DesignWall
 * http://www.designwall.com
 */

;(function(window,document,$){


	$.fn.grayscale = function(){

		var dfd = $.Deferred();

		$(this).each(function(){
			if( 'ontouchstart' in document.documentElement ) return;
			var el = jQuery(this);
			
			if(isCanvasSupported()){
					el.wrap("<div class='img_wrapper' style='position:relative;'>").clone()
					.addClass('img_grayscale')
					.css({"position":"absolute","z-index":"9","opacity":"0",'left':'0','top':'0'})
					.insertBefore(el).queue(function(){
					var el1 = jQuery(this);
					el1.dequeue();
					});

				var curel = this;
				dfd.done(function(){
					var newel = curel;

					jQuery('<img />').attr('src',newel.src).load(function(){
						newel.src = grayscale(this);
					})
				})
				// Fade image 
				el.parent().find('img').mouseover(function(){
					jQuery(this).parent().find('img:first').stop().animate({opacity:1}, 200);
				})
			}
			else{
				el.wrap("<div class='img_wrapper' style='position:relative;'>").clone()
					.addClass('img_grayscale')
					.css({"position":"absolute","z-index":"9",'left':'0','top':'0','filter':'gray'})
					.insertBefore(el)
				el.parent().hover(function(){$(this).find('.img_grayscale').hide()},function(){$(this).find('.img_grayscale').show()})
			}
			
			
		
			
		})
		dfd.resolve();
		if(isCanvasSupported()){
			jQuery('.img_grayscale').live('mouseout',function(){
					jQuery(this).stop().animate({opacity:0}, 200);
				});	
		}
	}

	function isCanvasSupported(){
	  var elem = document.createElement('canvas');
	  return !!(elem.getContext && elem.getContext('2d'));
	}
	
	// Grayscale w canvas method
	function grayscale(elem){

        var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');
        canvas.width = elem.width;
		canvas.height = elem.height; 
		ctx.drawImage(elem, 0, 0); 
		var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
		for(var y = 0; y < imgPixels.height; y++){
			for(var x = 0; x < imgPixels.width; x++){
				var i = (y * 4) * imgPixels.width + x * 4;
				var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
				imgPixels.data[i] = avg; 
				imgPixels.data[i + 1] = avg; 
				imgPixels.data[i + 2] = avg;
			}
		}
		ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
		
		return canvas.toDataURL();
    }

    jQuery(document).ready(function($) {
		jQuery('.thumbnail img').grayscale();
    });
    

})(this,document,jQuery)