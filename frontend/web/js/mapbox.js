(function ($) {
    var visibles = [], lg, lt, ico, element, mapParams = [], searchChecked, showMap, streetId;
    $(window).on('load', function () {
        searchChecked = false;
        showMap = false;
        $("#searchonmap").prop("checked", searchChecked);
        $("#onMap").prop("checked", showMap);
        initMap();
        //console.log(geojson);
        if (geojson.result != 'offices') {
            $('.marker').removeClass('hover');
        }
    });

    $(".filter-form").submit(function (event) {
        searchChecked = false;
        $('#searchonmap').prop('checked') === false;
    });


    $(document).on('pjax:complete', function (event) {
        initMap();
        console.log(streetId);

        $(".map_object_templ").addClass("map_show");
        $("#onMap").prop("checked", showMap);
        if (!showMap) {
            $(".map_object_templ").removeClass("map_show");
            $(".object_map").removeClass("visible");
        }
        $("#searchonmap").prop("checked", searchChecked);
        if (geojson.result != 'offices') {
            $('.marker').removeClass('hover');
        }

        if(streetId){
            marker_change_ico(streetId);
        } else {
            marker_change_ico(0);
        }
        
        getCardParams();
        cardSlider();
        expertsSlider();
    });

    function pjax_result(vis, cn, zm) {
        visibles = vis;
        $.pjax({
            type: 'POST',
            data: {visibles: visibles, center: cn, zoom: zm, result: geojson.result},
            container: '#cardsPjax',
            async: true,
            scrollTo: false
        });
    }

    function pjax_street(id) {
        streetId = id;
        $.pjax({
            url: window.location.href,
            type: 'POST',
            data: {streetId: streetId},
            container: '#cardsPjax',
            async: true,
            scrollTo: false
        });
        //console.log(streetId);
    }

    function pjax_close_street() {
        streetId = undefined;
        $.pjax({
            url: window.location.href,
            type: 'POST',
            data: {closeStreet: true},
            container: '#cardsPjax',
            async: true,
            scrollTo: false
        });
    }
//close_street
    $(document).on({
        click: function () {
            pjax_close_street();
        }
    }, '.close_street');


    $(document).on({
     click: function () {
     if ($(this).attr('data-id')) {
     if ($('#onMap').prop('checked') == true && $('#searchonmap').prop('checked') == false && markers[$(this).attr('data-id')]._lngLat !== 'undefined') {
     var mapCenter = map.getCenter(), mapLg, mapLt;
     lg = markers[$(this).attr('data-id')]._lngLat.lng;
     lt = markers[$(this).attr('data-id')]._lngLat.lat;
     if (lt > mapCenter) {
     lt = lt + (lt - mapCenter.lat);
     }

     map.flyTo({
     center: [
     lg,
     lt
     ],
     zoom: 13,
     });

     marker_change_ico($(this).attr('data-id'));
     }
     }
     }
     }, ".objects_cards .object_card");

    $(document).on({
        change: function () {
            if ($('#searchonmap').prop('checked') === true) {
                searchChecked = true;
                mapParams = getVisibles();
                pjax_result(mapParams['visibles'], mapParams['center'], mapParams['zoom']);
            } else {
                searchChecked = false;
                pjax_result(0, 0, 0);
            }
        }
    }, '#searchonmap');

    $(document).on({
        click: function () {
            if ($(this).find("input").prop("checked")) {
                showMap = true;
                $(".map_object_templ").addClass("map_show");
                $(".object_map").addClass("visible");
            } else {
                showMap = false;
                $(".map_object_templ").removeClass("map_show");
                $(".object_map").removeClass("visible");
            }
        }
    }, '.map_checkbox');

    $(document).on({
        click: function () {
            var markerId = $(this).attr('class').split(' ')[1];
            $('.marker').removeClass('hover');
            $(this).addClass('hover');
            if ($('#onMap').prop('checked') == true
                && $('#searchonmap').prop('checked') == false
                && geojson.result == 'offices'
                && markerId !== 'undefined') {
                marker_change_ico(markerId);
                pjax_street(markerId);
            }
        }
    }, '.marker');


    function marker_change_ico(id) {
        $('.marker').removeClass('hover');
        if (id === 0) return false;
        element = $(markers[id]._element);
        element.addClass('hover');
    }


    function getVisibles(){
        var bounds, minLat, maxLat, minLng, maxLng, center, zoom;
        bounds = map.getBounds();
        minLat = bounds._sw.lat;
        maxLat = bounds._ne.lat;
        minLng = bounds._sw.lng;
        maxLng = bounds._ne.lng;
        visibles = {};
        for (var i = 0; i < geojson.features.length; i++) {
            if (
                geojson.features[i].geometry.coordinates[0] >= minLng &&
                geojson.features[i].geometry.coordinates[0] <= maxLng &&
                geojson.features[i].geometry.coordinates[1] >= minLat &&
                geojson.features[i].geometry.coordinates[1] <= maxLat
            )
                visibles[i] = geojson.features[i].properties.id;
        }
        center = map.getCenter();
        mapParams['center'] = [center.lng, center.lat]
        mapParams['zoom'] = map.getZoom();
        mapParams['visibles'] = visibles;
        return(mapParams);
    }


    function initMap() {
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2RiLXN0dWRpbyIsImEiOiJjanl3amJ5NHUweTdiM2JuNGV0b3VvOXlhIn0.4EWyUOq1U6Ib_bZi4-d2KQ';
        map = new mapboxgl.Map({
            container: 'object_map',
            style: 'mapbox://styles/mapbox/light-v10',
            center: center,
            zoom: zoom,
        });

        var lang = geojson.lang !=='ua' ? geojson.lang : 'mul';
        map.addControl(new MapboxLanguage({
            defaultLanguage: lang
            //defaultLanguage: 'en'
            //defaultLanguage: 'ru'
        }));

        geojson.features.forEach(function (marker) {
            var el = document.createElement('div'), html = '', id = marker.properties.id;

            el.className = 'marker ' + id;
            if(geojson.result!='offices') {
                html += '<div class="map-img">';
                html += '<img src="' + marker.properties.img + '"/>';
                html += '<div class="green_circle">' + marker.properties.class + '</div>';
                html += '</div>';
                html +='<h4>' + marker.properties.title + '</h4>';
                html += '<p>' + marker.properties.address + '</p>';

                mar = new mapboxgl.Marker(el)
                    .setLngLat(marker.geometry.coordinates)
                    .setPopup(new mapboxgl.Popup({offset: 25}).setHTML(html))
                    .addTo(map);
            } else {
                mar = new mapboxgl.Marker(el)
                    .setLngLat(marker.geometry.coordinates)
                    .addTo(map);
            }
            markers[id] = mar;
        });

        map.on('dragend', function () {
            if ($('#searchonmap').prop('checked') == true) {
                mapParams = getVisibles();
                pjax_result(mapParams['visibles'], mapParams['center'], mapParams['zoom']);
            }
        });

        map.on('load', function() {
            map.on('click', function (e) {
                var targetClassName = $(e.originalEvent.srcElement).attr('class');
                console.log($(e.originalEvent.srcElement).attr('class'), streetId);
                if ($('#onMap').prop('checked') == true
                    && $('#searchonmap').prop('checked') == false
                    && geojson.result == 'offices'
                    && targetClassName === 'mapboxgl-canvas'
                    && streetId!==undefined) {
                    pjax_close_street();
                }
            });

        });

        map.on('zoomstart', function() {
            $('.marker.hover').removeClass('hover');
        });

        map.on('zoomend', function() {
         console.log(map.getZoom());
         });

    }
})(jQuery);