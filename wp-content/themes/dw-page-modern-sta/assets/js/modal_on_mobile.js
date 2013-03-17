jQuery(window).load(function(){
    jQuery('.carousel').bind('slide',function(){
        var active = jQuery(this).find('.item.active');
        var detail = active.find('li.block .project-details:first');
        detail.slideUp(500,function(){
            detail.addClass('hide');
        });
    });
    jQuery('.portfolio .thumbnail a.show-popup').on('click',function(e){
        e.preventDefault();
        var t = jQuery(this),
            prj = t.closest('.thumbnail'),
            detail = prj.next('.project-details');

            if( detail.hasClass('hide') ){
                detail.hide();
                detail.removeClass('hide');
                detail.slideDown(500);
            }else{
                detail.slideUp(500,function(){
                    detail.addClass('hide');
                });
            }

            detail.find('button.close').on('click',function(){
                detail.slideUp(500,function(){
                    detail.addClass('hide');
                });
            });
        
    });

})