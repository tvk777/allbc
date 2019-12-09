/**
 * Created by Tatyana on 21.06.2019.
 */
(function ($) {
$('form').submit(function(e){
    var formData = new FormData($(this)[0]);
    $.ajax({
        type: 'post',
        url:'url',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {

        }
    })
    e.preventDefault();

    return false;
});


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#social-file").change(function(){
        readURL(this);
    });

    $('link-del').click(function(e){
        e.preventDefault();
        $.ajax({
            type:'POST',
            cache: false,
            url: '',
            success  : function(response) {
                $('.link-del').html(response);
                $('.postImg').remove();
            }
        });
    });

})(jQuery);
