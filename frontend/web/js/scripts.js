function getHeaderParams() {
    var headerSite = $(".header_site");
    if (bodyWidth <= 800) {
        if ($(".promo_sect").length > 0) {
            if (headerSite.offset().top > 1) {
                headerSite.addClass("js");
            } else {
                headerSite.removeClass("js");
            }
        } else {
            headerSite.addClass("js");
        }
    }
}

function getAdaptivePositionElements() {
    $(".append-elem").each(function () {
        screenParam = parseInt($(this).attr("data-min-screen"));
        indexElem = $(this).attr("data-append-desktop-elem");
        if (bodyWidth <= screenParam) {
            $("[data-append-elem = '" + indexElem + "']").append($(this).children());
        }
        if (bodyWidth > screenParam) {
            $("[data-append-desktop-elem = '" + indexElem + "']").append($("[data-append-elem = '" + indexElem + "']").children());
        }
    });
}

function getBarsChart() {
    if ($(".bars").length > 0) {
        $(".bars").each(function () {
            if ($(this).is(":visible")) {
                var heightArr = [];
                bar = $(this).find(".bar");
                barsLength = bar.length;
                bar.each(function () {
                    heightVal = parseInt($(this).attr("data-count-val"));
                    heightArr.push(heightVal);
                });
                maxHeight = Math.max.apply(null, heightArr);
                chartHeight = $(this).height();
                chartWidth = $(this).width();
                heightModul = chartHeight / maxHeight;
                bar.each(function () {
                    heightVal = parseInt($(this).attr("data-count-val"));
                    $(this).css({
                        "height": ( heightVal * heightModul ) + "px",
                        "width": chartWidth / barsLength + "px"
                    });
                });
                barsCharts = $(this).closest(".bars_range_wrapp");
                handleLower = barsCharts.find(".noUi-handle-lower");
                handleUpperr = barsCharts.find(".noUi-handle-upper");
                leftCoord = handleLower.offset().left;
                rightCoord = handleUpperr.offset().left;
                $(this).find(".bar").each(function () {
                    if ($(this).offset().left > leftCoord && $(this).offset().left < rightCoord) {
                        $(this).removeClass("disable");
                    } else {
                        $(this).addClass("disable");
                    }
                });
            }
        });
    }
}

function getMapParams() {
    if ($(".object_map").length > 0) {
        filtersCoord = $(".filter_nav").offset().top + $(".filter_nav").height();
        mapCoord = $(".object_map").offset().top;
        if (filtersCoord >= mapCoord) {
            $(".map_scroll").addClass("fixed");
            $(".map_scroll").css({
                "top": $(".filter_nav").height() + "px"
            });
            mapScrollBootmCoord = filtersCoord + $(".map_scroll").height();
            bottomCoord = $(".bottom_coord").offset().top;
            if (mapScrollBootmCoord >= bottomCoord) {
                $(".map_scroll").addClass("bottom_position");
            } else {
                $(".map_scroll").removeClass("bottom_position");
            }
        } else {
            $(".map_scroll").removeClass("fixed");
            $(".map_scroll").css({
                "top": 0
            });
        }
    }
}

function getfilterNavParams() {
    if ($("#filters").length > 0) {
        if ($(window).scrollTop() > $("#filters").offset().top) {
            $(".filter_nav").addClass("fixed");
            $(".filter_resp").addClass("scroll");
            $("#filters").outerHeight($(".filter_nav").outerHeight());
        } else {
            $(".filter_nav").removeClass("fixed");
            $(".filter_resp").removeClass("scroll");
            $("#filters").height(false);
        }
    }
}

function getCardParams() {
    $(".object_card").each(function () {
        var innerWrapp = $(this).find(".inner_wrapp");
        $(this).height(innerWrapp.height());
    });
}

function cardSlider() {
    if ($(".object_slider").length > 0) {
        var slideImgBox;
        var imagePath;
        var objectSlider;

        objectSlider = $(".object_slider").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            autoplay: false,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            prevArrow: '<button class="slick-prev white_left_arrow" aria-label="Previous" type="button"></button>',
            nextArrow: '<button class="slick-next white_right_arrow" aria-label="Next" type="button"></button>'
        });

        $(".object_slider").each(function () {
            slideImgBox = $(this).find(".slick-current .img_box");
            imagePath = $(this).find(".slick-current .img_box").attr("data-imageurl");
            slideImgBox.find("img").attr("src", imagePath);
        });

        objectSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            slideImgBox = $(this).find("[data-slick-index =" + nextSlide + "] .img_box");
            imagePath = slideImgBox.attr("data-imageurl");
            slideImgBox.find("img").attr("src", imagePath);
        });

        $(".object_card *").on('click', function (e) {
            if ($(this).hasClass("slick-prev") || $(this).hasClass("slick-next")) {
                e.preventDefault();
            }
        });

    }
}

function expertsSlider() {
    // alert('expert');
    if ($(".slider_2").length > 0) {
        $(".slider_2").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1100,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 510,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
}


var w = window,
    d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0],
    bodyWidth = w.innerWidth || e.clientWidth || g.clientWidth;

var parentBlock;
var HEIGHTCONST;
var screenParam;
var indexElem;
var hide_element;

var bar,
    heightVal,
    chartHeight,
    chartWidth,
    heightModul,
    maxHeight,
    barsLength;

var minVal,
    maxVal,
    leftRange,
    rightRange,
    leftCoord,
    rightCoord,
    values,
    handleLower,
    handleUpperr;

var filtersCoord,
    mapCoord,
    mapScrollBootmCoord,
    bottomCoord;

var innerWrapp;

$(window).on("load", function () {
    //console.log($(".scroll").length + ' ' + $(".scroll").attr('class'));
    if ($(".scroll").length > 0) {
        $(".scroll").mCustomScrollbar();
    }
});

$(window).resize(function () {
    bodyWidth = w.innerWidth || e.clientWidth || g.clientWidth;
    getAdaptivePositionElements();
    getHeaderParams();
    getMapParams();
    getBarsChart();
    getfilterNavParams();
    getCardParams();
});

$(document).scroll(function () {
    getHeaderParams();
    getMapParams();
    getfilterNavParams();
    getCardParams();
});

$(document).on('pjax:complete', function (event) {
    if(currency==1){
        var priceText = '₴ ' + minPrice.toString() + ' - ' + maxPrice.toString();
    } else if(currency==2){
        var priceText = '$ ' + minPrice.toString() + ' - ' + maxPrice.toString();
    } else if(currency==3) {
        var priceText = '€ ' + minPrice.toString() + ' - ' + maxPrice.toString();
    }
    $('.price-filter .item_title_text p').text(priceText);

    if (document.getElementById("range_slider_2")) { //price slider ₴/м²/mec
        if (maxTotalPrice === null) {
            maxPrice = 0;
            maxTotalPrice = 0;
            start = [0, 10000];
        } else {
            maxPrice = parseInt(maxPrice);
            minPrice = parseInt(minPrice);
            maxTotalPrice = parseInt(maxTotalPrice);
            start = [minPrice, maxPrice];
        }

        priceSlider2 = document.getElementById("range_slider_2");
        if (priceSlider2.noUiSlider) {
            priceSlider2.noUiSlider.destroy();
        }
        noUiSlider.create(priceSlider2, {
            start: start,
            range: {
                'min': [0],
                'max': [maxTotalPrice]
            },
            connect: true,
            format: wNumb({
                decimals: 0
            })
        });

        priceSlider2.noUiSlider.on('update', function (values, handle) {
            minVal = parseInt(values[0]);
            maxVal = parseInt(values[1]);
            $("#input-number_1").val(minVal);
            $("#input-number_2").val(maxVal);
            leftRange = minVal;
            rightRange = maxVal;
            handleLower = $("#range_slider_2").find(".noUi-handle-lower");
            handleUpperr = $("#range_slider_2").find(".noUi-handle-upper");
            leftCoord = handleLower.offset().left;
            rightCoord = handleUpperr.offset().left + 1;
            barsCharts = handleLower.closest(".bars_range_wrapp");
            barsCharts.find(".bars .bar").each(function () {
                if ($(this).offset().left >= leftCoord && $(this).offset().left <= rightCoord) {
                    $(this).removeClass("disable");
                } else {
                    $(this).addClass("disable");
                }
            });
            $("[data-filters-index='filters_3'] .minVal2").html(leftRange);
            $("[data-filters-index='filters_3'] .maxVal2").html(rightRange);
            $(".price_resp").html($("#price_sel").html());
        });
        priceSlider2.noUiSlider.on('set', function (values, handle) {
            setTimeout(function () {
                handleLower = $("#range_slider_2").find(".noUi-handle-lower");
                handleUpperr = $("#range_slider_2").find(".noUi-handle-upper");
                leftCoord = handleLower.offset().left;
                rightCoord = handleUpperr.offset().left;
                console.log(leftCoord + ' - ' + rightCoord);
                barsCharts = handleLower.closest(".bars_range_wrapp");
                console.log(barsCharts.find(".bars .bar:last-child").offset().left);
                barsCharts.find(".bars .bar").each(function () {
                    if ($(this).offset().left >= leftCoord && $(this).offset().left <= rightCoord) {
                        $(this).removeClass("disable");
                    } else {
                        $(this).addClass("disable");
                    }
                });
            }, 500);
            $("[data-filters-index='filters_3'] .minVal2").html(minVal);
            $("[data-filters-index='filters_3'] .maxVal2").html(maxVal);
            $(".price_resp").html($("#price_sel").html());
        });
        priceSlider2.noUiSlider.on('change', function (values, handle) {
            minVal = parseInt($("#input-number_1").val());
                $("#minpricem2").val(minVal);

            maxVal = parseInt($("#input-number_2").val());
            $("#maxpricem2").val(maxVal);
        });

        $("#input-number_1").keyup(function () {
            activeInputVal = parseInt($(this).val());
            if (activeInputVal < parseInt($("#input-number_2").val())) {
                leftRange = parseInt($(this).val());
                priceSlider2.noUiSlider.set([leftRange, null]);
            }
                $("#minpricem2").val(activeInputVal);
        });
        $("#input-number_2").keyup(function () {
            activeInputVal = parseInt($(this).val());
            if (activeInputVal > parseInt($("#input-number_1").val())) {
                rightRange = parseInt($(this).val());
                priceSlider2.noUiSlider.set([null, rightRange]);
            }
                $("#maxpricem2").val(activeInputVal);
        });
        getBarsChart();
    }


});

$(document).ready(function () {
    var countDiv = $("#count"),
        countCity = countDiv.find(".city-name"),
        countNumber = countDiv.find(".free_count h3"),
        cityLink = $("#city_link"),
        main_type = $("#main_type"),
        cityUrl;
    getHeaderParams();
    getAdaptivePositionElements();
    getMapParams();
    getBarsChart();
    getfilterNavParams();
    getCardParams();
    expertsSlider();
    cardSlider();


    /*if($("#searchonmap") && $("#searchonmap").length>0) {
     $("#searchonmap").prop("checked", false);
     }*/

    $(".top_menu").each(function () {
        $(this).find(".main_nav > li ul").each(function () {
            $(this).addClass("sub-menu");
        });
        $(this).find(".main_nav > li").each(function () {
            if ($(this).find(".sub-menu").length > 0) {
                $(this).append("<button type='button' class='menu_btn'></button>");
            }
        });
    });

    $(".menu_btn").on("click", function (e) {
        e.preventDefault();
        var menuItem = $(this).closest("li").find(".sub-menu");
        if (menuItem.is(":hidden")) {
            menuItem.slideDown(300);
            $(this).addClass("active");
        } else {
            menuItem.slideUp(300);
            $(this).removeClass("active");
        }
    });

    $(".respmenubtn").click(function () {
        if ($("#resp_nav").is(":hidden")) {
            $("#resp_nav").fadeIn(300);
            $(this).addClass("active");
        } else {
            $("#resp_nav").fadeOut(300);
            $(this).removeClass("active");
        }
    });

    $(this).keydown(function (eventObject) {
        if (eventObject.which == 27 &&
            $("#resp_nav").is(":visible")) {
            $("#resp_nav").fadeOut(300);
            $(".respmenubtn").removeClass("active");
        }
    });

    $(".search_open").on('click', function (e) {
        e.preventDefault();
        var searchPopup = $(".search_popup");
        searchPopup.toggleClass("active");
        if (!searchPopup.hasClass("active")) {
            $(".search_result").css({
                "display": "none"
            });
        }
    });

    $(".close_x").on('click', function (e) {
        e.preventDefault();
        var searchPopup = $(".search_popup");
        searchPopup.removeClass("active");
        $(".search_result").css({
            "display": "none"
        });
    });

    $(this).keydown(function (eventObject) {
        if (eventObject.which == 27) {
            $(".search_popup").removeClass("active");
        }
    });

    $(document).mouseup(function (e) {
        hide_element = $(".search_popup")
        if (!hide_element.is(e.target)
            && hide_element.has(e.target).length === 0) {
            $(".search_popup").removeClass("active");
        }
    });

    $(".dropdown_title").on('click', function (e) {
        e.preventDefault();
        parentBlock = $(this).closest(".dropdowm_wrapp");
        var dropdownMenu = parentBlock.find(".dropdown_menu");
        if (dropdownMenu.is(":hidden")) {
            parentBlock.addClass("active");
            dropdownMenu.slideDown(300);
        } else {
            dropdownMenu.slideUp(300);
            setTimeout(function () {
                parentBlock.removeClass("active");
            }, 400);
        }
    });

    $(".dropdowm_wrapp ul a").on('click', function (e) {
        var linkText = $(this).text();
        parentBlock = $(this).closest(".dropdowm_wrapp");
        parentBlock.find(".p_width").text(linkText);
        parentBlock.find(".dropdown_title input").val(linkText);
        parentBlock.find("ul a").removeClass("active");
        $(this).addClass("active");
    });

    $(".choose-city a").on('click', function (e) {
        e.preventDefault();
        countNumber.html($(this).data('count'));
        countCity.html($(this).data('inflect'));
        cityLink.val($(this).data('value'));
        cityLink.data('valuesell', $(this).data('valuesell'));
        $("#submit_main_form").click();
    });
    $(".sel-type").on('click', function (e) {
        main_type.val($(this).data('value'));
    });
    $("#submit_main_form").on('click', function (e) {
        e.preventDefault();
        if (main_type.val() == 1) {
            cityUrl = cityLink.val();
        } else {
            cityUrl = cityLink.data('valuesell');
        }
        window.location.href = "/" + cityUrl;
    });

    $(this).keydown(function (eventObject) {
        if (eventObject.which == 27) {
            $(".dropdown_menu").slideUp(300);
            setTimeout(function () {
                $(".dropdowm_wrapp").removeClass("active");
            }, 400);
        }
    });

    $(document).mouseup(function (e) {
        hide_element = $(".dropdown_menu");
        if (!hide_element.is(e.target)
            && hide_element.has(e.target).length === 0) {
            parentBlock = hide_element.closest(".dropdowm_wrapp");
            hide_element.slideUp(300);
            setTimeout(function () {
                $(".dropdowm_wrapp").each(function () {
                    if ($(this).find(".dropdown_menu").is(":hidden")) {
                        $(this).removeClass("active");
                    }
                });
            }, 400);
        }
    });

    $(".text_box").each(function (e) {
        $(this).css({
            "height": parseInt($(this).attr("data-minheight")) + "px"
        });
    });

    $("[data-slidebox-id]").on('click', function (e) {
        e.preventDefault();
        var slideTextName = $(this).attr('data-slidebox-id');
        var slideText = $("#" + slideTextName + "");
        HEIGHTCONST = parseInt(slideText.attr("data-minheight"));
        if (slideText.height() > HEIGHTCONST) {
            slideText.animate({
                "height": HEIGHTCONST + "px"
            }, 500);
            $(this).removeClass("active");
        } else {
            slideText.animate({
                "height": slideText.find(".inner_height").height() + "px"
            }, 500);
            setTimeout(function () {
                slideText.css({
                    "height": "auto"
                });
            }, 600);
            $(this).addClass("active");
        }
    });

    var countItem;

    $(".number_list").each(function () {
        countItem = 0;
        $(this).find("li").each(function () {
            countItem++;
            $(this).prepend("<span class='number'>" + countItem + ". </span>");
        });
    });

    if ($(".slider_partners").length > 0) {
        $(".slider_partners").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 6,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1220,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 560,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 410,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }

    if ($(".testimonial_slider").length > 0) {
        $(".testimonial_slider").not(".slick-initialized").slick({
            dots: false,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            appendArrows: $(".testimonial_slider_contorls"),
            asNavFor: $(".slider_partners_2")
        });
    }

    if ($(".slider_partners_2").length > 0) {
        $(".slider_partners_2").not(".slick-initialized").slick({
            dots: false,
            arrows: false,
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: $(".testimonial_slider"),
            responsive: [
                {
                    breakpoint: 1140,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 960,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 510,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

    }

    if ($(".slider_3").length > 0) {
        $(".slider_3").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 3,
            slidesToScroll: 1,
            appendArrows: $(".slider_3_controls"),
            responsive: [
                {
                    breakpoint: 1130,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }

    if ($(".slider_alt").length > 0) {
        $(".slider_alt").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            autoplay: false,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 4,
            slidesToScroll: 1,
            appendArrows: $(".slider_alt_controls"),
            responsive: [
                {
                    breakpoint: 1130,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }

    if ($(".slider_4").length > 0) {
        $(".slider_4").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 3,
            slidesToScroll: 1,
            appendArrows: $(".slider_4_controls"),
            responsive: [
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 620,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }

    $("[data-slidedown-btn]").on('click', function (e) {
        e.preventDefault();
        var slideBoxName = $(this).attr("data-slidedown-btn");
        var slideBox = $("[data-slidedown = '" + slideBoxName + "']");
        HEIGHTCONST = parseInt(slideBox.attr("data-minheight"));
        if (slideBox.height() <= HEIGHTCONST) {
            slideBox.animate({
                "height": slideBox.find(".tags_slidedown").height() + "px"
            }, 300);
            setTimeout(function () {
                slideBox.css({
                    "height": "auto"
                });
            }, 400);
            $(this).addClass("active");
        } else {
            slideBox.animate({
                "height": HEIGHTCONST + "px"
            }, 300);
            $(this).removeClass("active");
        }

    });

    if ($(".charts_slider").length > 0) {
        $(".charts_slider").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 1,
            slidesToScroll: 1,
            appendArrows: $(".charts_slider_controls")
        });
    }


    if ($(".table_slider").length > 0) {
        $(".table_slider").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            // autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            appendArrows: $(".table_slider_controls")
        });
    }

    var dropdowmMenu;

    $(".dropdown_item_title").on('click', function (e) {
        e.preventDefault();
        parentBlock = $(this).closest(".dropdow_item_wrapp");
        dropdowmMenu = parentBlock.find(".dropdown_item_menu");
        if ($(this).closest(".items_sect").length > 0) {
            $(".dropdown_item_menu").slideUp(300);
            $(".dropdow_item_wrapp").removeClass("visible");
            if (dropdowmMenu.is(":hidden")) {
                $(".item_wrapp").removeClass("z_top");
                parentBlock.closest(".item_wrapp").addClass("z_top");
                $("#map_box .mask").addClass("visible");
            } else {
                $("#map_box .mask").removeClass("visible");
            }
            $("#filters_menu").removeClass("visible");
            $(".more_filter").removeClass("active");
        }
        if (dropdowmMenu.is(":hidden")) {
            dropdowmMenu.slideDown(300);
            parentBlock.addClass("active");
            getBarsChart();
        } else {
            dropdowmMenu.slideUp(300);
            parentBlock.removeClass("active");
        }
    });

    $("#map_box .mask").on("click", function (e) {
        e.preventDefault();
        $(".dropdown_item_menu").slideUp(300);
        setTimeout(function () {
            $(".dropdow_item_wrapp").removeClass("active");
            $("#map_box .mask").removeClass("visible");
        }, 400);
    });

    var curTop;

    $(".more_filter").on('click', function (e) {
        e.preventDefault();
        if (!$("#filters_menu").hasClass("visible")) {
            $("#filters_menu").addClass("visible");
            $(this).addClass("active");
            getBarsChart();
            $("body").css({
                "position": "fixed",
                "top": -$(document).scrollTop() + "px",
                "overflow": "hidden",
                "right": 0,
                "left": 0,
                "bottom": 0
            });
            $("body").addClass("fixed_position");
        } else {
            $("#filters_menu").removeClass("visible");
            $(this).removeClass("active");
            curTop = $("body").css("top");
            curTop = Math.abs(parseInt(curTop, 10));
            $("body").attr("style", "")
            if (curTop !== 0) {
                $("html").scrollTop(curTop);
            }
            $("body").removeClass("fixed_position");
        }
        $(".dropdown_item_menu").slideUp(300);
        $(".dropdow_item_wrapp").removeClass("active");
        $("#map_box .mask").removeClass("visible");
    });

    $(".close_filter").on("click", function (e) {
        e.preventDefault();
        $("#filters_menu").removeClass("visible");
        $("body").removeClass("fixed_position");
        curTop = $("body").css("top");
        curTop = Math.abs(parseInt(curTop, 10));
        $("body").attr("style", "")
        if (curTop !== 0) {
            $("html").scrollTop(curTop);
        }
        $(".more_filter").removeClass("active");
        $(".dropdown_item_menu").slideUp(300);
        $(".dropdow_item_wrapp").removeClass("active");
        $("#map_box .mask").removeClass("visible");
    });

    $(".mask_2").on("click", function () {
        $("#filters_menu").removeClass("visible");
        $(".more_filter").removeClass("active");
        $("body").removeClass("fixed_position");
        curTop = $("body").css("top");
        curTop = Math.abs(parseInt(curTop, 10));
        $("body").attr("style", "")
        if (curTop !== 0) {
            $("html").scrollTop(curTop);
        }
    });

    $(this).keydown(function (eventObject) {
        if (eventObject.which == 27) {
            $("#filters_menu").removeClass("visible");
            $(".more_filter").removeClass("active");
            $(".dropdown_item_menu").slideUp(300);
            $("body").removeClass("fixed_position");
            curTop = $("body").css("top");
            curTop = Math.abs(parseInt(curTop, 10));
            $("body").attr("style", "")
            if (curTop !== 0) {
                $("html").scrollTop(curTop);
            }
            setTimeout(function () {
                $(".dropdow_item_wrapp").removeClass("active");
                $("#map_box .mask").removeClass("visible");
            }, 400);
        }
    });

    $(document).mouseup(function (e) {
        hide_element = $(".dropdown_item_menu");
        if (!hide_element.is(e.target)
            && hide_element.has(e.target).length === 0) {
            hide_element.slideUp(300);
            setTimeout(function () {
                $(".dropdown_item_menu").each(function () {
                    if ($(this).is(":hidden")) {
                        $(this).closest(".dropdow_item_wrapp").removeClass("active");
                    }
                });
            }, 400);
            $("#map_box .mask").removeClass("visible");
        }
    });


    $(this).keydown(function (eventObject) {
        if (eventObject.which == 27) {
            $(".dropdown_select").slideUp(300);
            setTimeout(function () {
                $(".custom_select").removeClass("active");
            }, 400);
        }
    });

    $(document).mouseup(function (e) {
        hide_element = $(".dropdown_select");
        if (!hide_element.is(e.target)
            && hide_element.has(e.target).length === 0) {
            hide_element.slideUp(300);
            setTimeout(function () {
                $(".dropdown_select").each(function () {
                    if ($(this).is(":hidden")) {
                        $(this).closest(".custom_select").removeClass("active");
                    }
                });
            }, 400);
        }
    });

    $(document).on({
        click: function (e) {
            e.preventDefault();
            parentBlock = $(this).closest(".custom_select");
            dropdowmMenu = parentBlock.find(".dropdown_select");
            if (dropdowmMenu.is(":hidden")) {
                dropdowmMenu.slideDown(200);
                parentBlock.addClass("active");
            } else {
                dropdowmMenu.slideUp(200);
                parentBlock.removeClass("active");
            }
        }
    }, '.custom_select .select_input');


    $(document).on({
        click: function () {
            var itemText = $(this).text();
            parentBlock = $(this).closest(".custom_select");
            var inputVal = parentBlock.find(".select_input .sel_val");
            parentBlock.find(".select_res").val(itemText);
            inputVal.html(itemText);
            if (inputVal.attr("id") == "price_sel") {
                $(".price_resp").html(itemText);
            }
            parentBlock.find(".dropdown_select").slideUp(200);
        }
    }, '.select_item p');

    $(document).on({
        click: function () {
            var type = $(this).data('type'),
                currency = $(this).data('currency');
            $('#type').val(type);
            $('#currency').val(currency);
            $('#typeF').val(type);
            $('#currF').val(currency);
            $("#barsForm").submit();
        }
    }, '#price-filter .select_item p');


    // Range Slider

    if (document.getElementById("range_slider_2")) { //price slider ₴/м²/mec
        if (maxTotalPrice === null) {
            maxPrice = 0;
            maxTotalPrice = 0;
            start = [0, 10000];
        } else {
            maxPrice = parseInt(maxPrice);
            minPrice = parseInt(minPrice);
            maxTotalPrice = parseInt(maxTotalPrice);
            start = [minPrice, maxPrice];
            console.log(start);
        }

        priceSlider2 = document.getElementById("range_slider_2");
        noUiSlider.create(priceSlider2, {
            start: start,
            range: {
                'min': [0],
                'max': [maxTotalPrice]
            },
            connect: true,
            format: wNumb({
                decimals: 0
            })
        });

        priceSlider2.noUiSlider.on('update', function (values, handle) {
            minVal = parseInt(values[0]);
            maxVal = parseInt(values[1]);
            $("#input-number_1").val(minVal);
            $("#input-number_2").val(maxVal);
            leftRange = minVal;
            rightRange = maxVal;
            handleLower = $("#range_slider_2").find(".noUi-handle-lower");
            handleUpperr = $("#range_slider_2").find(".noUi-handle-upper");
            leftCoord = handleLower.offset().left;
            rightCoord = handleUpperr.offset().left + 1;
            barsCharts = handleLower.closest(".bars_range_wrapp");
            barsCharts.find(".bars .bar").each(function () {
                if ($(this).offset().left >= leftCoord && $(this).offset().left <= rightCoord) {
                    $(this).removeClass("disable");
                } else {
                    $(this).addClass("disable");
                }
            });
            $("[data-filters-index='filters_3'] .minVal2").html(leftRange);
            $("[data-filters-index='filters_3'] .maxVal2").html(rightRange);
            $(".price_resp").html($("#price_sel").html());
        });
        priceSlider2.noUiSlider.on('set', function (values, handle) {
            setTimeout(function () {
                handleLower = $("#range_slider_2").find(".noUi-handle-lower");
                handleUpperr = $("#range_slider_2").find(".noUi-handle-upper");
                leftCoord = handleLower.offset().left;
                rightCoord = handleUpperr.offset().left;
                console.log(leftCoord + ' - ' + rightCoord);
                barsCharts = handleLower.closest(".bars_range_wrapp");
                console.log(barsCharts.find(".bars .bar:last-child").offset().left);
                barsCharts.find(".bars .bar").each(function () {
                    if ($(this).offset().left >= leftCoord && $(this).offset().left <= rightCoord) {
                        $(this).removeClass("disable");
                    } else {
                        $(this).addClass("disable");
                    }
                });
            }, 500);
            $("[data-filters-index='filters_3'] .minVal2").html(minVal);
            $("[data-filters-index='filters_3'] .maxVal2").html(maxVal);
            $(".price_resp").html($("#price_sel").html());
        });
        priceSlider2.noUiSlider.on('change', function (values, handle) {
            minVal = parseInt($("#input-number_1").val());
            $("#minpricem2").val(minVal);
            maxVal = parseInt($("#input-number_2").val());
                $("#maxpricem2").val(maxVal);
        });

        $("#input-number_1").keyup(function () {
            activeInputVal = parseInt($(this).val());
            if (activeInputVal < parseInt($("#input-number_2").val())) {
                leftRange = parseInt($(this).val());
                priceSlider2.noUiSlider.set([leftRange, null]);
            }
                $("#minpricem2").val(activeInputVal);
        });
        $("#input-number_2").keyup(function () {
            activeInputVal = parseInt($(this).val());
            if (activeInputVal > parseInt($("#input-number_1").val())) {
                rightRange = parseInt($(this).val());
                priceSlider2.noUiSlider.set([null, rightRange]);
            }
                $("#maxpricem2").val(activeInputVal);
        });
    }

    if (document.getElementById("range_slider_3")) {
        priceSlider3 = document.getElementById("range_slider_3");
        noUiSlider.create(priceSlider3, {
            start: [metroVal],
            range: {
                'min': [0],
                'max': [5000]
            },
            connect: [true, false],
            tooltips: true,
            format: wNumb({
                decimals: 0
            }),
        });
        priceSlider3.noUiSlider.on('update', function (values, handle) {
            minVal = parseInt(values[0]);
            $("#metro_val").text(minVal);
            $("#metro_name").html($("#metro_name_val a").html());
        });
        priceSlider3.noUiSlider.on('change', function (values, handle) {
            minVal = parseInt(values[0]);
            $("#walk_dist").val(minVal);
        });

    }

    if (document.getElementById("range_slider_4")) { //m2 slider
        if (maxTotal === null) {
            maxM2 = 0;
            maxTotal = 0;
            start = [0, 10000];
        } else {
            maxM2 = parseInt(maxM2);
            minM2 = parseInt(minM2);
            maxTotal = parseInt(maxTotal);
            start = [minM2, maxM2];
        }
        priceSlider4 = document.getElementById("range_slider_4");
        noUiSlider.create(priceSlider4, {
            start: start,
            range: {
                'min': [0],
                'max': [maxTotal]
            },
            connect: true,
            format: wNumb({
                decimals: 0
            })
        });
        inputNumberMin = document.getElementById("input-number_5");
        inputNumberMax = document.getElementById("input-number_6");

        priceSlider4.noUiSlider.on('update', function (values, handle) {
            minVal = parseInt(values[0]);
            maxVal = parseInt(values[1]);
            leftRange = maxVal;
            rightRange = maxVal;
            $("#input-number_5").val(minVal);
            $("#input-number_6").val(maxVal);
            handleLower = $("#range_slider_4").find(".noUi-handle-lower");
            handleUpperr = $("#range_slider_4").find(".noUi-handle-upper");
            leftCoord = handleLower.offset().left;
            rightCoord = handleUpperr.offset().left;
            barsCharts = handleLower.closest(".bars_range_wrapp");
            barsCharts.find(".bars .bar").each(function () {
                if ($(this).offset().left > leftCoord && $(this).offset().left < rightCoord) {
                    $(this).removeClass("disable");
                } else {
                    $(this).addClass("disable");
                }
            });
            $("[data-filters-index='filters_4'] .minVal").html(minVal);
            $("[data-filters-index='filters_4'] .maxVal").html(maxVal);
        });

        priceSlider4.noUiSlider.on('set', function (values, handle) {
            setTimeout(function () {
                handleLower = $("#range_slider_4").find(".noUi-handle-lower");
                handleUpperr = $("#range_slider_4").find(".noUi-handle-upper");
                leftCoord = handleLower.offset().left;
                rightCoord = handleUpperr.offset().left;
                barsCharts = handleLower.closest(".bars_range_wrapp");
                barsCharts.find(".bars .bar").each(function () {
                    if ($(this).offset().left > leftCoord && $(this).offset().left < rightCoord) {
                        $(this).removeClass("disable");
                    } else {
                        $(this).addClass("disable");
                    }
                });
            }, 500);
        });

        priceSlider4.noUiSlider.on('change', function (values, handle) {
            minVal = parseInt($("#input-number_5").val());
                $("#minm2").val(minVal);
            maxVal = parseInt($("#input-number_6").val());
            $("#maxm2").val(maxVal);
        });


        $("#input-number_5").keyup(function () {
            activeInputVal = parseInt($(this).val());
            if (activeInputVal < parseInt($("#input-number_6").val())) {
                leftRange = parseInt($(this).val());
                priceSlider4.noUiSlider.set([leftRange, null]);
            }
            $("#minm2").val(activeInputVal);
        });
        $("#input-number_6").keyup(function () {
            activeInputVal = parseInt($(this).val());
            if (activeInputVal > parseInt($("#input-number_5").val())) {
                rightRange = parseInt($(this).val());
                priceSlider4.noUiSlider.set([null, rightRange]);
            }
            $("#maxm2").val(activeInputVal);
        });
    }

    var imagesArrayPaths = [];
    var index,
        imagesPathParent,
        pathVal,
        galleryimagesLinks;

    $("[data-photogallerylink]").on("click", function (e) {
        e.preventDefault();
        $(".photo_gallery").html("");
        imagesArrayPaths = [];
        index = $(this).attr("data-photogallerylink");
        imagesPathParent = $("[data-photogalleryindex ='" + index + "' ]");
        imagesPathParent.find("[data-imagepath]").each(function () {
            pathVal = $(this).attr("data-imagepath");
            imagesArrayPaths.push(pathVal);
        });
        galleryimagesLinks = "";
        jQuery.each(imagesArrayPaths, function (i, val) {
            galleryimagesLinks += '<a href="' + val + '" data-fancybox="1"><img src="' + val + '" alt="#" /></a>';
        });
        $(".photo_gallery").html(galleryimagesLinks);
        $(".photo_gallery [data-fancybox]:eq(0)").trigger("click");
    });

    var rentLinks = $(".rent-links"), saleLinks = $(".sale-links");
    $(".switch-type a").on("click", function (e) {
        e.preventDefault();
        $(this).addClass('active');

        if ($(this).attr('id') == 'sale') {
            $('#rent').removeClass('active');
            rentLinks.hide();
            saleLinks.show();
        } else {
            $('#sale').removeClass('active');
            saleLinks.hide();
            rentLinks.show();
        }
    });
    var selectVal,
        selectList, href;

    $(".custom_select_item").on("click", function (e) {
        e.preventDefault();
        selectVal = $(this).html();
        parentBlock = $(this).closest(".custom_select_2");
        parentBlock.find(".custom_select_title").html(selectVal);
        parentBlock.find(".custom_select_item").removeClass("selected");
        $(this).addClass("selected");
        if (parentBlock.find(".custom_select_title").attr("id") == "metro_name_val") {
            $("#metro_name").html(selectVal);
        }
        href = $(this).find('a').attr('href'); //.replace(new RegExp('/','g'), '');
        window.location.href = href;
    });

    $(".custom_select_title").on("click", function (e) {
        e.preventDefault();
        parentBlock = $(this).closest(".custom_select_2");
        dropdowmMenu = parentBlock.find(".custom_select_list");
        if (dropdowmMenu.is(":hidden")) {
            dropdowmMenu.slideDown(200);
            parentBlock.addClass("active");
        } else {
            dropdowmMenu.slideUp(200);
            parentBlock.removeClass("active");
        }
    });

    $(this).keydown(function (eventObject) {
        if (eventObject.which == 27) {
            $(".custom_select_list").slideUp(300);
            setTimeout(function () {
                $(".custom_select_2").removeClass("active");
            }, 400);
        }
    });

    $(document).mouseup(function (e) {
        hide_element = $(".custom_select_list");
        if (!hide_element.is(e.target)
            && hide_element.has(e.target).length === 0) {
            hide_element.slideUp(300);
            setTimeout(function () {
                $(".custom_select_list").each(function () {
                    if ($(this).is(":hidden")) {
                        $(this).closest(".custom_select_2").removeClass("active");
                    }
                });
            }, 400);
        }
    });

    // ------------------
    var filtersIndex;
    var filtersArray;

    $("[data-filter]").on("click", function () {
        if (!$(this).hasClass("checked_filter")) {
            $(this).addClass("checked_filter");
            filtersIndex = $(this).attr("data-filter");
        } else {
            $(this).removeClass("checked_filter");
        }
        filtersArray = [];
        $("[data-filter = '" + filtersIndex + "']").each(function () {
            if ($(this).hasClass("checked_filter")) {
                filtersArray.push($(this).text());
            }
        });
        $("[data-filters-index = '" + filtersIndex + "']").text(filtersArray);
    });

    $("[data-radio-filter]").on("click", function () {
        filtersIndex = $(this).attr("data-radio-filter");
        filtersArray = "";
        $("[data-filters-index = '" + filtersIndex + "']").text($(this).html());
    });

    $(".subway").on("click", function () {
        $("#subway").val($(this).data('subway'));
    });

    /*var dataBranch, allSubways = $(".subway.custom_select_item");

     $(".metro_radio input").on("click", function () {
     dataBranch = $(this).data('branch');
     allSubways.removeClass('hidden');
     if(dataBranch!=0) {
     $(".subway.custom_select_item").each(function () {
     if ($(this).data('branch') != dataBranch) $(this).addClass('hidden');
     });
     }

     });*/


    //Submit form and clear filters buttons

    $(".filter-form .submit").on("click", function () {
        $(".filter-form").submit();
    });

    $(".filter-form .more-filters .remove").on("click", function () {
        $(".checkbox .more-filters").attr('checked', false);
        $("#metro_val").text(defaultDist);
        $("#metro_name").html(defaultName);
        $("#metro_name_val a").html(defaultName);
        priceSlider3.noUiSlider.set(defaultDist);
        $("#walk_dist").val('');
        $("#subway").val('');
        $(".filter-form").submit();
    });

    $(".filter-form .m2-filter .remove").on("click", function () {
        $("#maxm2").val('');
        $("#minm2").val('');
        $(".dropdown_item_title.m2-filter").removeClass('green_active');
        $(".filter-form").submit();
    });

    $(".filter-form .price_w .remove").on("click", function () {
        $("#minpricem2").val('');
        $("#maxpricem2").val('');
        $("#currF").val(1);
        $("#typeF").val(1);
        $(".dropdown_item_title.price-filter").removeClass('green_active');
        $(".filter-form").submit();
    });


    if ($("#bgslider").length > 0) {
        $("#bgslider").sliderResponsive({
            hoverZoom: "off",
            hideDots: "on",
            //autoPlay:"off",
            slidePause: 10000,
            fadeSpeed: 800,
        });
    }

    // -----------------

    if ($(".object_slider_big").length > 0) {
        $(".object_slider_big").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            asNavFor: '.object_slider_miniatures',
            prevArrow: '<button class="slick-prev slick_prev_white" aria-label="Previous" type="button"><img src="/img/slider_arrow_white.svg" alt="" /></button>',
            nextArrow: '<button class="slick-next slick_next_white" aria-label="Next" type="button"><img src="/img/slider_arrow_white.svg" alt="" /></button>'
            // appendArrows: $(".slider_4_controls"),
        });
    }

    if ($(".object_slider_miniatures").length > 0) {
        $(".object_slider_miniatures").not(".slick-initialized").slick({
            dots: false,
            arrows: false,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.object_slider_big',
            prevArrow: '<button class="slick-prev slick_prev_white" aria-label="Previous" type="button"><img src="img/slider_arrow_white.svg" alt="" /></button>',
            nextArrow: '<button class="slick-next slick_next_white" aria-label="Next" type="button"><img src="img/slider_arrow_white.svg" alt="" /></button>',
            // appendArrows: $(".slider_4_controls"),
            responsive: [
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 620,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });

    }

    $("[data-slider-btn = 'object_slider_big']").on("click", function (e) {
        e.preventDefault();
        $(".object_slider_big").find(".slick-active [data-fancybox]").trigger("click");
    });

    // --------------------

    $(".slideLink").on("click", function (e) {
        e.preventDefault();
        parentBlock = $(this).closest(".slidedown_box");
        var prevContent = parentBlock.find(".prev_content");
        var nextContent = parentBlock.find(".next_content");
        if ($(this).hasClass("slidedown_link")) {
            parentBlock.addClass("active");
        } else {
            parentBlock.removeClass("active");
        }
    });

    // ---------------------

    $(".radio_2 input").on("change", function () {
        if ($(this).checked) {
            $(this).prop("checked", "false");
        } else {
            $(this).prop("checked", "true");
            var tableName = $(this).closest("[data-table]").attr("data-table");
            $("[data-table-list = '" + tableName + "']").css({
                "display": "block"
            });
        }
    });

    // ---------------------

    $(".show_tel").on("click", function (e) {
        e.preventDefault();
        parentBlock = $(this).closest(".tel_pill");
        parentBlock.css({
            "display": "none"
        });
        dataVal = parentBlock.attr("data-tel-pill");
        $(".tel_visible_pill").filter("[data-tel-pill = '" + dataVal + "']").css({
            "display": "block"
        });
    });

    $(".hide_tel").on("click", function (e) {
        e.preventDefault();
        parentBlock = $(this).closest(".tel_pill");
        parentBlock.css({
            "display": "none"
        });
        dataVal = parentBlock.attr("data-tel-pill");
        $(".tel_hide_pill").filter("[data-tel-pill = '" + dataVal + "']").css({
            "display": "block"
        });
    });

    // ---------------------

    $(".slide_socials").on("click", function (e) {
        e.preventDefault();
        var socList = $(this).closest(".socials_list");
        var socItems = socList.find(".hide_soc");
        if ($(this).hasClass("more_socials")) {
            socItems.addClass("visible");
            socList.addClass("visible");
        } else {
            socItems.removeClass("visible");
            socList.removeClass("visible");
        }
    });

    // ----------

    $(".scroll_link").click(function (e) {
        e.preventDefault();
        var scrollCoordElem = $(this).attr("href");
        var scrollCoord = $(scrollCoordElem).offset().top;
        $('html, body').stop().animate({
            'scrollTop': scrollCoord
        }, 500);
    });

    // ----------

    $("[data-popup-link]").on("click", function (e) {
        e.preventDefault();
        popupName = $(this).attr("data-popup-link");
        div = document.createElement('div');
        div.style.overflowY = 'scroll';
        div.style.width = '50px';
        div.style.height = '50px';
        div.style.visibility = 'hidden';
        document.body.appendChild(div);
        scrollWidth = div.offsetWidth - div.clientWidth;
        document.body.removeChild(div);
        $("body").css({
            "position": "fixed",
            "top": -$(document).scrollTop() + "px",
            "overflow": "hidden",
            "right": 0,
            "left": 0,
            "bottom": 0,
            "padding-right": scrollWidth + "px"
        });
        $("body").addClass("fixed");
        $("[data-popup = '" + popupName + "']").fadeIn(300);
    });

    $(".close_btn").on("click", function (e) {
        e.preventDefault();
        curTop = $("body").css("top");
        curTop = Math.abs(parseInt(curTop, 10));
        $("body").attr("style", "")
        if (curTop !== 0) {
            $("html").scrollTop(curTop);
        }
        $("body").removeClass("fixed");
        $(this).closest("[data-popup]").fadeOut(300);
    });

    $(this).keydown(function (eventObject) {
        if (eventObject.which == 27) {
            curTop = $("body").css("top");
            curTop = Math.abs(parseInt(curTop, 10));
            $("body").attr("style", "")
            if (curTop !== 0) {
                $("html").scrollTop(curTop);
            }
            $("body").removeClass("fixed");
            $("[data-popup]").fadeOut(300);
        }
    });

    $(".popup_sect").mouseup(function (e) {
        hide_element = $(".popup_wrapp");
        if (!hide_element.is(e.target)
            && hide_element.has(e.target).length === 0) {
            curTop = $("body").css("top");
            curTop = Math.abs(parseInt(curTop, 10));
            $("body").attr("style", "")
            if (curTop !== 0) {
                $("html").scrollTop(curTop);
            }
            $("body").removeClass("fixed");
            $("[data-popup]").fadeOut(300);
        }
    });

    // -----------------------

    if ($(".office_slider").length > 0) {
        $(".office_slider").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 1200,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            prevArrow: '<button class="slick-prev slick_prev_white" aria-label="Previous" type="button"><img src="img/slider_arrow_white.svg" alt="" /></button>',
            nextArrow: '<button class="slick-next slick_next_white" aria-label="Next" type="button"><img src="img/slider_arrow_white.svg" alt="" /></button>'
            // appendArrows: $(".slider_4_controls"),
        });
    }

    // ---------------------------

    if ($(".slider_arendators").length > 0) {
        $(".slider_arendators").not(".slick-initialized").slick({
            dots: false,
            arrows: true,
            slidesToShow: 6,
            slidesToScroll: 1,
            appendArrows: $(".arendators_slider_contorls"),
            responsive: [
                {
                    breakpoint: 1140,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 960,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 510,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

    }

    // ---------------------------

    var galleryIndex;
    var galleriesBox;
    var activeGallery;
    $("[data-officegallery-index]").on("mouseover", function (e) {
        e.preventDefault();
        galleryIndex = $(this).attr("data-officegallery-index");
        galleriesBox = $(this).closest("[data-galleries-table]").attr("data-galleries-table");
        activeGallery = $("[data-galleries ='" + galleriesBox + "'] [data-officegallery-index ='" + galleryIndex + "']");
        if (activeGallery.is(":hidden")) {
            $("[data-galleries ='" + galleriesBox + "'] .office_gallery").css({
                "display": "none"
            });
            activeGallery.css({
                "display": "block"
            });
        }
    });

    $(".gallery_2").each(function () {
        if ($(this).find(".img_box").length == 2) {
            $(this).addClass("gallery_two_cols");
        } else if ($(this).find(".img_box").length == 1) {
            $(this).addClass("gallery_one_cols");
        }
    });

    $(".experts .slide a").on("click", function (e) {
        location.href = $(this).attr("href");

    });

});