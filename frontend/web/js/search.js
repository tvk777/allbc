(function ($) {
    $('.search_input').bind("change keyup input click", function() {
        var target = $("#main_type").val(),
            city = $(".choose-city .dropdown_menu .active").data('id'),
            result = $(this).data('result');
        if(this.value.length >= 3){
            $.ajax({
                url: '/site/search',
                type: 'POST',
                data: {"referal": this.value, "target": target,"city": city, "result": result, "_csrf": yii.getCsrfToken()},
            }).done(function (response) {
                $(".search_result").html(response).fadeIn();
            });

        } else {
            $(".search_result").html('').fadeOut(); 
        }
    });

    /*$('#pill_ch_1').bind('change', function(e){
        e.preventDefault();
        console.log($(this).prop("checked") == true);
    });*/


})(jQuery);
