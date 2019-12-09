(function ($) {
    $(function () {
        //save the latest tab (http://stackoverflow.com/a/18845441)
        $('a[data-toggle="tab"]').on('click', function (e) {
            localStorage.setItem('lastTab', $(e.target).attr('href'));
        });

        //go to the latest tab, if it exists:
        var lastTab = localStorage.getItem('lastTab');

        if (lastTab) {
            $('a[href="' + lastTab + '"]').click();
        }
    });

    $("#bcitems-total_m2").on("change", function () {
        $(this).val($(this).val().replace(',', '.'));
    });


    $(document).on('keyup', '#globalSearch .global-search', function () {
        setTimeout(function () {
            $('#globalSearch').submit();
        }, 1000);
    });

    /*$(document).on('submit', '#globalSearch', function () {
        alert(1);
        $('#globalSearch .global-search').focus();
    });*/

    $(document).on('pjax:complete', function (event) {
        $('#globalSearch .global-search').focus();
        //alert('foc');
        event.preventDefault();
        event.stopPropagation();
        //return false;
    });

    $("#selectButton").on("click", function () {
        var keys = $('#grid').yiiGridView('getSelectedRows');
        console.log(keys);
    });


})(jQuery);
