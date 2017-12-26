var User = function(){
    return {
        login:function(){
            $("form#loginform").submit(function(){
                var valid = true;
                var msg = "<p>Các trường có dấu * là bắt buộc!</p>";
                
                $("form#loginform input[type='text'], form#loginform input[type='password']").each(function(){
                    if($(this).val().length == 0){
                        $(this).parent('span.input-text').css({
                            'border': '1px solid red'
                        });
                        valid = false;
                    }else{
                        $(this).parent('span.input-text').css({
                            'border': '1px solid #CCCCCC'
                        });
                    }
                });
                
                if(!valid){
                    $("#message").html(msg).addClass('warning');
                    return false;
                }
            });
        },
        register:function(){
            $("form#registerform").submit(function(){
                var valid = true;
                var msg = "<p>Các trường có dấu * là bắt buộc!</p>";
                var emailField = $("form#registerform #user_email");
                var pwd1 = $("form#registerform #user_pass");
                var pwd2 = $("form#registerform #user_pass2");
                
                $("form#registerform input[type='text'], form#registerform input[type='password']").each(function(){
                    if($(this).attr('name') != 'user_dob_year'){
                        if($(this).val().length == 0){
                            $(this).parent('span.input-text').css({
                                'border': '1px solid red'
                            });
                            valid = false;
                        }else{
                            $(this).parent('span.input-text').css({
                                'border': '1px solid #CCCCCC'
                            });
                        }
                    }
                });
                if(pwd2.val() != pwd1.val()){
                    pwd2.parent('span.input-text').css({
                        'border': '1px solid red'
                    });
                    valid = false;
                    msg += "<p>Xác nhận mật khẩu không chính xác!</p>";
                }else{
                    pwd2.parent('span.input-text').css({
                        'border': '1px solid #CCCCCC'
                    });
                }
                if(!isValidEmail(emailField.val())){
                    emailField.parent('span.input-text').css({
                        'border': '1px solid red'
                    });
                    valid = false;
                    msg += "<p>Địa chỉ email không hợp lệ!</p>";
                }else{
                    emailField.parent('span.input-text').css({
                        'border': '1px solid #CCCCCC'
                    });
                }
                
                if(!valid){
                    $("#message").html(msg).addClass('warning');
                    return false;
                }
            });
        }
    }
}();
var FixedColumn = function(){
    return {
        menubar:function(){
            var summaries = $('#header');
            summaries.each(function(i) {
                var summary = $(summaries[i]);
                var next = summaries[i + 1];

                summary.scrollToFixed({
                    marginTop: $('#wpadminbar').outerHeight(true),
                    limit: function() {
                        var limit = 0;
                        if (next) {
                            limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                        } else {
                            // footer offset top
                            limit = $('#footer').offset().top - $(this).outerHeight(true) - 10;
                        }
                        return limit;
                    },
                    zIndex: 999
                });
            });
        },
        single:function(){
            var summaries = $('.col-left');
            summaries.each(function(i) {
                var summary = $(summaries[i]);
                var next = summaries[i + 1];

                summary.scrollToFixed({
                    marginTop: $('#wpadminbar').outerHeight(true) + $('#header').outerHeight(true),
                    limit: function() {
                        var limit = 0;
                        if (next) {
                            limit = $(next).offset().top - $(this).outerHeight(true) - 10;
                        } else {
                            // footer offset top
                            limit = $('.post-tag').offset().top - $(this).outerHeight(true) - 10;
                        }
                        return limit;
                    },
                    zIndex: 999
                });
            });
        }
    }
}();

// Run
$(function(){
    function changeStyleInputSearch($elm){
        var input_search = $(".nav-search input[name='s']");
        if($elm.width() <= 1280){
            input_search.addClass('input-search2').removeClass('input-search1');
        }else{
            input_search.addClass('input-search1').removeClass('input-search2');
        }
    }
    $(window).load(function(){
        changeStyleInputSearch($(window));
    });
    $(window).resize(function(){
        changeStyleInputSearch($(window));
    });

    $(".tabs-news").tabs();
    
    $("#backToTop").click(function(){
        scrollToElement("#top_content");
    });
    
    if($(".page-404").length > 0){
        var height = $(window).height() - 82 - 80;
        $(".page-404").css({
            'height': height/2 + 146 - 146/2,
            'padding-top': height/2 - 146 + 146/2
        });
    }
    
    FixedColumn.menubar();
});