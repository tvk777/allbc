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

    $(".linkable td").on("click", function () {
        if (!$(this).hasClass('action-column')) {
            var link = $(this).closest('.linkable').data('link');
            location.href = link;
        }
    });

    $('.remove-selection').on("click", function (e) {
        var selection = $('.action-column input:checkbox:checked').length;
        if(selection >0){
            if(!confirm('Вы уверены в том, что хотите удалить выделенные элементы?')) e.preventDefault();
        } else {
            e.preventDefault();
            return;
        }
    });

    /*$('#bcitemssearch-searchstring').on('change', function () {
        if($(this).val().length>3) {
            console.log($(this).val());
            $('#searchString').submit();
            /!*setTimeout(function () {
            $('#searchString').submit();
        }, 1000);*!/
        }
    });*/

})(jQuery);
