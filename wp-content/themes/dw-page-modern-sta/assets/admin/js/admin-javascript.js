jQuery(document).ready(function($) {
    // Media Uploader
    window.formfield = '';
    
    $('.dw_page_upload_btn').live('click', function (e) {
        e.preventDefault();
        formfield = $( $(this).attr('rel') );
        window.formfield = $( $(this).attr('rel') );
        window.tbframe_interval = setInterval(function() {
            jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Use this file').end().find('#insert-gallery, .wp-post-thumbnail').hide();
        }, 2000);
        var post_id = $('#post_ID').val();
        if( !post_id ) return;
        tb_show('', 'media-upload.php?post_id='+post_id+'&TB_iframe=true');
    });
    
    window.original_send_to_editor = window.send_to_editor;

    window.send_to_editor = function (html) {            
        if (window.formfield) {
            imgurl = $('img',html).attr('src');
            window.formfield.val(imgurl);
            window.clearInterval(window.tbframe_interval);
            tb_remove();
        } else {
            window.original_send_to_editor(html);
        }
        window.formfield = '';
        window.imagefield = false;
    }
    
    


    $('.dw-page-remove-slide-image').live('click',function(event){
        event.preventDefault();
        var post_id = $(this).attr('alt');
        var parent = $(this).parent();
        $.ajax({
            url: dw_page_admin_script.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: { action : 'dw_page_remove_slide_image', post_id : post_id, image_url : $(this).attr('href') },
            success: function(data) {
                if( data.status == 'success' ){
                    parent.remove();
                }
            },

        });
        
    });
    

    $('#project-video-option').hide();
    $('#project-display-option').change(function(e) {
        if( 'video' == $(this).val() ){
            $('#project-images-option').hide(300);
            $('#project-video-option').show(300);
        }else{
            $('#project-video-option').hide(300);
            $('#project-images-option').show(300);

        }
    });

    // Checked event on Hire status setting of User->Hiring menu
    $('#dw_page-hire-enable').change(function(){
        if( $(this).is(':checked') ){
            $('#dw_page-hire-title').focus();
            $('#dw_page-hire-title').select();
            $('#dw_page-hire-title').removeAttr('disabled');
            $('#dw_page-hire-job').removeAttr('disabled');
            $('#dw_page-hire-desc').removeAttr('disabled');
            $('#dw_page-hire-contact').removeAttr('disabled');
        }else{
            $('#dw_page-hire-title').attr('disabled','disabled');
            $('#dw_page-hire-job').attr('disabled','disabled');
            $('#dw_page-hire-desc').attr('disabled','disabled');
            $('#dw_page-hire-contact').attr('disabled','disabled');
        }
    });

});


