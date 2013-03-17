
jQuery(window).load(function(){
    
    var modal_id = '#modal-project',
            modal = jQuery( modal_id );

    // Show popup of project infomation
    var onAction = false, onModal = false;
    modal.on('hide',function(){
        jQuery('body').css('overflow','auto');
    });
    jQuery('.portfolio .thumbnail a.show-popup').on('click',function(e){
        e.preventDefault();
        if( onAction ) return;
        onAction = true;
        var t = jQuery(this),
            projectID = t.data('project');
        jQuery.ajax({
            url: dw_page_script.ajax_url,
            type: 'GET',
            dataType: 'json',
            data: { 
                action: 'dw_page_get_project',
                projectID : projectID
            },
            success: function(data) {
                onAction = false;
                if( data.status === true ){
                    modal.find('.modal-title').text(data.title);
                    if( data.image ){
                        var image = '<img src="'+data.image+'" >';
                        modal.find('.modal-image').html(image);
                    }
                    modal.find('.modal-data').html(data.detail);
                    modal.find('.modal-content').html(data.content);
                    jQuery('body').css('overflow','hidden');
                    modal.modal('show');
                }
            }
        });
        
    });

})