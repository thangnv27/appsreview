var Post = function(){
    return {
        getTopViews:function(action, btnNext, btnPrev, paged, current_page, total_page, content){
            content.addClass('ajax-loading');
            
            var exclude_post_id = $("link[rel='exclude_post_id']").attr('content');
            if(!exclude_post_id) exclude_post_id = 0;
            
            $.ajax({  
                type: 'POST',  
                url: siteUrl + '/wp-admin/admin-ajax.php',  
                data: {
                    action: action,
                    paged: paged,
                    exclude_post_id: exclude_post_id
                },
                dataType: 'json',
                cache: false,
                success: function(response, textStatus, XMLHttpRequest){
                    if(response.data.length > 0){
                        content.html(response.data);
                        current_page.text(response.current_page);
                        total_page.text(response.total_page);
                        btnNext.attr('rel', response.next_page);
                        btnPrev.attr('rel', response.prev_page);
                    }
                },  
                error: function(MLHttpRequest, textStatus, errorThrown){  
                    //alert(errorThrown);
                },
                complete:function(){
                    content.removeClass('ajax-loading');
                }
            }); 
        },
        topViewNews: function($){
            var action = 'get_top_view_news';
            var current_page = $("#pagingnews .current-page");
            var total_page = $("#pagingnews .total-page");
            var btnNext = $("#pagingnews a.next-page");
            var btnPrev = $("#pagingnews a.prev-page");
            var content = $("#topviewNews_content");
            
            $(window).load(function(){
                Post.getTopViews(action, btnNext, btnPrev, 1, current_page, total_page, content);
            });
            $("#pagingnews a.next-page, #pagingnews a.prev-page").click(function(){
                Post.getTopViews(action, btnNext, btnPrev, $(this).attr('rel'), current_page, total_page, content);
                return false;
            });
            
            /*$('#form').ajaxForm({  
                data: {  
                    // Here you can include additional data along with the form fields  
                },  
                dataType: 'json',
                beforeSubmit: function(formData, jqForm, options) {  
                    // optional data processing before submitting the form  
                },  
                success : function(responseText, statusText, xhr, $form) {  
                }  
            });*/
        },
        topViewApps: function($){
            var action = 'get_top_view_apps';
            var current_page = $("#pagingapps .current-page");
            var total_page = $("#pagingapps .total-page");
            var btnNext = $("#pagingapps a.next-page");
            var btnPrev = $("#pagingapps a.prev-page");
            var content = $("#topviewApps_content");
            
            $(window).load(function(){
                Post.getTopViews(action, btnNext, btnPrev, 1, current_page, total_page, content);
            });
            $("#pagingapps a.next-page, #pagingapps a.prev-page").click(function(){
                Post.getTopViews(action, btnNext, btnPrev, $(this).attr('rel'), current_page, total_page, content);
                return false;
            }); 
        }
    }
}();

jQuery(document).ready(function($) {  
    Post.topViewNews($);
    Post.topViewApps($);
}); 